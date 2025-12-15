<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scrappings extends Model
{
    //
    protected $fillable = [
        'name',
        'url',
        'status',
        'created_at',
        'updated_at',
    ];
}
