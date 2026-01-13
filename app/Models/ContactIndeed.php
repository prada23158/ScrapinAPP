<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactIndeed extends Model
{
    //
    public $primaryKey = 'id';
    protected $table = 'contactsindeed';
    protected $fillable = [
        'entreprise',
        'contact1',
        'contact2',
        'contact3',
        'contact4',
        'contact5',
        'date_insertion',
        'statut',
    ];
}
