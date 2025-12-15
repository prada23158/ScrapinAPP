<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaintGraalExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return DB::table('liens_scrappedFT as L')
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
            )
            ->orderBy('O.entreprise', 'asc')
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