<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:registrations,email'],
            'nrp' => ['required', 'regex:/^[0-9]{10}$/', 'unique:registrations,nrp'],
            'faculty' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'ukm' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'has_allergy' => ['required', 'boolean'],
            'allergy_description' => [
                'nullable',
                'string',
                Rule::requiredIf(fn () => (bool) $request->input('has_allergy')),
                'max:2000',
            ],
            'integrity_agreed' => ['accepted'],
        ], [
            'nrp.regex' => 'NRP harus terdiri dari tepat 10 digit angka.',
            'allergy_description.required' => 'Penjelasan alergi wajib diisi jika memilih YA.',
            'integrity_agreed.accepted' => 'Pakta Integritas wajib disetujui sebelum submit.',
        ]);

        $registration = Registration::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nrp' => $validated['nrp'],
            'faculty' => $validated['faculty'],
            'department' => $validated['department'],
            'major' => $validated['major'],
            'ukm' => $validated['ukm'],
            'phone' => $validated['phone'],
            'has_allergy' => $validated['has_allergy'],
            'allergy_description' => $validated['has_allergy'] ? $validated['allergy_description'] : null,
            'integrity_accepted_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil disimpan.',
            'id' => $registration->id,
        ], 201);
    }
}