<?php

namespace App\Livewire;
use Livewire\Component;
use Flux\Flux;
use App\Models\LinksFT;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class LinksFranceTravail extends Component
{
    
    use WithPagination;

    // public $links = [];
    // public $showModal = false; // Ajoutez cette ligne
    protected $paginationTheme = 'tailwind';

    // 🔹 lié à flux:select
    public string $statusFilter = 'all';

    // (optionnel) pour garder le filtre dans l'URL
    protected $queryString = [
        'statusFilter' => ['except' => 'all'],
    ];

    public function mount()
    {
        
    }

    // Quand on change de filtre, on revient à la page 1
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = LinksFT::orderBy('created_aat', 'desc');
        
         // Appliquer le filtre si nécessaire
        
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }
        
        $links = $query->paginate(10);

        // on passe les données à la vue

        return view('livewire.links-francetravail', [
            'links' => $links, // IMPORTANT : on passe le paginator tel quel
        ]);
    }
}






