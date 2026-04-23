<?php

namespace App\Domains\Marketplace\Services;

use App\Domains\Marketplace\Repositories\Contracts\ExtensionRepositoryInterface;
use Illuminate\Support\Facades\Artisan;

class ExtensionUninstallService
{
    public function __construct(
        public ExtensionRepositoryInterface $repository
    ) {}

    public function uninstall(string $slug): array
    {
        $extension = $this->repository->findBySlugInDb($slug);

        $responseExtension = $this->repository->find($extension->getAttribute('slug'));

        Artisan::call('cache:clear');

        $extension
            ->update([
                'installed' => 0,
                'version'   => data_get($responseExtension, 'version', $extension->getAttribute('version')),
            ]);

        return [
            'status'  => true,
            'message' => 'Extension uninstalled locally',
        ];
    }
}
