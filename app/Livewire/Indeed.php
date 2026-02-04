<?php

namespace App\Livewire;

use Livewire\Component;
use Flux\Flux;
use Illuminate\Support\Facades\Http;
use App\Models\ApifyIndeed;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaintGraalIndeedExport;
use Illuminate\Http\Client\ConnectionException;


class Indeed extends Component
{
    public string $workflowUrl = '';
    public $offresIndeed;
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
    public string $workflowUrl2 = '';
    public string $workflowUrl3 = '';
    public string $workflowUrl4 = '';
    public $OffresIndeed;

    public int $countDoublons;

    public function compterDoublons()
    {

        $stats = ApifyIndeed::from('offresindeed as t1')
            ->join('offresindeed as t2', 't1.entreprise', '=', 't2.entreprise')
            ->whereColumn('t1.id', '>', 't2.id')
            ->selectRaw('COUNT(DISTINCT t1.entreprise) as entreprises_en_doublon, 
            COUNT(*) as nombre_total_doublons')
            ->first();

        // $this->entreprisesEnDoublon = $stats->entreprises_en_doublon ?? 0;
        $this->countDoublons = $stats->nombre_total_doublons ?? 0;

    }

    public function mount()
    {
        // Initialisation si nécessaire
        $this->OffresIndeed = ApifyIndeed::all();

        // nombre de doublons
        $this->compterDoublons();
    }

    public function export()
    {
        // dd('La méthode export() est appelée !');

        return Excel::download(new SaintGraalIndeedExport, 'saint-graal-indeed.xlsx');
    }


    public function stepOneIndeedWorkflow()
    {
        $this->workflowUrl = config('services.n8n-prod.stepone_indeed_prod');
        // $this->workflowUrl = config('services.n8n-test.stepone_indeed_test');
        // récuperer la dernière exécution du workflow
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        // api_Key n8n
        $this->apiKey = config('services.n8n.api_key');
        // ID Workflow n8n
        $this->workflowID = config('services.n8n.workflow_One_ID_INDEED');
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
                    'workflowId' => config('services.n8n.workflow_One_ID_INDEED'),
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

                $this->dispatch('indeedOne-error', [
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

                $this->dispatch('indeedOne-error', [
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
                $this->dispatch('indeedOne-error', [
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
                $this->dispatch('indeedOne-success', [
                    'success' => true,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } elseif (in_array($status, ['error', 'failed','canceled'])) {
                $this->dispatch('indeedOne-error', [
                    'success' => false,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } else {
                // running, waiting, etc.
                $this->dispatch('indeedOne-error', [
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

            $this->dispatch('indeedOne-error', [
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

            $this->dispatch('indeedOne-error', [
                'success' => false,
                'errorCode' => 500,
                'errorMessage' => 'Erreur interne.',
                'errorHint' => 'Consultez les logs pour plus de détails.',
            ]);
        }
    }

    // ======================================DEBUT STEP TWO INDEED====================================================================
    public function StepInfoIndeedWorkflow()
    {
        $this->workflowUrl2 = config('services.n8n-prod.steptwo_indeed_prod');
        // $this->workflowUrl2 = config('services.n8n-test.steptwo_indeed_test');
        // récuperer la dernière exécution du workflow
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        // api_Key n8n
        $this->apiKey = config('services.n8n.api_key');
        // ID Workflow n8n
        $this->workflowID = config('services.n8n.workflow_Two_ID_INDEED');
        // Envoyer une requête POST au workflow externe
        // z$response = Http::get($this->workflowUrl);
        // dd($response->json());
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
                    'workflowId' => config('services.n8n.workflow_Two_ID_INDEED'),
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

                $this->dispatch('indeedTwo-error', [
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

                $this->dispatch('indeedTwo-error', [
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
                $this->dispatch('indeedTwo-error', [
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
                $this->dispatch('indeedTwo-success', [
                    'success' => true,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } elseif (in_array($status, ['error', 'failed','canceled'])) {
                $this->dispatch('indeedTwo-error', [
                    'success' => false,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } else {
                // running, waiting, etc.
                $this->dispatch('indeedTwo-error', [
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

            $this->dispatch('indeedTwo-error', [
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

            $this->dispatch('indeedTwo-error', [
                'success' => false,
                'errorCode' => 500,
                'errorMessage' => 'Erreur interne.',
                'errorHint' => 'Consultez les logs pour plus de détails.',
            ]);
        }
    }

    // ======================================DEBUT STEP THREE INDEED====================================================================
    public function StepProspectIndeedWorkflow()
    {
        // dd('La méthode StepProspectIndeedWorkflow() est appelée !');
        $this->workflowUrl3 = config('services.n8n-prod.stepthree_indeed_prod');
        // $this->workflowUrl3 = config('services.n8n-test.stepthree_indeed_test');
        // récuperer la dernière exécution du workflow
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        // api_Key n8n
        $this->apiKey = config('services.n8n.api_key');
        // ID Workflow n8n
        $this->workflowID = config('services.n8n.workflow_Three_ID_INDEED');
        // Envoyer une requête POST au workflow externe
        // z$response = Http::get($this->workflowUrl);
        // dd($response->json());
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
            // dd($executionData);

            // Extraction des informations depuis data[0]
            $execution = $executionData['data'][0] ?? null;
            // dd($execution);
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
            } elseif (in_array($status, ['error', 'failed','canceled'])) {
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
                'url' => $this->workflowUrl3,
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

    // ======================================DEBUT STEP FOUR INDEED====================================================================
    public function StepTelIndeedWorkflow()
    {

        // dd('La méthode StepTelIndeedWorkflow() est appelée !');
        // dd('La méthode StepProspectIndeedWorkflow() est appelée !');
        $this->workflowUrl4 = config('services.n8n-prod.steptel_indeed_prod');
        // $this->workflowUrl4 = config('services.n8n-test.steptel_indeed_test');
        // récuperer la dernière exécution du workflow
        $this->railway_host = config('services.RAILWAY_HOST.railway_host');
        // api_Key n8n
        $this->apiKey = config('services.n8n.api_key');
        // ID Workflow n8n
        $this->workflowID = config('services.n8n.workflow_Tel_ID_INDEED');
        // Envoyer une requête POST au workflow externe
        // z$response = Http::get($this->workflowUrl);
        // dd($response->json());
        // dd("1");

        try {
            // ⏱️ Timeout court : on ne bloque jamais l’UI
            $response = Http::timeout(10)->get($this->workflowUrl4);
            sleep(5);
            // Obtenir la dernière exécution du workflow via l'API n8n
            $data = Http::withHeaders([
                'X-N8N-API-KEY' => config('services.n8n.api_key')
            ])
                ->timeout(10)
                ->get($this->railway_host . '/api/v1/executions', [
                    'workflowId' => config('services.n8n.workflow_Tel_ID_INDEED'),
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

                $this->dispatch('indeedTel-error', [
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

                $this->dispatch('indeedTel-error', [
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
                $this->dispatch('indeedTel-error', [
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
                $this->dispatch('indeedTel-success', [
                    'success' => true,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } elseif (in_array($status, ['error', 'failed','canceled'])) {
                $this->dispatch('indeedTel-error', [
                    'success' => false,
                    'response' => $success,
                    'status' => $status,
                    'finished' => $finished,
                    'startedAt' => $startedAt,
                    'stoppedAt' => $stoppedAt,
                ]);
            } else {
                // running, waiting, etc.
                $this->dispatch('indeedTel-error', [
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
                'url' => $this->workflowUrl4,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('indeedTel-error', [
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

            $this->dispatch('indeedTel-error', [
                'success' => false,
                'errorCode' => 500,
                'errorMessage' => 'Erreur interne.',
                'errorHint' => 'Consultez les logs pour plus de détails.',
            ]);
        }

    }

    public function render()
    {
        return view('livewire.indeed');
    }
}