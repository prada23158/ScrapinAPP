<?php

namespace App\Livewire;
use App\Models\ContactIndeed;
use Livewire\Component;

class ContactsIndeed extends Component
{
    public $searchContacts = '';

    public function clearSearch()
    {
        $this->searchContacts = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = ContactIndeed::where('statut', 0)
            ->orderBy('date_insertion', 'desc');

        if ($this->searchContacts) {
            $query->where(function ($q) {
                $q->where('entreprise', 'like', '%' . $this->searchContacts . '%')
                    ->orWhere('contact1', 'like', '%' . $this->searchContacts . '%')
                    ->orWhere('contact2', 'like', '%' . $this->searchContacts . '%')
                    ->orWhere('contact3', 'like', '%' . $this->searchContacts . '%')
                    ->orWhere('contact4', 'like', '%' . $this->searchContacts . '%')
                    ->orWhere('contact5', 'like', '%' . $this->searchContacts . '%');
            });
        }

        $contacts = $query->paginate(50);

        return view('livewire.contacts-indeed', [
            'contacts' => $contacts,
        ]);
    }
}
