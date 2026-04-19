<?php

namespace App\Support;

class ContactPersonResolver
{
    /**
     * @var array{name: string, whatsapp_url: string}
     */
    private const SECONDARY_CONTACT = [
        'name' => 'Irsyad Akbar',
        'whatsapp_url' => 'https://wa.me/6282179119634',
    ];

    /**
     * @var array<string, array{name: string, whatsapp_url: string}>
     */
    private const PRIMARY_BY_UKM = [
        'Karate-Do' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'Kempo' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'Kendo' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'Merpati Putih (MP)' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'Muay Thai' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'Perisai Diri (PD)' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'PSHT' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'Taekwondo' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],
        'UKM Tapak Suci' => ['name' => 'Irsyad Akbar', 'whatsapp_url' => 'https://wa.me/6282179119634'],

        'IBC (Badminton)' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'ITS Basketball' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'IB (Biliard)' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'Bridge' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'Catur' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'Flag Football' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'Voli (IVB)' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'Sepakbola' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],
        'Tenis Lapangan' => ['name' => 'Dara Ghony Assyarifa Alawiyah', 'whatsapp_url' => 'https://wa.me/6285791154704'],

        'Softball' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'ITS Archery (ITSA)' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'HDE' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'GOLF' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'Tenis Meja' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'Rebana (URI)' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'Musik' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'PSM' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],
        'Teater Tiyang Alit' => ['name' => 'Dela Agatha Boru Tobing', 'whatsapp_url' => 'https://wa.me/6282131993412'],

        'UKAFO' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'UKTK' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'VSNMC' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'IAC' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'IFLS' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'KOPMA' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'KSR-PMI' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'MC' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],
        'Penalaran' => ['name' => 'Nadya Noemens Setiawan', 'whatsapp_url' => 'https://wa.me/6288230247801'],

        'Menwa' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'Pramuka' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'Robotik' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'PLH Siklus' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'TDC' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'MUN' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'UKM Automotif' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'ITS Quran Society' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
        'UKM Cyber Security' => ['name' => 'Fina Nailatul Izzah', 'whatsapp_url' => 'https://wa.me/6281278947950'],
    ];

    /**
     * @return array{name: string, whatsapp_url: string}
     */
    public static function primaryForUkm(?string $ukm): array
    {
        if ($ukm === null) {
            return self::SECONDARY_CONTACT;
        }

        $normalizedUkm = self::normalizeUkm($ukm);
        foreach (self::PRIMARY_BY_UKM as $registeredUkm => $contact) {
            if (self::normalizeUkm($registeredUkm) === $normalizedUkm) {
                return $contact;
            }
        }

        return self::SECONDARY_CONTACT;
    }

    /**
     * @return array{name: string, whatsapp_url: string}
     */
    public static function secondary(): array
    {
        return self::SECONDARY_CONTACT;
    }

    private static function normalizeUkm(string $ukm): string
    {
        $normalized = preg_replace('/\s+/u', ' ', trim($ukm)) ?? '';

        return mb_strtolower($normalized);
    }
}
