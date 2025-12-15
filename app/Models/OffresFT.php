<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffresFT extends Model
{
    //
    protected $primaryKey = 'idoffresFT';
    protected $table = 'offresFT';
    public $fillable = [
        'idoffresFT',
        'Poste',
        'entreprise',
        'Lieu',
        'Contrat',
        'Page_URL',
        'row_lien',
        'status',
        'num_scrapped',
        'created_at',
        'updated_at'
    ];


}
