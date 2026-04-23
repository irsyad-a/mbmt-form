@extends('dashboard.layouts.app')

@php
    use Illuminate\Support\Carbon;
    $settings = $settings ?? ['form_open' => true, 'form_deadline' => null];
    $deadlineValue = $settings['form_deadline']
        ? Carbon::parse($settings['form_deadline'])->format('Y-m-d\TH:i')
        : '';
@endphp

@section('content')
    <div style="margin-bottom: 20px; display:flex; align-items:center; gap:10px;">
        <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary" style="padding:8px 12px; font-size:13px;">← Kembali</a>
        <div>
            <h2 style="margin:0 0 2px; display:flex; align-items:center; gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="15" cy="12" r="3"/><rect width="20" height="14" x="2" y="5" rx="7"/></g></svg>
                Pengaturan Buka / Tutup Form
            </h2>
            <div class="muted">Atur apakah form pendaftaran publik sedang menerima pendaftaran atau tidak.</div>
        </div>
    </div>

    {{-- STATUS INDICATOR --}}
    <div style="margin-bottom: 20px; padding: 16px 20px; border-radius: 12px; display:flex; align-items:center; gap:14px;
        {{ $isOpen ? 'background:#e8f7ed; border:1px solid #b5dfc5;' : 'background:#fde8e8; border:1px solid #f1bcbc;' }}">
        <div style="width:48px; height:48px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; {{ $isOpen ? 'background:#e8f7ed; color:#17663a;' : 'background:#fde8e8; color:#c62828;' }}">
            @if ($isOpen)
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path fill="currentColor" d="M21.801 10A10 10 0 1 1 17 3.335"/><path fill="currentColor" d="m9 11l3 3L22 4"/></g></svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.36 6.64A9 9 0 0 1 20.77 14M6.16 6.16a9 9 0 0 0 12.68 12.68M12 2a9 9 0 0 1 9 9M2.06 12.06A9 9 0 0 0 12 21M3.93 3.93L20.07 20.07"/></svg>
            @endif
        </div>
        <div>
            <div style="font-weight:700; font-size:18px; color:{{ $isOpen ? '#17663a' : '#c62828' }};">
                Form saat ini: {{ $isOpen ? 'TERBUKA' : 'DITUTUP' }}
            </div>
            <div style="font-size:13px; color:#5f6c8a; margin-top:3px;">
                @if ($isOpen)
                    Pendaftaran sedang berjalan. Semua submission baru akan diterima.
                @else
                    Pendaftaran ditutup. Semua submission baru akan ditolak secara otomatis.
                @endif
            </div>
            @if ($settings['form_deadline'])
                <div style="font-size:13px; margin-top:4px; color:#5f6c8a;">
                    Deadline:
                    <strong>
                        {{ \Illuminate\Support\Carbon::parse($settings['form_deadline'])
                            ->locale('id')->translatedFormat('l, d F Y H:i') }} WIB
                    </strong>
                </div>
            @endif
        </div>
    </div>

    {{-- FORM SETTINGS --}}
    <form method="POST" action="{{ route('dashboard.form_settings.update') }}">
        @csrf

        {{-- TOGGLE --}}
        <div style="margin-bottom: 20px; padding: 18px; background: #f8faff; border: 1px solid #d8e0f3; border-radius: 10px;">
            <div style="font-weight:700; font-size:14px; margin-bottom:10px;">Status Form</div>

            <label style="display:flex; align-items:center; gap:12px; cursor:pointer; user-select:none;" id="toggle-label">
                {{-- Toggle Switch --}}
                <div style="position:relative; width:52px; height:28px;" onclick="toggleFormSwitch()">
                    <input type="checkbox" name="form_open" id="form_open_check" value="1"
                           {{ $settings['form_open'] ? 'checked' : '' }}
                           style="position:absolute; opacity:0; width:0; height:0;">
                    <div id="toggle-track" style="
                        width:52px; height:28px; border-radius:14px; transition: background 0.2s;
                        background: {{ $settings['form_open'] ? '#1f4fe0' : '#ccc' }};
                        cursor:pointer; position:relative;">
                        <div id="toggle-thumb" style="
                            position:absolute; top:3px;
                            left: {{ $settings['form_open'] ? '26px' : '3px' }};
                            width:22px; height:22px; border-radius:50%; background:#fff;
                            box-shadow:0 1px 4px rgba(0,0,0,0.25); transition: left 0.2s;">
                        </div>
                    </div>
                </div>

                <span id="toggle-text" style="font-size:14px; font-weight:600; color:{{ $settings['form_open'] ? '#17663a' : '#c62828' }};">
                    {{ $settings['form_open'] ? 'Buka (Form Menerima Pendaftaran)' : 'Tutup (Form Tidak Aktif)' }}
                </span>
            </label>
        </div>

        {{-- DEADLINE --}}
        <div style="margin-bottom: 20px; padding: 18px; background: #f8faff; border: 1px solid #d8e0f3; border-radius: 10px;">
            <div style="font-weight:700; font-size:14px; margin-bottom:6px;">Batas Waktu Pendaftaran (Deadline)</div>
            <div class="muted" style="margin-bottom: 10px;">
                Setelah deadline ini, form akan otomatis ditutup meskipun toggle di atas masih "Buka".
                Kosongkan jika tidak ingin menggunakan deadline otomatis.
            </div>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <input
                    type="datetime-local"
                    name="form_deadline"
                    id="form_deadline"
                    value="{{ $deadlineValue }}"
                    style="max-width:280px;"
                >
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('form_deadline').value = ''" style="font-size:13px; padding:8px 12px;">
                    Hapus Deadline
                </button>
            </div>
            @if ($settings['form_deadline'])
                @php
                    $dl = \Illuminate\Support\Carbon::parse($settings['form_deadline']);
                    $isPast = $dl->isPast();
                @endphp
                <div style="margin-top: 10px; padding: 8px 12px; border-radius: 8px;
                    {{ $isPast ? 'background:#fde8e8; color:#c62828; border:1px solid #f1bcbc;' : 'background:#e8f7ed; color:#17663a; border:1px solid #b5dfc5;' }}
                    font-size: 13px;">
                    @if ($isPast)
                        ⏰ Deadline sudah lewat — form <strong>otomatis tertutup</strong>.
                    @else
                        ⏳ Deadline aktif. Form akan otomatis tutup pada
                        <strong>{{ $dl->locale('id')->translatedFormat('l, d F Y H:i') }} WIB</strong>
                        ({{ $dl->diffForHumans() }}).
                    @endif
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 12px 24px; font-size:15px; display:flex; align-items:center; gap:8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm-1.2 9a3 3 0 1 0 0 6a3 3 0 0 0 0-6M5 3v4a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V3"/></svg>
            Simpan Pengaturan
        </button>
    </form>

    <script>
        const checkboxEl = document.getElementById('form_open_check');
        const trackEl    = document.getElementById('toggle-track');
        const thumbEl    = document.getElementById('toggle-thumb');
        const textEl     = document.getElementById('toggle-text');

        function toggleFormSwitch() {
            checkboxEl.checked = !checkboxEl.checked;
            updateToggleUI();
        }

        function updateToggleUI() {
            const isOn = checkboxEl.checked;
            trackEl.style.background = isOn ? '#1f4fe0' : '#ccc';
            thumbEl.style.left = isOn ? '26px' : '3px';
            textEl.textContent = isOn
                ? 'Buka (Form Menerima Pendaftaran)'
                : 'Tutup (Form Tidak Aktif)';
            textEl.style.color = isOn ? '#17663a' : '#c62828';
        }
    </script>
@endsection
