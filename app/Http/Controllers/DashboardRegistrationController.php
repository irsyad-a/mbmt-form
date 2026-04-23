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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardRegistrationController extends Controller
{
    // ─────────────────────────────────────────────
    // ITS Data (faculty → department → major)
    // ─────────────────────────────────────────────

    /** @var array<string, array<string, list<string>>> */
    private const ITS_DATA = [
        'FSAD - Fakultas Sains dan Analitika Data' => [
            'Fisika'     => ['Sarjana Fisika (S1)'],
            'Matematika' => ['Sarjana Matematika (S1)'],
            'Statistika' => ['Sarjana Statistika (S1)', 'Sarjana Sains Data (S1)'],
            'Kimia'      => ['Sarjana Kimia (S1)', 'Sarjana Sains Analitik dan Instrumentasi Kimia (S1)'],
            'Biologi'    => ['Sarjana Biologi (S1)'],
            'Aktuaria'   => ['Sarjana Aktuaria (S1)'],
        ],
        'FTIRS - Fakultas Teknologi Industri dan Rekayasa Sistem' => [
            'Teknik Mesin'                 => ['Sarjana Teknik Mesin (S1)', 'Sarjana Rekayasa Keselamatan Proses (S1)'],
            'Teknik Kimia'                 => ['Sarjana Teknik Kimia (S1)', 'Sarjana Teknik Pangan (S1)'],
            'Teknik Fisika'                => ['Sarjana Teknik Fisika (S1)'],
            'Teknik dan Sistem Industri'   => ['Sarjana Teknik Industri (S1)'],
            'Teknik Material dan Metalurgi'=> ['Sarjana Teknik Material (S1)'],
        ],
        'FTSPK - Fakultas Teknik Sipil, Perencanaan, dan Kebumian' => [
            'Teknik Sipil'                 => ['Sarjana Teknik Sipil (S1)'],
            'Arsitektur'                   => ['Sarjana Arsitektur (S1)'],
            'Teknik Lingkungan'            => ['Sarjana Teknik Lingkungan (S1)'],
            'Teknik Geomatika'             => ['Sarjana Teknik Geomatika (S1)'],
            'Perencanaan Wilayah dan Kota' => ['Sarjana Perencanaan Wilayah dan Kota (S1)'],
            'Teknik Geofisika'             => ['Sarjana Teknik Geofisika (S1)'],
            'Teknik Pertambangan'          => ['Sarjana Teknik Pertambangan (S1)'],
        ],
        'FTK - Fakultas Teknologi Kelautan' => [
            'Teknik Perkapalan'        => ['Sarjana Teknik Perkapalan (S1)'],
            'Teknik Sistem Perkapalan' => ['Sarjana Teknik Sistem Perkapalan (S1)'],
            'Teknik Kelautan'          => ['Sarjana Teknik Kelautan (S1)'],
            'Teknik Transportasi Laut' => ['Sarjana Teknik Transportasi Laut (S1)'],
            'Teknik Lepas Pantai'      => ['Sarjana Teknik Lepas Pantai (S1)'],
        ],
        'FTEIC - Fakultas Teknologi Elektro dan Informatika Cerdas' => [
            'Teknik Elektro'    => ['Sarjana Teknik Elektro (S1)', 'Sarjana Teknik Telekomunikasi (S1)'],
            'Teknik Informatika'=> ['Sarjana Teknik Informatika (S1)', 'Sarjana Rekayasa Perangkat Lunak (S1)', 'Sarjana Rekayasa Kecerdasan Artifisial (S1)'],
            'Sistem Informasi'  => ['Sarjana Sistem Informasi (S1)', 'Sarjana Inovasi Digital (S1)'],
            'Teknik Komputer'   => ['Sarjana Teknik Komputer (S1)'],
            'Teknik Biomedik'   => ['Sarjana Teknik Biomedik (S1)'],
            'Teknologi Informasi'=> ['Sarjana Teknologi Informasi (S1)'],
        ],
        'FDKBD - Fakultas Desain Kreatif dan Bisnis Digital' => [
            'Manajemen Bisnis'         => ['Sarjana Manajemen Bisnis (S1)', 'Sarjana Bisnis Digital (S1)'],
            'Desain Produk Industri'   => ['Sarjana Desain Produk Industri (S1)'],
            'Desain Interior'          => ['Sarjana Desain Interior (S1)'],
            'Desain Komunikasi Visual' => ['Sarjana Desain Komunikasi Visual (S1)'],
            'Studi Pembangunan'        => ['Sarjana Studi Pembangunan (S1)'],
        ],
        'FV - Fakultas Vokasi' => [
            'Teknik Infrastruktur Sipil'=> ['Sarjana Terapan Teknik Sipil (D4)', 'Sarjana Terapan Teknologi Rekayasa Konstruksi Bangunan Air (D4)'],
            'Teknik Mesin Industri'     => ['Sarjana Terapan Teknologi Rekayasa Manufaktur (D4)', 'Sarjana Terapan Teknologi Rekayasa Konversi Energi (D4)'],
            'Teknik Kimia Industri'     => ['Sarjana Terapan Teknik Teknologi Rekayasa Kimia Industri (D4)'],
            'Teknik Elektro Otomasi'    => ['Sarjana Terapan Teknologi Rekayasa Otomasi (D4)'],
            'Teknik Instrumentasi'      => ['Sarjana Terapan Rekayasa Teknologi Instrumentasi (D4)'],
            'Statistika Bisnis'         => ['Sarjana Terapan Statistika Bisnis (D4)'],
        ],
        'FKK - Fakultas Kedokteran dan Kesehatan' => [
            'Kedokteran' => ['Sarjana Kedokteran (S1)', 'Sarjana Teknologi Kedokteran (S1)'],
        ],
    ];

    /** @var list<string> */
    private const UKM_LIST = [
        'Karate-Do', 'Kempo', 'Kendo', 'Merpati Putih (MP)', 'Muay Thai',
        'Perisai Diri (PD)', 'PSHT', 'Taekwondo', 'UKM Tapak Suci',
        'IBC (Badminton)', 'ITS Basketball', 'IB (Biliard)', 'Bridge', 'Catur',
        'Flag Football', 'Voli (IVB)', 'Sepakbola', 'Tenis Lapangan', 'Softball',
        'ITS Archery (ITSA)', 'HDE', 'GOLF', 'Tenis Meja', 'Rebana (URI)',
        'Musik', 'PSM', 'Teater Tiyang Alit', 'UKAFO', 'UKTK', 'VSNMC',
        'IAC', 'IFLS', 'KOPMA', 'KSR-PMI', 'MC', 'Penalaran', 'Menwa',
        'Pramuka', 'Robotik', 'PLH Siklus', 'TDC', 'MUN', 'UKM Automotif',
        'ITS Quran Society', 'UKM Cyber Security',
    ];

    // ─────────────────────────────────────────────
    // CRUD
    // ─────────────────────────────────────────────

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
            'registrations'   => $registrations,
            'search'          => $search,
            'totalCount'      => Registration::count(),
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
            'generatedAt'   => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('registrations-'.now()->format('Ymd-His').'.pdf');
    }

    // ─────────────────────────────────────────────
    // SUMMARY PAGES
    // ─────────────────────────────────────────────

    public function summaryFacultyMap(): View
    {
        return view('dashboard.summary.faculty_map', [
            'itsData' => self::ITS_DATA,
        ]);
    }

    public function summaryAllergyMap(): View
    {
        $registrations = Registration::query()
            ->where('has_allergy', true)
            ->orderBy('name')
            ->get(['id', 'name', 'nrp', 'ukm', 'allergy_description', 'created_at']);

        return view('dashboard.summary.allergy_map', [
            'registrations' => $registrations,
        ]);
    }

    public function summaryUkmTransparency(Request $request): View
    {
        $sortBy = $request->query('sort', 'name'); // name | count | status

        // Count registrations per UKM
        $counts = Registration::query()
            ->selectRaw('ukm, COUNT(*) as total')
            ->groupBy('ukm')
            ->pluck('total', 'ukm')
            ->toArray();

        // Build full list from the master UKM list
        $rows = array_map(function (string $ukm) use ($counts): array {
            $total  = (int) ($counts[$ukm] ?? 0);
            $status = $total >= 2 ? 'aman' : 'belum_aman';
            return compact('ukm', 'total', 'status');
        }, self::UKM_LIST);

        // Sort
        usort($rows, function (array $a, array $b) use ($sortBy): int {
            return match ($sortBy) {
                'count'  => $b['total'] <=> $a['total'],
                'status' => $a['status'] <=> $b['status'],
                default  => strcmp($a['ukm'], $b['ukm']),
            };
        });

        $totalUkm      = count(self::UKM_LIST);
        $belumAmanRows = array_filter($rows, fn (array $r): bool => $r['status'] === 'belum_aman');
        $belumAmanCount = count($belumAmanRows);

        return view('dashboard.summary.ukm_transparency', [
            'rows'          => $rows,
            'belumAmanRows' => array_values($belumAmanRows),
            'totalUkm'      => $totalUkm,
            'belumAmanCount'=> $belumAmanCount,
            'sortBy'        => $sortBy,
        ]);
    }

    // ─────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────

    /**
     * @return array<string, mixed>
     */
    private function validatedPayload(Request $request, ?Registration $registration = null): array
    {
        $hasAllergy = $request->boolean('has_allergy');

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('registrations', 'email')->ignore($registration?->id),
            ],
            'nrp'        => [
                'required',
                'regex:/^[0-9]{10}$/',
                Rule::unique('registrations', 'nrp')->ignore($registration?->id),
            ],
            'faculty'    => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'major'      => ['required', 'string', 'max:255'],
            'ukm'        => ['required', 'string', 'max:100'],
            'phone'      => ['required', 'string', 'max:30'],
            'has_allergy'=> ['required', 'boolean'],
            'allergy_description' => [
                'nullable',
                'string',
                Rule::requiredIf($hasAllergy),
                'max:2000',
            ],
            'integrity_accepted_at' => ['nullable', 'date'],
        ], [
            'nrp.regex'                       => 'NRP harus terdiri dari tepat 10 digit angka.',
            'allergy_description.required'    => 'Penjelasan alergi wajib diisi jika memilih YA.',
        ]);

        $integrityAcceptedAt = ! empty($validated['integrity_accepted_at'])
            ? Carbon::parse($validated['integrity_accepted_at'])
            : now();

        return [
            'name'                 => $validated['name'],
            'email'                => $validated['email'],
            'nrp'                  => $validated['nrp'],
            'faculty'              => $validated['faculty'],
            'department'           => $validated['department'],
            'major'                => $validated['major'],
            'ukm'                  => $validated['ukm'],
            'phone'                => $validated['phone'],
            'has_allergy'          => $hasAllergy,
            'allergy_description'  => $hasAllergy ? ($validated['allergy_description'] ?? null) : null,
            'integrity_accepted_at'=> $integrityAcceptedAt,
        ];
    }
}
