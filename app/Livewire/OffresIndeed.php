<?php

namespace App\Livewire;
use App\Models\ApifyIndeed;
use Livewire\Component;
use Livewire\WithPagination;


class OffresIndeed extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    public $searchOffres = '';

    public function clearSearch()
    {
        $this->searchOffres = '';
        $this->resetPage();
    }
    
    public function render()
    {
        
        $query = ApifyIndeed::orderBy('date_insertion', 'desc');

        if ($this->searchOffres) {
            $search = '%' . $this->searchOffres . '%';
            $query->where(function($q) use ($search) {
                $q->where('entreprise', 'like', $search)
                ->orWhere('poste', 'like', $search)
                ->orWhere('lieu', 'like', $search);
            });
        }

        $offres = $query->paginate(50);

        // dd($offres);

        return view('livewire.offres-indeed', 
        [
            'offres' => $offres,
        ]);
    }


    //pour faire la recherche sur l'entreprise
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    


}
