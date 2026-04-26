<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'cover', 'category', 'description', 'content',
        'coach', 'schedule', 'member_count', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
