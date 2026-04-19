<?php

namespace Tests\Unit;

use App\Support\ContactPersonResolver;
use Tests\TestCase;

class ContactPersonResolverTest extends TestCase
{
    public function test_it_resolves_primary_contact_for_exact_match(): void
    {
        $contact = ContactPersonResolver::primaryForUkm('KOPMA');

        $this->assertSame('Nadya Noemens Setiawan', $contact['name']);
        $this->assertSame('https://wa.me/6288230247801', $contact['whatsapp_url']);
    }

    public function test_it_resolves_primary_contact_for_non_standard_spacing_and_case(): void
    {
        $contact = ContactPersonResolver::primaryForUkm('   ukm   cyber   security   ');

        $this->assertSame('Fina Nailatul Izzah', $contact['name']);
        $this->assertSame('https://wa.me/6281278947950', $contact['whatsapp_url']);
    }

    public function test_it_falls_back_to_secondary_contact_for_unknown_ukm(): void
    {
        $contact = ContactPersonResolver::primaryForUkm('UKM Tidak Dikenal');

        $this->assertSame('Irsyad Akbar', $contact['name']);
        $this->assertSame('https://wa.me/6282179119634', $contact['whatsapp_url']);
    }
}
