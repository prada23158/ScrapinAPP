<?php

namespace App\Livewire;
use App\Models\ApifyIndeed;
use Livewire\Attributes\On;
use Livewire\Component;

class DoublonsOffresIndeed extends Component
{
     // propriétés des doublons
    public $processing = false;
    public $counting = false;
    public $deleting = false;
    public $finished = false;
    public $entreprisesEnDoublon = 0;
    public $nombreTotalDoublons = 0;
    public $doublonsSupprimes = 0;

    #[On('start-suppression')]
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
        $stats = ApifyIndeed::from('offresindeed as t1')
            ->join('offresindeed as t2', 't1.entreprise', '=', 't2.entreprise')
            ->whereColumn('t1.id', '>', 't2.id')
            ->selectRaw('COUNT(DISTINCT t1.entreprise) as entreprises_en_doublon, 
            COUNT(*) as nombre_total_doublons')
            ->first();

        $this->entreprisesEnDoublon = $stats->entreprises_en_doublon ?? 0;
        $this->nombreTotalDoublons = $stats->nombre_total_doublons ?? 0;
    }

    private function supprimerDoublons()
    {
        $doublonsIds = ApifyIndeed::from('offresindeed as t1')
            ->join('offresindeed as t2', 't1.entreprise', '=', 't2.entreprise')
            ->whereColumn('t1.id', '>', 't2.id')
            ->pluck('t1.id');

        $this->doublonsSupprimes = ApifyIndeed::whereIn('id', $doublonsIds)->delete();
    }

    public function fermerModal()
    {
        $this->reset();
        $this->dispatch('close-modal', 'doublonsoffres-indeed');
    }

    public function render()
    {
        return view('livewire.doublons-offres-indeed');
    }

}
