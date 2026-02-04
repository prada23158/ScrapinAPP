<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Keyword;
use Livewire\Attributes\On;
use Flux\Flux;

class KeywordEdit extends Component
{
    public $metiers;
    public $villes;
    public $keywordId;

    public function render()
    {
        return view('livewire.keyword-edit');
    }

    #[On('editKeyword')]
    public function editKeyword($id)
    {
        $keyword = Keyword::query()->whereKey($id)->firstOrFail(); 
        // dd(get_class($keyword));

        $this->keywordId = $id;
        $this->metiers = $keyword->metiers;
        $this->villes = $keyword->villes;

        // Add other fields as necessary
        Flux::modal('keyword-edit' , $id)->show();
    }

    public function updateKeyword()
    {
        $this->validate([
            'metiers' => 'required|string|max:255',
            'villes' => 'required|string|max:255',
        ]);

        $keyword = Keyword::query()->whereKey($this->keywordId)->firstOrFail();

        $keyword->metiers = $this->metiers;
        $keyword->villes = $this->villes;
        // Update other fields as necessary
        $keyword->save();

        // Close the modal after updating
        Flux::modal('keyword-edit')->close();

        // Optionally, you can emit an event to refresh the keywords list
        $this->dispatch(event:"keywordUpdated");
    }
}
