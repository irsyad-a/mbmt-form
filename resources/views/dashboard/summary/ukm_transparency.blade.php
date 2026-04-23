@extends('dashboard.layouts.app')

@php
    // Deadline info for WA template
    use App\Support\FormSettingsService;
    $formSettings = app(FormSettingsService::class)->get();
    $deadlineStr = $formSettings['form_deadline']
        ? \Illuminate\Support\Carbon::parse($formSettings['form_deadline'])
            ->locale('id')->translatedFormat('l, d F Y H:i') . ' WIB'
        : 'yang telah ditentukan oleh panitia';
@endphp

@section('content')
    {{-- HEADER --}}
    <div style="margin-bottom: 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary" style="padding:8px 12px; font-size:13px;">← Kembali</a>
            <div>
                <h2 style="margin:0 0 2px;">Transparansi UKM</h2>
                <div class="muted">
                    Jumlah pendaftar per UKM.
                    <strong style="color: #c62828;">{{ $belumAmanCount }}</strong> dari <strong>{{ $totalUkm }}</strong> UKM belum memenuhi kuota (min. 2 perwakilan).
                </div>
            </div>
        </div>

        {{-- Sort controls --}}
        <div style="display:flex; gap:6px; flex-wrap:wrap;">
            <a href="{{ route('dashboard.summary.ukm_transparency', ['sort' => 'name']) }}"
               class="btn {{ $sortBy === 'name' ? 'btn-primary' : 'btn-secondary' }}" style="padding:8px 12px; font-size:12px;">
                Urutkan: Nama A–Z
            </a>
            <a href="{{ route('dashboard.summary.ukm_transparency', ['sort' => 'count']) }}"
               class="btn {{ $sortBy === 'count' ? 'btn-primary' : 'btn-secondary' }}" style="padding:8px 12px; font-size:12px;">
                Urutkan: Jumlah ↓
            </a>
            <a href="{{ route('dashboard.summary.ukm_transparency', ['sort' => 'status']) }}"
               class="btn {{ $sortBy === 'status' ? 'btn-primary' : 'btn-secondary' }}" style="padding:8px 12px; font-size:12px;">
                Urutkan: Status
            </a>
        </div>
    </div>

    {{-- COPY WA BUTTON --}}
    @if ($belumAmanCount > 0)
        <div style="background: #fff8f0; border: 1px solid #fcd09e; border-radius: 10px; padding: 14px 16px; margin-bottom: 16px;">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <div>
                    <strong style="font-size:14px;">📣 Copy Template Pesan WhatsApp</strong>
                    <div class="muted" style="margin-top:3px;">Pesan siap-kirim untuk grup WhatsApp UKM yang belum aman.</div>
                </div>
                <button id="btn-copy-wa" class="btn btn-primary" onclick="copyWaTemplate()" style="background: #25D366; display:flex; align-items:center; gap:6px;">
                    <svg width="16" height="16" fill="white" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm13 0a1 1 0 0 0-1-1v9a2 2 0 0 1-2 2H4a1 1 0 0 0 1 1h8a2 2 0 0 1 2-2V5a1 1 0 0 0-1-1z"/></svg>
                    Copy Pesan WA
                </button>
            </div>

            {{-- Preview pesan --}}
            <div style="margin-top:12px;">
                <div class="muted" style="font-size:11px; margin-bottom:4px;">Preview pesan (akan di-copy ke clipboard):</div>
                <div id="wa-preview" style="background:#fff; border:1px solid #e7ebf7; border-radius:8px; padding:12px; font-size:13px; font-family: monospace; white-space: pre-wrap; line-height:1.6; color:#1f2a44; max-height: 320px; overflow-y: auto;"></div>
            </div>
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-wrap">
        <table style="min-width: 560px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama UKM</th>
                    <th style="text-align:center;">Jumlah Pendaftar</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $i => $row)
                    <tr style="{{ $row['status'] === 'belum_aman' ? 'background:#fff8f0;' : '' }}">
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $row['ukm'] }}</strong></td>
                        <td style="text-align:center; font-size:15px; font-weight:700; color:{{ $row['total'] >= 2 ? '#17663a' : '#c62828' }};">
                            {{ $row['total'] }}
                        </td>
                        <td style="text-align:center;">
                            @if ($row['status'] === 'aman')
                                <span style="display:inline-block; padding:3px 10px; border-radius:20px; background:#e8f7ed; color:#17663a; font-size:12px; font-weight:700;">
                                    ✅ Aman
                                </span>
                            @else
                                <span style="display:inline-block; padding:3px 10px; border-radius:20px; background:#fde8e8; color:#c62828; font-size:12px; font-weight:700;">
                                    ⚠️ Belum Aman
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Hidden data for JS --}}
    <script>
        const belumAmanUkm = @json(array_column($belumAmanRows, 'ukm'));
        const belumAmanCount = {{ $belumAmanCount }};
        const totalUkm = {{ $totalUkm }};
        const deadlineStr = @json($deadlineStr);

        function buildWaTemplate() {
            const now = new Date();
            const wibFormatter = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta',
                day: '2-digit', month: 'long', year: 'numeric',
                hour: '2-digit', minute: '2-digit',
                hour12: false
            });
            const nowStr = wibFormatter.format(now) + ' WIB';

            const ukmList = belumAmanUkm.map((u, i) => `${i + 1}. ${u}`).join('\n');

            // WhatsApp formatting: *bold* and _italic_
            return `*HARAP PERHATIAN UNTUK SEMUA UKM YANG ADA!!!*\n\nPanitia MBMT LMB ITS 2026 ingin memberi kabar buruk bahwa *${belumAmanCount}* dari ${totalUkm} belum mendaftaran perwakilannya ke acara MBMT LMB ITS 2026. Seperti yang kita ketahui bahwa setiap UKM Wajib mengirimkan minimal 2 perwakilan untuk mengikuti agenda MBMT LMB ITS ini.\n\nBerikut ini nama-nama UKM yang belum memenuhi syarat kuota forum MBMT LMB ITS 2026:\n${ukmList}\n\nDiharapkan untuk UKM di atas untuk segera mendaftarkan perwakilannya sebelum tanggal ${deadlineStr}.\n\nJika suatu UKM masih belum memenuhi persyaratan tersebut akan dikenakan denda sebesar Rp.20.000 per kursi yang belum terpenuhi.\n\nJIka ada pertanyaan silahkan hubungi:\n wa.me/6282179119634 (Irsyad)\n\nTerima kasih atas atensinya\n\n_Form ini dibuat secara otomatis oleh sistem pada tanggal ${nowStr}. Jika informasi ini keliru mohon konfirmasi dengan pihak bersangkutan._`;
        }

        function renderPreview() {
            const previewEl = document.getElementById('wa-preview');
            if (!previewEl) return;
            previewEl.textContent = buildWaTemplate();
        }

        function copyWaTemplate() {
            const text = buildWaTemplate();
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById('btn-copy-wa');
                const orig = btn.innerHTML;
                btn.innerHTML = '✅ Tersalin!';
                btn.style.background = '#17663a';
                setTimeout(() => {
                    btn.innerHTML = orig;
                    btn.style.background = '#25D366';
                }, 2500);
            }).catch(() => {
                // Fallback for older browsers
                const ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                alert('Pesan berhasil disalin!');
            });
        }

        document.addEventListener('DOMContentLoaded', renderPreview);
    </script>
@endsection
