<?php

namespace App\Http\Controllers;

use App\Domains\Entity\Contracts\EntityDriverInterface;
use App\Domains\Entity\Contracts\WithCreditInterface;
use App\Domains\Entity\EntityStats;
use App\Enums\Roles;
use App\Helpers\Classes\Helper;
use App\Helpers\Classes\InstallationHelper;
use App\Models\Setting;
use App\Models\User;
use App\Services\Common\MenuService;
use App\Services\Extension\ExtensionService;
use App\Services\Theme\ThemeService;
use Database\Seeders\EngineSeeder;
use Database\Seeders\EntitySeeder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InstallationController extends Controller
{
    public function __construct(
        public ExtensionService $extensionService,
        public ThemeService $themeService
    ) {}

    public function envFileEditor()
    {
        $db_ready = 0;

        try {
            DB::connection()->getPdo();
            $db_set = 1;
        } catch (Exception $e) {
            $db_set = 2;
        }
        if ($db_set == 1) {
            if (Schema::hasTable('migrations')) {
                $db_ready = 1;
            }
        } else {
            $db_ready = 0;
        }

        if ($db_ready == 0) {
            return view('vendor.installer.env_file_editor');
        }

        if (Auth::check() && Auth::user()?->isAdmin()) {
            return view('vendor.installer.env_file_editor');
        }

        abort(404);
    }

    public function envFileEditorSave(Request $request)
    {
        $validated = $request->validate([
            'app_name'            => 'required|string|max:255',
            'environment'         => 'required|string|in:production,local,staging',
            'app_debug'           => 'required|string|in:true,false',
            'app_url'             => 'required|url|max:255',
            'database_hostname'   => 'required|string|max:255',
            'database_name'       => 'required|string|max:255',
            'database_username'   => 'required|string|max:255',
            'database_password'   => 'nullable|string',
            'mail_mailer'         => 'required|string|max:50',
            'mail_host'           => 'nullable|string|max:255',
            'mail_port'           => 'nullable|string|max:10',
            'mail_username'       => 'nullable|string|max:255',
            'mail_password'       => 'nullable|string',
            'mail_encryption'     => 'nullable|string|max:50',
            'mail_from_address'   => 'nullable|string|max:255',
            'mail_from_name'      => 'nullable|string|max:255',
        ]);

        $envFileData =
            'APP_NAME="' . $validated['app_name'] . '"' . "\n" .
            'APP_ENV=' . $validated['environment'] . "\n" .
            'APP_KEY=' . 'base64:' . base64_encode(Str::random(32)) . "\n" .
            'APP_DEBUG=' . $validated['app_debug'] . "\n" .
            'APP_URL=' . $validated['app_url'] . "\n\n" .
            'LOG_CHANNEL=stack' . "\n" .
            'LOG_DEPRECATIONS_CHANNEL=null' . "\n" .
            'LOG_LEVEL=debug' . "\n\n" .
            'DB_CONNECTION=' . 'mysql' . "\n" .
            'DB_HOST=' . $validated['database_hostname'] . "\n" .
            'DB_PORT=' . '3306' . "\n" .
            'DB_DATABASE=' . $validated['database_name'] . "\n" .
            'DB_USERNAME=' . $validated['database_username'] . "\n" .
            'DB_PASSWORD="' . ($validated['database_password'] ?? '') . '"' . "\n\n" .
            'BROADCAST_DRIVER=' . 'log' . "\n" .
            'CACHE_DRIVER=' . 'file' . "\n" .
            'FILESYSTEM_DISK=' . 'local' . "\n" .
            'SESSION_DRIVER=' . 'file' . "\n" .
            'SESSION_LIFETIME=' . '120' . "\n" .
            'QUEUE_CONNECTION=' . 'sync' . "\n\n" .
            'MEMCACHED_HOST=' . '127.0.0.1' . "\n\n" .
            'REDIS_HOST=' . '127.0.0.1' . "\n" .
            'REDIS_PASSWORD=' . 'null' . "\n" .
            'REDIS_PORT=' . '6379' . "\n\n" .
            'MAIL_MAILER=' . $validated['mail_mailer'] . "\n" .
            'MAIL_HOST=' . ($validated['mail_host'] ?? '') . "\n" .
            'MAIL_PORT=' . ($validated['mail_port'] ?? '') . "\n" .
            'MAIL_USERNAME=' . ($validated['mail_username'] ?? '') . "\n" .
            'MAIL_PASSWORD="' . ($validated['mail_password'] ?? '') . '"' . "\n" .
            'MAIL_ENCRYPTION=' . ($validated['mail_encryption'] ?? '') . "\n" .
            'MAIL_FROM_ADDRESS="' . ($validated['mail_from_address'] ?? '') . '"' . "\n" .
            'MAIL_FROM_NAME="' . ($validated['mail_from_name'] ?? $validated['app_name']) . '"' . "\n\n" .
            'AWS_ACCESS_KEY_ID=' . "\n" .
            'AWS_SECRET_ACCESS_KEY=' . "\n" .
            'AWS_DEFAULT_REGION=us-east-1' . "\n" .
            'AWS_BUCKET=' . "\n" .
            'AWS_USE_PATH_STYLE_ENDPOINT=false' . "\n\n" .
            'PUSHER_APP_ID=' . '' . "\n" .
            'PUSHER_APP_KEY=' . '' . "\n" .
            'PUSHER_APP_SECRET=' . '' . "\n" .
            'PUSHER_HOST=' . "\n" .
            'PUSHER_PORT=443' . "\n" .
            'PUSHER_SCHEME=https' . "\n" .
            'PUSHER_APP_CLUSTER=mt1' . "\n\n" .
            'VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"' . "\n" .
            'VITE_PUSHER_HOST="${PUSHER_HOST}"' . "\n" .
            'VITE_PUSHER_PORT="${PUSHER_PORT}"' . "\n" .
            'VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"' . "\n" .
            'VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"' . "\n";

        try {
            $envPath = base_path('.env');
            file_put_contents($envPath, $envFileData);
            $request->flash();

            return redirect()->route('installer.install');
        } catch (Exception $e) {
            echo 'Cannot update .env file. Please update file manually in order to run this script. Need help? <br> <a href="https://liquidthemes.freshdesk.com/support/tickets/new">Submit a Ticket</a>';
        }
    }

    public function install(Request $request)
    {

        try {
            $dbconnect = DB::connection()->getPDO();
            $dbname = DB::connection()->getDatabaseName();
        } catch (Exception $e) {
            return redirect()->route('installer.envEditor');
        }

        if (! Schema::hasTable('migrations')) {
            Artisan::call('migrate', [
                '--force' => true,
            ]);
            Artisan::call('db:seed', [
                '--force' => true,
            ]);
        } else {
            return redirect()->route('index');
        }

        if (! Schema::hasTable('activity')) {
            return 'You are using Plesk for Bued AI. It requires MariaDB 10.X or Mysql 5.6,5.7. Please check your MariaDB or MySQL version. After upgrading your database, please reset the table.';
        }

        // First Startup of Script
        $settings = Setting::getCache();
        if ($settings == null) {
            $settings = new Setting;
            $settings->save();
        }

        $adminUser = User::where('type', Roles::SUPER_ADMIN->value)->first();
        if ($adminUser === null) {
            $adminUser = new User;
            $adminUser->name = 'Admin';
            $adminUser->surname = 'Admin';
            $adminUser->email = 'admin@admin.com';
            $adminUser->phone = '5555555555';
            $adminUser->type = Roles::SUPER_ADMIN->value;
            $adminUser->password = '$2y$10$XptdAOeFTxl7Yx2KmyfEluWY9Im6wpMIHoJ9V5yB96DgQgTafzzs6';
            $adminUser->status = 1;
            $adminUser->affiliate_code = 'P60NPGHAAFGD';
            $adminUser->save();
        }

        // make sure the entity and engines are seeded
        app(EntitySeeder::class)->run();
        app(EngineSeeder::class)->run();

        EntityStats::all()->map(function ($entity) use ($adminUser) {
            return $entity->forUser($adminUser)->list()->each(function (EntityDriverInterface&WithCreditInterface $entity) {
                return $entity->setDefaultCreditForDemo();
            });
        });

        Auth::login($adminUser);

        return redirect()->route('dashboard.admin.settings.general');
    }

    public function upgrade()
    {
        $version = 1.15;

        $currentVersion = Setting::getCache()->script_version;

        if ($version > $currentVersion) {
            if (! Schema::hasTable('migrations')) {
                return 'Bued AI is not installed. Install it first. Go to /install';
            }

            Artisan::call('migrate', [
                '--force' => true,
            ]);

            $settings = Setting::getCache();
            $settings->script_version = $version;
            $settings->save();

            return "<p>Bued AI updated to version: $version. You can go home now. The 1.20 update is for testing. If you want to contribute to this system, please go to admin and use the update menu to test the auto-update system.
<br>This is the last version for updates.
";
        }

        return 'Your system is at final version. This method is deprecated please update via admin panel.';
    }

    public function updateManual(Request $request)
    {
        $version = '10.40';

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        $check = $request->pass ?? true;
        // Run the installation
        InstallationHelper::runInstallation($check);

        File::put(base_path() . '/version.txt', $version);

        $settings = Setting::getCache();
        $settings->script_version = $version;
        $settings->save();

        Artisan::call('optimize:clear');

        return "<p>Bued AI updated to version: $version. Please don't forget to clear your browser cache. You can close this window.";
    }

    public function updateManual2(): string
    {
        return $this->updateManual(false);
    }

    public function installTheme($slug)
    {
        if (Helper::appIsDemo()) {
            return back()
                ->with([
                    'message' => __('This feature is disabled in Demo version.'),
                    'type'    => 'error',
                ]);
        }

        try {
            $data = $this->themeService->install($slug);

            if ($data['status']) {
                return redirect()->back()
                    ->with([
                        'message' => $data['message'],
                        'type'    => 'success',
                    ]);
            }

            return response()
                ->error(
                    $data['message'],
                    500
                );
        } catch (Exception $exception) {
            return response()
                ->error(
                    $exception->getMessage(),
                    500
                );
        }
    }

    public function installExtension($slug)
    {
        if (Helper::appIsDemo()) {
            return back()
                ->with([
                    'message' => __('This feature is disabled in Demo version.'),
                    'type'    => 'error',
                ]);
        }

        try {
            $data = $this->extensionService->install($slug);

            if ($data['status']) {
                return response()->json($data);
            }

            return response()
                ->error(
                    $data['message'],
                    500
                );
        } catch (Exception $exception) {
            return response()
                ->error(
                    $exception->getMessage(),
                    500
                );
        }
    }

    public function uninstallExtension($slug)
    {
        if (Helper::appIsDemo()) {
            return back()->with(['message' => __('This feature is disabled in Demo version.'), 'type' => 'error']);
        }

        try {
            $data = $this->extensionService->uninstall($slug);

            if ($data['status']) {
                return response()->json($data);
            }

            return response()
                ->error(
                    $data['message'],
                    500
                );
        } catch (Exception $exception) {
            return response()
                ->error(
                    $exception->getMessage(),
                    500
                );
        }
    }

    public function menuClearCache(): \Illuminate\Http\RedirectResponse
    {
        app(MenuService::class)->regenerate();
        Artisan::call('optimize:clear');

        return redirect()->route('dashboard.index')->with(['message' => __('Menu cache cleared successfully.'), 'type' => 'success']);
    }
}
