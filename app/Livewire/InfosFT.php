<?php

namespace App\Livewire;
use App\Models\Infos;
use Livewire\Component;
use Livewire\WithPagination;

class InfosFT extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

        // 🔹 lié à flux:select
    public string $statusFilter = 'all';

    // Une seule fois au montage du composant par exemple paramètres
    public function mount()
    {
        // Initialisation si nécessaire
    }


    //A chaque rendu, on récupère les infos avec statut 0 (non traitées)
    public function render()
    {

        $query = Infos::orderBy('date_insertion', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('statut', $this->statusFilter);
        }

        $infos = $query->paginate(10);
        return view('livewire.infos-ft', 
        [
            'infos' => $infos,
        ]);
        
        // $infos = Infos::orderBy('date_insertion', 'desc')
        //     ->paginate(10);

        // return view('livewire.infos-ft', 
        // [
        //     'infos' => $infos,
        // ]);
    }
}
