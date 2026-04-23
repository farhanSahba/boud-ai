<footer class="site-footer relative pb-20 pt-20 lg:pt-40">
    <div class="absolute bottom-0 start-0 w-full">
        <svg
            class="h-auto w-full"
            width="1920"
            height="392"
            viewBox="0 0 1920 392"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="none"
        >
            <path
                d="M1471.91 61.0162C1371.64 61.7729 1257.15 89.2924 1131.3 162.855C682.907 424.919 -56.8224 743.726 -399 352.635V510.317H1894V236.557C1838.62 182.552 1688.47 59.3748 1471.91 61.0162Z"
                fill="#F4F4F9"
            />
            <path
                d="M241.526 0.00799561C143.249 -0.499908 57.5801 23.9959 0.524048 43.7156V472.5H1920V63.8272C1847.63 243.476 1649.54 451.696 1354.63 290.563C984.198 88.1618 980.376 597.656 678.682 224.259C537.267 49.2313 377.38 0.720856 241.526 0.00799561Z"
                fill="#EFF4F6"
            />
        </svg>
    </div>
    <div class="relative z-1">
        <div class="container mb-28">
            <div class="mx-auto w-1/2 text-center max-lg:w-10/12 max-sm:w-full">
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
                    {{ __($fSetting->footer_text_small) }}
                </h6>
                <p class="mx-auto mb-11 font-heading text-[84px] font-bold leading-none tracking-[--h1-letter-spacing] text-heading-foreground max-sm:text-[18vw] lg:w-2/3">
                    {{ __($fSetting->footer_header) }}
                </p>
                <p class="mb-20 px-10 text-xl font-normal leading-7">
                    {{ __($fSetting->footer_text) }}
                </p>
                <a
                    class="group relative inline-flex items-center overflow-hidden rounded-full border-opacity-0 bg-primary px-7 py-4 text-primary-foreground transition-all duration-300 hover:scale-105 hover:bg-primary-foreground hover:text-primary hover:shadow-lg"
                    href="{{ !empty($fSetting->footer_button_url) ? $fSetting->footer_button_url : '#' }}"
                    target="_blank"
                >
                    <span class="relative z-10 inline-flex items-center gap-3">
                        <x-tabler-arrow-right class="size-5" />
                        {!! __($fSetting->footer_button_text) !!}
                    </span>
                </a>
            </div>
        </div>

        <div class="container">
            <div class="flex flex-wrap items-center justify-between gap-8 border-b pb-7 pt-10 max-sm:justify-center">
                <a href="{{ route('index') }}">
                    @if (isset($setting->logo_2x_path))
                        <img
                            src="{{ custom_theme_url($setting->logo_path, true) }}"
                            srcset="/{{ $setting->logo_2x_path }} 2x"
                            alt="{{ $setting->site_name }} logo"
                        >
                    @else
                        <img
                            src="{{ custom_theme_url($setting->logo_path, true) }}"
                            alt="{{ $setting->site_name }} logo"
                        >
                    @endif
                </a>
                <ul class="flex flex-wrap items-center justify-center gap-14 whitespace-nowrap text-sm max-xl:gap-10 max-lg:gap-5">
                    @php
                        $setting->menu_options = $setting->menu_options
                            ? $setting->menu_options
                            : '[{"title": "Home","url": "#banner","target": false},{"title": "Features","url": "#features","target": false},{"title": "How it Works","url": "#how-it-works","target": false},{"title": "Testimonials","url": "#testimonials","target": false},{"title": "Pricing","url": "#pricing","target": false},{"title": "FAQ","url": "#faq","target": false}]';
                        $menu_options = json_decode($setting->menu_options, true);
                    @endphp
                    @foreach ($menu_options as $menu_item)
                        <li>
                            <a
                                class="relative transition-colors hover:text-primary [&.active]:text-primary"
                                href="{{ Route::currentRouteName() != 'index' ? url('/') . $menu_item['url'] : $menu_item['url'] }}"
                                target="{{ $menu_item['target'] === false ? '_self' : '_blank' }}"
                            >
                                {{ __($menu_item['title']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-4 py-9 max-sm:text-center">
                <p
                    class="w-full text-xs opacity-50 lg:w-[40%]"
                    style="color: {{ $fSetting->footer_text_color }};"
                >
                    {{ date('Y') . ' ' . $setting->site_name . '. ' . __($fSetting->footer_copyright) }}
                </p>
                <div class="w-full lg:w-[40%]">
                    <ul class="flex flex-wrap items-center gap-7 text-xs max-sm:justify-center lg:justify-end">
                        @foreach (\App\Models\SocialMediaAccounts::where('is_active', true)->get() as $social)
                            <li>
                                <a
                                    class="inline-flex items-center gap-2"
                                    href="{{ $social['link'] }}"
                                >
                                    <span class="w-3.5 [&_svg]:h-auto [&_svg]:w-full">
                                        {!! $social['icon'] !!}
                                    </span>
                                    {{ $social['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
