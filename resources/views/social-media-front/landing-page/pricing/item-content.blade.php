<div @class([
    'group/pricing rounded-[20px] border px-12 py-12 transition-all hover:border-background hover:bg-background hover:shadow-2xl hover:shadow-black/5 [&.featured]:border-background [&.featured]:bg-background [&.featured]:shadow-[0_4px_44px_hsl(0_0%_0%/7%)]',
    'featured' => $plan->is_featured == 1,
])>
    <p class="mb-3.5 font-heading text-[22px]/none font-bold text-heading-foreground">
        {!! $plan->name !!}
    </p>

    <p class="mb-9 font-heading text-[60px] font-bold leading-none -tracking-tight text-heading-foreground">
        {!! displayPlanPrice($plan, currency()) !!}
        <span class="text-[18px] font-normal tracking-normal text-foreground/50">
            /
            {{ $period ?? $plan->frequency == 'monthly' ? 'month' : 'year' }}
        </span>
    </p>

    <x-button
        class="group mb-6 inline-flex items-center justify-center gap-6 rounded-full py-3.5 pe-5 ps-4 text-xl font-medium text-heading-foreground outline-heading-foreground/5 transition-all hover:scale-105 hover:shadow-lg"
        variant="outline"
        href="{{ route('register', ['plan' => $plan->id]) }}"
    >
        <span @class([
            'inline-grid size-12 transition-all group-hover:text-heading-foreground group-hover:bg-background shrink-0 place-items-center rounded-full group-hover:translate-x-1.5 group-hover:text-black group-hover:[--gradient-from:#fff] group-hover:[--gradient-to:#fff] group-hover:[--gradient-via:#fff] group-hover:border-transparent group-hover:shadow-lg',
            'bg-gradient text-primary-foreground' => $plan->is_featured == 1,
            'border' => $plan->is_featured == 0,
        ])>
            <svg
                widh="20"
                height="15"
                viewBox="0 0 20 15"
            >
                <use href="#arrow-icon" />
            </svg>
        </span>
        {{ __('Get Started') }}
    </x-button>

    <div class="text-heading-foreground">
        <x-plan-details-card
            :plan="$plan"
            :period="$plan->frequency"
            style="style-2"
        />
    </div>

</div>
