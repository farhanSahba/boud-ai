{!! adsense_templates_728x90() !!}
<section
    class="site-section pb-9 pt-20 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="templates"
    x-data="{ 'showAll': false }"
>
    <div class="absolute inset-x-0 top-0 z-0 w-full overflow-hidden [mask-image:linear-gradient(0deg,transparent,black)]">
        <marquee behavior="alternate">
            <div class="slide-on-scroll flex w-full gap-4">
                @for ($i = 0; $i < 2; $i++)
                    <span class="whitespace-nowrap font-heading text-[18vw] font-extrabold leading-none text-heading-foreground/5">
                        {{ __('Custom promt templates') }}
                    </span>
                @endfor
            </div>
        </marquee>
    </div>
    <div class="container">
        <div class="mx-auto mb-24 w-full text-center lg:w-2/3">
            <h6 class="relative mb-7 flex items-center justify-center gap-4 text-2xs font-bold uppercase tracking-[0.26em]">
                <svg
                    width="21"
                    height="21"
                    viewBox="0 0 21 21"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        width="21"
                        height="21"
                        rx="4"
                        fill="url(#paint0_linear_90_1196)"
                    />
                    <path
                        d="M11.4857 4L6 11.5H9.65705V16L15.1427 8.50002H11.4857V4Z"
                        fill="#EDF3F5"
                    />
                    <defs>
                        <linearGradient
                            id="paint0_linear_90_1196"
                            x1="0"
                            y1="10.5"
                            x2="21"
                            y2="10.5"
                            gradientUnits="userSpaceOnUse"
                        >
                            <stop stop-color="#1D5580" />
                            <stop
                                offset="1"
                                stop-color="#102E3B"
                            />
                        </linearGradient>
                    </defs>
                </svg>
                {!! __($fSectSettings->custom_templates_subtitle_one) !!}
                <span class="dot"></span>
                {!! __($fSectSettings->custom_templates_subtitle_two) !!}
            </h6>
            <h2 class="mb-10">
                {!! __($fSectSettings->custom_templates_title) !!}
            </h2>
            <p class="text-xl leading-7 [&_strong]:font-normal [&_strong]:text-heading-foreground">
                {!! $fSectSettings->custom_templates_description ?? 'Unrivaled AI Generators in terms of <strong>quality, versatility, and ease of use.</strong>' !!}
            </p>
        </div>

        <div class="relative">
            <div class="templates-cards grid grid-cols-3 gap-4 max-lg:grid-cols-2 max-md:grid-cols-1">
                @foreach ($templates as $item)
                    @if ($item->active != 1)
                        @continue
                    @endif
                    @include('landing-page.custom-templates.item')
                @endforeach
            </div>
        </div>

        <div
            class="relative z-20 mt-4 text-center"
            :class="{ 'hidden': showAll }"
        >
            <button
                class="hove inline-flex items-center gap-1.5 rounded-lg bg-purple-800/10 px-3 py-2 text-xs font-semibold leading-none text-purple-800 transition-all hover:bg-purple-500 hover:text-white"
                @click.prevent="showAll = true"
            >
                <x-tabler-plus class="size-4" />
                {{ __('Show more') }}
            </button>
        </div>
    </div>
</section>
