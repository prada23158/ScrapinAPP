<?php

namespace App\Livewire;
use App\Models\ContactsFT;
use Livewire\Component;

class ContactsFranceTravail extends Component
{
    public function render()
    {
        $query = ContactsFT::orderBy('created_at', 'desc');
        $contacts = $query->paginate(10);
        return view('livewire.contacts-france-travail', [
            'contacts' => $contacts,
        ]);
    }
}
