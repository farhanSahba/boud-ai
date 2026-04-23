<div
    class="group flex gap-6 rounded-xl bg-heading-foreground/[2%] py-10 pe-5 ps-8 transition-all hover:scale-105 hover:bg-heading-foreground hover:text-heading-background hover:shadow-xl">
    <span
        class="size-14 inline-flex shrink-0 items-center justify-center rounded-full bg-heading-foreground/[3%] text-heading-foreground transition-all group-hover:scale-105 group-hover:bg-heading-background"
    >
        {!! $item->image !!}
    </span>
    <div>
        <h4 class="mb-5 group-hover:text-inherit">
            {!! __($item->title) !!}
        </h4>
        <p class="text-xs">
            {!! __($item->description) !!}
        </p>
    </div>
</div>
