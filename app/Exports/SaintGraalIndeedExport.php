<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaintGraalIndeedExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return DB::table('offresindeed as O')
        ->join('infossociete as I', 'O.id', '=', 'I.id_entreprise')
        ->join('contactsindeed as C', 'O.id', '=', 'C.id_entreprise')
        ->join('numeros_indeed as N', 'O.id', '=', 'N.row_lien')
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
            'N.telephone',
            'C.contact1',
            'C.contact2',
            'C.contact3',
            'C.contact4',
            'C.contact5'
            )
            ->groupBy(
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
            'N.telephone',
            'C.contact1',
            'C.contact2',
            'C.contact3',
            'C.contact4',
            'C.contact5'
            )->orderBy('O.entreprise', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Entreprise',
            'Lieu',
            'URL de la page',
            'Téléphone',
            'Adresse 1',
            'Adresse 2',
            'Adresse 3',
            'Email 1',
            'Email 2',
            'Email 3',
            'Site Web 1',
            'Site Web 2',
            'Site Web 3',
            'Contact 1',
            'Contact 2',
            'Contact 3',
            'Contact 4',
            'Contact 5',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}