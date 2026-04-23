{!! adsense_pricing_728x90() !!}
<section
    class="site-section py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 lg:pb-24 lg:pt-16 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="pricing"
>
    <div class="container">
        <header class="mx-auto mb-14 w-full text-center lg:w-4/5">
            <h6
                class="relative mb-12 inline-flex translate-y-6 items-center gap-1.5 overflow-hidden rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                <x-tabler-rocket
                    class="size-5"
                    stroke-width="1.5"
                />
                {!! $fSectSettings->pricing_subtitle ? __($fSectSettings->pricing_subtitle) : __($fSetting->hero_subtitle) !!}
            </h6>
            <h2 class="mb-7">
                {!! $fSectSettings->pricing_title ? __($fSectSettings->pricing_title) : __('AI generator for ultimate technology.') !!}
            </h2>
            <p class="mx-auto mb-4 text-xl/7 lg:w-9/12">
                {!! $fSectSettings->pricing_description
                    ? __($fSectSettings->pricing_description)
                    : __('Glide gives you the powers of a developer and a code — for designer to create remarkable tools that solve your most challenging business problems.') !!}"
            </p>
        </header>

        <div class="lqd-tabs flex flex-wrap justify-center">
            <div class="lqd-tabs-triggers mx-auto mb-24 inline-flex flex-wrap justify-between gap-3 rounded-2xl border border-white/5 p-2 max-sm:w-full md:rounded-full">
                @if ($plansSubscriptionMonthly->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-monthly',
                        'label' => __('Monthly'),
                        'active' => true,
                        'currency' => $currency,
                    ])
                @endif
                @if ($plansSubscriptionAnnual->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-annual',
                        'label' => __('Annual'),
                        'badge' => __($fSectSettings->pricing_save_percent),
                        'active' => false,
                        'currency' => $currency,
                    ])
                @endif
                @if ($plansSubscriptionLifetime->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-lifetime',
                        'label' => __('Lifetime'),
                        'active' => false,
                        'currency' => $currency,
                    ])
                @endif
                @if ($plansPrepaid->count() > 0)
                    @include('landing-page.pricing.item-trigger', [
                        'target' => '#pricing-prepaid',
                        'label' => __('Pre-Paid'),
                        'active' => false,
                        'currency' => $currency,
                    ])
                @endif
            </div>

            <div class="lqd-tabs-content-wrap w-full px-10 max-xl:px-0">
                <div class="lqd-tabs-content">
                    <div id="pricing-monthly">
                        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansSubscriptionMonthly as $plan)
                                @include('landing-page.pricing.item-content', ['period' => $plan->frequency == 'monthly' ? 'month' : 'year'])
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="hidden"
                        id="pricing-annual"
                    >
                        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansSubscriptionAnnual as $plan)
                                @include('landing-page.pricing.item-content', ['period' => $plan->frequency == 'monthly' ? 'month' : 'year'])
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="hidden"
                        id="pricing-prepaid"
                    >
                        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansPrepaid as $plan)
                                @include('landing-page.pricing.item-content', ['period' => __('One Time Payment')])
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="hidden"
                        id="pricing-lifetime"
                    >
                        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($plansSubscriptionLifetime as $plan)
                                @include('landing-page.pricing.item-content', ['period' => $plan->frequency == 'lifetime_monthly' ? 'month' : 'year'])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
