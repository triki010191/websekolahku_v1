<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'content', 'attachment',
        'priority', 'published_at', 'expires_at', 'status',
    ];

    protected $casts = [
        'published_at' => 'date',
        'expires_at'   => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('status', 'active')
                 ->where('published_at', '<=', now())
                 ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }
}
