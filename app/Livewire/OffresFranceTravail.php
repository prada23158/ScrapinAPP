<?php

namespace App\Livewire;
use App\Models\OffresFT;
use Livewire\Component;
use Livewire\WithPagination;


class OffresFranceTravail extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    
    public function render()
    {
        $query = OffresFT::orderBy('created_at', 'desc');

        $offres = $query->paginate(50);

        // dd($offres);

        return view('livewire.offres-francetravail', 
        [
            'offres' => $offres,
        ]);
    }
}
