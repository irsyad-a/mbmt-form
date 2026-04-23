@extends('dashboard.layouts.app')

@section('content')
    {{-- ===================== SUMMARY & PENGATURAN PANEL ===================== --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 20px;">

        <a href="{{ route('dashboard.summary.faculty_map') }}" style="text-decoration:none;">
            <div style="padding: 16px; border: 1px solid #d8e0f3; border-radius: 10px; background: #f8faff; display:flex; gap:12px; align-items:center; transition: box-shadow 0.2s, transform 0.2s;" onmouseover="this.style.boxShadow='0 4px 18px rgba(31,79,224,0.13)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
                <div style="font-size:28px; line-height:1;">🏫</div>
                <div>
                    <div style="font-weight:700; font-size:14px; color:#1f2a44;">Pemetaan Fakultas</div>
                    <div class="muted" style="margin-top:3px;">Hierarki Fakultas → Dept → Prodi</div>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.summary.allergy_map') }}" style="text-decoration:none;">
            <div style="padding: 16px; border: 1px solid #d8e0f3; border-radius: 10px; background: #f8faff; display:flex; gap:12px; align-items:center; transition: box-shadow 0.2s, transform 0.2s;" onmouseover="this.style.boxShadow='0 4px 18px rgba(31,79,224,0.13)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
                <div style="font-size:28px; line-height:1;">🤧</div>
                <div>
                    <div style="font-weight:700; font-size:14px; color:#1f2a44;">Pemetaan Alergi</div>
                    <div class="muted" style="margin-top:3px;">Daftar pendaftar dengan alergi</div>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.summary.ukm_transparency') }}" style="text-decoration:none;">
            <div style="padding: 16px; border: 1px solid #d8e0f3; border-radius: 10px; background: #f8faff; display:flex; gap:12px; align-items:center; transition: box-shadow 0.2s, transform 0.2s;" onmouseover="this.style.boxShadow='0 4px 18px rgba(31,79,224,0.13)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
                <div style="font-size:28px; line-height:1;">📊</div>
                <div>
                    <div style="font-weight:700; font-size:14px; color:#1f2a44;">Transparansi UKM</div>
                    <div class="muted" style="margin-top:3px;">Status kuota & copy template WA</div>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.form_settings.index') }}" style="text-decoration:none;">
            <div style="padding: 16px; border: 1px solid #d8e0f3; border-radius: 10px; background: #fff8f0; display:flex; gap:12px; align-items:center; transition: box-shadow 0.2s, transform 0.2s;" onmouseover="this.style.boxShadow='0 4px 18px rgba(224,120,31,0.13)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
                <div style="font-size:28px; line-height:1;">⚙️</div>
                <div>
                    <div style="font-weight:700; font-size:14px; color:#1f2a44;">Buka / Tutup Form</div>
                    <div class="muted" style="margin-top:3px;">Toggle & deadline pendaftaran</div>
                </div>
            </div>
        </a>

    </div>

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
