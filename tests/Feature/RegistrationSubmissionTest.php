<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_submission_is_saved_to_database(): void
    {
        $payload = [
            'name' => 'Anisa Fitriani',
            'email' => 'anisa.fitriani@example.com',
            'nrp' => '5024536283',
            'faculty' => 'FSAD - Fakultas Sains dan Analitika Data',
            'department' => 'Statistika',
            'major' => 'Sarjana Statistika (S1)',
            'ukm' => 'KOPMA',
            'phone' => '082128373847',
            'has_allergy' => true,
            'allergy_description' => 'Alergi kacang tanah.',
            'integrity_agreed' => true,
        ];

        $response = $this->postJson(route('registrations.store'), $payload);

        $response
            ->assertCreated()
            ->assertJsonFragment(['message' => 'Registrasi berhasil disimpan.'])
            ->assertJsonPath('cp_primer.name', 'Nadya Noemens Setiawan')
            ->assertJsonPath('cp_primer.whatsapp_url', 'https://wa.me/6288230247801')
            ->assertJsonPath('cp_sekunder.name', 'Irsyad Akbar')
            ->assertJsonPath('cp_sekunder.whatsapp_url', 'https://wa.me/6282179119634');

        $this->assertDatabaseHas('registrations', [
            'email' => 'anisa.fitriani@example.com',
            'nrp' => '5024536283',
            'has_allergy' => 1,
            'allergy_description' => 'Alergi kacang tanah.',
        ]);
    }

    public function test_allergy_description_is_required_when_has_allergy_is_true(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'nrp' => '5024536284',
            'faculty' => 'FSAD - Fakultas Sains dan Analitika Data',
            'department' => 'Statistika',
            'major' => 'Sarjana Sains Data (S1)',
            'ukm' => 'LMB',
            'phone' => '081234567890',
            'has_allergy' => true,
            'allergy_description' => null,
            'integrity_agreed' => true,
        ];

        $response = $this->postJson(route('registrations.store'), $payload);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['allergy_description']);
    }
}