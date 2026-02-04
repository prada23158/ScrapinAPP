<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    //
    protected $fillable = ['metiers', 'villes','date_insertion','updated_aat'];

    protected $table = 'keywords';

    protected $primaryKey = 'id';
}
