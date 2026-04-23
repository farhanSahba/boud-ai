<section
    class="site-section relative flex min-h-screen items-center justify-center overflow-hidden py-64 text-center xl:py-52"
    id="banner"
>
    <figure
        @class([
            'absolute start-0 opacity-0 blur-lg origin-top-left duration-500 -translate-y-20 transition-all rotate-6 ease-out group-[.page-loaded]/body:opacity-100 group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:rotate-0 group-[.page-loaded]/body:blur-0',
            'top-10' => $fSectSettings->preheader_active,
            'top-0' => !$fSectSettings->preheader_active,
        ])
        aria-hidden="true"
    >
        <img
            src="{{ custom_theme_url('/assets/img/landing-page/banner-1.png') }}"
            alt="{{ __('Robot hand') }}"
            width="612"
            height="610"
        >
    </figure>
    <div class="container relative z-2">
        <div class="mx-auto flex w-full flex-col items-center lg:w-9/12">
            <h6
                class="relative mb-8 flex translate-y-6 items-center gap-4 text-2xs font-bold uppercase tracking-[0.26em] opacity-0 transition-all ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
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
                {!! __($fSetting->hero_subtitle) !!}
            </h6>
            <div class="banner-title-wrap relative">
                <h1
                    class="banner-title mb-11 translate-y-7 opacity-0 transition-all delay-[75ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
                    {!! __($fSetting->hero_title) !!}
                    @if ($fSetting->hero_title_text_rotator != null)
                        <span class="lqd-text-rotator inline-grid grid-cols-1 grid-rows-1 transition-[width] duration-200">
                            @foreach (explode(',', __($fSetting->hero_title_text_rotator)) as $keyword)
                                <span
                                    class="lqd-text-rotator-item {{ $loop->first ? 'lqd-is-active' : '' }} text-gradient col-start-1 row-start-1 inline-flex translate-x-3 opacity-0 blur-sm transition-all duration-300 [&.lqd-is-active]:translate-x-0 [&.lqd-is-active]:opacity-100 [&.lqd-is-active]:blur-0"
                                >
                                    <span>{!! $keyword !!}</span>
                                </span>
                            @endforeach
                        </span>
                    @endif
                    {!! __('technology.') !!}
                </h1>
            </div>
            <p
                class="mb-20 w-3/4 translate-y-3 text-xl leading-[1.25em] text-fuchsia-700 opacity-0 transition-all delay-[150ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:text-foreground group-[.page-loaded]/body:opacity-100 max-sm:w-full">
                {!! __($fSetting->hero_description) !!}
            </p>
            <div
                class="flex w-full translate-y-3 flex-wrap items-center justify-center gap-8 text-lg font-semibold opacity-0 transition-all delay-[225ms] group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
                @if ($fSetting->hero_button_type == 1)
                    <a
                        class="group relative inline-flex items-center overflow-hidden rounded-xl border-opacity-0 bg-primary px-7 py-4 text-primary-foreground transition-all duration-300 hover:scale-105 hover:bg-primary-foreground hover:text-primary hover:shadow-lg"
                        href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                    >
                        <span class="relative z-10 inline-flex items-center">
                            {!! __($fSetting->hero_button) !!}
                            <svg
                                class="ml-2"
                                width="11"
                                height="14"
                                viewBox="0 0 47 62"
                                fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M27.95 0L0 38.213H18.633V61.141L46.583 22.928H27.95V0Z"></path>
                            </svg>
                        </span>
                    </a>
                @else
                    <a
                        class="group inline-flex items-center justify-center rounded-full bg-primary px-4 py-3 text-primary-foreground transition-all duration-300 hover:scale-105 hover:bg-primary-foreground hover:text-primary hover:shadow-lg"
                        data-fslightbox="video-gallery"
                        href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                    >
                        <span
                            class="size-10 me-3 inline-flex items-center justify-center rounded-full bg-primary-foreground/15 transition-all group-hover:scale-110 group-hover:bg-primary group-hover:text-primary-foreground"
                        >
                            <x-tabler-player-play-filled class="size-4" />
                        </span>
                        {!! __($fSetting->hero_button) !!} &nbsp;
                    </a>
                @endif
                <a
                    class="transition-all hover:scale-105 hover:text-primary"
                    href="#features"
                >
                    {!! __($fSetting->hero_scroll_text) !!}
                </a>
            </div>
        </div>
    </div>
    <div class="banner-divider absolute inset-x-0 -bottom-[2px] z-0">
        <svg
            class="h-auto w-full fill-background"
            width="1919"
            height="473"
            viewBox="0 0 1919 473"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="none"
        >
            <path
                d="M240.526 0.00775146C142.249 -0.500153 56.5801 23.9957 -0.475952 43.7153V472.5H1919V63.827C1846.63 243.475 1648.54 451.696 1353.63 290.563C983.198 88.1616 979.376 597.655 677.682 224.259C536.267 49.2311 376.38 0.720612 240.526 0.00775146Z"
                fill="#EFF4F6"
            />
        </svg>
    </div>
</section>
