<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinksFT extends Model
{
    protected $table = 'liens_scrappedFT';
    protected $fillable = ['titre_offre', 'lien_offre', 'status'];
}
