<?php

namespace App\Livewire;
use App\Models\NumeroIndeed;
use Livewire\Component;

class NumerosIndeed extends Component
{
    public $searchTelephones = '';

    public function clearSearch()
    {
        $this->searchTelephones = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = NumeroIndeed::orderBy('created_at', 'desc');

        if ($this->searchTelephones) {
            $query->where(function ($q) {
                $q->where('entreprise', 'like', '%' . $this->searchTelephones . '%')
                    ->orWhere('telephone', 'like', '%' . $this->searchTelephones . '%');
            });
        }
        $numeros = $query->paginate(50);

        return view('livewire.numeros-indeed', [
            'numeros' => $numeros,
        ]);
    }
}
