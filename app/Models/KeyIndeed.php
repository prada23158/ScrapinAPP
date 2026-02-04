<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyIndeed extends Model
{
    //model de la table keyword_indeed
    protected $table = 'keywords_indeed';

    protected $fillable = ['metiers', 'villes','date_insertion','updated_aat'];

    protected $primaryKey = 'id';
}
