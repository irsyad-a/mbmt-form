<?php

namespace Tests\Feature;

use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardRegistrationCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_can_create_update_and_delete_registration(): void
    {
        $this->loginDashboard();

        $createPayload = $this->validPayload([
            'email' => 'create@example.com',
            'nrp' => '5024536201',
        ]);

        $this->post(route('dashboard.registrations.store'), $createPayload)
            ->assertRedirect(route('dashboard.registrations.index'));

        $this->assertDatabaseHas('registrations', [
            'email' => 'create@example.com',
            'nrp' => '5024536201',
            'has_allergy' => 1,
        ]);

        $registration = Registration::query()->where('email', 'create@example.com')->firstOrFail();

        $updatePayload = $this->validPayload([
            'name' => 'Data Sudah Diperbarui',
            'email' => 'update@example.com',
            'nrp' => '5024536202',
            'has_allergy' => '0',
            'allergy_description' => '',
        ]);

        $this->put(route('dashboard.registrations.update', $registration), $updatePayload)
            ->assertRedirect(route('dashboard.registrations.index'));

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'name' => 'Data Sudah Diperbarui',
            'email' => 'update@example.com',
            'nrp' => '5024536202',
            'has_allergy' => 0,
            'allergy_description' => null,
        ]);

        $this->delete(route('dashboard.registrations.destroy', $registration))
            ->assertRedirect(route('dashboard.registrations.index'));

        $this->assertDatabaseMissing('registrations', [
            'id' => $registration->id,
        ]);
    }

    public function test_dashboard_can_export_excel_and_pdf(): void
    {
        Registration::query()->create([
            'name' => 'Export Test',
            'email' => 'export@example.com',
            'nrp' => '5024536210',
            'faculty' => 'FSAD',
            'department' => 'Statistika',
            'major' => 'Sains Data',
            'ukm' => 'LMB',
            'phone' => '081234567899',
            'has_allergy' => false,
            'allergy_description' => null,
            'integrity_accepted_at' => now(),
        ]);

        $this->loginDashboard();

        $excelResponse = $this->get(route('dashboard.registrations.export.excel'));
        $excelResponse
            ->assertOk()
            ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $pdfResponse = $this->get(route('dashboard.registrations.export.pdf'));
        $pdfResponse
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Anisa Fitriani',
            'email' => 'anisa@example.com',
            'nrp' => '5024536200',
            'faculty' => 'FSAD - Fakultas Sains dan Analitika Data',
            'department' => 'Statistika',
            'major' => 'Sarjana Statistika (S1)',
            'ukm' => 'LMB',
            'phone' => '081234567890',
            'has_allergy' => '1',
            'allergy_description' => 'Alergi seafood',
            'integrity_accepted_at' => now()->format('Y-m-d\TH:i'),
        ], $overrides);
    }

    private function loginDashboard(): void
    {
        config()->set('dashboard.username', 'admin');
        config()->set('dashboard.password', 'secret123');

        $this->post(route('dashboard.login.store'), [
            'username' => 'admin',
            'password' => 'secret123',
        ])->assertRedirect(route('dashboard.registrations.index'));
    }
}
