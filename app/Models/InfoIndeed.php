<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoIndeed extends Model
{
    //
    public $primaryKey = 'id';
    protected $table = 'infossociete';
    protected $fillable = [
        'entreprise',
        'adresse1',
        'adresse2',
        'adresse3',
        'phone1',
        'phone2',
        'phone3',
        'email1',
        'email2',
        'email3',
        'website1',
        'website2',
        'website3',
        'date_insertion',
        'statut',
    ];
}
