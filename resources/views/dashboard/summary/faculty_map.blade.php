@extends('dashboard.layouts.app')

@section('content')
    <div style="margin-bottom: 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary" style="padding:8px 12px; font-size:13px;">← Kembali</a>
            <div>
                <h2 style="margin:0 0 2px;">Pemetaan Asal Pendaftar</h2>
                <div class="muted">
                    Fakultas, Departemen, dan Prodi yang dipilih oleh pendaftar.
                    Total: <strong>{{ $totalRegistrants }} pendaftar</strong>
                </div>
            </div>
        </div>
    </div>

    @if (empty($mapped))
        <div style="padding: 40px; text-align: center; color: var(--muted); background: #f8faff; border: 1px solid #d8e0f3; border-radius: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" style="opacity:0.4; margin-bottom:10px;"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path fill="currentColor" d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0zM22 10v6"/><path fill="currentColor" d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></g></svg>
            <div>Belum ada pendaftar. Data akan muncul di sini setelah ada yang mendaftar.</div>
        </div>
    @else
        @foreach ($mapped as $fakultas => $departments)
            @php
                $totalFak = collect($departments)->map(fn($majors) => array_sum($majors))->sum();
            @endphp
            <details open style="margin-bottom: 10px; border: 1px solid #d8e0f3; border-radius: 10px; overflow: hidden;">
                <summary style="padding: 12px 16px; background: #f0f4ff; cursor: pointer; font-weight: 700; font-size: 14px; color: #1f2a44; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span style="display:flex; align-items:center; gap:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="color:#1f4fe0; flex-shrink:0;"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path fill="currentColor" d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0zM22 10v6"/><path fill="currentColor" d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></g></svg>
                        {{ $fakultas }}
                    </span>
                    <span style="background:#1f4fe0; color:#fff; border-radius:20px; padding:2px 10px; font-size:12px; font-weight:700; flex-shrink:0;">
                        {{ $totalFak }} orang
                    </span>
                </summary>
                <div style="padding: 0;">
                    @foreach ($departments as $dept => $majors)
                        @php $totalDept = array_sum($majors); @endphp
                        <div style="border-top: 1px solid #e7ebf7; padding: 10px 16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <div style="font-weight: 600; font-size: 13px; color: #374470; display:flex; align-items:center; gap:6px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zm-10 5H4m6 0h10M6 12h.01"/></svg>
                                    {{ $dept }}
                                </div>
                                <span class="muted" style="font-size:12px;">{{ $totalDept }} orang</span>
                            </div>
                            <div class="table-wrap" style="margin-top:0;">
                                <table style="min-width:300px;">
                                    <thead>
                                        <tr>
                                            <th>Program Studi</th>
                                            <th style="text-align:center; width:80px;">Jumlah</th>
                                            <th style="width:160px;">Proporsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($majors as $major => $count)
                                            <tr>
                                                <td style="font-size:13px;">{{ $major }}</td>
                                                <td style="text-align:center; font-weight:700; color:#1f4fe0;">{{ $count }}</td>
                                                <td>
                                                    <div style="background:#e7ebf7; border-radius:4px; height:8px; overflow:hidden;">
                                                        <div style="background:#1f4fe0; height:100%; width:{{ $totalRegistrants > 0 ? round($count / $totalRegistrants * 100) : 0 }}%;"></div>
                                                    </div>
                                                    <span class="muted" style="font-size:11px;">{{ $totalRegistrants > 0 ? round($count / $totalRegistrants * 100, 1) : 0 }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </details>
        @endforeach
    @endif
@endsection
