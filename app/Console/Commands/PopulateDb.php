<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PopulateDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database migrations and seed the database locally';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database migration and seeding...');

        try {
            $exitCode = Artisan::call('migrate', [
                '--seed' => true,
                '--force' => true,
            ]);

            $output = trim(Artisan::output());

            if ($output !== '') {
                $this->line($output);
            }

            if ($exitCode !== 0) {
                $this->error('Database migration and seeding failed.');

                return $exitCode;
            }

            $this->info('Database migrated and seeded successfully.');

        } catch (Exception $e) {
            $this->error('An error occurred while migrating and seeding the database:');
            $this->error($e->getMessage());

            return 1;
        }

        return 0;
    }
}
