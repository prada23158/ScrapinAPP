<?php

namespace App\Livewire;

use Livewire\Component;
use Flux\Flux;
use Illuminate\Support\Facades\Http;
use App\Models\ApifyIndeed;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaintGraalIndeedExport;

class Indeed extends Component
{
    public string $workflowUrl = '';
    public $OffresIndeed;

    public function mount()
    {
        // Initialisation si nécessaire
        $this->OffresIndeed = ApifyIndeed::all();
    }

    public function export()
    {
        // dd('La méthode export() est appelée !');

        return Excel::download(new SaintGraalIndeedExport, 'saint-graal-indeed.xlsx');
    }


    public function stepOneIndeedWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/offres-indeed';
        // Envoyer une requête GET au workflow externe
        $response = Http::get($this->workflowUrl);
        // dd($response->json());
        // dd("1");

        if ($response->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Workflow Indeed déclenché avec succès.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: 'Échec du déclenchement du workflow Indeed.',
                variant: 'danger'
            );
        }

        // return view('livewire.indeed');
    }

    Public function StepInfoIndeedWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/infos-indeed';
        // Envoyer une requête GET au workflow externe
        $response2 = Http::get($this->workflowUrl);
        // dd($response->json());

        if ($response2->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Récupération des infos des entreprises réussie.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: "Échec de la récupération des infos des entreprises.",
                variant: 'danger'
            );
        }

        // return view('livewire.indeed');
    }

    public function StepContactIndeedWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/contact-indeed';
        // Envoyer une requête GET au workflow externe
        $response3 = Http::get($this->workflowUrl);
        // dd($response->json());

        if ($response3->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Récupération des contacts des entreprises réussie.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: "Échec de la récupération des contacts des entreprises.",
                variant: 'danger'
            );
        }

        // return view('livewire.indeed');
    }

    public function StepTelIndeedWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/tel-indeed';
        // Envoyer une requête POST au workflow externe
        $response4 = Http::get($this->workflowUrl);
        // dd($response->json());

        if ($response4->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Récupération des numéros des entreprises réussie.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: "Échec de la récupération des numéros des entreprises.",
                variant: 'danger'
            );
        }

        // return view('livewire.indeed');
    }

    public function render()
    {
        return view('livewire.indeed');
    }

}
