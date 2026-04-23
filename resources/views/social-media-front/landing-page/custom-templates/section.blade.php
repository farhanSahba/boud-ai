{!! adsense_templates_728x90() !!}
<section
    class="site-section pb-9 pt-20 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="templates"
    x-data="{ 'showAll': false }"
>
    <div class="container">
        <div class="mx-auto mb-5 w-full text-center">
            <h2 class="mx-auto mb-5 w-full lg:w-2/3 [&_svg]:inline">
                {!! __($fSectSettings->custom_templates_title) !!}
            </h2>
            <p class="mx-auto mb-0 w-full text-xl/[1.3em] opacity-80 lg:w-1/2">
                {!! $fSectSettings->custom_templates_description ?? 'Unrivaled AI Generators in terms of <strong>quality, versatility, and ease of use.</strong>' !!}
            </p>
        </div>
    </div>

    <div
        class="[--mask-from:10%] [--mask-to:90%]"
        style="mask-image: linear-gradient(to right, transparent, black var(--mask-from), black var(--mask-to), transparent);"
        x-data="marquee"
    >
        <div class="lqd-marquee-viewport relative flex w-full gap-6 overflow-hidden">
            <div class="lqd-marquee-slider flex w-full gap-6 py-10">
                @foreach ($templates as $item)
                    @if ($item->active !== 1 || $item->custom_template === 0)
                        @continue
                    @endif
                    @include('landing-page.custom-templates.item')
                @endforeach
            </div>
        </div>
    </div>

    <svg
        width="0"
        height="0"
    >
        <defs>
            <linearGradient
                id="icons-gradient-1"
                x1="0"
                y1="0"
                x2="1"
                y2="1"
            >
                <stop stop-color="#EB6434" />
                <stop
                    offset="0.5"
                    stop-color="#BB2D9F"
                />
                <stop
                    offset="1"
                    stop-color="#BB802D"
                />
            </linearGradient>
        </defs>
    </svg>
</section>
