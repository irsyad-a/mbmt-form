<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Export Registrasi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1f2a44;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 16px;
        }

        .meta {
            margin-bottom: 10px;
            font-size: 10px;
            color: #4b5d8b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #c8d0e6;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background: #eef2ff;
            font-size: 9px;
            text-transform: uppercase;
        }

        td {
            font-size: 9px;
        }
    </style>
</head>

<body>
    <h1>Data Registrasi MBMT</h1>
    <div class="meta">
        Total data: {{ $registrations->count() }} | Dibuat: {{ $generatedAt->format('d-m-Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NRP</th>
                <th>Fakultas</th>
                <th>Departemen</th>
                <th>Jurusan</th>
                <th>UKM</th>
                <th>Telepon</th>
                <th>Alergi</th>
                <th>Deskripsi</th>
                <th>Pakta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registrations as $registration)
                <tr>
                    <td>{{ $registration->id }}</td>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->nrp }}</td>
                    <td>{{ $registration->faculty }}</td>
                    <td>{{ $registration->department }}</td>
                    <td>{{ $registration->major }}</td>
                    <td>{{ $registration->ukm }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->has_allergy ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $registration->allergy_description }}</td>
                    <td>{{ optional($registration->integrity_accepted_at)?->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
