<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardAuthController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if ((bool) $request->session()->get('dashboard.authenticated', false)) {
            return redirect()->route('dashboard.registrations.index');
        }

        return view('dashboard.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $expectedUsername = (string) config('dashboard.username');
        $expectedPassword = (string) config('dashboard.password');

        if ($expectedPassword === '') {
            Log::warning('Dashboard login attempted without DASHBOARD_PASSWORD configured.');

            return back()->withErrors([
                'password' => 'Dashboard belum dikonfigurasi. Set DASHBOARD_PASSWORD di file .env.',
            ])->onlyInput('username');
        }

        $usernameMatches = hash_equals($expectedUsername, $credentials['username']);
        $passwordMatches = hash_equals($expectedPassword, $credentials['password']);

        if (! $usernameMatches || ! $passwordMatches) {
            return back()->withErrors([
                'password' => 'Username atau password dashboard tidak valid.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();
        $request->session()->put('dashboard.authenticated', true);
        $request->session()->put('dashboard.username', $expectedUsername);

        return redirect()
            ->route('dashboard.registrations.index')
            ->with('status', 'Login dashboard berhasil.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget(['dashboard.authenticated', 'dashboard.username']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.login')->with('status', 'Anda sudah logout dari dashboard.');
    }
}
