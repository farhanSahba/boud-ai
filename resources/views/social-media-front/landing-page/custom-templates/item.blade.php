<div
    class='lqd-marquee-cell group flex w-1/2 shrink-0 grow-0 basis-auto flex-col justify-center rounded-lg bg-surface-background px-4 py-10 text-center transition-all hover:bg-white hover:shadow-[0_4px_44px_hsl(0_0%_0%/5%)] md:w-1/3 md:hover:scale-105 lg:w-1/4 xl:w-[12%]'>
    <div class="mx-auto mb-5 [&_path:not([fill=none])]:[fill:url(#icons-gradient-1)] [&_svg]:mx-auto [&_svg]:size-6 [&_svg]:[fill:url(#icons-gradient-1)]">
        {!! $item->image !!}
    </div>
    <h4 class="mb-0 text-lg/snug font-medium">
        {{ __($item->title) }}
    </h4>
</div>
