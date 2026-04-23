<?php

namespace App\Console\Commands;

use App\Models\Gateways;
use App\Models\Plan;
use App\Models\UserOrder;
use App\Services\PaymentGateways\TapService;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription as Subscriptions;

class TapRenewSubscriptionsCommand extends Command
{
    protected $signature = 'tap:renew-subscriptions {--dry-run : Do not create charges, only log what would happen} {--subscription-id= : Force renew a specific subscription id (Tap only)} {--force : When used with --subscription-id, ignore ends_at/auto_renewal checks}';

    protected $description = 'Charge and renew expiring Tap subscriptions (merchant initiated)';

    public function handle(): int
    {
        $gateway = Gateways::query()->where('code', 'tap')->where('is_active', 1)->first();
        if (! $gateway) {
            $this->info('Tap gateway not active.');

            return self::SUCCESS;
        }

        $now = Carbon::now();

        $forcedId = $this->option('subscription-id');
        if ($forcedId !== null) {
            $subscription = Subscriptions::query()->where('paid_with', 'tap')->where('id', $forcedId)->first();
            if (! $subscription) {
                $this->error('Tap subscription not found for id: ' . $forcedId);

                return self::FAILURE;
            }

            if (! (bool) $this->option('force')) {
                if ((int) $subscription->auto_renewal !== 1) {
                    $this->error('Subscription auto_renewal is not enabled. Set auto_renewal=1 or pass --force.');

                    return self::FAILURE;
                }
                if (! $subscription->ends_at || Carbon::parse($subscription->ends_at)->greaterThan($now)) {
                    $this->error('Subscription ends_at is not due yet. Set ends_at in the past or pass --force.');

                    return self::FAILURE;
                }
            }

            $dueSubscriptions = collect([$subscription]);
        } else {
            $base = Subscriptions::query()->where('paid_with', 'tap');
            $countAllTap = (clone $base)->count();
            $countApproved = (clone $base)->where('stripe_status', 'tap_approved')->count();
            $countAutoRenew = (clone $base)->where('stripe_status', 'tap_approved')->where('auto_renewal', 1)->count();
            $countHasEndsAt = (clone $base)->where('stripe_status', 'tap_approved')->where('auto_renewal', 1)->whereNotNull('ends_at')->count();
            $countDueByDate = (clone $base)
                ->where('stripe_status', 'tap_approved')
                ->where('auto_renewal', 1)
                ->whereNotNull('ends_at')
                ->where('ends_at', '<=', $now)
                ->count();
            $countHasIds = (clone $base)
                ->where('stripe_status', 'tap_approved')
                ->where('auto_renewal', 1)
                ->whereNotNull('ends_at')
                ->where('ends_at', '<=', $now)
                ->whereNotNull('tap_customer_id')
                ->whereNotNull('tap_card_id')
                ->whereNotNull('tap_payment_agreement_id')
                ->count();

            $dueSubscriptions = (clone $base)
                ->where('auto_renewal', 1)
                ->where('stripe_status', 'tap_approved')
                ->whereNotNull('ends_at')
                ->where('ends_at', '<=', $now)
                ->whereNotNull('tap_customer_id')
                ->whereNotNull('tap_card_id')
                ->whereNotNull('tap_payment_agreement_id')
                ->get();
        }

        if ($dueSubscriptions->isEmpty()) {
            $this->info('No Tap subscriptions due for renewal.');

            $this->line('--- Diagnostics (tap:renew-subscriptions) ---');
            $this->line('Now: ' . $now->toDateTimeString());
            $this->line('Total tap subscriptions (paid_with=tap): ' . ($countAllTap ?? 0));
            $this->line('tap_approved: ' . ($countApproved ?? 0));
            $this->line('tap_approved + auto_renewal=1: ' . ($countAutoRenew ?? 0));
            $this->line('... + ends_at not null: ' . ($countHasEndsAt ?? 0));
            $this->line('... + ends_at <= now: ' . ($countDueByDate ?? 0));
            $this->line('... + has tap_customer_id/tap_card_id/tap_payment_agreement_id: ' . ($countHasIds ?? 0));

            $sample = Subscriptions::query()
                ->where('paid_with', 'tap')
                ->orderByDesc('id')
                ->limit(5)
                ->get(['id', 'user_id', 'stripe_id', 'stripe_status', 'auto_renewal', 'ends_at', 'tap_customer_id', 'tap_card_id', 'tap_payment_agreement_id']);

            foreach ($sample as $row) {
                $this->line(json_encode($row->toArray()));
            }

            return self::SUCCESS;
        }

        $dryRun = (bool) $this->option('dry-run');

        foreach ($dueSubscriptions as $subscription) {
            try {
                $orderId = 'TAP-RENEW-' . strtoupper(Str::random(13));

                $plan = Plan::query()->where('id', $subscription->plan_id)->first();
                if (! $plan) {
                    $this->warn("Subscription {$subscription->id} has no plan. Skipping.");
                    continue;
                }

                $amount = (float) ($subscription->total_amount ?: $plan->price);

                $this->info("Renewing Tap subscription {$subscription->id} (user {$subscription->user_id}) with order {$orderId} amount {$amount}");

                if ($dryRun) {
                    continue;
                }

                UserOrder::query()->create([
                    'order_id'           => $orderId,
                    'plan_id'            => $plan->id,
                    'user_id'            => $subscription->user_id,
                    'payment_type'       => 'tap',
                    'price'              => $amount,
                    'affiliate_earnings' => 0,
                    'status'             => 'WAITING',
                    'country'            => $subscription->user()->first()?->country ?? 'Unknown',
                    'tax_rate'           => $subscription->tax_rate ?? 0,
                    'tax_value'          => $subscription->tax_value ?? 0,
                    'type'               => 'subscription-renewal',
                    'payload'            => [],
                ]);

                TapService::createRecurringChargeForSubscription(
                    gateway: $gateway,
                    subscription: $subscription,
                    reference: $orderId,
                    amount: $amount,
                );
            } catch (Exception $ex) {
                Log::error('TapRenewSubscriptionsCommand::handle() ' . $ex->getMessage());
                $this->error($ex->getMessage());
            }
        }

        return self::SUCCESS;
    }
}
