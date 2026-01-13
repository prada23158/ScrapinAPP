<?php

namespace App\Livewire;
use App\Models\InfoIndeed;
use Livewire\Component;

class InfosIndeed extends Component
{
    public $searchInfos = '';

    public function clearSearch()
    {
        $this->searchInfos = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = InfoIndeed::orderBy('date_insertion', 'desc');

        if ($this->searchInfos) {
            $search = '%' . $this->searchInfos . '%';
            $query->where(function($q) use ($search) {
                $q->where('entreprise', 'like', $search);
            });
        }

        $infos = $query->paginate(50);

        return view('livewire.infos-indeed', [
            'infos' => $infos,
        ]);
    }
}
