<?php
namespace App\Livewire;
// namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SaintGraalIndeed extends Component
{
    public function render()
    {

        $query = DB::table('offresindeed as O')
        ->join('infossociete as I', 'O.id', '=', 'I.id_entreprise')
        // ->join('contactsindeed as C', 'O.id', '=', 'C.id_entreprise')
        // ->join('numeros_indeed as N', 'O.id', '=', 'N.row_lien')
        ->select(
            'O.Poste',
            'O.entreprise',
            'O.lieu',
            'O.Page_URL',
            'I.adresse1',
            'I.adresse2',
            'I.adresse3',
            'I.phone1',
            'I.phone2',
            'I.phone3',
            'I.email1',
            'I.email2',
            'I.email3',
            'I.website1',
            'I.website2',
            'I.website3',
            // 'N.telephone',
            // 'C.contact1',
            // 'C.contact2',
            // 'C.contact3',
            // 'C.contact4',
            // 'C.contact5'
            )
            ->distinct()
            ->orderBy('O.entreprise', 'desc');

        $graalIndeed = $query->paginate(50);

        logger($graalIndeed);

        return view('livewire.saint-graal-indeed', [
            'graalIndeed' => $graalIndeed,
        ]);
    }
}
