<?php

declare(strict_types=1);

use App\Http\Controllers\BlogController;
use App\Http\Controllers\Common\CheckSubscriptionEndController;
use App\Http\Controllers\Common\ClearController;
use App\Http\Controllers\Common\DebugModeController;
use App\Http\Controllers\Common\LocaleController;
use App\Http\Controllers\Common\SitemapController;
use App\Http\Controllers\Common\UpdateApiKeyController;
use App\Http\Controllers\FontsController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Payment\PlanAndPricingController;
use App\Http\Controllers\PrivatePlanController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('language/{lang}/change', LocaleController::class)->name('language.change');

Route::any('test', [TestController::class, 'test'])->name('test');
Route::post('test', [TestController::class, 'test'])->name('test.post');
Route::get('test/stream/{model}', [TestController::class, 'stream'])->name('test.stream');

Route::view('test/chatbot', 'default.chatbot');
Route::get('default', static function () {
    return response()->noContent(

    );
})->name('default');
Route::view('account-deletion', 'default.account-deletion');
Route::middleware('checkInstallation')
    ->group(static function () {
        Route::get('', IndexController::class)->name('index');
        Route::controller(PageController::class)
            ->group(static function () {
                Route::get('privacy-policy', 'pagePrivacy')->name('pagePrivacy');
                Route::get('terms', 'pageTerms')->name('pageTerms');
                Route::get('page/{slug}', 'pageContent')->name('pageContent');
            });

        Route::controller(BlogController::class)
            ->group(static function () {
                Route::get('blog', 'index')->name('blog.index');
                Route::get('blog/{slug}', 'post')->name('blog.post');
                Route::get('blog/tag/{slug}', 'tags')->name('blog.tags');
                Route::get('blog/category/{slug}', 'categories')->name('blog.categories');
                Route::get('blog/author/{slug}', 'author')->name('blog.author');
            });

        Route::get('credit-list-partial', [PlanAndPricingController::class, 'creditListPartial'])->name('credit-list-partial');
        Route::get('team-credit-list-partial', [PlanAndPricingController::class, 'teamCreditListPartial'])->name('team-credit-list-partial');
    });

Route::get('sitemap.xml', [SitemapController::class, 'index']);
Route::get('plan/private/subscription/{key}', [PrivatePlanController::class, 'index']);
Route::get('confirm/email/{email_confirmation_code}', [MailController::class, 'emailConfirmationMail']);

Route::controller(InstallationController::class)
    ->group(static function () {
        Route::prefix('install')->name('installer.')->group(static function () {
            Route::get('/', 'envFileEditor')->name('envEditor');
            Route::post('/environment', 'envFileEditorSave')->name('envEditor.save');
            Route::get('/run', 'install')->name('install');
        });

        Route::get('upgrade-script', static fn () => abort(404))->name('upgrade-script');
        Route::get('update-manual/{pass?}', static fn () => abort(404))->name('update-manual');
        Route::get('cache-clear-menu', 'menuClearCache')->name('menuClearCache');
        Route::post('install-extension/{slug}', 'installExtension')->name('install-extension');
        Route::post('uninstall-extension/{slug}', 'uninstallExtension')->name('uninstall-extension');

    });

Route::get('clear-log', [ClearController::class, 'clearLog'])->name('clearLog');
Route::get('cache-clear', [ClearController::class, 'cacheClear'])->name('cache.clear');
Route::get('update-fonts', [FontsController::class, 'updateFontsCache']);
Route::get('debug/{token?}', DebugModeController::class)->name('debug');
if (app()->environment('local')) {
    Route::get('debug/tap-payload/{orderId}', static function (string $orderId) {
        $order = \App\Models\UserOrder::query()
            ->where('order_id', $orderId)
            ->where('payment_type', 'tap')
            ->first();

        if (! $order) {
            abort(404);
        }

        $subscription = \Laravel\Cashier\Subscription::query()
            ->where('stripe_id', $orderId)
            ->where('paid_with', 'tap')
            ->first();

        return response()->json([
            'order' => [
                'order_id'      => $order->order_id,
                'type'          => $order->type,
                'status'        => $order->status,
                'payment_type'  => $order->payment_type,
                'payload'       => $order->payload,
                'created_at'    => $order->created_at,
                'updated_at'    => $order->updated_at,
            ],
            'subscription' => $subscription ? [
                'id'                       => $subscription->id,
                'user_id'                  => $subscription->user_id,
                'stripe_id'                => $subscription->stripe_id,
                'stripe_status'            => $subscription->stripe_status,
                'ends_at'                  => $subscription->ends_at,
                'auto_renewal'             => $subscription->auto_renewal,
                'tap_customer_id'          => $subscription->tap_customer_id ?? null,
                'tap_card_id'              => $subscription->tap_card_id ?? null,
                'tap_payment_agreement_id' => $subscription->tap_payment_agreement_id ?? null,
                'tap_last_charge_id'       => $subscription->tap_last_charge_id ?? null,
                'created_at'               => $subscription->created_at,
                'updated_at'               => $subscription->updated_at,
            ] : null,
        ]);
    })->name('debug.tap.payload');
}
Route::get('keys/{provider}/{secret}/{newKey}', UpdateApiKeyController::class)->middleware(['auth', 'admin']);
Route::get('check-subscription-end', CheckSubscriptionEndController::class)->name('check-subscription-end');

if (file_exists(base_path('routes/custom_routes_web.php'))) {
    include base_path('routes/custom_routes_web.php');
}

require __DIR__ . '/auth.php';
require __DIR__ . '/panel.php';
require __DIR__ . '/webhooks.php';
