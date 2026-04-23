<div
    class="group rounded-[18px] bg-heading-foreground/[3%] transition [&.lqd-is-active]:bg-surface-background"
    data-index="{{ $loop->index }}"
    :class="{ 'lqd-is-active': activeTab == $el.getAttribute('data-index') }"
>
    <button
        data-index="{{ $loop->index }}"
        @click.prevent="setActiveTab({{ $loop->index }})"
        @class([
            'font-heading text-heading-foreground flex w-full cursor-pointer items-center justify-between rounded px-6 md:px-10 py-8 text-start text-lg/tight font-bold transition-all',
            'lqd-is-active' => $loop->first,
        ])
        :class="{ 'lqd-is-active': activeTab == $el.getAttribute('data-index') }"
    >
        <span class="group-[&.lqd-is-active]:text-gradient">
            {!! $item->title !!}
        </span>

        <x-tabler-plus class="ms-auto size-6 transition-all group-[&.lqd-is-active]:rotate-45" />
    </button>
    <div class="px-6 md:px-10">
        <div
            data-index="{{ $loop->index }}"
            x-show="activeTab == {{ $loop->index }}"
            @if ($loop->first) x-cloak @endif
            x-collapse
        >
            <p class="leading-heading-foreground pb-8">
                {!! __($item->description) !!}
            </p>
            <img
                class="mb-8 rounded-xl lg:hidden"
                src="{{ custom_theme_url($item->image, true) }}"
                alt="{!! __($item->title) !!}"
                width="696"
                height="426"
            >
        </div>
    </div>
</div>
