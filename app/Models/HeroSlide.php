<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image', 'button_text', 'button_url',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/'.$this->image)
            : asset('images/placeholder-post.svg');
    }
}
