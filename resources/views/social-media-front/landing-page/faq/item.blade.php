<h4 class="font-medium">
    <button
        @class([
            'group flex gap-3 w-full justify-between items-center rounded-full py-5 px-6 sm:px-10 text-start text-[18px]/tight transition-all bg-heading-foreground/[2%] hover:bg-heading-foreground/5 [&.lqd-is-active]:bg-white',
            'lqd-is-active' => $loop->first,
        ])
        :class="{ 'lqd-is-active': activeIndex == {{ $loop->index }} }"
        @click.prevent="activeIndex = {{ $loop->index }}"
    >
        {!! __($item->question) !!}
        <span class="inline-grid size-[50px] shrink-0 place-items-center rounded-full border border-heading-foreground/20">
            <x-tabler-plus class="inline-block size-5 transition-transform group-[&.lqd-is-active]:rotate-45" />
        </span>
    </button>
</h4>
<div
    @class([
        'lqd-accordion-content pb-4 px-8',
        'hidden' => !$loop->first,
        'lqd-is-active' => $loop->first,
    ])
    :class="{ 'lqd-is-active': activeIndex == {{ $loop->index }}, 'hidden': activeIndex != {{ $loop->index }} }"
>
    {!! __($item->answer) !!}
</div>
