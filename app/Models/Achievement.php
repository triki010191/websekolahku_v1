<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'title', 'level', 'category', 'winner',
        'year', 'description', 'cover',
    ];
}
