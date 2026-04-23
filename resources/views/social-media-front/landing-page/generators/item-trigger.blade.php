<button
    data-target="#{{ \Illuminate\Support\Str::slug($item->menu_title) }}"
    @class([
        'relative inline-flex py-5 leading-snug text-heading-foreground/50 after:absolute after:-bottom-px after:start-0 after:h-[3px] after:w-full after:origin-right after:origin-right after:scale-x-0 after:bg-gradient-to-r after:from-[--gradient-from] after:via-[--gradient-via] after:to-[--gradient-to] after:transition-transform hover:text-heading-foreground max-lg:w-1/2 max-lg:justify-center max-sm:w-full [&.lqd-is-active]:text-heading-foreground [&.lqd-is-active]:after:origin-left [&.lqd-is-active]:after:scale-x-100',
        'lqd-is-active' => $loop->first,
    ])
>
    {!! __($item->menu_title) !!}
</button>
