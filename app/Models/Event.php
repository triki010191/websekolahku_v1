<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'content', 'cover',
        'location', 'start_at', 'end_at', 'status', 'is_featured',
    ];

    protected $casts = [
        'start_at'    => 'datetime',
        'end_at'      => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function scopeUpcoming(Builder $q): Builder
    {
        return $q->where('status', 'upcoming')->orderBy('start_at');
    }
}
