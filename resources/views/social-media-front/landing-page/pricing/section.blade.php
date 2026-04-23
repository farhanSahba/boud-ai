{!! adsense_pricing_728x90() !!}
<section
    class="site-section relative border-b py-32 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="pricing"
    style="background: url({{ custom_theme_url('assets/landing-page/pricing-bg.png') }}); background-size: 750px; background-repeat: no-repeat; background-position: 50% 10%;"
>

    <div class="container relative">
        <div class="relative mx-auto mb-5 w-full text-center lg:w-10/12">
            <svg
                class="absolute bottom-full end-0"
                width="92"
                height="110"
                viewBox="0 0 92 110"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                stroke="#343434"
                stroke-width="3"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path
                    d="M13.7421 -43C13.7421 -43 -11.7759 36.4408 11.6177 45.4936C18.7875 47.8747 25.6122 45.4789 31.27 41.7728C38.9827 36.7203 44.2389 29.1247 44.2389 29.1247C44.2389 29.1247 38.0767 76.1519 53.9199 84.5721C69.7631 92.9923 78.7766 70.0816 78.7766 70.0816C78.7766 70.0816 72.3762 93.0806 89.7376 107.805"
                />
            </svg>
            <figure
                class="absolute -start-36 bottom-0 hidden lg:block"
                aria-hidden="true"
            >
                <img
                    src="{{ custom_theme_url('assets/landing-page/decor-10.png') }}"
                    width="106"
                    height="106"
                >
            </figure>
            <figure
                class="absolute -end-36 bottom-0 hidden lg:block"
                aria-hidden="true"
            >
                <img
                    src="{{ custom_theme_url('assets/landing-page/decor-9.png') }}"
                    width="70"
                    height="86"
                >
            </figure>
            <h2 class="mb-6 [&_svg]:inline">
                {!! __($fSectSettings->pricing_title) !!}
            </h2>
            <p class="mx-auto text-xl/[1.3em] opacity-80 lg:w-8/12">
                {!! __($fSectSettings->pricing_description) ?? __('Flexible pricing options that allow you to choose the best fit for your requirements') !!}
            </p>
        </div>

        <div class="lqd-tabs">
            <div class="lqd-tabs-nav-toggle mb-12 flex justify-center text-xl font-semibold">
                @if ($plansSubscriptionMonthly->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-monthly',
                        'label' => __('Monthly'),
                        'active' => true,
                    ])
                @endif
                @if ($plansSubscriptionAnnual->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-annual',
                        'label' => __('Annual'),
                        'badge' => __($fSectSettings->pricing_save_percent),
                    ])
                @endif
                @if ($plansSubscriptionLifetime->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-lifetime',
                        'label' => __('Lifetime'),
                    ])
                @endif
                @if ($plansPrepaid->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-prepaid',
                        'label' => __('Pre-Paid'),
                    ])
                @endif
            </div>
            <div class="lqd-tabs-content-wrap px-10 max-xl:px-0">
                <div class="lqd-tabs-content">
                    <div id="pricing-monthly">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansSubscriptionMonthly as $plan)
                                @include('landing-page.pricing.item-content', ['period' => $plan->frequency == 'monthly' ? 'month' : 'year'])
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="hidden"
                        id="pricing-annual"
                    >
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansSubscriptionAnnual as $plan)
                                @include('landing-page.pricing.item-content', ['period' => $plan->frequency == 'monthly' ? 'month' : 'year'])
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="hidden"
                        id="pricing-prepaid"
                    >
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansPrepaid as $plan)
                                @include('landing-page.pricing.item-content', ['period' => __('One Time Payment')])
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="hidden"
                        id="pricing-lifetime"
                    >
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansSubscriptionLifetime as $plan)
                                @include('landing-page.pricing.item-content', ['period' => $plan->frequency == 'lifetime_monthly' ? 'month' : 'year'])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 flex justify-center">
            <div class="flex w-full flex-col justify-center gap-5 text-center text-2xs lg:w-1/2">
                <svg
                    class="mx-auto"
                    width="15"
                    height="19"
                    viewBox="0 0 15 19"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="#343434"
                    fill-opacity="0.5"
                >
                    <path
                        d="M12.75 6.90198V5.83397C12.75 2.9345 10.3995 0.583984 7.49999 0.583984C4.60048 0.583984 2.25 2.9345 2.25 5.83397V6.90198C0.885023 7.49771 0.00196875 8.84468 0 10.334V14.834C0.00246094 16.904 1.67994 18.5815 3.74998 18.584H11.25C13.32 18.5815 14.9975 16.904 15 14.834V10.334C14.998 8.84468 14.115 7.49771 12.75 6.90198ZM8.24998 13.334C8.24998 13.7482 7.9142 14.084 7.49999 14.084C7.08578 14.084 6.75 13.7482 6.75 13.334V11.834C6.75 11.4198 7.08578 11.084 7.49999 11.084C7.9142 11.084 8.24998 11.4198 8.24998 11.834V13.334ZM11.25 6.584H3.74998V5.83401C3.74998 3.76295 5.4289 2.084 7.49999 2.084C9.57108 2.084 11.25 3.76292 11.25 5.83401V6.584Z"
                    />
                </svg>
                <p class="[&_strong]:block">
                    {{ __('All payments undergo processing through the associated payment gateway, ensuring complete security with 256-bit SSL encryption.') }}
                </p>
            </div>
        </div>
    </div>
</section>
