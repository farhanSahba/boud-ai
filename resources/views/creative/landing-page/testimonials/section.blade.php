{!! adsense_testimonials_728x90() !!}
<section
    class="site-section relative bg-contain bg-center bg-no-repeat pb-20 pt-28 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="testimonials"
    style="background-image: url({{ custom_theme_url('assets/img/landing-page/world-map.png') }})"
>
    <div class="absolute inset-x-0 top-0 z-0 w-full overflow-hidden [mask-image:linear-gradient(0deg,transparent,black)]">
        <marquee behavior="alternate">
            <div class="slide-on-scroll flex w-full gap-4">
                @for ($i = 0; $i < 2; $i++)
                    <span class="whitespace-nowrap font-heading text-[18vw] font-extrabold leading-none text-heading-foreground/5">
                        {{ __('Build for everyone') }}
                    </span>
                @endfor
            </div>
        </marquee>
    </div>
    <div class="container relative">
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
                {!! __($fSectSettings->testimonials_subtitle_one) !!}
                <span class="dot"></span>
                {!! __($fSectSettings->testimonials_subtitle_two) !!}
            </h6>
            <h2 class="mb-10">
                {!! __($fSectSettings->testimonials_title) !!}
            </h2>
            <p class="text-xl leading-7 [&_strong]:font-normal [&_strong]:text-heading-foreground">
                {!! $fSectSettings->testimonials_description ?? 'Trusted reviews from our businesses.' !!}
            </p>
        </div>
    </div>

    <div class="mb-32">
        <div
            class="testimonials-main-carousel text-[26px] leading-[1.27em] text-heading-foreground max-sm:text-lg max-sm:[&_.flickity-button-icon]:!left-1/4 max-sm:[&_.flickity-button-icon]:!top-1/4 max-sm:[&_.flickity-button-icon]:!h-1/2 max-sm:[&_.flickity-button-icon]:!w-1/2 [&_.flickity-button.next]:-right-16 max-md:[&_.flickity-button.next]:-right-10 [&_.flickity-button.previous]:-left-16 max-md:[&_.flickity-button.previous]:-left-10 [&_.flickity-button]:opacity-40 [&_.flickity-button]:transition-all [&_.flickity-button]:hover:bg-transparent [&_.flickity-button]:hover:opacity-100 [&_.flickity-button]:focus:shadow-none max-sm:[&_.flickity-button]:relative max-sm:[&_.flickity-button]:!left-auto max-sm:[&_.flickity-button]:!right-auto max-sm:[&_.flickity-button]:top-auto max-sm:[&_.flickity-button]:!mx-4 max-sm:[&_.flickity-button]:translate-y-0"
            data-flickity='{ "contain": true, "wrapAround": true, "pageDots": true, "prevNextButtons": false, "adaptiveHeight": true }'
        >
            @foreach ($testimonials as $item)
                @include('landing-page.testimonials.item-quote')
            @endforeach
        </div>
    </div>

    <div class="max-lg:11/12 mx-auto w-8/12 max-md:w-full">
        <div class="container">
            <div class="flex justify-center gap-20 opacity-80 max-lg:gap-12 max-sm:gap-4">
                @foreach ($clients as $entry)
                    <img
                        class="h-full w-full object-cover object-center"
                        style="max-width: 48px; max-height: 48px;"
                        src="{{ url('') . isset($entry->avatar) ? (str_starts_with($entry->avatar, 'asset') ? custom_theme_url($entry->avatar) : '/clientAvatar/' . $entry->avatar) : custom_theme_url('assets/img/auth/default-avatar.png') }}"
                        alt="{{ __($entry->alt) }}"
                        title="{{ __($entry->title) }}"
                    >
                @endforeach
            </div>
        </div>
    </div>
</section>
