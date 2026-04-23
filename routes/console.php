<?php

use App\Models\Registration;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('registrations:mark-local-dummy {--dry-run : Show the impact without writing changes}', function () {
    if (! app()->environment('local')) {
        $this->error('Command is blocked: this command can only run in APP_ENV=local.');

        return Command::FAILURE;
    }

    $total = Registration::count();

    if ($total === 0) {
        $this->info('No registration rows found. Nothing to sanitize.');

        return Command::SUCCESS;
    }

    $this->line('Rows found: '.$total);

    if ($this->option('dry-run')) {
        $sample = Registration::query()
            ->latest('id')
            ->limit(5)
            ->get(['id', 'name', 'email', 'nrp', 'phone'])
            ->map(function (Registration $row): array {
                $id = (int) $row->id;

                return [
                    'id' => $id,
                    'new_name' => 'DUMMY USER '.$id,
                    'new_email' => 'dummy+'.$id.'@example.test',
                    'new_nrp' => str_pad((string) (9000000000 + $id), 10, '0', STR_PAD_LEFT),
                    'new_phone' => '0800000'.str_pad((string) $id, 4, '0', STR_PAD_LEFT),
                ];
            })
            ->all();

        $this->table(['id', 'new_name', 'new_email', 'new_nrp', 'new_phone'], $sample);
        $this->warn('Dry run only: no data was changed.');

        return Command::SUCCESS;
    }

    DB::transaction(function (): void {
        Registration::query()
            ->select(['id', 'has_allergy'])
            ->orderBy('id')
            ->chunkById(200, function ($rows): void {
                foreach ($rows as $row) {
                    $id = (int) $row->id;
                    $hasAllergy = (bool) $row->has_allergy;

                    Registration::query()
                        ->whereKey($id)
                        ->update([
                            'name' => 'DUMMY USER '.$id,
                            'email' => 'dummy+'.$id.'@example.test',
                            'nrp' => str_pad((string) (9000000000 + $id), 10, '0', STR_PAD_LEFT),
                            'phone' => '0800000'.str_pad((string) $id, 4, '0', STR_PAD_LEFT),
                            'allergy_description' => $hasAllergy ? 'Data dummy lokal' : null,
                            'ip_address' => '127.0.0.1',
                            'user_agent' => 'local-dummy-command',
                            'updated_at' => now(),
                        ]);
                }
            });
    });

    $this->info('Done. All local registration rows are now sanitized as dummy data.');

    return Command::SUCCESS;
})->purpose('Sanitize local registration rows into deterministic dummy values');
