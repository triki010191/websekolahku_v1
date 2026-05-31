<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'slug', 'nip', 'name', 'gender', 'position', 'subject', 'education',
        'employment_status', 'field', 'email', 'phone',
        'photo', 'bio', 'motto', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/'.$this->photo)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=1d4ed8&color=ffffff&size=512';
    }

    public function getEmploymentStatusLabelAttribute(): string
    {
        return match ($this->employment_status) {
            'pns'     => 'PNS',
            'pppk'    => 'PPPK',
            'honorer' => 'Honorer',
            default   => strtoupper((string) $this->employment_status),
        };
    }
}
