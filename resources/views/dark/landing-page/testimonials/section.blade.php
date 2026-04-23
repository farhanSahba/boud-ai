{!! adsense_testimonials_728x90() !!}
<section
    class="site-section py-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="testimonials"
>
    <div class="container">
        <div class="relative w-full overflow-hidden rounded-3xl bg-black px-5 py-20 md:px-8 lg:px-20 lg:py-24">
            <figure
                class="pointer-events-none absolute start-1/2 top-0 z-0 w-full max-w-none -translate-x-1/2 -translate-y-1/2"
                aria-hidden="true"
            >
                <img
                    width="3110"
                    height="1142"
                    src="{{ custom_theme_url('/assets/landing-page/glow-1.png') }}"
                    alt="{{ __('Glowing blob') }}"
                />
            </figure>

            <header class="mb-24 flex flex-wrap items-end justify-between gap-y-5 [&_strong]:text-white/70">
                <div class="w-full lg:w-2/3 lg:pe-8">
                    <h6
                        class="relative mb-14 inline-flex translate-y-6 items-center gap-1.5 rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                        <x-tabler-rocket
                            class="size-5"
                            stroke-width="1.5"
                        />
                        {!! $fSectSettings->testimonials_subtitle_one ? __($fSectSettings->testimonials_subtitle_one) : __($fSetting->hero_subtitle) !!}
                    </h6>
                    <h2>
                        {!! __($fSectSettings->testimonials_title) !!}
                    </h2>
                </div>

                <div class="w-full lg:w-1/3">
                    <p class="mb-6">
                        {!! $fSectSettings->testimonials_description
                            ? __($fSectSettings->testimonials_description)
                            : __('Content and <strong>kickstart your earnings</strong> in minutes  kickstart your earnings in minutes') !!}
                    </p>
                </div>
            </header>

            <div class="relative mb-10 lg:-mx-24">
                <div class="absolute inset-x-0 top-1/2 z-0 -mt-9 h-px w-full -translate-y-1/2 bg-white/15"></div>
                <div
                    data-flickity='{ "asNavFor": ".testimonials-main-carousel", "contain": false, "pageDots": false, "cellAlign": "center", "prevNextButtons": false, "wrapAround": true, "draggable": false }'>
                    @for ($i = 0; $i < 2; $i++)
                        @foreach ($testimonials as $item)
                            @include('landing-page.testimonials.item-image')
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="relative mx-auto lg:mb-20 lg:w-1/2">
                <svg
                    class="absolute start-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"
                    width="471"
                    height="388"
                    viewBox="0 0 471 388"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        opacity="0.1"
                        d="M223.235 0L163.706 223.846V388H0V223.846L148.824 0H223.235ZM471 0L411.471 223.846V388H247.765V223.846L396.588 0H471Z"
                        fill="url(#paint0_linear_33_330)"
                    />
                    <defs>
                        <linearGradient
                            id="paint0_linear_33_330"
                            x1="0"
                            y1="194"
                            x2="471"
                            y2="194"
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
                <div
                    class="testimonials-main-carousel text-center text-xl/7 text-heading-foreground/60"
                    data-flickity='{ "contain": true, "wrapAround": true, "prevNextButtons": false, "pageDots": false, "adaptiveHeight": true }'
                >
                    @for ($i = 0; $i < 2; $i++)
                        @foreach ($testimonials as $item)
                            @include('landing-page.testimonials.item-quote')
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>
