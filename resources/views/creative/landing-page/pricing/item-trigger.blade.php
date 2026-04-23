<button
    data-target="{{ isset($target) ? $target : '' }}"
    @class([
        'inline-flex text-foreground border-b-[3px] text-xs leading-snug py-6 px-11 -mb-[3px] [&.lqd-is-active]:text-primary [&.lqd-is-active]:border-primary',
        'lqd-is-active' => isset($active),
    ])
>
    {!! isset($label) ? $label : '' !!}
    {!! isset($badge) ? $badge : '' !!}
</button>
