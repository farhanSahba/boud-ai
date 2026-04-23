<?php

namespace App\Domains\Marketplace\Repositories;

use App\Domains\Marketplace\MarketplaceServiceProvider;
use App\Domains\Marketplace\Repositories\Contracts\ExtensionRepositoryInterface;
use App\Models\Extension;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ExtensionRepository implements ExtensionRepositoryInterface
{
    private array $cachedLocalItems = [];

    public ?array $banners = [];

    public const APP_VERSION = 7.2;

    public function deleteCoupon(): array
    {
        return ['status' => 'success', 'message' => trans('Coupons are disabled in local marketplace mode.')];
    }

    public function storeCoupon(string $couponCode): array
    {
        return ['status' => 'success', 'message' => trans('Coupons are disabled in local marketplace mode.')];
    }

    public function licensed(array $data): array
    {
        return collect($data)
            ->reject(fn ($extension) => Str::contains($extension['slug'] ?? '', ['only-show']))
            ->values()
            ->toArray();
    }

    public function paidExtensions(): array
    {
        return [];
    }

    public function banners(): ?array
    {
        return [];
    }

    public function supportExtensions(): array
    {
        return $this->all(false);
    }

    public function extensions(): array
    {
        return $this->all(false);
    }

    public function themes(): array
    {
        return $this->all(true);
    }

    public function all(bool $isTheme = false): array
    {
        $cacheKey = $isTheme ? 'themes' : 'extensions';

        if (! array_key_exists($cacheKey, $this->cachedLocalItems)) {
            $data = $isTheme ? $this->localThemes() : $this->localExtensions();

            $this->updateExtensionsTable($data);

            $this->cachedLocalItems[$cacheKey] = $this->mergedInstalled($data);
        }

        return $this->cachedLocalItems[$cacheKey];
    }

    public function findId(int $id)
    {
        return collect($this->extensions())->where('id', $id)->first();
    }

    public function findSupport(string $slug): array
    {
        return $this->find($slug);
    }

    public function find(string $slug): array
    {
        return collect($this->supportExtensions())
            ->merge($this->themes())
            ->firstWhere('slug', $slug) ?: [];
    }

    public function install(string $slug, string $version)
    {
        return $this->localResponse([
            'status'  => 'success',
            'message' => trans('Local marketplace does not download extension archives.'),
        ]);
    }

    public function request(string $method, string $route, array $body = [], $fullUrl = null)
    {
        return $this->localResponse([
            'status'  => 'success',
            'message' => trans('Local marketplace request handled locally.'),
            'data'    => [],
        ]);
    }

    public function check($request, Closure $next)
    {
        return $next($request);
    }

    public function mergedInstalled(array $data): array
    {
        $extensions = Extension::getCache(
            static fn () => Extension::query()->get(),
            '_all'
        );

        return collect($data)
            ->map(function ($extension) use ($extensions) {
                $value = $extensions->firstWhere('slug', $extension['slug']);
                $dbVersion = $value?->version;

                return array_merge($extension, [
                    'id'         => $value?->id ?? $extension['id'],
                    'db_version' => $dbVersion,
                    'installed'  => (bool) ($value?->installed ?? false),
                    'upgradable' => $dbVersion ? $dbVersion !== $extension['version'] : false,
                ]);
            })
            ->sortBy('id')
            ->values()
            ->toArray();
    }

    private function updateExtensionsTable(array $data): void
    {
        if (! Schema::hasTable('extensions')) {
            return;
        }

        foreach ($data as $extension) {
            $values = [
                'version'  => $extension['version'],
                'is_theme' => $extension['is_theme'],
            ];

            $values = collect($values)
                ->filter(fn ($value, $column) => Schema::hasColumn('extensions', $column))
                ->toArray();

            Extension::query()->firstOrCreate(
                [
                    'slug'     => $extension['slug'],
                    'is_theme' => $extension['is_theme'],
                ],
                $values + ['installed' => false]
            );

            Extension::query()
                ->where('slug', $extension['slug'])
                ->where('is_theme', $extension['is_theme'])
                ->update($values);
        }

        Extension::forgetCache();
    }

    public function appKey(): string
    {
        return md5((string) config('app.key'));
    }

    public function licenseType(): string
    {
        return 'Local License';
    }

    public function domainKey(): string
    {
        return 'local';
    }

    public function subscription()
    {
        return $this->localResponse([
            'data'             => null,
            'payment'          => false,
            'extensionPayment' => '',
        ]);
    }

    public function subscriptionPayment(): string
    {
        return '';
    }

    public function appVersion(): bool|string|int
    {
        $file = base_path('version.txt');

        if (file_exists($file)) {
            return trim((string) file_get_contents($file));
        }

        return self::APP_VERSION;
    }

    public function cart(): ?array
    {
        return ['data' => []];
    }

    public function findBySlugInDb(string $slug): Model|Builder|null
    {
        $item = $this->find($slug);

        return Extension::query()->firstOrCreate(
            [
                'slug'     => $slug,
                'is_theme' => (bool) data_get($item, 'is_theme', false),
            ],
            [
                'version'   => data_get($item, 'version'),
                'installed' => false,
            ]
        );
    }

    public function blacklist(): bool
    {
        return false;
    }

    private function localExtensions(): array
    {
        $providerFolders = $this->providerFolders();

        return collect(File::directories(app_path('Extensions')))
            ->map(function (string $directory) use ($providerFolders) {
                $manifestPath = $directory . DIRECTORY_SEPARATOR . 'extension.json';

                if (! File::exists($manifestPath)) {
                    return null;
                }

                $manifest = json_decode((string) File::get($manifestPath), true) ?: [];
                $folder = basename($directory);
                $slug = $providerFolders[$folder] ?? Str::kebab($folder);

                return $this->baseItem(
                    slug: $slug,
                    name: data_get($manifest, 'name', Str::headline($folder)),
                    version: (string) data_get($manifest, 'version', '1.0.0'),
                    description: data_get($manifest, 'description', Str::headline($folder)),
                    isTheme: false,
                    folder: $folder
                );
            })
            ->filter()
            ->values()
            ->toArray();
    }

    private function localThemes(): array
    {
        return collect(File::directories(resource_path('views')))
            ->map(function (string $directory) {
                $manifestPath = $directory . DIRECTORY_SEPARATOR . 'theme.json';

                if (! File::exists($manifestPath)) {
                    return null;
                }

                $manifest = json_decode((string) File::get($manifestPath), true) ?: [];
                $slug = data_get($manifest, 'name', basename($directory));

                return $this->baseItem(
                    slug: $slug,
                    name: Str::headline($slug),
                    version: (string) data_get($manifest, 'version', '1.0.0'),
                    description: data_get($manifest, 'description', Str::headline($slug) . ' theme'),
                    isTheme: true,
                    folder: $slug,
                    themeType: data_get($manifest, 'theme_type', 'All')
                );
            })
            ->filter()
            ->values()
            ->toArray();
    }

    private function baseItem(
        string $slug,
        string $name,
        string $version,
        string $description,
        bool $isTheme,
        string $folder,
        string $themeType = 'All'
    ): array {
        $icon = asset('themes/default/assets/img/default-ai-img.png');

        return [
            'id'                 => abs(crc32($slug . ($isTheme ? '-theme' : '-extension'))),
            'slug'               => $slug,
            'name'               => $name,
            // Marketplace blades expect "single" or "bundle" item types.
            'type'               => 'single',
            'version'            => $version,
            'description'        => $description,
            'detail'             => e($description),
            'category'           => $isTheme ? 'Theme' : 'Local Extension',
            'categories'         => [$isTheme ? 'Local theme' : 'Local extension', 'No external download', 'No license check'],
            'badge'              => 'Local',
            'price'              => 0,
            'fake_price'         => 0,
            'price_id'           => null,
            'review'             => 5,
            'is_featured'        => false,
            'image'              => $icon,
            'image_url'          => $icon,
            'icon'               => $icon,
            'youtube'            => null,
            'questions'          => [],
            'only_premium'       => false,
            'relatedExtensions'  => [],
            'bundleExtensions'   => [],
            'bundle_discount_percent' => 0,
            'parent'             => null,
            'extension'          => [],
            'extension_id'       => null,
            'licensed'           => true,
            'is_buy'             => false,
            'only_show'          => false,
            'check_subscription' => false,
            'is_theme'           => $isTheme,
            'theme_type'         => $themeType,
            'extension_folder'   => $folder,
            'support'            => ['support' => true],
            'routes'             => [
                'payment'            => '',
                'paymentJson'        => '',
                'paymentSupport'     => '',
                'preview'            => $isTheme ? url('/') : '',
                'redirect'           => '',
                'cart-add-or-delete' => '',
            ],
        ];
    }

    private function providerFolders(): array
    {
        return collect(MarketplaceServiceProvider::getExtensionProviders())
            ->mapWithKeys(function (string $provider, string $slug) {
                if (! preg_match('/\\\\Extensions\\\\([^\\\\]+)\\\\/', $provider, $matches)) {
                    return [];
                }

                return [$matches[1] => $slug];
            })
            ->toArray();
    }

    private function localResponse(array $payload, int $status = 200): object
    {
        return new class($payload, $status)
        {
            public function __construct(private array $payload, private int $status) {}

            public function ok(): bool
            {
                return $this->status >= 200 && $this->status < 300;
            }

            public function successful(): bool
            {
                return $this->ok();
            }

            public function failed(): bool
            {
                return ! $this->ok();
            }

            public function json(?string $key = null)
            {
                return $key ? data_get($this->payload, $key) : $this->payload;
            }

            public function body(): string
            {
                return json_encode($this->payload);
            }
        };
    }
}
