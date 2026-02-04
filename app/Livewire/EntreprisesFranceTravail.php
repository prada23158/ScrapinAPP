<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Infos;
use App\Models\OffresFT;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Flux\Flux;
use Livewire\Attributes\On;


class EntreprisesFranceTravail extends Component
{
    // Propriétés d'état
    public bool $success = true;
    public ?string $errorCode = null;
    public ?string $errorMessage = null;
    public ?string $errorHint = null;
    public bool $finished = false;
    public string $status = 'waiting';
    public ?string $executionId = 'null';
    public $data;
    public $response = null;
    public string $apiKey = '';
    public string $workflowID = '';
    public int $offresScrapped = 0;
    public int $offres_restantes = 0;
    public int $offresTotal = 0;


    // Configuration
    private string $railway_host;
    private string $workflowUrl3;

    public function mount(): void
    {
        $this->workflowUrl3 = config('services.n8n-prod.stepfour_francetravail_prod');
        // $this->workflowUrl4 = config('services.n8n.stepfour_francetravail_test');
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        $this->refreshCount();
    }

    protected $listeners = ['refreshInfosCount' => 'refreshCount'];

   /**
     * Méthode optimisée pour récupérer toutes les statistiques en une seule requête
     */
    public function getAllStats(): array
    {
        // $today = Carbon::today();
        
        // Statistiques des infos entreprises scrappées aujourd'hui
        $EntreprisesCount = Infos::whereNotNull('date_insertion')->count();

        // Statistiques des infos scrappées et non scrappées aujourd'hui
        $offresStats = OffresFT::selectRaw('
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as scrapped,
                SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as offres_restantes,
                COUNT(*) as total
            ')
            ->first();

        return [
            'entreprises' => $EntreprisesCount,
            'offres_scrapped' => $offresStats->scrapped ?? 0,
            'offres_restantes' => $offresStats->offres_restantes ?? 0,
            'offres_total' => $offresStats->total ?? 0,
        ];
    }

    public function refreshCount(): void
    {
        $stats = $this->getAllStats();

        $this->data = $stats['entreprises'];
        $this->offresScrapped = $stats['offres_scrapped'];
        $this->offres_restantes = $stats['offres_restantes'];
        $this->offresTotal = $stats['offres_total'];
    }

    #[On('entreprises-error')]
    public function setError(array $data): void
    {
        $this->success = false;
        $this->errorCode = $data['errorCode'] ?? null;
        $this->errorMessage = $data['errorMessage'] ?? 'Erreur inconnue';
        $this->errorHint = $data['errorHint'] ?? null;
        $this->status = $data['status'] ?? 'error';
        $this->finished = $data['finished'] ?? false;
        $this->executionId = $data['executionId'] ?? null;

        // Réinitialiser les données de succès
        $this->response = null;
        
    }

    #[On('entreprises-success')]
    public function setSuccess(array $data): void
    {
        $this->success = (bool) ($data['success'] ?? true);
        $this->response = $data['response'] ?? null;
        $this->executionId = $data['executionId'] ?? null;
        $this->finished = $data['finished'] ?? false;
        $this->status = $data['status'] ?? 'Succeeded';

        // Réinitialiser les erreurs
        $this->errorCode = null;
        $this->errorMessage = null;
        $this->errorHint = null;

        // ✅ Rafraîchit le compteur quand le workflow est OK
        $this->refreshCount();
    }

    public function stepTwoFrancetravailWorkflow()
    {
        $this->workflowUrl3 = config('services.n8n-prod.stepthree_francetravail_prod');
        // $this->workflowUrl3 = config('services.n8n-test.stepthree_francetravail_test');
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        $this->apiKey = config('services.n8n.api_key');
        $this->workflowID = config('services.n8n.workflow_Three_ID_FT');

        // ❌ RETIREZ CECI :
        // dd("1");

        try {
            // ⏱️ Timeout court : on ne bloque jamais l’UI
            $response = Http::timeout(10)->get($this->workflowUrl3);
            sleep(5);
            // Obtenir la dernière exécution du workflow via l'API n8n
            $data = Http::withHeaders([
                'X-N8N-API-KEY' => config('services.n8n.api_key')
            ])
                ->timeout(10)
                ->get($this->railway_host . '/api/v1/executions', [
                    'workflowId' => config('services.n8n.workflow_Three_ID_FT'),
                    'limit' => 1
                ]);

            if ($response->failed()) {
                // ❌ ERREUR HTTP (4xx / 5xx)
                $error = $response->json() ?? [];

                $code = $error['code'] ?? $response->status();
                $message = $error['message'] ?? 'Erreur inconnue';
                $hint = $error['hint'] ?? null;

                logger()->error('Erreur HTTP n8n', [
                    'code' => $code,
                    'message' => $message,
                    'hint' => $hint,
                ]);

                $this->dispatch('entreprises-error', [
                    'success' => false,
                    'errorCode' => $code,
                    'errorMessage' => $message,
                    'errorHint' => $hint,
                ]);

                return;
            }

            if ($data->failed()) {
                $failStatus = $data->json() ?? [];
                $message = $failStatus['message'] ?? 'Erreur inconnue';

                logger()->error('Erreur appel API n8n', [
                    'message' => $message
                ]);

                $this->dispatch('entreprises-error', [
                    'success' => false,
                    'status' => 'error',
                    'finished' => 'false',
                    'errorCode' => $data->status(),
                    'errorMessage' => $message,
                    'errorHint' => "'Vérifiez que l\'API n8n est accessible et que votre clé API est valide' "
                ]);

                return;
            }

            // ✅ SUCCÈS HTTP
            $success = $response->json();
            $executionData = $data->json();

            // Extraction des informations depuis data[0]
            $execution = $executionData['data'][0] ?? null;
            if (!$execution) {
                logger()->warning('Aucune exécution trouvée');
                $this->dispatch('entreprises-error', [
                    'success' => false,
                    'errorCode' => 404,
                    'errorMessage' => 'Aucune exécution trouvée',
                    'errorHint' => 'Le workflow n\'a peut-être pas encore démarré',
                    'status' => 'error',
                ]);

                return;
            }

            // Extraction des valeurs
            $executionId = $execution['id'] ?? 'unknown';
            $finished = $execution['finished'] ?? false;
            $status = $execution['status'] ?? 'error';
            $startedAt = $execution['startedAt'] ?? null;
            $stoppedAt = $execution['stoppedAt'] ?? null;
            $workflowId = $execution['workflowId'] ?? null;
            // dd($status);
            // dd($finished);

            logger()->info('Workflow n8n déclenché avec succès', [
                'execution_id' => $executionId,
                'finished' => $finished,
                'status' => $status,
                'started_at' => $startedAt,
                'stopped_at' => $stoppedAt,
                'workflowId' => $workflowId,
            ]);

            // ⚠️ Attention : dispatch correct selon le statut
            if ($status === 'success' && $finished) {
                $this->dispatch('entreprises-success', [
                    'success' => true,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } elseif (in_array($status, ['error', 'failed','canceled'])) {
                $this->dispatch('entreprises-error', [
                    'success' => false,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } else {
                // running, waiting, etc.
                $this->dispatch('entreprises-error', [
                    'success' => true,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            }
        } catch (ConnectionException $e) {
            // ❌ Timeout / réseau / SSL
            logger()->error('Connexion impossible vers n8n', [
                'url' => $this->workflowUrl3,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('entreprises-error', [
                'success' => false,
                'errorCode' => 408,
                'errorMessage' => 'Le workflow met trop de temps à répondre.',
                'errorHint' => 'Le traitement est peut-être long ou le service est indisponible.',
            ]);
        } catch (\Throwable $e) {
            // ❌ Erreur inattendue
            logger()->critical('Erreur inattendue lors de l’appel n8n', [
                'exception' => $e,
            ]);

            $this->dispatch('entreprises-error', [
                'success' => false,
                'errorCode' => 500,
                'errorMessage' => 'Erreur interne.',
                'errorHint' => 'Consultez les logs pour plus de détails.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.entreprises-francetravail', [
            'success' => $this->success,
            'errorCode' => $this->errorCode,
            'errorMessage' => $this->errorMessage,
            'errorHint' => $this->errorHint,
            'response' => $this->response,
            'data' => $this->data, // ✅ on passe data à la vue
            'status' => $this->status,
        ]);
    }
}
