<section
    class="site-section group relative pt-4 [&_strong]:text-white/75"
    id="banner"
>
    <div class="container relative w-full max-w-[1680px]">
        <div
            class="relative flex w-full translate-y-8 scale-[0.985] flex-wrap items-start gap-y-8 overflow-hidden rounded-3xl bg-black px-5 py-32 pb-80 opacity-0 transition-all duration-700 group-[&.lqd-is-in-view]:translate-y-0 group-[&.lqd-is-in-view]:scale-100 group-[&.lqd-is-in-view]:opacity-100 md:px-8 lg:min-h-[80vh] lg:items-center lg:justify-between lg:px-20 lg:pt-36">
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
            <figure
                class="pointer-events-none absolute bottom-0 start-0 z-0 w-full max-w-none -translate-x-1/4 opacity-50"
                aria-hidden="true"
            >
                <img
                    width="2942"
                    height="1294"
                    src="{{ custom_theme_url('/assets/landing-page/glow-2.png') }}"
                    alt="{{ __('Glowing blob') }}"
                />
            </figure>

            <div class="w-full lg:w-8/12">
                <h6
                    class="relative mb-8 inline-flex translate-y-6 items-center gap-1.5 overflow-hidden rounded-full bg-secondary px-5 py-2 text-secondary-foreground opacity-0 shadow-xs shadow-primary transition-all delay-200 ease-out group-[&.lqd-is-in-view]:translate-y-0 group-[&.lqd-is-in-view]:opacity-100">
                    <div
                        class="banner-subtitle-gradient pointer-events-none absolute -inset-3 blur-2xl transition-all delay-150 duration-500 group-[&.lqd-is-in-view]:translate-x-2/3 group-[&.lqd-is-in-view]:opacity-0">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-green-200"></div>
                    </div>
                    <x-tabler-rocket
                        class="size-5"
                        stroke-width="1.5"
                    />
                    {!! __($fSetting->hero_subtitle) !!}
                </h6>

                <div class="banner-title-wrap relative">
                    <h1
                        class="banner-title mb-7 translate-y-7 font-body font-bold -tracking-wide opacity-0 transition-all delay-300 ease-out group-[&.lqd-is-in-view]:translate-y-0 group-[&.lqd-is-in-view]:opacity-100">
                        {!! __($fSetting->hero_title) !!}
                        @if ($fSetting->hero_title_text_rotator != null)
                            <span class="lqd-text-rotator grid w-full grid-cols-1 grid-rows-1 transition-[width] duration-200 md:whitespace-nowrap">
                                @foreach (explode(',', __($fSetting->hero_title_text_rotator)) as $keyword)
                                    <span
                                        class="lqd-text-rotator-item {{ $loop->first ? 'lqd-is-active' : '' }} col-start-1 row-start-1 inline-flex w-full translate-x-3 opacity-0 blur-sm transition-all duration-300 [&.lqd-is-active]:translate-x-0 [&.lqd-is-active]:opacity-100 [&.lqd-is-active]:blur-0"
                                    >
                                        <span class="group-[&.lqd-is-in-view]:opacity-55 transition-all delay-500 duration-500">{!! $keyword !!}</span>
                                    </span>
                                @endforeach
                            </span>
                        @endif
                    </h1>
                    <div
                        class="pointer-events-none absolute inset-0 bg-gradient-to-r from-primary to-transparent mix-blend-darken blur-2xl transition-all delay-[400ms] duration-500 group-[&.lqd-is-in-view]:translate-x-full">
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-4/12">
                <p
                    class="mb-9 translate-y-3 text-xl/7 text-white/40 opacity-0 transition-all delay-[450ms] ease-out group-[&.lqd-is-in-view]:translate-y-0 group-[&.lqd-is-in-view]:opacity-100">
                    {!! __($fSetting->hero_description) !!}
                </p>

                <div class="flex flex-wrap items-center gap-8 text-sm">
                    <div class="translate-y-3 opacity-0 transition-all delay-[600ms] group-[&.lqd-is-in-view]:translate-y-0 group-[&.lqd-is-in-view]:opacity-100">
                        @if ($fSetting->hero_button_type == 1)
                            <a
                                class="relative inline-flex w-56 gap-3 overflow-hidden whitespace-nowrap rounded-lg bg-gradient-to-r from-gradient-from to-gradient-to to-50% py-5 font-semibold text-primary-foreground transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-primary/20"
                                href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                            >
                                <span
                                    class="flex animate-marquee justify-between gap-3 before:content-[attr(data-txt)] after:content-[attr(data-txt)]"
                                    data-txt="{!! __($fSetting->hero_button) !!}"
                                >
                                    {!! __($fSetting->hero_button) !!}
                                </span>
                                <span
                                    class="absolute start-3 top-5 flex animate-marquee-2 justify-between gap-3 before:content-[attr(data-txt)] after:content-[attr(data-txt)]"
                                    data-txt="{!! __($fSetting->hero_button) !!}"
                                >
                                    {!! __($fSetting->hero_button) !!}
                                </span>
                            </a>
                        @else
                            <a
                                class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-3 font-semibold text-black transition-all duration-300 hover:bg-opacity-20"
                                data-fslightbox="video-gallery"
                                href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                            >
                                <svg
                                    class="icon icon-tabler icon-tabler-player-play-filled me-4 bg-white"
                                    style="padding: 13px; border-radius: 2rem;"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="40"
                                    height="40"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    ></path>
                                    <path
                                        d="M6 4v16a1 1 0 0 0 1.524 .852l13 -8a1 1 0 0 0 0 -1.704l-13 -8a1 1 0 0 0 -1.524 .852z"
                                        stroke-width="0"
                                        fill="#37393d"
                                    ></path>
                                </svg>
                                {!! __($fSetting->hero_button) !!} &nbsp;
                            </a>
                        @endif
                    </div>
                    <div class="translate-y-3 opacity-0 transition-all delay-[600ms] group-[&.lqd-is-in-view]:translate-y-0 group-[&.lqd-is-in-view]:opacity-100">
                        <a
                            class="group/btn flex items-center gap-2 text-white transition-colors hover:text-primary"
                            href="#clients"
                        >
                            {!! __($fSetting->hero_scroll_text) !!}
                            <x-tabler-chevron-right class="size-5 transition-transform group-hover/btn:translate-x-1" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section
    class="site-section group relative z-2 -mt-64 overflow-hidden p-0.5 px-5 lg:px-0"
    id="banner-ig"
>
    <div class="container">
        <figure
            class="relative translate-y-4 rounded-3xl opacity-0 transition-all delay-[650ms] duration-500 group-[&.lqd-is-in-view]:translate-y-0 group-[&.lqd-is-in-view]:opacity-100"
        >
            <img
                class="w-full rounded-3xl"
                width="2880"
                height="1750"
                src="{{ $fSetting->hero_image }}"
                alt="{{ __('Image of ' . $setting->site_name . ' dashboard') }}"
            >
            <x-outline-glow />
            <x-outline-glow class="[&_.lqd-outline-glow-inner]:[animation-direction:alternate]" />
        </figure>
    </div>
</section>
