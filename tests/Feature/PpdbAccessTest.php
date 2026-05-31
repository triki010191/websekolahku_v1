<?php

namespace Tests\Feature;

use App\Models\PpdbRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpdbAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_and_pdf_require_verified_session(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0001',
            'nisn'                => '1234567890',
            'spmb_banten_number'  => 'SPMB-TEST-001',
            'form_status'         => 'submitted',
            'full_name'           => 'Siswa Test',
            'gender'              => 'L',
        ]);

        $this->get(route('ppdb.success', $reg->registration_number))
            ->assertRedirect(route('spmb.index'));

        $this->get(route('ppdb.pdf', $reg->registration_number))
            ->assertRedirect(route('spmb.index'));
    }

    public function test_lookup_grants_access_to_success_and_pdf(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0002',
            'nisn'                => '9876543210',
            'spmb_banten_number'  => 'SPMB-TEST-002',
            'form_status'         => 'submitted',
            'full_name'           => 'Siswa Dua',
            'gender'              => 'P',
        ]);

        $this->post(route('ppdb.lookup'), [
            'nisn'               => '9876543210',
            'spmb_banten_number' => 'SPMB-TEST-002',
        ])->assertRedirect(route('ppdb.success', $reg->registration_number));

        $this->get(route('ppdb.success', $reg->registration_number))->assertOk();
        $this->get(route('ppdb.pdf', $reg->registration_number))->assertOk();
    }
}
