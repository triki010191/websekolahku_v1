<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbRegistration extends Model
{
    use HasFactory;

    /** @var list<string> */
    public const STATUSES = ['pending', 'revisi', 'accepted', 'rejected'];

    protected $fillable = [
        'registration_number', 'spmb_banten_number', 'major_id',
        'full_name', 'nisn', 'nik', 'gender', 'religion', 'birth_place', 'birth_date',
        'birth_cert_number', 'citizenship', 'country_name', 'special_needs',
        'phone', 'home_phone', 'email', 'address', 'rt', 'rw', 'hamlet', 'village',
        'district', 'city', 'postal_code', 'latitude', 'longitude',
        'residence_type', 'transport_mode',
        'kks_number', 'child_order', 'kps_pkh_receiver', 'kps_pkh_number',
        'pip_eligible', 'kip_receiver', 'kip_number', 'kip_name', 'kip_card_received', 'pip_reason',
        'bank_name', 'bank_account_number', 'bank_account_holder',
        'previous_school', 'graduation_year',
        'height_cm', 'weight_kg', 'distance_category', 'distance_km',
        'travel_hours', 'travel_minutes', 'siblings_count',
        'achievements', 'scholarships',
        'father_name', 'father_nik', 'father_birth_year', 'father_education', 'father_job', 'father_income', 'father_special_needs',
        'mother_name', 'mother_nik', 'mother_birth_year', 'mother_education', 'mother_job', 'mother_income', 'mother_special_needs',
        'guardian_name', 'guardian_nik', 'guardian_birth_year', 'guardian_education', 'guardian_job', 'guardian_income',
        'parent_phone', 'parent_income',
        'pathway', 'registration_type', 'nis', 'school_entry_date',
        'exam_number', 'diploma_serial', 'skhus_serial', 'data_declaration',
        'doc_ijazah', 'doc_kk', 'doc_photo', 'doc_akta',
        'status', 'form_status', 'draft_token', 'note', 'verified_by', 'verified_at',
    ];

    protected $casts = [
        'birth_date'        => 'date',
        'school_entry_date' => 'date',
        'verified_at'       => 'datetime',
        'special_needs'     => 'array',
        'father_special_needs' => 'array',
        'mother_special_needs' => 'array',
        'achievements'      => 'array',
        'scholarships'      => 'array',
        'kps_pkh_receiver'  => 'boolean',
        'pip_eligible'      => 'boolean',
        'kip_receiver'      => 'boolean',
        'kip_card_received' => 'boolean',
        'data_declaration'  => 'boolean',
        'latitude'          => 'float',
        'longitude'         => 'float',
        'distance_km'       => 'float',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isSubmitted(): bool
    {
        return $this->form_status === 'submitted';
    }

    public function allowsCorrection(): bool
    {
        return $this->isSubmitted() && $this->status === 'revisi';
    }

    /** @return array<string, string> */
    public static function statusLabels(): array
    {
        return [
            'pending'  => 'Menunggu Review',
            'revisi'   => 'Perlu Revisi',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? (string) $this->status;
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending'  => 'bg-warning text-dark',
            'revisi'   => 'bg-info text-dark',
            'accepted' => 'bg-success',
            'rejected' => 'bg-danger',
            default    => 'bg-secondary',
        };
    }

    public function genderLabel(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public static function generateNumber(): string
    {
        $year = date('Y');

        return \Illuminate\Support\Facades\DB::transaction(function () use ($year) {
            $last = self::query()
                ->where('registration_number', 'like', "DAFTAR-{$year}-%")
                ->lockForUpdate()
                ->orderByDesc('registration_number')
                ->value('registration_number');

            $seq = 1;
            if ($last && preg_match('/-(\d+)$/', $last, $m)) {
                $seq = ((int) $m[1]) + 1;
            }

            return sprintf('DAFTAR-%s-%04d', $year, $seq);
        });
    }

    public function scopeSubmitted(Builder $q): Builder
    {
        return $q->where('form_status', 'submitted');
    }

    public static function spmbAlreadySubmitted(string $number, ?int $exceptId = null): bool
    {
        $number = trim($number);
        if ($number === '') {
            return false;
        }

        return self::query()
            ->where('spmb_banten_number', $number)
            ->where('form_status', 'submitted')
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->exists();
    }
}
