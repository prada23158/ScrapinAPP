<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumerosFT extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'num_entreprise';

    protected $fillable = [
        'entreprise',
        'telephone',
        'place_id',
        'row_lien',
    ];
}
