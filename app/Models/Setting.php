<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $map = Cache::rememberForever('settings.all', fn () => self::pluck('value', 'key')->toArray());

        return $map[$key] ?? $default;
    }

    /**
     * @param  mixed  $value  Disimpan sebagai string; array di-json-kan di caller jika perlu.
     */
    public static function set(string $key, mixed $value, ?string $group = null, ?string $type = null): void
    {
        $row = self::query()->where('key', $key)->first();
        $group = $group ?? $row?->group ?? 'general';
        $type = $type ?? $row?->type ?? 'text';
        if (! is_string($value) && $value !== null) {
            $value = (string) $value;
        }
        self::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value, 'group' => $group, 'type' => $type]
        );
        Cache::forget('settings.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
