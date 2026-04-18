<?php

namespace App\Http\Controllers;

use App\Exports\RegistrationsExport;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardRegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $registrations = Registration::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $inner) use ($search): void {
                    $like = "%{$search}%";

                    $inner
                        ->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('nrp', 'like', $like)
                        ->orWhere('faculty', 'like', $like)
                        ->orWhere('department', 'like', $like)
                        ->orWhere('major', 'like', $like)
                        ->orWhere('ukm', 'like', $like)
                        ->orWhere('phone', 'like', $like);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.registrations.index', [
            'registrations' => $registrations,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('dashboard.registrations.create', [
            'registration' => new Registration(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedPayload($request);
        $payload['ip_address'] = $request->ip();
        $payload['user_agent'] = (string) $request->userAgent();

        Registration::create($payload);

        return redirect()
            ->route('dashboard.registrations.index')
            ->with('status', 'Data pendaftar berhasil ditambahkan.');
    }

    public function edit(Registration $registration): View
    {
        return view('dashboard.registrations.edit', [
            'registration' => $registration,
        ]);
    }

    public function update(Request $request, Registration $registration): RedirectResponse
    {
        $payload = $this->validatedPayload($request, $registration);

        $registration->update($payload);

        return redirect()
            ->route('dashboard.registrations.index')
            ->with('status', 'Data pendaftar berhasil diperbarui.');
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('dashboard.registrations.index')
            ->with('status', 'Data pendaftar berhasil dihapus.');
    }

    public function exportExcel(): BinaryFileResponse
    {
        $filename = 'registrations-'.now()->format('Ymd-His').'.xlsx';

        return Excel::download(new RegistrationsExport(), $filename);
    }

    public function exportPdf(): Response
    {
        $registrations = Registration::query()->latest()->get();

        $pdf = Pdf::loadView('dashboard.registrations.exports.pdf', [
            'registrations' => $registrations,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('registrations-'.now()->format('Ymd-His').'.pdf');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedPayload(Request $request, ?Registration $registration = null): array
    {
        $hasAllergy = $request->boolean('has_allergy');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('registrations', 'email')->ignore($registration?->id),
            ],
            'nrp' => [
                'required',
                'regex:/^[0-9]{10}$/',
                Rule::unique('registrations', 'nrp')->ignore($registration?->id),
            ],
            'faculty' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'ukm' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'has_allergy' => ['required', 'boolean'],
            'allergy_description' => [
                'nullable',
                'string',
                Rule::requiredIf($hasAllergy),
                'max:2000',
            ],
            'integrity_accepted_at' => ['nullable', 'date'],
        ], [
            'nrp.regex' => 'NRP harus terdiri dari tepat 10 digit angka.',
            'allergy_description.required' => 'Penjelasan alergi wajib diisi jika memilih YA.',
        ]);

        $integrityAcceptedAt = ! empty($validated['integrity_accepted_at'])
            ? Carbon::parse($validated['integrity_accepted_at'])
            : now();

        return [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nrp' => $validated['nrp'],
            'faculty' => $validated['faculty'],
            'department' => $validated['department'],
            'major' => $validated['major'],
            'ukm' => $validated['ukm'],
            'phone' => $validated['phone'],
            'has_allergy' => $hasAllergy,
            'allergy_description' => $hasAllergy ? ($validated['allergy_description'] ?? null) : null,
            'integrity_accepted_at' => $integrityAcceptedAt,
        ];
    }
}
