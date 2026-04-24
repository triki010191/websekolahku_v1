<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Download extends Model
{
    protected $fillable = [
        'category_id', 'title', 'file_path', 'file_type',
        'file_size', 'description', 'download_count', 'is_public',
    ];

    protected $casts = ['is_public' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getSizeHumanAttribute(): string
    {
        $size  = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i     = 0;
        while ($size > 1024 && $i < count($units) - 1) { $size /= 1024; $i++; }
        return round($size, 1) . ' ' . $units[$i];
    }
}
