<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApifyIndeed extends Model
{
    //
    public $primaryKey = 'id';
    protected $table = 'offresindeed';

    protected $fillable = [
        'poste',
        'entreprise',
        'lieu',
        'contrat',
        'lien',
        'statut',
        'date_insertion',
    ];
}
