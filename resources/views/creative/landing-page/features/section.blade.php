{!! adsense_features_728x90() !!}
<section
    class="site-section relative pb-20 pt-44 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="features"
>
    <div class="absolute inset-x-0 top-20 z-0 w-full overflow-hidden [mask-image:linear-gradient(0deg,transparent,black)]">
        <marquee behavior="alternate">
            <div class="slide-on-scroll flex w-full gap-4">
                @for ($i = 0; $i < 2; $i++)
                    <span class="whitespace-nowrap font-heading text-[15vw] font-extrabold leading-none text-heading-foreground/5">
                        {{ __('The future of AI') }}
                    </span>
                @endfor
            </div>
        </marquee>
    </div>
    <div class="container relative z-1">
        <div class="mb-20 flex flex-wrap items-end justify-between gap-y-8">
            <div class="w-full md:w-[48%]">
                <h6 class="relative mb-7 flex items-center gap-4 text-2xs font-bold uppercase tracking-[0.26em]">
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
                    {!! __('LET’S MEET') !!}
                </h6>
                <h2>
                    {!! __($fSectSettings->features_title) !!}
                </h2>
            </div>
            <div class="w-full md:w-[48%] md:text-end">
                <p class="text-xl">
                    {!! __($fSectSettings->features_description) ??
                        __('We offer a wide range of content creation capabilities, <span class="text-heading-foreground">from text to images, videos to audio files.</span>') !!}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-3 justify-between gap-8 max-lg:grid-cols-2 max-lg:gap-x-10 max-md:grid-cols-1">
            @foreach ($futures as $item)
                @include('landing-page.features.item')
            @endforeach
        </div>
    </div>
</section>
