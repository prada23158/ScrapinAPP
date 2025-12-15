<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\LinksFT;
use Livewire\WithPagination;

class FrancetravailModal extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // public $resultats = [];
    public string $workflowUrl;

    public function render()
    {
        //les résultats paginés
        $resultats = LinksFT::where('status', 0)
            ->orderBy('created_aat', 'desc') // Correction ici
            ->paginate(10);
            
        // Pas besoin d'appeler hasPages() ici, c'est automatiquement disponible dans la vue
                
        return view('livewire.francetravail-modal', [
            'resultats' => $resultats,
        ]);
    }    
}
