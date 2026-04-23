<div
    @class([
        'group relative z-2 flex-col rounded-3xl p-1 px-10 pt-10 transition-all duration-300',
        'flex' => $loop->index <= 5,
        'hidden' => $loop->index > 5,
    ])
    x-data="{ 'index': {{ $loop->index }} }"
    :class="{ 'flex': showMore, 'hidden': !showMore && index > 5 }"
>
    <div
        class="pointer-events-none absolute inset-x-0 -top-20 bottom-0 z-0 overflow-hidden rounded-3xl p-0.5 transition-all duration-300 group-hover:shadow-[0_5px_75px_hsl(var(--primary)/10%)] group-hover:delay-200">
        <div class="absolute inset-[1px] translate-y-20 rounded-3xl bg-black transition-all duration-300 group-hover:translate-y-0">
            <x-outline-glow class="opacity-0 transition-all duration-300 group-hover:opacity-100" />
        </div>
    </div>
    <div class="relative z-1 transition-all duration-300 group-hover:-translate-y-20">
        <div class="mb-12">
            <div class="custom-templates-icon w-12 [&_svg]:h-auto [&_svg]:w-full">
                {!! $item->image !!}
            </div>
        </div>
        <h5 class="mb-6">
            {{ __($item->title) }}
        </h5>
        <p class="mb-10">
            {{ __($item->description) }}
        </p>
    </div>

    <div class="group/link absolute bottom-0 end-10 start-10 z-1 flex h-20 -translate-y-20 items-center overflow-hidden transition-all duration-300 group-hover:translate-y-0">
        {{-- add link option --}}
        <a
            class="flex h-full w-full translate-y-20 items-center justify-between gap-2 border-t border-white/20 text-sm font-semibold text-white transition-all duration-300 hover:text-primary group-hover:translate-y-0"
            href="#"
        >
            @lang('Learn more')
            <x-tabler-chevron-right class="size-5 -translate-x-4 transition-transform duration-300 group-hover/link:translate-x-1 group-hover:translate-x-0" />
        </a>
    </div>
</div>
