<?php

namespace Tests\Feature;

use App\Mail\DashboardMailTestMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DashboardMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_mail_test_requires_login(): void
    {
        $response = $this->post(route('dashboard.mail.test'), [
            'test_email' => 'receiver@example.com',
        ]);

        $response->assertRedirect(route('dashboard.login'));
    }

    public function test_dashboard_mail_test_can_send_email_when_logged_in(): void
    {
        Mail::fake();

        $response = $this
            ->withSession(['dashboard.authenticated' => true])
            ->post(route('dashboard.mail.test'), [
                'test_email' => 'receiver@example.com',
            ]);

        $response
            ->assertRedirect(route('dashboard.registrations.index'))
            ->assertSessionHas('status');

        Mail::assertSent(DashboardMailTestMessage::class, function (DashboardMailTestMessage $mailMessage): bool {
            return $mailMessage->hasTo('receiver@example.com');
        });
    }
}
