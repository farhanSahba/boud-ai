<button
    data-target="#{{ \Illuminate\Support\Str::slug($item->menu_title) }}"
    @class([
        'inline-flex text-foreground border-b-[3px] leading-snug py-6 px-11 -mb-[3px] [&.lqd-is-active]:text-primary [&.lqd-is-active]:border-primary max-lg:w-1/2 max-lg:justify-center max-sm:w-full',
        'lqd-is-active' => $loop->first,
    ])
>
    {!! __($item->menu_title) !!}
</button>
