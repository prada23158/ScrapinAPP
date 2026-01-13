<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\LinksFT;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaintGraalExport;
use Illuminate\Http\Client\ConnectionException;
use Livewire\Attributes\On;

class FranceTravail extends Component
{
    public string $workflowUrl = '';
    public $liens;
    public string $railway_host = '';
    public string $apiKey = '';
    public string $workflowID = '';
    public int $executionId = 0;
    public bool $finished = false;
    public $status;
    public string $startedAt = 'null';
    public string $stoppedAt = 'null';
    public bool $success = false;
    public ?int $errorCode = 0;
    public ?string $errorMessage = 'null';
    public ?string $errorHint = 'null';

    // protected $listeners = ['ft-error' => 'handleError'];
    // public function handleError($data)
    // {
    //     $this->success = $data['success'];
    //     $this->status = $data['status'];
    //     $this->finished = $data['finished'];
    //     $this->errorCode = $data['errorCode'];
    //     $this->errorMessage = $data['errorMessage'];
    //     $this->errorHint = $data['errorHint'];
    // }

    public function mount()
    {
        // Initialisation si nécessaire
        $this->liens = LinksFT::all();
        // initialisation si besoin
        $this->status = 'waiting';
    }

    // Méthode d'export
    public function export()
    {
        // dd('La méthode export() est appelée !');

        return Excel::download(new SaintGraalExport, 'saint-graal.xlsx');
    }

    public function stepOneFrancetravailWorkflow()
    {
        // $this->workflowUrl = config('services.n8n.stepone_francetravail_prod');
        $this->workflowUrl = config('services.n8n-test.stepone_francetravail_test');
        // récuperer la dernière exécution du workflow
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        // api_Key n8n
        $this->apiKey = config('services.n8n.api_key');
        // ID Workflow n8n
        $this->workflowID = config('services.n8n.workflow_One_ID_FT');
        // Envoyer une requête POST au workflow externe
        // z$response = Http::get($this->workflowUrl);
        // dd($response->json());
        // dd("1");

        try {
            // ⏱️ Timeout court : on ne bloque jamais l’UI
            $response = Http::timeout(10)->get($this->workflowUrl);
            sleep(5);
            // Obtenir la dernière exécution du workflow via l'API n8n
            $data = Http::withHeaders([
                'X-N8N-API-KEY' => config('services.n8n.api_key')
            ])
                ->timeout(10)
                ->get($this->railway_host . '/api/v1/executions', [
                    'workflowId' => config('services.n8n.workflow_One_ID_FT'),
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

                $this->dispatch('ft-error', [
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

                $this->dispatch('ft-error', [
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
            // dd($executionData);

            // Extraction des informations depuis data[0]
            $execution = $executionData['data'][0] ?? null;
            // dd($execution);
            if (!$execution) {
                logger()->warning('Aucune exécution trouvée');
                $this->dispatch('ft-error', [
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
                $this->dispatch('ft-success', [
                    'success' => true,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } elseif (in_array($status, ['error', 'failed'])) {
                $this->dispatch('ft-error', [
                    'success' => false,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } else {
                // running, waiting, etc.
                $this->dispatch('ft-error', [
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
                'url' => $this->workflowUrl,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('ft-error', [
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

            $this->dispatch('ft-error', [
                'success' => false,
                'errorCode' => 500,
                'errorMessage' => 'Erreur interne.',
                'errorHint' => 'Consultez les logs pour plus de détails.',
            ]);
        }
    }

    public function stepTwoFrancetravailWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/infos-offres';
        // Envoyer une requête POST au workflow externe
        $response2 = Http::get($this->workflowUrl);
        // dd($response->json());
        // dd("2");

        if ($response2->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Collecte des informations des entreprises France Travail déclenchée avec succès.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: "Échec du déclenchement de la collecte des informations des entreprises France Travail.",
                variant: 'danger'
            );
        }

        return view('livewire.france-travail');
    }

    public function stepThreeFrancetravailWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/infos-entreprises';
        // Envoyer une requête POST au workflow externe
        $response3 = Http::get($this->workflowUrl);
        // dd($response->json());
        // dd("2");

        if ($response3->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Collecte des informations des offres France Travail déclenchée avec succès.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: "Échec du déclenchement de la collecte des informations des offres France Travail.",
                variant: 'danger'
            );
        }

        return view('livewire.france-travail');
    }

    public function stepFourFrancetravailWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/contact-entreprises';
        // Envoyer une requête POST au workflow externe
        $response4 = Http::post($this->workflowUrl);
        // dd($response->json());
        // dd("2");

        if ($response4->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Collecte des informations des offres France Travail déclenchée avec succès.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: "Échec du déclenchement de la collecte des informations des offres France Travail.",
                variant: 'danger'
            );
        }

        return view('livewire.france-travail');
    }

    public function stepTelFrancetravailWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/tel-entreprises';
        // Envoyer une requête POST au workflow externe
        $ListTel = Http::post($this->workflowUrl);
        // dd($response->json());
        // dd("tel");

        if ($ListTel->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Collecte des informations téléphoniques France Travail déclenchée avec succès.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: "Échec du déclenchement de la collecte des informations téléphoniques France Travail.",
                variant: 'danger'
            );
        }

        return view('livewire.france-travail');
    }

    // public function stepGraalFrancetravailWorkflow()
    // {
    //     $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/graal-ft';
    //     // Envoyer une requête POST au workflow externe
    //     $Graal = Http::post($this->workflowUrl);
    //     // dd($response->json());
    //     // dd("graal");

    //     if ($Graal->successful()) {
    //         Flux::toast(
    //             heading: 'Succès',
    //             text: 'Graal France Travail déclenché avec succès.',
    //             variant: 'success'
    //         );
    //     } else {
    //         Flux::toast(
    //             heading: 'Erreur',
    //             text: "Échec du déclenchement du Graal France Travail.",
    //             variant: 'danger'
    //         );
    //     }

    //     return view('livewire.france-travail');
    // }

}
