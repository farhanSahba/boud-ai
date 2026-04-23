<div
    @class([
        'templates-all templates-{{ \Illuminate\Support\Str::slug($item->filters) }} group rounded-lg p-10 transition-all md:hover:scale-105 hover:bg-white hover:shadow-[0_4px_44px_hsl(0_0%_0%/5%)]',
        'hidden' => $loop->index > 5,
    ])
    @if ($loop->index >= 6) :class="{ 'hidden': !showAll }" @endif
>
    <div class="[&_svg]:size-14 mb-11">
        {!! $item->image !!}
    </div>
    <h4 class="mb-6 font-semibold">
        {{ __($item->title) }}
    </h4>
    <p class="mb-10">
        {{ __($item->description) }}
    </p>
    <a
        class="flex items-center gap-2 text-xs text-purple-600 transition-all md:invisible md:translate-y-2 md:opacity-0 md:group-hover:visible md:group-hover:translate-y-0 md:group-hover:opacity-100"
        href="#"
    >
        {{ __('Learn more') }}
        <x-tabler-chevron-right class="size-4" />
    </a>
</div>
