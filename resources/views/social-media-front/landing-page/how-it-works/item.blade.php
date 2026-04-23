<div @class([
    'group relative',
    'lg:after:h-px lg:after:absolute lg:after:z-0 lg:after:top-3.5 lg:after:start-0 lg:after:-end-20 xl:after:-end-52 lg:after:bg-heading-foreground/5' => !$loop->last,
])>
    <span class="relative z-1 mb-14 inline-grid size-[30px] place-items-center rounded-full border border-heading-foreground/5 bg-background text-xs text-heading-foreground">
        {{ $item->order }}
    </span>
    @if ($item->title)
        <h4 class="mb-3.5">
            {!! __($item->title) !!}
        </h4>
    @endif
    @if ($item->description)
        <p>
            {!! __($item->description) !!}
        </p>
    @endif
</div>
