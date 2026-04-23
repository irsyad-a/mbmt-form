<?php

namespace App\Http\Controllers;

use App\Mail\CommitmentDocumentMail;
use App\Mail\RegistrationSuccessMail;
use App\Models\Registration;
use App\Support\ContactPersonResolver;
use App\Support\FormSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class RegistrationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Check if form is currently accepting submissions
        /** @var FormSettingsService $formSettings */
        $formSettings = app(FormSettingsService::class);
        if (! $formSettings->isFormOpen()) {
            return response()->json([
                'message' => 'Pendaftaran sudah ditutup. Formulir ini tidak lagi menerima submission baru.',
            ], 403);
        }

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

        $primaryCp = ContactPersonResolver::primaryForUkm($registration->ukm);
        $secondaryCp = ContactPersonResolver::secondary();

        // Run email and commitment generation after response to improve submit UX latency.
        app()->terminating(function () use ($registration, $primaryCp, $secondaryCp): void {
            $this->sendRegistrationEmails($registration, $primaryCp, $secondaryCp);
        });

        return response()->json([
            'message' => 'Registrasi berhasil disimpan.',
            'id' => $registration->id,
            'ukm' => $registration->ukm,
            'link_grup' => (string) config('services.mbmt.group_link', ''),
            'cp_primer' => $primaryCp,
            'cp_sekunder' => $secondaryCp,
        ], 201);
    }

    /**
     * @param  array{name: string, whatsapp_url: string}  $primaryCp
     * @param  array{name: string, whatsapp_url: string}  $secondaryCp
     */
    private function sendRegistrationEmails(Registration $registration, array $primaryCp, array $secondaryCp): void
    {
        try {
            Mail::to($registration->email)->send(new RegistrationSuccessMail([
                'nama' => $registration->name,
                'link_grup' => (string) config('services.mbmt.group_link', ''),
                'cp_primer_nama' => $primaryCp['name'],
                'cp_primer_wa' => $primaryCp['whatsapp_url'],
                'cp_sekunder_nama' => $secondaryCp['name'],
                'cp_sekunder_wa' => $secondaryCp['whatsapp_url'],
            ]));

            Mail::to($registration->email)->send(new CommitmentDocumentMail([
                'nama' => $registration->name,
                'pdf_link' => $this->createCommitmentDocument($registration),
            ]));
        } catch (Throwable $exception) {
            Log::error('Gagal mengirim email registrasi MBMT.', [
                'registration_id' => $registration->id,
                'email' => $registration->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function createCommitmentDocument(Registration $registration): string
    {
        $directory = public_path('commitments');
        File::ensureDirectoryExists($directory, 0755, true);

        $filename = sprintf(
            'lembar-komitmen-%d-%s.txt',
            $registration->id,
            Str::lower(Str::random(12))
        );

        $content = implode(PHP_EOL, [
            'LEMBAR KOMITMEN MBMT 2026',
            '=========================',
            'Nama: '.$registration->name,
            'NRP: '.$registration->nrp,
            'Email: '.$registration->email,
            'UKM: '.$registration->ukm,
            'Departemen: '.$registration->department,
            'Waktu Persetujuan: '.($registration->integrity_accepted_at?->format('Y-m-d H:i:s') ?? '-'),
            '',
            'Dengan dokumen ini, peserta menyatakan bersedia mematuhi seluruh ketentuan MBMT 2026.',
        ]);

        File::put($directory.DIRECTORY_SEPARATOR.$filename, $content);

        $appUrl = trim((string) config('app.url'));
        if ($appUrl !== '') {
            return rtrim($appUrl, '/').'/commitments/'.$filename;
        }

        return url('/commitments/'.$filename);
    }
}
