<div class="group w-1/2 cursor-pointer p-1 text-center text-[15px] font-medium md:w-1/3 lg:w-1/4">
    <figure class="size-36 md:size-48 mx-auto mb-8 scale-[0.85] rounded-full transition-all group-[&.is-nav-selected]:scale-100 group-[&.is-nav-selected]:shadow-sm">
        <img
            class="h-full w-full rounded-full object-cover object-center saturate-0"
            src="{{ url('') . isset($item->avatar) ? (str_starts_with($item->avatar, 'asset') ? custom_theme_url($item->avatar) : '/testimonialAvatar/' . $item->avatar) : custom_theme_url('assets/img/auth/default-avatar.png') }}"
            alt="{{ __($item->full_name) }}"
        >
        <div class="absolute inset-0 rounded-full bg-primary opacity-0 mix-blend-multiply transition-opacity group-[&.is-nav-selected]:opacity-100"></div>
        <div class="absolute inset-0 rounded-full bg-secondary opacity-0 mix-blend-difference transition-opacity group-[&.is-nav-selected]:opacity-100"></div>
        <x-outline-glow class="opacity-0 transition-opacity [--outline-glow-w:3px] group-[&.is-nav-selected]:opacity-100" />
    </figure>
    <div class="whitespace-nowrap opacity-0 transition-all group-[&.is-nav-selected]:opacity-100">
        <p class="mb-1 text-lg text-heading-foreground">{!! __($item->full_name) !!}</p>
        <p class="text-base text-heading-foreground/50">{!! __($item->job_title) !!}</p>
    </div>
</div>
