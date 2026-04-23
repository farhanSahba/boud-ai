<div @class([
    'relative flex flex-col items-start rounded-3xl px-10 py-10 text-start transition-all md:hover:-translate-y-1 md:hover:scale-[1.025] md:hover:z-1 lg:py-12',
    'bg-black' => !$plan->is_featured,
    'bg-[#0d0d0d]' => $plan->is_featured,
])>
    <h5 class="gradient-text relative mb-6 inline-block text-xs font-medium uppercase">
        {!! $plan->name !!}
    </h5>

    <p class="mb-7 text-sm">
        <span class="align-sub font-heading text-[50px] font-bold leading-none text-heading-foreground">
            {!! displayPlanPrice($plan, currency()) !!}
        </span>
        /
        {{ $period }}
    </p>

    <hr class="w-full">

    <x-plan-details-card
        :plan="$plan"
        :period="$plan->frequency"
    />

    <span class="block h-8"></span>

    <a
        class="relative mx-auto mt-auto inline-flex w-full max-w-[400px] gap-3 overflow-hidden whitespace-nowrap rounded-lg bg-gradient-to-r from-gradient-from to-gradient-to to-50% py-5 font-semibold text-primary-foreground transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-primary/20"
        href="{{ route('register', ['plan' => $plan->id]) }}"
    >
        @if ($plan->is_featured)
            <span
                class="flex animate-marquee justify-between gap-3 before:content-[attr(data-txt)] after:content-[attr(data-txt)]"
                data-txt="{{ __('Select') }} {{ __($plan->name) }}"
            >
                {{ __('Select') }} {{ __($plan->name) }}
            </span>
            <span
                class="absolute start-3 top-5 flex animate-marquee-2 justify-between gap-3 before:content-[attr(data-txt)] after:content-[attr(data-txt)]"
                data-txt="{{ __('Select') }} {{ __($plan->name) }}"
            >
                {{ __('Select') }} {{ __($plan->name) }}
            </span>
        @else
            <span class="flex w-full justify-center text-center">
                {{ __('Select') }} {{ __($plan->name) }}
            </span>
        @endif
    </a>

    @if ($plan->is_featured)
        <div class="pointer-events-none absolute inset-[1px] overflow-hidden rounded-[inherit]">
            <x-outline-glow class="inset-0" />
            <figure
                class="pointer-events-none absolute bottom-0 end-0 z-0 overflow-hidden"
                aria-hidden="true"
            >
                <img
                    width="920"
                    height="1250"
                    src="{{ custom_theme_url('/assets/landing-page/glow-4.png') }}"
                    alt="{{ __('Glowing blob') }}"
                />
            </figure>
        </div>
    @endif
</div>
