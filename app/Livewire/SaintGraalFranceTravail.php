<?php
namespace App\Livewire;
// namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SaintGraalFranceTravail extends Component
{
    public function render()
    {

        $query = DB::table('liens_scrappedFT as L')
        ->join('offresFT as O', 'L.id', '=', 'O.row_lien')
        ->join('infossocieteFT as I', 'O.idoffresFT', '=', 'I.id_entreprise')
        ->join('prospectft as P', 'O.idoffresFT', '=', 'P.id_entreprise')
        ->join('num_entreprise as N', 'O.idoffresFT', '=', 'N.row_lien')
        ->select(
                'O.entreprise',
                'O.lieu',
                'O.Page_URL',
                'N.telephone',
                'I.adresse1',
                'I.adresse2',
                'I.adresse3',
                'I.email1',
                'I.email2',
                'I.email3',
                'I.website1',
                'I.website2',
                'I.website3',
                'P.contact1',
                'P.contact2',
                'P.contact3',
                'P.contact4',
                'P.contact5',
            )
            ->groupBy(
                'O.entreprise',
                'O.lieu',
                'O.Page_URL',
                'N.telephone',
                'I.adresse1',
                'I.adresse2',
                'I.adresse3',
                'I.email1',
                'I.email2',
                'I.email3',
                'I.website1',
                'I.website2',
                'I.website3',
                'P.contact1',
                'P.contact2',
                'P.contact3',
                'P.contact4',
                'P.contact5',
            )->orderBy('O.entreprise', 'asc');

        $saintgraalFT = $query->paginate(10);

        return view('livewire.saint-graal-france-travail', [
            'saintgraalFT' => $saintgraalFT,
        ]);
    }
}
