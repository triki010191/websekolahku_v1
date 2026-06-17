<?php

namespace Tests\Feature;

use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPpdbKartuTesTest extends TestCase
{
    use RefreshDatabase;

    public function test_kartu_tes_pdf_only_for_valid_status(): void
    {
        $this->seed();

        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->firstOrFail();

        $reg = PpdbRegistration::factory()->create([
            'form_status' => 'submitted',
            'status'      => 'pending',
            'exam_number' => null,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.ppdb.kartu-tes', $reg))
            ->assertForbidden();

        $reg->update(['status' => 'valid', 'exam_number' => 'TES-2026-0001']);

        $this->actingAs($admin)
            ->get(route('admin.ppdb.kartu-tes', $reg))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_update_status_to_valid_generates_exam_number(): void
    {
        $this->seed();

        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->firstOrFail();

        $reg = PpdbRegistration::factory()->create([
            'form_status' => 'submitted',
            'status'      => 'pending',
            'exam_number' => null,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.ppdb.status', $reg), [
                'status' => 'valid',
                'note'   => 'Data sudah sesuai',
            ])
            ->assertRedirect();

        $reg->refresh();

        $this->assertSame('valid', $reg->status);
        $this->assertNotNull($reg->exam_number);
        $this->assertMatchesRegularExpression('/^TES-\d{4}-\d{4}$/', $reg->exam_number);
    }
}
