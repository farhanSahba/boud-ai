@php
    $learn_more_link = $fSectSettings->custom_templates_learn_more_link;
    $learn_more_link_url = $fSectSettings->custom_templates_learn_more_link_url;
    // fallback to banner settings
    if (!$learn_more_link) {
        $learn_more_link = $fSetting->hero_scroll_text;
    }
    if (!$learn_more_link_url) {
        $learn_more_link_url = '#templates';
    }
@endphp

{!! adsense_templates_728x90() !!}
<section
    class="site-section py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 lg:py-24 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="templates"
    x-data="{ 'showMore': false }"
>
    <svg
        width="0"
        height="0"
        viewBox="0 0 48 48"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <defs>
            <linearGradient
                id="custom-templates-gradient"
                x1="0"
                y1="24"
                x2="47.999"
                y2="24"
                gradientUnits="userSpaceOnUse"
            >
                <stop stop-color="#DBDADA" />
                <stop
                    offset="1"
                    stop-color="#7A7878"
                />
            </linearGradient>
        </defs>
    </svg>
    <div class="container">
        <header class="mx-auto mb-24 w-full text-center lg:w-4/5">
            <h6
                class="relative mb-12 inline-flex translate-y-6 items-center gap-1.5 overflow-hidden rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                <x-tabler-rocket
                    class="size-5"
                    stroke-width="1.5"
                />
                {!! $fSectSettings->custom_templates_subtitle_one ? __($fSectSettings->custom_templates_subtitle_one) : __($fSetting->hero_subtitle) !!}
            </h6>
            <h2 class="mb-12">
                {!! $fSectSettings->custom_templates_title ? __($fSectSettings->custom_templates_title) : __('Write anywhere and everywhere with thee custom templates') !!}
            </h2>
            <a
                class="group/btn flex items-center justify-center gap-2 text-white transition-colors hover:text-primary"
                href="{{ $learn_more_link_url }}"
            >
                {!! __($learn_more_link) !!}
                <x-tabler-chevron-right class="size-5 transition-transform group-hover/btn:translate-x-1" />
            </a>
        </header>

        <div class="grid grid-cols-3 gap-4 max-lg:grid-cols-2 max-md:grid-cols-1">
            @foreach ($templates as $item)
                @if ($item->active != 1)
                    @continue
                @endif
                @include('landing-page.custom-templates.item')
            @endforeach
        </div>

        <div class="mt-24 text-center">
            <a
                class="group/btn flex items-center justify-center gap-2 text-white transition-colors hover:text-primary"
                href="#"
                @click.prevent="showMore = !showMore; setTimeout(() => { !showMore && window.scrollTo({ top: ($el.getBoundingClientRect().top + window.scrollY) - ( window.innerHeight / 2 ), behavior: 'instant' }) }, 10 )"
            >
                <span :class="{ 'hidden': showMore }">
                    {{ trans('Show More') }}
                </span>
                <span
                    class="hidden"
                    :class="{ 'hidden': !showMore }"
                >
                    {{ trans('Show Less') }}
                </span>
                <x-tabler-chevron-right class="size-5 transition-transform group-hover/btn:translate-x-1" />
            </a>
        </div>
    </div>
</section>
