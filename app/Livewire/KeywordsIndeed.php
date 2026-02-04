<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KeyIndeed;
use Livewire\WithPagination;
use Flux\Flux;

class KeywordsIndeed extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // Propriétés publiques pour stocker les mots-clés et les villes
    public string $metiers = '';
    public string $villes = '';
    public string $date_insertion = '';
    public string $updated_aat = '';
    public $searchKeywords = '';
    
    public function clearSearch()
    {
        $this->searchKeywords = '';
        $this->resetPage();
    }

    public function createKeyword(): void
    {
        $this->validate([
            'metiers' => 'required|string|max:255',
            'villes' => 'required|string|max:255',
            'date_insertion' => 'nullable|date',
            'updated_aat' => 'nullable|date',
        ]);

        KeyIndeed::create([
            'metiers' => $this->metiers,
            'villes' => $this->villes,
            'date_insertion' => now(),
            'updated_aat' => now(),
        ]);

        // Réinitialiser les champs après l'ajout
        $this->metiers = '';
        $this->villes = '';

        // Réinitialiser la pagination à la page 1
        $this->resetPage();
        
        // $this->dispatch(event:"keywordAdded");

        // Optionnel: Afficher un message de succès
        // Flux::success(message:"Keyword added successfully.");
        // Flux::toast('Mot clé ajouté avec succès.', variant: 'success');
    }

    // suppression d'un mot clé
    public function deleteKeyword(int $keywordId): void
    {
        $keyword = KeyIndeed::findOrFail($keywordId);
        $keyword->delete();
        // Réinitialiser la pagination à la page 1
        $this->resetPage();
        // Flux::toast('Mot clé supprimé avec succès.', variant: 'success');
    }

    // Activer un mot clé
    public function activateKeyword(int $keywordId): void
    {
        $keyword = KeyIndeed::findOrFail($keywordId);
        $keyword->statut = 0; // Supposons que 0 signifie "activé"
        $keyword->save();
        // Dispatch un événement
        $keyword->message='Le mot clé est activé.';
    }

    // Désactiver un mot clé
    public function deactivateKeyword(int $keywordId): void
    {
        $keyword = KeyIndeed::findOrFail($keywordId);
        $keyword->statut = 1; // Supposons que 1 signifie "désactivé"
        $keyword->save();
        $keyword->message='Le mot clé est désactivé.';
    }

    // Éditer un mot clé
    public function editKey($id)
    {
        // $keyword = Keyword::find($id);
        
        $this->dispatch('editKeyword', [
            'id' => $id            
        ]);

        Flux::modal('keyword-edit' , $id)->show();
    }

    // obtenir les mots-clés et les villes depuis la base de données

    public function render()
    {
        $query = KeyIndeed::orderBy('date_insertion', 'desc');

        // if (!empty($this->searchKeywords)) {
        //     $query->where(function ($q) {
        //         $q->where('metiers', 'like', '%' . $this->searchKeywords . '%')
        //           ->orWhere('villes', 'like', '%' . $this->searchKeywords . '%');
        //     });
        // }

        $keywords = $query->paginate(5);

        // $keywordsIndeed = KeywordIndeed::all();

        $message = 'Composant KeywordsIndeed chargé avec succès.';
        return view('livewire.keywords-indeed', [
            'keywords' => $keywords,
            // 'message' => $message,
        ]);
        // ->with('keywordIndeed', $keywordIndeed);
    }
}
