<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumeroIndeed extends Model
{
    //
    public $primaryKey = 'id';
    protected $table = 'numeros_indeed';
    protected $fillable = [
        'entreprise',
        'telephone',
        'place_id',
        'created_at'
    ];
}
