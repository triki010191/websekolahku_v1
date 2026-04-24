<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'category', 'description',
        'coach', 'schedule', 'member_count', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];
}
