<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactsFT extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'prospectft';

    protected $fillable = [
        'id_entreprise',
        'entreprise',
        'contact1',
        'contact2',
        'contact3',
        'contact4',
        'contact5',
        'row_lien',
    ];
}
