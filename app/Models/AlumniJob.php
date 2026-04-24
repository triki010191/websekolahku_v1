<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniJob extends Model
{
    protected $fillable = [
        'user_id', 'title', 'company', 'location', 'type',
        'salary_range', 'description', 'requirements',
        'contact_email', 'contact_link', 'closes_at', 'status',
    ];

    protected $casts = ['closes_at' => 'date'];

    public function poster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
