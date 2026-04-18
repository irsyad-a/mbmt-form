<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_login_page_can_be_opened(): void
    {
        $response = $this->get(route('dashboard.login'));

        $response->assertOk();
    }

    public function test_dashboard_index_requires_login(): void
    {
        $response = $this->get(route('dashboard.registrations.index'));

        $response->assertRedirect(route('dashboard.login'));
    }

    public function test_dashboard_user_can_login_with_config_credentials(): void
    {
        config()->set('dashboard.username', 'admin');
        config()->set('dashboard.password', 'secret123');

        $response = $this->post(route('dashboard.login.store'), [
            'username' => 'admin',
            'password' => 'secret123',
        ]);

        $response
            ->assertRedirect(route('dashboard.registrations.index'))
            ->assertSessionHas('dashboard.authenticated', true);

        $this->get(route('dashboard.registrations.index'))->assertOk();
    }
}
