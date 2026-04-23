<?php

namespace App\Listeners;

use App\Actions\CreateActivity;
use App\Enums\Plan\FrequencyEnum;
use App\Events\TapLifetimeEvent;
use App\Models\UserOrder;
use App\Services\PaymentGateways\Contracts\CreditUpdater;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Subscription as Subscriptions;

class TapLifetimeListener implements ShouldQueue
{
    use CreditUpdater;
    use InteractsWithQueue;

    public bool $afterCommit = true;

    public string $queue = 'default';

    public int $delay = 0;

    public function handle(TapLifetimeEvent $event): void
    {
        try {
            $status = $event->status;
            $order_ids = $event->orderIds;

            if ($status === 'tap_approved') {
                $orders = UserOrder::whereIn('order_id', $order_ids)->get();

                foreach ($orders as $order) {
                    switch ($order->plan->frequency) {
                        case FrequencyEnum::YEARLY->value:
                        case FrequencyEnum::LIFETIME_YEARLY->value:
                            Subscriptions::where('stripe_id', $order->order_id)->update([
                                'stripe_status' => $status,
                                'ends_at'       => \Carbon\Carbon::now()->addYears(1),
                            ]);
                            $msg = __('Subscription renewed for 1 year.');
                            break;

                        case FrequencyEnum::MONTHLY->value:
                        default:
                            // FrequencyEnum::LIFETIME_MONTHLY->value
                            Subscriptions::where('stripe_id', $order->order_id)->update([
                                'stripe_status' => $status,
                                'ends_at'       => \Carbon\Carbon::now()->addMonths(1),
                            ]);
                            $msg = __('Subscription renewed for 1 month.');
                            break;
                    }

                    self::creditIncreaseSubscribePlan($order->user, $order->plan);
                    CreateActivity::for($order->user, $msg, $order->plan->name . ' ' . __('Plan'));
                }
            }
        } catch (Exception $ex) {
            Log::error("TapLifetimeListener::handle()\n" . $ex->getMessage());
        }
    }
}
