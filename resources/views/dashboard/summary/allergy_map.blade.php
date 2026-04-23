@extends('dashboard.layouts.app')

@section('content')
    <div style="margin-bottom: 16px; display:flex; align-items:center; gap:10px;">
        <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary" style="padding:8px 12px; font-size:13px;">← Kembali</a>
        <div>
            <h2 style="margin:0 0 2px;">Pemetaan Alergi</h2>
            <div class="muted">Pendaftar yang memiliki alergi makanan/minuman. Total: <strong>{{ $registrations->count() }} orang</strong></div>
        </div>
    </div>

    @if ($registrations->isEmpty())
        <div style="padding: 32px; text-align: center; color: var(--muted); background: #f8faff; border: 1px solid #d8e0f3; border-radius: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" style="opacity:0.4; margin-bottom:10px;"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3L22 4M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <div>Tidak ada pendaftar yang memiliki alergi saat ini.</div>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NRP</th>
                        <th>UKM</th>
                        <th>Keterangan Alergi</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registrations as $i => $reg)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $reg->name }}</strong></td>
                            <td>{{ $reg->nrp }}</td>
                            <td>{{ $reg->ukm }}</td>
                            <td style="max-width: 300px;">{{ $reg->allergy_description ?? '-' }}</td>
                            <td class="muted">{{ $reg->created_at?->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
