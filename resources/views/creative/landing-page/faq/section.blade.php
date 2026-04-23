{!! adsense_faq_728x90() !!}
<section
    class="site-section pb-24 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="faq"
>
    <div class="container relative">
        <figure
            class="absolute end-0 top-0 hidden [mask-image:linear-gradient(0deg,transparent_15%,black_60%)] lg:block"
            aria-hidden="true"
        >
            <img
                src="{{ custom_theme_url('/assets/img/landing-page/robo-head.png') }}"
                alt="{{ __('Robot') }}"
                width="265"
                height="240"
            >
        </figure>

        <div class="mx-auto mb-20 w-full text-center lg:w-2/3">
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
                {!! __($fSectSettings->faq_text_one) !!}
                <span class="dot"></span>
                {!! __($fSectSettings->faq_text_two) !!}
            </h6>
            <h2 class="mb-10">
                {!! __($fSectSettings->faq_title) !!}
            </h2>
            <p class="text-xl leading-7 [&_strong]:font-normal [&_strong]:text-heading-foreground">
                {!! $fSectSettings->faq_subtitle ?? 'Trusted reviews from our businesses.' !!}
            </p>
        </div>

        <div
            class="lqd-accordion mx-auto w-5/6 max-lg:w-full"
            x-data="{
                'activeIndex': 0
            }"
        >
            @foreach ($faq as $item)
                @include('landing-page.faq.item')
            @endforeach
        </div>
    </div>
</section>
