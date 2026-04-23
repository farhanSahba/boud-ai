@php
    $buy_link = $item->buy_link;
    $buy_link_url = $item->buy_link_url;
    $learn_more_link = $item->learn_more_link;
    $learn_more_link_url = $item->learn_more_link_url;

    // fallback to banner settings
    if (!$buy_link) {
        $buy_link = $fSetting->hero_button;
    }
    if (!$buy_link_url) {
        $buy_link_url = $fSetting->hero_button_url;
    }
    if (!$learn_more_link) {
        $learn_more_link = $fSetting->hero_scroll_text;
    }
    if (!$learn_more_link_url) {
        $learn_more_link_url = '#templates';
    }
@endphp

<div
    id="tools-{{ \Illuminate\Support\Str::slug($item->title) }}"
    @class(['hidden' => !$loop->first])
>
    <div class="flex flex-wrap items-center justify-between gap-4 gap-y-14">
        <figure class="w-full lg:w-6/12">
            <img
                class="w-full rounded-3xl transition-all hover:scale-105"
                src="{{ custom_theme_url($item->image, true) }}"
                alt="{!! __($item->title) !!}"
                width="696"
                height="426"
            >
        </figure>

        <div class="w-full lg:w-5/12">
            <h3 class="mb-10">
                {!! __($item->title) !!}
            </h3>
            <p class="mb-10">
                {!! __($item->description) !!}
            </p>

            {{-- TODO: add bullet points option 
            @if ($item->bullet_points)
                <ul class="mb-10 flex flex-col gap-6">
                    @foreach ($item->bullet_points as $point)
                        <li class="flex items-center gap-6">
                            <span class="size-7 inline-grid shrink-0 place-content-center rounded-full bg-secondary text-secondary-foreground">
                                <x-tabler-check class="size-5" />
                            </span>
                            {!! __($point) !!}
                        </li>
                    @endforeach
                </ul>
            @endif
			--}}

            @if ($buy_link || $learn_more_link)
                <div class="flex flex-wrap items-center gap-8 text-sm">
                    @if ($buy_link)
                        <a
                            class="relative inline-flex w-56 gap-3 overflow-hidden whitespace-nowrap rounded-lg bg-gradient-to-r from-gradient-from to-gradient-to to-50% py-5 font-semibold text-primary-foreground transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-primary/20"
                            href="{{ !empty($buy_link_url) ? $buy_link_url : '#' }}"
                        >
                            <span
                                class="flex animate-marquee justify-between gap-3 before:content-[attr(data-txt)] after:content-[attr(data-txt)]"
                                data-txt="{!! __($buy_link) !!}"
                            >
                                {!! __($buy_link) !!}
                            </span>
                            <span
                                class="absolute start-3 top-5 flex animate-marquee-2 justify-between gap-3 before:content-[attr(data-txt)] after:content-[attr(data-txt)]"
                                data-txt="{!! __($buy_link) !!}"
                            >
                                {!! __($buy_link) !!}
                            </span>
                        </a>
                    @endif
                    <a
                        class="group/btn flex items-center gap-2 text-white transition-colors hover:text-primary"
                        href="{{ $learn_more_link_url }}"
                    >
                        {!! __($learn_more_link) !!}
                        <x-tabler-chevron-right class="size-5 transition-transform group-hover/btn:translate-x-1" />
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
