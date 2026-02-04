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


class EntreprisesIndeed extends Component
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
    public int $offres_restantes = 0;


    // Configuration
    private string $railway_host;
    private string $workflowUrl2;

    public function mount(): void
    {
        $this->workflowUrl2 = config('services.n8n-prod.steptwo_indeed_prod');
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        $this->refreshCount();
    }

    protected $listeners = ['refreshInfosCount' => 'refreshCount'];

    public function getEntreprisesCount(): array
    {
        $EntreprisesCount = Infos::whereNotNull('date_insertion')
        ->selectRaw('SUM(CASE WHEN statut = 1 THEN 1 ELSE 0 END) as scrapped_count,
                    SUM(CASE WHEN statut = 0 THEN 1 ELSE 0 END) as not_scrapped_count,
                    COUNT(*) as entreprises')
                    ->first();

        $offresCount = OffresFT::whereNotNull('created_at')
        ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as scrapped_count,
                    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as not_scrapped_count,
                    COUNT(*) as offres')
                    ->first();

        return [
            'entreprises' => $EntreprisesCount->entreprises ?? 0,
            'entreprises_scrapped' => $EntreprisesCount->scrapped_count ?? 0,
            'offres_restantes' => $offresCount->not_scrapped_count ?? 0,
            // 'entreprises_not_scrapped' => $EntreprisesCount->not_scrapped_count ?? 0

        ];

    }

    public function refreshCount(): void
    {
        $stats = $this->getEntreprisesCount();

        $this->data = $stats['entreprises'];
        $this->offres_restantes = $stats['offres_restantes'];
        // $this->linksNotScrappedToday = $stats['links_not_scrapped'];
    }

    #[On('indeedThree-error')]
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

    #[On('indeedThree-success')]
    public function setSuccess(array $data): void
    {
        $this->success = (bool) ($data['success'] ?? true);
        $this->response = $data['response'] ?? null;
        $this->executionId = $data['executionId'] ?? null;
        $this->finished = $data['finished'] ?? false;
        $this->status = $data['status'] ?? 'success';

        // Réinitialiser les erreurs
        $this->errorCode = null;
        $this->errorMessage = null;
        $this->errorHint = null;

        // ✅ Rafraîchit le compteur quand le workflow est OK
        $this->refreshCount();
    }

    public function StepInfoIndeedWorkflow()
    {
        $this->workflowUrl2 = config('services.n8n-prod.stepthree_francetravail_prod');
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        $this->apiKey = config('services.n8n.api_key');
        $this->workflowID = config('services.n8n.workflow_Three_ID_INDEED');

        // ❌ RETIREZ CECI :
        // dd("1");

        try {
            // ⏱️ Timeout court : on ne bloque jamais l’UI
            $response = Http::timeout(10)->get($this->workflowUrl2);
            sleep(5);
            // Obtenir la dernière exécution du workflow via l'API n8n
            $data = Http::withHeaders([
                'X-N8N-API-KEY' => config('services.n8n.api_key')
            ])
                ->timeout(10)
                ->get($this->railway_host . '/api/v1/executions', [
                    'workflowId' => config('services.n8n.workflow_Three_ID_INDEED'),
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

                $this->dispatch('indeedThree-error', [
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

                $this->dispatch('indeedThree-error', [
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
                $this->dispatch('indeedThree-error', [
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
                $this->dispatch('indeedThree-success', [
                    'success' => true,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } elseif (in_array($status, ['error', 'failed'])) {
                $this->dispatch('indeedThree-error', [
                    'success' => false,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } else {
                // running, waiting, etc.
                $this->dispatch('indeedThree-error', [
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
                'url' => $this->workflowUrl2,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('indeedThree-error', [
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

            $this->dispatch('indeedThree-error', [
                'success' => false,
                'errorCode' => 500,
                'errorMessage' => 'Erreur interne.',
                'errorHint' => 'Consultez les logs pour plus de détails.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.entreprises-indeed', [
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
