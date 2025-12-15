<?php

namespace App\Livewire;
use Flux\Flux;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\LinksFT;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaintGraalExport;

class FranceTravail extends Component
{
    public string $workflowUrl = '';
    public $liens;

    public function mount()
    {
        // Initialisation si nécessaire
        $this->liens = LinksFT::all();
    }

    // Méthode d'export
    public function export()
    {
        // dd('La méthode export() est appelée !');

        return Excel::download(new SaintGraalExport, 'saint-graal.xlsx');
    }   

    public function stepOneFrancetravailWorkflow()
    {
        $this->workflowUrl = 'https://primary-production-cd85.up.railway.app/webhook-test/scrapped-ft';
        // Envoyer une requête POST au workflow externe
        $response = Http::post($this->workflowUrl);
        // dd($response->json());
        // dd("1");

        if ($response->successful()) {
            Flux::toast(
                heading: 'Succès',
                text: 'Workflow France Travail déclenché avec succès.',
                variant: 'success'
            );
        } else {
            Flux::toast(
                heading: 'Erreur',
                text: 'Échec du déclenchement du workflow France Travail.',
                variant: 'danger'
            );
        }

        return view('livewire.france-travail');
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
