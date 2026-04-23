<?php

namespace App\Services\PaymentGateways;

use App\Actions\CreateActivity;
use App\Actions\EmailPaymentConfirmation;
use App\Enums\Plan\FrequencyEnum;
use App\Helpers\Classes\Helper;
use App\Models\GatewayProducts;
use App\Models\Gateways;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserOrder;
use App\Services\Contracts\BaseGatewayService;
use App\Services\PaymentGateways\Contracts\CreditUpdater;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription as Subscriptions;

class TapService implements BaseGatewayService
{
    use CreditUpdater;

    protected static string $GATEWAY_CODE = 'tap';

    protected static string $GATEWAY_NAME = 'Tap';

    private const WEBHOOK_HASH_HEADER = 'hashstring';

    private const TAP_API_BASE = 'https://api.tap.company/v2';

    private static function deleteSavedCard(string $secretKey, string $customerId, string $cardId): void
    {
        $customerId = trim($customerId);
        $cardId = trim($cardId);

        if ($customerId === '' || $cardId === '') {
            return;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->delete(self::TAP_API_BASE . '/card/' . $customerId . '/' . $cardId);

        if (! $response->successful()) {
            $body = $response->json();
            $errorDescription = (string) (data_get($body, 'errors.0.description') ?? data_get($body, 'errors.0.error') ?? '');
            $message = $errorDescription !== ''
                ? $errorDescription
                : (string) (data_get($body, 'message') ?? $response->body());

            throw new Exception('Tap delete saved card failed: ' . $message);
        }
    }

    public static function saveAllProducts()
    {
        try {
            $plans = Plan::query()->where('active', 1)->get();
            foreach ($plans as $plan) {
                self::saveProduct($plan);
            }
        } catch (Exception $ex) {
            Log::error(self::$GATEWAY_CODE . '-> saveAllProducts(): ' . $ex->getMessage());

            return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }
    }

    public static function saveProduct($plan)
    {
        try {
            GatewayProducts::query()->firstOrCreate([
                'plan_id'       => $plan->id,
                'gateway_code'  => self::$GATEWAY_CODE,
                'gateway_title' => self::$GATEWAY_NAME,
            ], [
                'plan_name'  => $plan->name,
                'product_id' => 'TAP-' . strtoupper(Str::random(13)),
                'price_id'   => 'Not Needed',
            ]);
        } catch (Exception $ex) {
            Log::error(self::$GATEWAY_CODE . '-> saveProduct(): ' . $ex->getMessage());

            return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }
    }

    public static function getPlansPriceIdsForMigration()
    {
        return null;
    }

    public static function getUsersCustomerIdsForMigration(Subscriptions $subscription)
    {
        return null;
    }

    public static function subscribe($plan)
    {
        $product = GatewayProducts::query()->where(['plan_id' => $plan->id, 'gateway_code' => self::$GATEWAY_CODE])->first();
        if (! $product) {
            self::saveProduct($plan);
        }

        $order_id = 'ORDER-' . strtoupper(Str::random(13));
        $newDiscountedPrice = null;

        return view('panel.user.finance.subscription.' . self::$GATEWAY_CODE, compact('plan', 'order_id', 'newDiscountedPrice'));
    }

    public static function prepaid($plan)
    {
        $product = GatewayProducts::query()->where(['plan_id' => $plan->id, 'gateway_code' => self::$GATEWAY_CODE])->first();
        if (! $product) {
            self::saveProduct($plan);
        }

        $order_id = 'ORDER-' . strtoupper(Str::random(13));

        return view('panel.user.finance.prepaid.' . self::$GATEWAY_CODE, compact('plan', 'order_id'));
    }

    public static function subscribeCheckout(Request $request, $referral = null)
    {
        $planID = $request->input('planID');
        $orderID = $request->input('orderID');

        $plan = Plan::query()->where('id', $planID)->first();
        if (! $plan) {
            abort(404);
        }

        $user = Auth::user();

        $gateway = self::getGateway();
        if (! $gateway) {
            return back()->with(['message' => __('Please enable Tap gateway'), 'type' => 'error']);
        }

        $total = (float) $plan->price;

        try {
            DB::beginTransaction();

            $subscription = Subscriptions::query()->create([
                'user_id'       => $user->id,
                'name'          => $plan->id,
                'stripe_id'     => $orderID,
                'stripe_status' => 'WAITING',
                'stripe_price'  => 'Not Needed',
                'quantity'      => 1,
                'trial_ends_at' => null,
                'auto_renewal'  => in_array($plan->frequency, [FrequencyEnum::MONTHLY->value, FrequencyEnum::YEARLY->value, FrequencyEnum::LIFETIME_MONTHLY->value, FrequencyEnum::LIFETIME_YEARLY->value], true) ? 1 : 0,
                'tax_rate'      => $gateway->tax ?? 0,
                'tax_value'     => taxToVal($plan->price, $gateway->tax ?? 0),
                'coupon'        => null,
                'total_amount'  => $total,
                'plan_id'       => $plan->id,
                'paid_with'     => self::$GATEWAY_CODE,
            ]);

            $order = UserOrder::query()->create([
                'order_id'           => $orderID,
                'plan_id'            => $plan->id,
                'user_id'            => $user->id,
                'payment_type'       => self::$GATEWAY_CODE,
                'price'              => $total,
                'affiliate_earnings' => 0,
                'status'             => 'WAITING',
                'country'            => $user->country ?? 'Unknown',
                'tax_rate'           => $gateway->tax ?? 0,
                'tax_value'          => taxToVal($plan->price, $gateway->tax ?? 0),
                'type'               => 'subscription',
                'payload'            => [],
            ]);

            $charge = self::createCharge(
                gateway: $gateway,
                amount: (float) $total,
                currency: self::resolveCurrencyCode($gateway, $plan),
                reference: $orderID,
                customer: $user,
                description: $plan->name,
                metadata: [
                    'plan_id' => $plan->id,
                    'user_id' => $user->id,
                    'type'    => 'subscription',
                ],
                saveCard: true,
            );

            $order->update(['payload' => $charge]);

            DB::commit();

            $redirect = data_get($charge, 'transaction.url');
            if ($redirect) {
                return redirect()->away($redirect);
            }

            return back()->with(['message' => __('Could not create Tap payment.'), 'type' => 'error']);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error(self::$GATEWAY_CODE . '-> subscribeCheckout(): ' . $ex->getMessage());

            return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }
    }

    public static function prepaidCheckout(Request $request, $referral = null)
    {
        $planID = $request->input('planID');
        $orderID = $request->input('orderID');

        $plan = Plan::query()->where('id', $planID)->first();
        if (! $plan) {
            abort(404);
        }

        $user = Auth::user();

        $gateway = self::getGateway();
        if (! $gateway) {
            return back()->with(['message' => __('Please enable Tap gateway'), 'type' => 'error']);
        }

        $total = (float) $plan->price;

        try {
            DB::beginTransaction();

            $order = UserOrder::query()->create([
                'order_id'           => $orderID,
                'plan_id'            => $plan->id,
                'user_id'            => $user->id,
                'payment_type'       => self::$GATEWAY_CODE,
                'price'              => $total,
                'affiliate_earnings' => 0,
                'status'             => 'WAITING',
                'country'            => $user->country ?? 'Unknown',
                'tax_rate'           => $gateway->tax ?? 0,
                'tax_value'          => taxToVal($plan->price, $gateway->tax ?? 0),
                'type'               => 'token-pack',
                'payload'            => [],
            ]);

            $charge = self::createCharge(
                gateway: $gateway,
                amount: (float) $total,
                currency: self::resolveCurrencyCode($gateway, $plan),
                reference: $orderID,
                customer: $user,
                description: $plan->name,
                metadata: [
                    'plan_id' => $plan->id,
                    'user_id' => $user->id,
                    'type'    => 'token-pack',
                ],
                saveCard: false,
            );

            $order->update(['payload' => $charge]);

            DB::commit();

            $redirect = data_get($charge, 'transaction.url');
            if ($redirect) {
                return redirect()->away($redirect);
            }

            return back()->with(['message' => __('Could not create Tap payment.'), 'type' => 'error']);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error(self::$GATEWAY_CODE . '-> prepaidCheckout(): ' . $ex->getMessage());

            return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }
    }

    public static function subscribeCancel(?User $internalUser = null)
    {
        $user = Auth::user() ?: $internalUser;

        if (! $user) {
            return back()->with(['message' => __('Could not find user.'), 'type' => 'error']);
        }

        $userId = $user->getAttribute('id');

        $activeSub = getCurrentActiveSubscription($userId);

        if (! $activeSub || $activeSub->paid_with !== self::$GATEWAY_CODE) {
            return back()->with(['message' => __('Could not find active Tap subscription. Nothing changed!'), 'type' => 'error']);
        }

        $plan = Plan::query()->where('id', $activeSub->getAttribute('plan_id'))->first();

        try {
            $gateway = self::getGateway();
            if ($gateway) {
                $secretKey = self::getSecretKey($gateway);
                if ($secretKey !== '' && $activeSub->tap_customer_id && $activeSub->tap_card_id) {
                    self::deleteSavedCard(
                        secretKey: $secretKey,
                        customerId: (string) $activeSub->tap_customer_id,
                        cardId: (string) $activeSub->tap_card_id,
                    );
                }
            }
        } catch (Exception $ex) {
            Log::warning(self::$GATEWAY_CODE . '-> subscribeCancel(): remote card delete failed: ' . $ex->getMessage());
        }

        $activeSub->stripe_status = 'cancelled';
        $activeSub->ends_at = Carbon::now();
        $activeSub->auto_renewal = 0;
        $activeSub->tap_last_charge_id = null;
        $activeSub->tap_customer_id = null;
        $activeSub->tap_card_id = null;
        $activeSub->tap_payment_agreement_id = null;
        $activeSub->save();

        if ($plan) {
            self::creditDecreaseCancelPlan($user, $plan);
        }

        $user->save();

        CreateActivity::for($user, __('Cancelled'), __('Subscription plan'));

        return back()->with(['message' => __('Your subscription is cancelled succesfully.'), 'type' => 'success']);
    }

    public static function cancelSubscribedPlan($subscription, $planId)
    {
        return true;
    }

    public static function createWebhook()
    {
        return null;
    }

    public static function checkIfTrial(): bool
    {
        return false;
    }

    public static function getSubscriptionRenewDate()
    {
        return false;
    }

    public static function getSubscriptionStatus($incomingUserId = null)
    {
        return false;
    }

    public static function getSubscriptionDaysLeft()
    {
        return null;
    }

    public static function handleWebhook(Request $request)
    {
        if ($request->isMethod('post')) {
            $verified = self::verifyIncomingJson($request);
            if ($verified !== true) {
                abort(404);
            }
        }

        $tapId = $request->input('tap_id');

        if ($tapId) {
            try {
                $gateway = self::getGateway();
                if (! $gateway) {
                    abort(404);
                }

                $charge = self::retrieveCharge($gateway, $tapId);

                $status = data_get($charge, 'status');
                $isSuccess = $status && in_array(Str::lower((string) $status), ['captured', 'paid', 'success', 'succeeded'], true);

                // Tap charges include the original reference.transaction in the response
                $reference = data_get($charge, 'reference.transaction')
                    ?? data_get($charge, 'reference.order');

                if ($reference) {
                    // Re-use local handler logic by merging payload
                    $request->merge([
                        'reference' => $reference,
                        'status'    => $status,
                    ]);

                    // Persist payload and mark as paid only if captured
                    self::handleWebhookFromPayload($request, $charge);
                }

                // After Tap redirect callback, send user to app success/error page.
                if ($isSuccess) {
                    return redirect()->route('dashboard.user.payment.succesful');
                }

                return redirect()->route('dashboard.user.payment.subscription')->with([
                    'message' => __('Payment failed or was cancelled.'),
                    'type'    => 'error',
                ]);
            } catch (Exception $ex) {
                Log::error(self::$GATEWAY_CODE . '-> handleWebhook(tap_id): ' . $ex->getMessage());

                return redirect()->route('dashboard.user.payment.subscription')->with([
                    'message' => $ex->getMessage(),
                    'type'    => 'error',
                ]);
            }
        }

        // Tap might send JSON body; also the generic route accepts GET/POST.
        $payload = $request->all();

        $reference = data_get($payload, 'reference.transaction')
            ?? data_get($payload, 'reference.order')
            ?? $request->input('reference')
            ?? $request->input('order_id');

        if (! $reference) {
            return true;
        }

        $order = UserOrder::query()
            ->where('order_id', $reference)
            ->where('payment_type', self::$GATEWAY_CODE)
            ->first();

        if (! $order) {
            return true;
        }

        $status = data_get($payload, 'status')
            ?? data_get($payload, 'charge.status')
            ?? $request->input('status');

        self::handleWebhookFromPayload($request, $payload);

        return true;
    }

    private static function handleWebhookFromPayload(Request $request, array $payload): void
    {
        $reference = data_get($payload, 'reference.transaction')
            ?? data_get($payload, 'reference.order')
            ?? $request->input('reference')
            ?? $request->input('order_id');

        if (! $reference) {
            return;
        }

        $order = UserOrder::query()
            ->where('order_id', $reference)
            ->where('payment_type', self::$GATEWAY_CODE)
            ->first();

        if (! $order) {
            return;
        }

        $status = data_get($payload, 'status')
            ?? data_get($payload, 'charge.status')
            ?? $request->input('status');

        if (! $status || ! in_array(Str::lower((string) $status), ['captured', 'paid', 'success', 'succeeded'], true)) {
            $normalizedStatus = Str::lower((string) ($status ?? ''));
            $orderStatus = $normalizedStatus === 'canceled' || $normalizedStatus === 'cancelled'
                ? 'CANCELLED'
                : 'FAILED';

            $order->update([
                'status'  => $orderStatus,
                'payload' => $payload,
            ]);

            $subscription = Subscriptions::query()
                ->where('paid_with', self::$GATEWAY_CODE)
                ->where('stripe_id', $reference)
                ->first();

            if ($subscription) {
                $subscription->stripe_status = Str::lower($orderStatus);
                $subscription->ends_at = now();
                $subscription->save();
            }

            return;
        }

        $plan = Plan::query()->where('id', $order->plan_id)->first();
        $user = User::query()->where('id', $order->user_id)->first();

        if ($plan && $user) {
            self::creditIncreaseSubscribePlan($user, $plan);
        }

        $order->update([
            'status'  => 'PAID',
            'payload' => $payload,
        ]);

        $subscription = Subscriptions::query()
            ->where('paid_with', self::$GATEWAY_CODE)
            ->where('stripe_id', $reference)
            ->first();

        if (! $subscription) {
            $subscription = Subscriptions::query()
                ->where('paid_with', self::$GATEWAY_CODE)
                ->where('user_id', $order->user_id)
                ->where('stripe_status', self::$GATEWAY_CODE . '_approved')
                ->latest('id')
                ->first();
        }

        if ($subscription) {
            $subscription->stripe_status = self::$GATEWAY_CODE . '_approved';

            $subscription->tap_last_charge_id = (string) (data_get($payload, 'id') ?? $subscription->tap_last_charge_id);
            $subscription->tap_customer_id = (string) (data_get($payload, 'customer.id') ?? $subscription->tap_customer_id);
            $subscription->tap_card_id = (string) (data_get($payload, 'card.id') ?? data_get($payload, 'source.id') ?? $subscription->tap_card_id);
            $subscription->tap_payment_agreement_id = (string) (data_get($payload, 'payment_agreement.id') ?? $subscription->tap_payment_agreement_id);

            if ($plan) {
                switch ($plan->frequency) {
                    case FrequencyEnum::MONTHLY->value:
                        $subscription->ends_at = Carbon::now()->addMonths(1);
                        $subscription->auto_renewal = 1;
                        break;
                    case FrequencyEnum::YEARLY->value:
                        $subscription->ends_at = Carbon::now()->addYears(1);
                        $subscription->auto_renewal = 1;
                        break;
                    case FrequencyEnum::LIFETIME_MONTHLY->value:
                        $subscription->ends_at = Carbon::now()->addMonths(1);
                        $subscription->auto_renewal = 1;
                        break;
                    case FrequencyEnum::LIFETIME_YEARLY->value:
                        $subscription->ends_at = Carbon::now()->addYears(1);
                        $subscription->auto_renewal = 1;
                        break;
                    default:
                        $subscription->ends_at = Carbon::now()->addDays(30);
                        break;
                }
            }

            $subscription->save();
        }

        if ($plan && $user) {
            CreateActivity::for($order->user, __('Purchased'), $order->plan->name . ' ' . __('Plan'));
            EmailPaymentConfirmation::create($user, $plan)->send();
        }
    }

    private static function getGateway(): ?Gateways
    {
        return Gateways::query()->where('code', self::$GATEWAY_CODE)->where('is_active', 1)->first();
    }

    private static function getSecretKey(Gateways $gateway): string
    {
        // Use admin-selected mode to pick key.
        $mode = $gateway->mode ?? 'live';

        if ($mode === 'sandbox') {
            return (string) ($gateway->sandbox_client_secret ?? '');
        }

        return (string) ($gateway->live_client_secret ?? '');
    }

    private static function createCharge(
        Gateways $gateway,
        float $amount,
        string $currency,
        string $reference,
        User $customer,
        string $description,
        array $metadata = [],
        bool $saveCard = false,
    ): array {
        $secretKey = self::getSecretKey($gateway);

        if ($secretKey === '') {
            throw new Exception('Tap API key is missing. Please save Tap settings first.');
        }

        $payload = [
            'amount'      => $amount,
            'currency'    => $currency,
            'threeDSecure'=> true,
            'save_card'   => $saveCard,
            'description' => $description,
            'reference'   => [
                'transaction' => $reference,
            ],
            'customer' => [
                'first_name' => $customer->name ?? 'Customer',
                'email'      => $customer->email,
            ],
            'source' => [
                'id' => 'src_all',
            ],
            'redirect' => [
                'url' => url('/webhooks/tap'),
            ],
            'post' => [
                'url' => url('/webhooks/tap'),
            ],
            'metadata' => $metadata,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->post(self::TAP_API_BASE . '/charges', $payload);

        if (! $response->successful()) {
            $body = $response->json();
            $errorCode = (string) (data_get($body, 'errors.0.code') ?? '');
            $errorDescription = (string) (data_get($body, 'errors.0.description') ?? data_get($body, 'errors.0.error') ?? '');
            $referenceId = (string) (data_get($body, 'reference_id') ?? '');
            $message = $errorDescription !== ''
                ? $errorDescription
                : (string) (data_get($body, 'message') ?? $response->body());

            if ($saveCard === true && $errorCode === '1108') {
                $suffix = $referenceId !== '' ? (' reference_id=' . $referenceId) : '';
                throw new Exception('Tap charge creation failed: Save card features are not enabled. Please enable Save Card in your Tap account to use subscriptions/recurring payments.' . $suffix);
            }

            $suffix = $referenceId !== '' ? (' reference_id=' . $referenceId) : '';
            throw new Exception('Tap charge creation failed: ' . $message . $suffix);
        }

        return (array) $response->json();
    }

    public static function createRecurringChargeForSubscription(
        Gateways $gateway,
        Subscriptions $subscription,
        string $reference,
        float $amount,
    ): array {
        $secretKey = self::getSecretKey($gateway);

        if ($secretKey === '') {
            throw new Exception('Tap API key is missing. Please save Tap settings first.');
        }

        $customerId = (string) $subscription->tap_customer_id;
        $cardId = (string) $subscription->tap_card_id;
        $agreementId = (string) $subscription->tap_payment_agreement_id;

        if ($customerId === '' || $cardId === '' || $agreementId === '') {
            throw new Exception('Tap recurring identifiers are missing on subscription. Please complete first successful subscription payment with save_card enabled.');
        }

        $token = self::createTokenFromSavedCard(
            secretKey: $secretKey,
            customerId: $customerId,
            cardId: $cardId,
        );

        $currency = self::resolveCurrencyCode($gateway, $subscription->plan);

        $payload = [
            'amount'             => $amount,
            'currency'           => $currency,
            'customer_initiated' => false,
            'threeDSecure'       => false,
            'save_card'          => false,
            'payment_agreement'  => [
                'id' => $agreementId,
            ],
            'description' => 'Subscription renewal',
            'metadata'    => [
                'type'             => 'subscription-renewal',
                'subscription_id'  => (string) $subscription->id,
                'subscription_ref' => (string) $subscription->stripe_id,
                'user_id'          => (string) $subscription->user_id,
                'plan_id'          => (string) $subscription->plan_id,
            ],
            'reference' => [
                'transaction' => $reference,
                'order'       => $subscription->stripe_id,
            ],
            'customer' => [
                'id' => $customerId,
            ],
            'source' => [
                'id' => $token,
            ],
            'post' => [
                'url' => url('/webhooks/tap'),
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->post(self::TAP_API_BASE . '/charges', $payload);

        if (! $response->successful()) {
            $body = $response->json();
            $errorCode = (string) (data_get($body, 'errors.0.code') ?? '');
            $errorDescription = (string) (data_get($body, 'errors.0.description') ?? data_get($body, 'errors.0.error') ?? '');
            $message = $errorDescription !== ''
                ? $errorDescription
                : (string) (data_get($body, 'message') ?? $response->body());

            if ($errorCode === '1108') {
                $message .= ' (Tap account Save Card feature is not enabled. Please enable it from Tap dashboard or contact Tap support.)';
            }

            throw new Exception('Tap recurring charge creation failed: ' . $message);
        }

        return (array) $response->json();
    }

    private static function createTokenFromSavedCard(string $secretKey, string $customerId, string $cardId): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->post(self::TAP_API_BASE . '/tokens', [
            'customer_id' => $customerId,
            'card_id'     => $cardId,
        ]);

        if (! $response->successful()) {
            $body = $response->json();
            $errorCode = (string) (data_get($body, 'errors.0.code') ?? '');
            $errorDescription = (string) (data_get($body, 'errors.0.description') ?? data_get($body, 'errors.0.error') ?? '');
            $message = $errorDescription !== ''
                ? $errorDescription
                : (string) (data_get($body, 'message') ?? $response->body());

            if ($errorCode === '1108') {
                $message .= ' (Tap account Save Card feature is not enabled. Enable Save Card to allow subscription renewals.)';
            } elseif ($errorCode === '7022') {
                $message .= ' (Invalid customer/card data. Verify subscription has correct tap_customer_id and tap_card_id from a successful first payment with save_card enabled.)';
            }

            throw new Exception('Tap token creation failed: ' . $message);
        }

        $tokenId = (string) (data_get($response->json(), 'id') ?? '');
        if ($tokenId === '') {
            throw new Exception('Tap token creation failed: missing token id in response.');
        }

        return $tokenId;
    }

    private static function verifyIncomingJson(Request $request): bool
    {
        try {
            $gateway = self::getGateway();
            if (! $gateway) {
                return false;
            }

            $secretKey = self::getSecretKey($gateway);
            if ($secretKey === '') {
                return false;
            }

            $postedHashString = (string) $request->header(self::WEBHOOK_HASH_HEADER);
            if ($postedHashString === '') {
                return false;
            }

            $payload = $request->all();
            $id = (string) data_get($payload, 'id');
            if ($id === '') {
                $id = (string) data_get($payload, 'charge.id');
            }

            $amount = data_get($payload, 'amount');
            if ($amount === null) {
                $amount = data_get($payload, 'charge.amount');
            }
            $currency = (string) (data_get($payload, 'currency') ?? data_get($payload, 'charge.currency') ?? '');
            $gatewayReference = (string) (data_get($payload, 'reference.gateway') ?? data_get($payload, 'charge.reference.gateway') ?? '');
            $paymentReference = (string) (data_get($payload, 'reference.payment') ?? data_get($payload, 'charge.reference.payment') ?? '');
            $status = (string) (data_get($payload, 'status') ?? data_get($payload, 'charge.status') ?? '');
            $created = (string) (data_get($payload, 'transaction.created') ?? data_get($payload, 'charge.transaction.created') ?? '');

            if ($id === '' || $currency === '' || $status === '' || $created === '' || $amount === null) {
                return false;
            }

            $amountString = self::formatTapAmount($amount, $currency);

            $toBeHashedString = 'x_id' . $id
                . 'x_amount' . $amountString
                . 'x_currency' . $currency
                . 'x_gateway_reference' . $gatewayReference
                . 'x_payment_reference' . $paymentReference
                . 'x_status' . $status
                . 'x_created' . $created;

            $myHashString = hash_hmac('sha256', $toBeHashedString, $secretKey);

            return hash_equals($myHashString, $postedHashString);
        } catch (Exception $ex) {
            Log::error(self::$GATEWAY_CODE . '-> verifyIncomingJson(): ' . $ex->getMessage());

            return false;
        }
    }

    private static function formatTapAmount(mixed $amount, string $currency): string
    {
        $currency = Str::upper($currency);
        $decimals = in_array($currency, ['BHD', 'KWD', 'OMR', 'JOD'], true) ? 3 : 2;

        return number_format((float) $amount, $decimals, '.', '');
    }

    private static function retrieveCharge(Gateways $gateway, string $tapId): array
    {
        $secretKey = self::getSecretKey($gateway);

        if ($secretKey === '') {
            throw new Exception('Tap API key is missing. Please save Tap settings first.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->get(self::TAP_API_BASE . '/charges/' . $tapId);

        if (! $response->successful()) {
            $body = $response->json();
            $message = data_get($body, 'message') ?? $response->body();
            throw new Exception('Tap charge retrieve failed: ' . $message);
        }

        return (array) $response->json();
    }

    private static function resolveCurrencyCode(Gateways $gateway, Plan $plan): string
    {
        // Prefer plan currency if present, else fallback to USD.
        $currency = $plan->currency ?? null;
        if (is_string($currency) && $currency !== '') {
            return strtoupper($currency);
        }

        return 'USD';
    }
}
