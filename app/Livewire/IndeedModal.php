<?php

namespace App\Livewire;
use App\Models\ApifyIndeed;
use Livewire\Component;

class IndeedModal extends Component
{
    public function render()
    {
        //les résultats paginés
        $resultats = ApifyIndeed::where('statut', 0)
            ->orderBy('date_insertion', 'desc') // Correction ici
            ->paginate(10);

        return view('livewire.indeed-modal', [
            'infos' => $resultats,
        ]);
    }

    
}
