<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbRegistration extends Model
{
    protected $fillable = [
        'registration_number', 'major_id',
        'full_name', 'nisn', 'gender', 'religion', 'birth_place', 'birth_date',
        'phone', 'email', 'address', 'city', 'postal_code',
        'previous_school', 'graduation_year',
        'father_name', 'father_job', 'mother_name', 'mother_job', 'parent_phone', 'parent_income',
        'pathway',
        'doc_ijazah', 'doc_kk', 'doc_photo', 'doc_akta',
        'status', 'note', 'verified_by', 'verified_at',
    ];

    protected $casts = [
        'birth_date'  => 'date',
        'verified_at' => 'datetime',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $seq  = str_pad((self::whereYear('created_at', $year)->count() + 1), 4, '0', STR_PAD_LEFT);
        return "PPDB-{$year}-{$seq}";
    }
}
