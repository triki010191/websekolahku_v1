<?php

namespace App\Services;

use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PpdbRegistrationService
{
    public function messages(): array
    {
        return [
            'spmb_banten_number.unique' => 'Nomor SPMB Banten ini sudah terdaftar. Formulir daftar ulang tidak dapat diisi ulang.',
            'nisn.unique'               => 'NISN ini sudah terdaftar pada formulir daftar ulang yang dikirim.',
        ];
    }

    public function rules(bool $submit = false, ?int $exceptId = null): array
    {
        $nisnRule = $submit
            ? ['required', 'string', 'size:10', Rule::unique('ppdb_registrations', 'nisn')->where('form_status', 'submitted')->ignore($exceptId)]
            : ['nullable', 'string', 'max:20'];

        return [
            'spmb_banten_number' => $this->spmbBantenRules($submit, $exceptId),
            'draft_token'        => ['nullable', 'string', 'max:64'],
            'major_id'           => $submit ? ['required', 'exists:majors,id'] : ['nullable', 'exists:majors,id'],
            'full_name'          => $submit ? ['required', 'string', 'max:255'] : ['nullable', 'string', 'max:255'],
            'nisn'               => $nisnRule,
            'nik'                => ['nullable', 'string', 'max:20'],
            'gender'             => $submit ? ['required', 'in:L,P'] : ['nullable', 'in:L,P'],
            'birth_place'        => ['nullable', 'string', 'max:80'],
            'birth_date'         => ['nullable', 'date'],
            'birth_cert_number'  => ['nullable', 'string', 'max:40'],
            'religion'           => ['nullable', 'string', 'max:50'],
            'citizenship'        => ['nullable', 'in:WNI,WNA'],
            'country_name'       => ['nullable', 'string', 'max:80'],
            'special_needs'      => ['nullable', 'array'],
            'special_needs.*'    => ['string', 'max:50'],
            'address'            => ['nullable', 'string'],
            'rt'                 => ['nullable', 'string', 'max:5'],
            'rw'                 => ['nullable', 'string', 'max:5'],
            'hamlet'             => ['nullable', 'string', 'max:80'],
            'village'            => ['nullable', 'string', 'max:80'],
            'district'           => ['nullable', 'string', 'max:80'],
            'city'               => ['nullable', 'string', 'max:80'],
            'postal_code'        => ['nullable', 'string', 'max:10'],
            'latitude'           => ['nullable', 'numeric'],
            'longitude'          => ['nullable', 'numeric'],
            'residence_type'     => ['nullable', 'string', 'max:40'],
            'transport_mode'     => ['nullable', 'string', 'max:40'],
            'kks_number'         => ['nullable', 'string', 'max:40'],
            'child_order'        => ['nullable', 'integer', 'min:1', 'max:20'],
            'kps_pkh_receiver'   => ['nullable', 'boolean'],
            'kps_pkh_number'     => ['nullable', 'string', 'max:40'],
            'pip_eligible'       => ['nullable', 'boolean'],
            'kip_receiver'       => ['nullable', 'boolean'],
            'kip_number'         => ['nullable', 'string', 'max:40'],
            'kip_name'           => ['nullable', 'string', 'max:255'],
            'kip_card_received'  => ['nullable', 'boolean'],
            'pip_reason'         => ['nullable', 'string', 'max:80'],
            'bank_name'          => ['nullable', 'string', 'max:80'],
            'bank_account_number'=> ['nullable', 'string', 'max:40'],
            'bank_account_holder'=> ['nullable', 'string', 'max:255'],
            'father_name'        => ['nullable', 'string', 'max:255'],
            'father_nik'         => ['nullable', 'string', 'max:20'],
            'father_birth_year'  => ['nullable', 'integer', 'min:1940', 'max:'.date('Y')],
            'father_education'   => ['nullable', 'string', 'max:40'],
            'father_job'         => ['nullable', 'string', 'max:255'],
            'father_income'      => ['nullable', 'string', 'max:40'],
            'father_special_needs' => ['nullable', 'array'],
            'mother_name'        => ['nullable', 'string', 'max:255'],
            'mother_nik'         => ['nullable', 'string', 'max:20'],
            'mother_birth_year'  => ['nullable', 'integer', 'min:1940', 'max:'.date('Y')],
            'mother_education'   => ['nullable', 'string', 'max:40'],
            'mother_job'         => ['nullable', 'string', 'max:255'],
            'mother_income'      => ['nullable', 'string', 'max:40'],
            'mother_special_needs' => ['nullable', 'array'],
            'guardian_name'      => ['nullable', 'string', 'max:255'],
            'guardian_nik'       => ['nullable', 'string', 'max:20'],
            'guardian_birth_year'=> ['nullable', 'integer', 'min:1940', 'max:'.date('Y')],
            'guardian_education' => ['nullable', 'string', 'max:40'],
            'guardian_job'       => ['nullable', 'string', 'max:255'],
            'guardian_income'    => ['nullable', 'string', 'max:40'],
            'home_phone'         => ['nullable', 'string', 'max:32'],
            'phone'              => ['nullable', 'string', 'max:32'],
            'email'              => ['nullable', 'email', 'max:255'],
            'height_cm'          => ['nullable', 'integer', 'min:50', 'max:250'],
            'weight_kg'          => ['nullable', 'integer', 'min:10', 'max:200'],
            'distance_category'  => ['nullable', 'string', 'max:20'],
            'distance_km'        => ['nullable', 'numeric', 'min:0'],
            'travel_hours'       => ['nullable', 'integer', 'min:0', 'max:23'],
            'travel_minutes'     => ['nullable', 'integer', 'min:0', 'max:59'],
            'siblings_count'     => ['nullable', 'integer', 'min:0', 'max:20'],
            'achievements'       => ['nullable', 'array'],
            'achievements.*.type'        => ['nullable', 'string', 'max:30'],
            'achievements.*.level'         => ['nullable', 'string', 'max:30'],
            'achievements.*.name'          => ['nullable', 'string', 'max:255'],
            'achievements.*.year'          => ['nullable', 'integer', 'min:1990', 'max:'.(date('Y') + 1)],
            'achievements.*.organizer'     => ['nullable', 'string', 'max:255'],
            'achievements.*.rank'          => ['nullable', 'string', 'max:50'],
            'scholarships'       => ['nullable', 'array'],
            'scholarships.*.type'        => ['nullable', 'string', 'max:30'],
            'scholarships.*.description'   => ['nullable', 'string', 'max:255'],
            'scholarships.*.year_start'    => ['nullable', 'integer', 'min:1990', 'max:'.(date('Y') + 5)],
            'scholarships.*.year_end'      => ['nullable', 'integer', 'min:1990', 'max:'.(date('Y') + 5)],
            'registration_type'  => $submit ? ['required', 'in:siswa_baru,pindahan,kembali'] : ['nullable', 'in:siswa_baru,pindahan,kembali'],
            'nis'                => ['nullable', 'string', 'max:20'],
            'school_entry_date'  => ['nullable', 'date'],
            'previous_school'    => $submit ? ['required', 'string', 'max:255'] : ['nullable', 'string', 'max:255'],
            'exam_number'        => ['nullable', 'string', 'max:40'],
            'diploma_serial'     => ['nullable', 'string', 'max:40'],
            'skhus_serial'       => ['nullable', 'string', 'max:40'],
            'data_declaration'   => $submit ? ['accepted'] : ['nullable'],
        ];
    }

    public function mapRequest(Request $request, bool $submit = false): array
    {
        $data = $request->only(array_keys($this->rules(submit: $submit)));

        foreach (['kps_pkh_receiver', 'pip_eligible', 'kip_receiver', 'kip_card_received'] as $bool) {
            if ($request->has($bool)) {
                $data[$bool] = $request->boolean($bool);
            }
        }

        $data['achievements']  = $this->cleanRepeater($request->input('achievements', []), ['type', 'level', 'name', 'year', 'organizer', 'rank']);
        $data['scholarships']  = $this->cleanRepeater($request->input('scholarships', []), ['type', 'description', 'year_start', 'year_end']);
        $data['special_needs'] = array_values(array_filter((array) $request->input('special_needs', [])));
        $data['father_special_needs'] = array_values(array_filter((array) $request->input('father_special_needs', [])));
        $data['mother_special_needs'] = array_values(array_filter((array) $request->input('mother_special_needs', [])));

        if ($request->filled('spmb_banten_number')) {
            $data['spmb_banten_number'] = trim((string) $request->input('spmb_banten_number'));
        }

        if ($request->boolean('data_declaration') || $request->input('data_declaration') === '1') {
            $data['data_declaration'] = true;
        }

        return $data;
    }

    public function saveDraft(Request $request): PpdbRegistration
    {
        $data = $this->mapRequest($request);
        $data['status'] = 'pending';

        $token = $request->input('draft_token') ?: Str::random(40);
        $data['draft_token'] = $token;

        $reg = PpdbRegistration::where('draft_token', $token)->first();

        if ($reg?->isSubmitted()) {
            return $reg;
        }

        $data['form_status'] = 'draft';
        $data = $this->applyDraftDefaults($data);

        if ($reg) {
            $reg->update($data);
        } else {
            $data['registration_number'] = PpdbRegistration::generateNumber();
            $reg = PpdbRegistration::create($data);
        }

        return $reg->fresh();
    }

    public function submit(Request $request): PpdbRegistration
    {
        $data = $this->mapRequest($request, submit: true);
        $data['form_status'] = 'submitted';
        $data['status']      = 'pending';

        $token = $request->input('draft_token');
        $reg   = $token ? PpdbRegistration::where('draft_token', $token)->first() : null;

        if ($reg) {
            $reg->update($data);
        } else {
            $data['registration_number'] = PpdbRegistration::generateNumber();
            $data['draft_token']         = Str::random(40);
            $reg = PpdbRegistration::create($data);
        }

        return $reg->fresh(['major']);
    }

    /** @param  array<string, mixed>  $data */
    private function applyDraftDefaults(array $data): array
    {
        $data['full_name'] ??= '(Draft)';
        $data['nisn']      ??= '0000000000';
        $data['gender']    ??= 'L';

        return $data;
    }

    /** @return list<mixed> */
    private function spmbBantenRules(bool $submit, ?int $exceptId): array
    {
        $rules = $submit ? ['required', 'string', 'max:64'] : ['nullable', 'string', 'max:64'];

        if ($submit) {
            $rules[] = Rule::unique('ppdb_registrations', 'spmb_banten_number')
                ->where('form_status', 'submitted')
                ->ignore($exceptId);

            return $rules;
        }

        $rules[] = function (string $attribute, mixed $value, \Closure $fail) use ($exceptId): void {
            if (blank($value)) {
                return;
            }
            if (PpdbRegistration::spmbAlreadySubmitted((string) $value, $exceptId)) {
                $fail('Nomor SPMB Banten ini sudah terdaftar. Formulir daftar ulang tidak dapat diisi ulang.');
            }
        };

        return $rules;
    }

    private function cleanRepeater(array $rows, array $keys): array
    {
        return collect($rows)
            ->map(fn ($row) => collect($keys)->mapWithKeys(fn ($k) => [$k => $row[$k] ?? null])->all())
            ->filter(fn ($row) => collect($row)->filter(fn ($v) => filled($v))->isNotEmpty())
            ->values()
            ->all();
    }
}
