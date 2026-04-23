<div class="lqd-accordion-item group relative rounded-lg bg-black px-7">
    <button
        class="group/btn peer flex w-full items-center justify-between py-7 text-start text-xl font-normal"
        data-target="#faq-{{ $item->id }}"
        data-trigger-type="accordion"
    >
        <span
            class="inline-block bg-gradient-to-r from-heading-foreground to-heading-foreground bg-clip-text text-transparent group-[&.lqd-is-active]/btn:from-gradient-from group-[&.lqd-is-active]/btn:to-gradient-to"
        >
            {!! $item->question !!}
        </span>
        <div class="ms-3 text-primary">
            <span class="group-[&.lqd-is-active]/btn:hidden">
                <x-tabler-chevron-down class="size-6" />
            </span>
            <span class="hidden group-[&.lqd-is-active]/btn:block">
                <x-tabler-chevron-up class="size-6" />
            </span>
        </div>
    </button>

    <x-outline-glow class="opacity-0 peer-[&.lqd-is-active]:opacity-100" />

    <div
        class="hidden"
        id="faq-{{ $item->id }}"
    >
        <div class="lqd-accordion-content pb-7">
            <p class="text-xl/7">{!! $item->answer !!}</p>
        </div>
    </div>

</div>
