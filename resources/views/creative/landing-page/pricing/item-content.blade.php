<div @class([
    'group/pricing px-11 py-10 rounded-xl [&.featured]:bg-white [&.featured]:shadow-[0_4px_44px_hsl(0_0%_0%/7%)]',
    'featured' => $plan->is_featured == 1,
])>
    <p class="mb-3 text-purple-600">
        {!! $plan->name !!}
    </p>
    <p class="mb-8 text-4xl font-bold leading-none -tracking-tight text-heading-foreground">
        {{ currency()->symbol }}{{ formatPrice($plan->price, 2) }}
        <span class="text-sm font-normal tracking-normal text-foreground/50">
            /
            {{ $period ?? $plan->frequency == 'monthly' ? 'month' : 'year' }}
        </span>
    </p>

    <hr class="my-0">

    <x-plan-details-card
        :plan="$plan"
        :period="$plan->frequency"
    />

    <div class="pt-10">
        <a
            class="group inline-flex items-center gap-3 rounded-full py-3 pe-6 ps-4 transition-all hover:scale-105 hover:bg-primary-foreground hover:text-primary hover:shadow-xl hover:shadow-black/5 group-[&.featured]/pricing:bg-primary group-[&.featured]/pricing:text-primary-foreground"
            href="{{ route('register', ['plan' => $plan->id]) }}"
        >
            <span
                class="size-10 inline-flex items-center justify-center rounded-full bg-primary/[7%] transition-all group-hover:scale-110 group-hover:bg-primary group-hover:text-primary-foreground group-[&.featured]/pricing:bg-primary-foreground/10 group-[&.featured]/pricing:text-primary-foreground"
            >
                <x-tabler-arrow-right class="size-4" />
            </span>
            {{ __('Select') }} {{ __($plan->name) }}
        </a>
    </div>
</div>
