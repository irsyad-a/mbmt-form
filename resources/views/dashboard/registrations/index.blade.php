@extends('dashboard.layouts.app')

@section('content')
    <div class="toolbar">
        <div>
            <h2 style="margin:0 0 6px;">Data Pendaftar</h2>
            <div class="muted">Kelola data registrasi, edit/hapus data, dan lakukan export.</div>
        </div>

        <div class="actions">
            <a href="{{ route('dashboard.registrations.create') }}" class="btn btn-primary">Tambah Data</a>
            <a href="{{ route('dashboard.registrations.export.excel') }}" class="btn btn-secondary">Export Excel</a>
            <a href="{{ route('dashboard.registrations.export.pdf') }}" class="btn btn-secondary">Export PDF</a>
        </div>
    </div>

    <form method="GET" action="{{ route('dashboard.registrations.index') }}" style="display:flex; gap:8px; margin-bottom:12px; flex-wrap:wrap;">
        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, email, NRP, fakultas, departemen..." style="max-width: 420px;">
        <button class="btn btn-secondary" type="submit">Cari</button>
        @if ($search !== '')
            <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NRP</th>
                    <th>Fak/Dept/Jurusan</th>
                    <th>UKM</th>
                    <th>Telp</th>
                    <th>Alergi</th>
                    <th>Pakta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $registration)
                    <tr>
                        <td>{{ $registration->id }}</td>
                        <td>{{ $registration->name }}</td>
                        <td>{{ $registration->email }}</td>
                        <td>{{ $registration->nrp }}</td>
                        <td>
                            <strong>{{ $registration->faculty }}</strong><br>
                            <span class="muted">{{ $registration->department }} | {{ $registration->major }}</span>
                        </td>
                        <td>{{ $registration->ukm }}</td>
                        <td>{{ $registration->phone }}</td>
                        <td>
                            @if ($registration->has_allergy)
                                Ya<br>
                                <span class="muted">{{ $registration->allergy_description }}</span>
                            @else
                                Tidak
                            @endif
                        </td>
                        <td>{{ optional($registration->integrity_accepted_at)?->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('dashboard.registrations.edit', $registration) }}" class="btn btn-secondary" style="margin-bottom:6px;">Edit</a>
                            <form method="POST" action="{{ route('dashboard.registrations.destroy', $registration) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="muted">Belum ada data pendaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $registrations->links() }}
    </div>
@endsection
