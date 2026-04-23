<?php

namespace App\Domains\Marketplace\Services;

use App\Domains\Marketplace\Repositories\Contracts\ExtensionRepositoryInterface;
use App\Models\Gateways;
use Database\Seeders\MenuSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ExtensionInstallService
{
    public string $extensionInstallCache = 'new_extension_installed';

    public function __construct(
        public ZipArchive $archive,
        public ExtensionRepositoryInterface $repository
    ) {}

    public function install(string $slug): array
    {
        $extension = $this->repository->findBySlugInDb($slug);

        if ($slug === 'checkout-registration') {
            $gateway = Gateways::query()
                ->where('is_active', '0')
                ->where('code', 'stripe')
                ->first();

            if ($gateway) {
                return [
                    'status'  => false,
                    'message' => trans('This extension is not available for installation. Please activate the Stripe payment gateway first.'),
                ];
            }
        }

        $responseExtension = $this->repository->findSupport($extension->getAttribute('slug'));

        app(MenuSeeder::class)->run();

        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        $migrate = Artisan::call('migrate', ['--force' => true]);
        Artisan::call('vendor:publish', [
            '--tag'   => 'extension',
            '--force' => true,
        ]);

        $extension
            ->update([
                'installed' => 1,
                'version'   => data_get($responseExtension, 'version', $extension->getAttribute('version')),
            ]);

        Cache::remember($this->getExtensionInstallCache(), 60, function () {
            return true;
        });

        return [
            'status'  => true,
            'data'    => $migrate,
            'message' => 'Extension installed locally',
        ];
    }

    public function mkdir($folder): string
    {
        if (Storage::disk('extension')->exists($folder)) {
            return Storage::disk('extension')->path($folder);
        }

        $mkCheck = Storage::disk('extension')->makeDirectory($folder);

        $folderPath = Storage::disk('extension')->path($folder);

        File::chmod($folderPath, 0777);

        return $mkCheck ? $folderPath : '';
    }

    public function getExtensionInstallCache(): string
    {
        return $this->extensionInstallCache;
    }
}
