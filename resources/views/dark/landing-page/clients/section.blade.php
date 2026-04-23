<section
    class="site-section relative pb-28 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="clients"
>
    <figure
        class="pointer-events-none absolute start-1/2 top-0 z-0 w-full max-w-none -translate-x-1/2 -translate-y-1/2"
        aria-hidden="true"
    >
        <img
            width="3110"
            height="1142"
            src="{{ custom_theme_url('/assets/landing-page/glow-1.png') }}"
            alt="{{ __('Glowing blob') }}"
        />
    </figure>

    <p class="mb-16 px-5 text-center text-[18px]">
        @lang('Trusted by 1000+ companies ')
        <span class="text-white">
            @lang('across the world.')
        </span>
    </p>

    <div class="relative w-full overflow-hidden [-webkit-mask-image:linear-gradient(90deg,transparent,black_15%,black_85%,transparent)]">
        <div class="flex animate-marquee justify-between gap-20 [animation-duration:20s] max-lg:gap-12 max-sm:gap-4">
            @foreach ($clients as $entry)
                <img
                    class="h-full max-h-[48px] w-full max-w-[48px] object-cover object-center"
                    src="{{ url('') . isset($entry->avatar) ? (str_starts_with($entry->avatar, 'asset') ? custom_theme_url($entry->avatar) : '/clientAvatar/' . $entry->avatar) : custom_theme_url('assets/img/auth/default-avatar.png') }}"
                    alt="{{ __($entry->alt) }}"
                    title="{{ __($entry->title) }}"
                >
            @endforeach
        </div>
        <div class="absolute start-0 top-0 flex w-full animate-marquee-2 justify-between gap-20 [animation-duration:20s] max-lg:gap-12 max-sm:gap-4">
            @foreach ($clients as $entry)
                <img
                    class="h-full max-h-[48px] w-full max-w-[48px] object-cover object-center first:invisible"
                    src="{{ url('') . isset($entry->avatar) ? (str_starts_with($entry->avatar, 'asset') ? custom_theme_url($entry->avatar) : '/clientAvatar/' . $entry->avatar) : custom_theme_url('assets/img/auth/default-avatar.png') }}"
                    alt="{{ __($entry->alt) }}"
                    title="{{ __($entry->title) }}"
                >
            @endforeach
        </div>
    </div>
</section>
