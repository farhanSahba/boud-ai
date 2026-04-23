<button
    data-target="{{ isset($target) ? $target : '' }}"
    @class([
        'inline-flex items-center text-base font-semibold flex-col relative',
        'lqd-is-active' => isset($active),
    ])
>
    <span class="lqd-tabs-nav-txt">
        {!! isset($label) ? $label : '' !!}
        {!! isset($badge) ? $badge : '' !!}
    </span>
</button>
