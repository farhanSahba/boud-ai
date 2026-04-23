<div class="group relative">
    <span class="block text-[148px] font-black leading-none text-heading-foreground/[7%] transition-colors group-hover:text-heading-foreground">
        {{ str_pad($item->order, 2, '0', STR_PAD_LEFT) }}
    </span>
    <p
        class="absolute bottom-0 start-0 z-2 min-w-full px-4 py-3 text-xs text-heading-foreground before:absolute before:inset-0 before:-z-1 before:scale-90 before:rounded-xl before:bg-background before:opacity-0 before:shadow-[0_4px_44px_hsl(0_0%_0%/5%)] before:transition-all group-hover:before:scale-100 group-hover:before:opacity-100 md:start-4">
        {!! __($item->title) !!}
    </p>
</div>
