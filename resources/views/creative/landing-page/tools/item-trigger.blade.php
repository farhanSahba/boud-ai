<button
    data-index="{{ $loop->index }}"
    x-init
    @click.prevent="activeTab = $el.getAttribute('data-index')"
    @class([
        'text-start px-3 py-1.5 rounded cursor-pointer transition-all [&.lqd-is-active]:bg-[#205781]/15 [&.lqd-is-active]:text-[#205781]',
        'lqd-is-active' => $loop->first,
    ])
    :class="{ 'lqd-is-active': activeTab == $el.getAttribute('data-index') }"
>
    {!! $item->title !!}
</button>
