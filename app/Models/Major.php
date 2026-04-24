<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = [
        'code', 'name', 'slug', 'tagline', 'description',
        'curriculum', 'career_prospects', 'certifications',
        'head_teacher', 'cover', 'color',
        'student_count', 'quota', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function ppdbRegistrations(): HasMany
    {
        return $this->hasMany(PpdbRegistration::class);
    }

    public function alumniProfiles(): HasMany
    {
        return $this->hasMany(AlumniProfile::class);
    }

    public function getRegistrationCountAttribute(): int
    {
        return $this->ppdbRegistrations()->count();
    }
}
