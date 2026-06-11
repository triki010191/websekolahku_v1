<?php

namespace Tests\Feature;

use App\Models\PpdbRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
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
            'spmb_banten_number'  => '1234567890',
            'form_status'         => 'submitted',
            'full_name'           => 'Siswa Test',
            'gender'              => 'L',
        ]);

        $this->get(route('ppdb.success', $reg->registration_number))
            ->assertRedirect(route('spmb.index'));

        $this->get(route('ppdb.pdf', $reg->registration_number))
            ->assertForbidden();
    }

    public function test_lookup_grants_access_to_success_and_pdf(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0002',
            'nisn'                => '9876543210',
            'spmb_banten_number'  => '9876543210',
            'birth_date'          => '2011-06-18',
            'form_status'         => 'submitted',
            'full_name'           => 'Siswa Dua',
            'gender'              => 'P',
        ]);

        $this->post(route('ppdb.lookup'), [
            'nisn'       => '9876543210',
            'birth_date' => $reg->birth_date->format('Y-m-d'),
        ])->assertRedirect(route('ppdb.success', $reg->registration_number));

        $this->get(route('ppdb.success', $reg->registration_number))->assertOk();
        $this->get(route('ppdb.pdf', $reg->registration_number))->assertOk();
    }

    public function test_signed_pdf_url_works_without_session(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0003',
            'nisn'                => '1111111111',
            'spmb_banten_number'  => '1111111111',
            'form_status'         => 'submitted',
            'full_name'           => 'Siswa Tiga',
            'gender'              => 'L',
        ]);

        $signedUrl = URL::temporarySignedRoute(
            'ppdb.pdf',
            now()->addHour(),
            ['number' => $reg->registration_number]
        );

        $this->get($signedUrl)
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_lookup_with_revisi_status_opens_correction_form(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0004',
            'nisn'                => '2222222222',
            'spmb_banten_number'  => '2222222222',
            'birth_date'          => '2011-01-15',
            'form_status'         => 'submitted',
            'status'              => 'revisi',
            'draft_token'         => 'revision-token-abc',
            'full_name'           => 'Siswa Revisi',
            'gender'              => 'L',
        ]);

        $this->post(route('ppdb.lookup'), [
            'nisn'       => '2222222222',
            'birth_date' => $reg->birth_date->format('Y-m-d'),
        ])->assertRedirect(route('ppdb.create'));

        $this->get(route('ppdb.create'))
            ->assertOk()
            ->assertSee('Mode Perbaikan Data')
            ->assertSee('revision-token-abc')
            ->assertSee('Siswa Revisi');
    }

    public function test_stale_session_allows_new_registration_form(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0006',
            'nisn'                => '4444444444',
            'spmb_banten_number'  => '4444444444',
            'birth_date'          => '2011-03-20',
            'form_status'         => 'submitted',
            'status'              => 'pending',
            'draft_token'         => 'pending-token-abc',
            'full_name'           => 'Siswa Pending',
            'gender'              => 'L',
        ]);

        $this->post(route('ppdb.lookup'), [
            'nisn'       => '4444444444',
            'birth_date' => $reg->birth_date->format('Y-m-d'),
        ])->assertRedirect(route('ppdb.success', $reg->registration_number));

        $this->withSession(['ppdb_access' => $reg->registration_number])
            ->get(route('ppdb.create'))
            ->assertOk()
            ->assertDontSee('Siswa Pending', false);
    }

    public function test_revisi_form_keeps_submitted_data(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0007',
            'nisn'                => '5555555555',
            'spmb_banten_number'  => '5555555555',
            'birth_date'          => '2011-04-10',
            'form_status'         => 'submitted',
            'status'              => 'revisi',
            'draft_token'         => 'revision-token-data',
            'full_name'           => 'Siswa Data Lengkap',
            'nik'                 => '3201010101010001',
            'gender'              => 'L',
            'address'             => 'Jl. Merdeka No. 10',
        ]);

        $this->withSession(['ppdb_access' => $reg->registration_number])
            ->get(route('ppdb.create'))
            ->assertOk()
            ->assertSee('Mode Perbaikan Data')
            ->assertSee('5555555555', false)
            ->assertSee('Siswa Data Lengkap', false)
            ->assertSee('Jl. Merdeka No. 10', false)
            ->assertSee('revision-token-data', false);
    }

    public function test_fresh_form_renders_helper_controls(): void
    {
        $this->seed();

        $this->get(route('ppdb.create'))
            ->assertOk()
            ->assertSee('Mulai Formulir Baru', false)
            ->assertSee('restoreBanner', false)
            ->assertSee('stepWarning', false)
            ->assertSee('createUrl', false)
            ->assertDontSee('<footer', false);
    }

    public function test_check_spmb_allows_own_number_during_revision(): void
    {
        $this->seed();

        $reg = PpdbRegistration::factory()->create([
            'registration_number' => 'DAFTAR-2026-0005',
            'nisn'                => '3333333333',
            'spmb_banten_number'  => '3333333333',
            'form_status'         => 'submitted',
            'status'              => 'revisi',
            'draft_token'         => 'revision-token-xyz',
            'full_name'           => 'Siswa Cek Spmb',
            'gender'              => 'L',
        ]);

        $this->withSession(['ppdb_access' => $reg->registration_number])
            ->get(route('ppdb.check-spmb', [
                'spmb_banten_number' => '3333333333',
                'draft_token'        => 'revision-token-xyz',
            ]))
            ->assertOk()
            ->assertJson(['available' => true]);
    }
}
