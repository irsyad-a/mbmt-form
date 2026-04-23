<?php

namespace App\Http\Controllers;

use App\Support\FormSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardFormSettingsController extends Controller
{
    public function __construct(private readonly FormSettingsService $formSettings) {}

    public function index(): View
    {
        $settings = $this->formSettings->get();
        $isOpen   = $this->formSettings->isFormOpen();

        return view('dashboard.form_settings.index', [
            'settings' => $settings,
            'isOpen'   => $isOpen,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'form_deadline' => ['nullable', 'date'],
        ]);

        $formOpen    = $request->boolean('form_open');
        $formDeadline = $request->input('form_deadline')
            ? $request->date('form_deadline')?->format('Y-m-d H:i:s')
            : null;

        $this->formSettings->save([
            'form_open'     => $formOpen,
            'form_deadline' => $formDeadline,
        ]);

        return redirect()
            ->route('dashboard.form_settings.index')
            ->with('status', 'Pengaturan form berhasil disimpan.');
    }
}
