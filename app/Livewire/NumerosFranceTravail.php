<?php

namespace App\Livewire;
use App\Models\NumerosFT;
use Livewire\Component;

class NumerosFranceTravail extends Component
{
    public function render()
    {
        $query = NumerosFT::orderBy('created_at', 'desc');
        $numeros = $query->paginate(50);
        return view('livewire.numeros-france-travail', [
            'numeros' => $numeros,
        ]);
    }
}
