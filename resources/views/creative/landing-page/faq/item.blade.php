<h4>
    <button
        @class([
            'group flex gap-3 w-full justify-between items-center border-b p-8 text-start text-2xl leading-tight transition-all hover:bg-heading-foreground/5',
            'lqd-is-active' => $loop->first,
        ])
        :class="{ 'lqd-is-active': activeIndex == {{ $loop->index }} }"
        @click.prevent="activeIndex = {{ $loop->index }}"
    >
        {!! __($item->question) !!}
        <x-tabler-plus class="size-4 inline-block transition-transform group-[&.lqd-is-active]:rotate-45" />
    </button>
</h4>
<div
    @class([
        'lqd-accordion-content pt-8 pb-4 px-8',
        'hidden' => !$loop->first,
        'lqd-is-active' => $loop->first,
    ])
    :class="{ 'lqd-is-active': activeIndex == {{ $loop->index }}, 'hidden': activeIndex != {{ $loop->index }} }"
>
    {!! __($item->answer) !!}
</div>
