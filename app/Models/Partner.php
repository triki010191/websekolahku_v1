<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'industry', 'website',
        'description', 'mou_number', 'mou_start', 'mou_end',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'mou_start' => 'date',
        'mou_end'   => 'date',
        'is_active' => 'boolean',
    ];
}
