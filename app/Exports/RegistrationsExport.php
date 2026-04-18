<?php

namespace App\Exports;

use App\Models\Registration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistrationsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Registration::query()->latest()->get();
    }

    /**
     * @return list<string>
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'NRP',
            'Fakultas',
            'Departemen',
            'Jurusan',
            'UKM',
            'No. Telepon',
            'Memiliki Alergi',
            'Deskripsi Alergi',
            'Pakta Disetujui Pada',
            'IP Address',
            'User Agent',
            'Dibuat Pada',
            'Diubah Pada',
        ];
    }

    /**
     * @param  Registration  $registration
     * @return list<string|int|null>
     */
    public function map($registration): array
    {
        return [
            $registration->id,
            $registration->name,
            $registration->email,
            $registration->nrp,
            $registration->faculty,
            $registration->department,
            $registration->major,
            $registration->ukm,
            $registration->phone,
            $registration->has_allergy ? 'Ya' : 'Tidak',
            $registration->allergy_description,
            optional($registration->integrity_accepted_at)?->format('Y-m-d H:i:s'),
            $registration->ip_address,
            $registration->user_agent,
            optional($registration->created_at)?->format('Y-m-d H:i:s'),
            optional($registration->updated_at)?->format('Y-m-d H:i:s'),
        ];
    }
}
