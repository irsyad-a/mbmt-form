<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class FormSettingsService
{
    private string $path;

    public function __construct()
    {
        $this->path = storage_path('app/form_settings.json');
    }

    /**
     * @return array{form_open: bool, form_deadline: string|null}
     */
    public function get(): array
    {
        if (! File::exists($this->path)) {
            return $this->defaults();
        }

        try {
            /** @var array<string, mixed> $data */
            $data = json_decode(File::get($this->path), true, 512, JSON_THROW_ON_ERROR);

            return [
                'form_open'     => (bool) ($data['form_open'] ?? true),
                'form_deadline' => isset($data['form_deadline']) ? (string) $data['form_deadline'] : null,
            ];
        } catch (\Throwable) {
            return $this->defaults();
        }
    }

    /**
     * @param array{form_open: bool, form_deadline: string|null} $settings
     */
    public function save(array $settings): void
    {
        File::ensureDirectoryExists(dirname($this->path));
        File::put($this->path, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Returns true if the form is currently accepting submissions.
     * Considers both the manual toggle and deadline.
     */
    public function isFormOpen(): bool
    {
        $settings = $this->get();

        if (! $settings['form_open']) {
            return false;
        }

        if ($settings['form_deadline'] !== null) {
            try {
                $deadline = Carbon::parse($settings['form_deadline']);
                if (Carbon::now()->greaterThan($deadline)) {
                    return false;
                }
            } catch (\Throwable) {
                // Invalid deadline string — ignore
            }
        }

        return true;
    }

    /**
     * @return array{form_open: bool, form_deadline: string|null}
     */
    private function defaults(): array
    {
        return [
            'form_open'     => true,
            'form_deadline' => null,
        ];
    }
}
