<div
    class="relative flex min-h-[400px] flex-col justify-between rounded-xl pb-9 pe-5 ps-9 pt-5"
    style="background-color: {{ $item['background'] ?? 'hsl(var(--primary))' }}; color: {{ $item['foreground'] ?? '#fff' }}"
    x-data="{
        isOpen: false
    }"
>
    <div class="flex justify-end">
        <button
            class="relative z-2 inline-grid size-10 place-items-center rounded-full bg-background text-heading-foreground transition-all hover:scale-110 hover:shadow-2xl"
            type="button"
            @click.outside="isOpen = false"
            @click.prevent="isOpen = !isOpen"
        >
            <span
                class="col-start-1 col-end-1 row-start-1 row-end-1"
                x-show="!isOpen"
                x-transition.duration.300ms
            >
                <x-tabler-plus class="size-6" />
            </span>
            <span
                class="col-start-1 col-end-1 row-start-1 row-end-1"
                x-show="isOpen"
                x-transition.duration.300ms
                x-cloak
            >
                <x-tabler-minus class="size-6" />
            </span>
        </button>
    </div>

    <div class="flex flex-col">
        <p
            class="mb-6 text-5xl/none mix-blend-luminosity"
            x-show="!isOpen"
            x-transition
        >
            {!! $item['emoji'] !!}
        </p>
        <h4
            class="mb-0 text-current"
            x-show="!isOpen"
            x-transition
        >
            {{ $item['title'] }}
        </h4>
    </div>

    <div
        class="absolute inset-0 z-1 pb-9 pe-20 ps-9 pt-7"
        x-clock
        x-show="isOpen"
        x-transition
    >
        <p class="mb-0">
            {{ $item['description'] }}
        </p>
    </div>
</div>
