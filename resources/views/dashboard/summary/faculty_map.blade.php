@extends('dashboard.layouts.app')

@section('content')
    <div style="margin-bottom: 16px; display:flex; align-items:center; gap:10px;">
        <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary" style="padding:8px 12px; font-size:13px;">← Kembali</a>
        <div>
            <h2 style="margin:0 0 2px;">Pemetaan Fakultas, Departemen &amp; Prodi</h2>
            <div class="muted">Data hierarki akademik ITS yang digunakan pada form pendaftaran.</div>
        </div>
    </div>

    @foreach ($itsData as $fakultas => $departments)
        <details style="margin-bottom: 10px; border: 1px solid #d8e0f3; border-radius: 10px; overflow: hidden;">
            <summary style="padding: 12px 16px; background: #f0f4ff; cursor: pointer; font-weight: 700; font-size: 14px; color: #1f2a44; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                <span>🏫 {{ $fakultas }}</span>
                <span class="muted" style="font-size:12px; font-weight:400;">{{ count($departments) }} Departemen</span>
            </summary>
            <div style="padding: 0;">
                @foreach ($departments as $dept => $prodis)
                    <div style="border-top: 1px solid #e7ebf7; padding: 10px 16px;">
                        <div style="font-weight: 600; font-size: 13px; color: #1f4fe0; margin-bottom: 6px;">📂 {{ $dept }}</div>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($prodis as $prodi)
                                <li style="font-size: 13px; color: #374470; padding: 3px 0;">{{ $prodi }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </details>
    @endforeach
@endsection
