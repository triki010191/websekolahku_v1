<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'cover', 'category', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'album_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
