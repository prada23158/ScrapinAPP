<?php

namespace App\Livewire;
use App\Models\OffresFT;
use Livewire\Attributes\On;
use Livewire\Component;

class DoublonsOffres extends Component
{
     // propriétés des doublons
    public $processing = false;
    public $counting = false;
    public $deleting = false;
    public $finished = false;
    public $entreprisesEnDoublon = 0;
    public $nombreTotalDoublons = 0;
    public $doublonsSupprimes = 0;

    #[On('start-deletion')]
    // suppression des doublons des offres
    public function deleteDoublonsOffres()
    {
        $this->reset(['processing', 'counting', 'deleting', 'finished']);
        $this->processing = true;
        
        // Étape 1 : Comptage
        $this->counting = true;
        $this->compterDoublons();
        sleep(1);
        
        // Étape 2 : Suppression
        $this->counting = false;
        $this->deleting = true;
        $this->supprimerDoublons();
        sleep(1);
        
        // Étape 3 : Terminé
        $this->deleting = false;
        $this->processing = false;
        $this->finished = true;
    }

    private function compterDoublons()
    {
        $stats = OffresFT::from('offresFT as t1')
            ->join('offresFT as t2', 't1.entreprise', '=', 't2.entreprise')
            ->whereColumn('t1.idoffresFT', '>', 't2.idoffresFT')
            ->selectRaw('COUNT(DISTINCT t1.entreprise) as entreprises_en_doublon, 
            COUNT(*) as nombre_total_doublons')
            ->first();

        $this->entreprisesEnDoublon = $stats->entreprises_en_doublon ?? 0;
        $this->nombreTotalDoublons = $stats->nombre_total_doublons ?? 0;
    }

    private function supprimerDoublons()
    {
        $doublonsIds = OffresFT::from('offresFT as t1')
            ->join('offresFT as t2', 't1.entreprise', '=', 't2.entreprise')
            ->whereColumn('t1.idoffresFT', '>', 't2.idoffresFT')
            ->pluck('t1.idoffresFT');

        $this->doublonsSupprimes = OffresFT::whereIn('idoffresFT', $doublonsIds)->delete();
    }

    public function fermerModal()
    {
        $this->reset();
        $this->dispatch('close-modal', 'doublons-offres');
    }

    public function render()
    {
        return view('livewire.doublons-offres');
    }

}
