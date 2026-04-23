<footer
    class="site-footer relative"
    id="footer"
>
    <div class="container">
        <div
            class="rounded-t-[55px] bg-cover bg-center px-6 pt-16 sm:px-10"
            style="background-image: url({{ custom_theme_url('assets/landing-page/footer-bg.jpg') }})"
        >
            <div class="mb-10 grid grid-cols-2 gap-5 gap-x-24 lg:grid-cols-5">
                @for ($i = 1; $i <= 5; $i++)
                    <figure>
                        <img src="{{ custom_theme_url('assets/landing-page/logo-' . $i . '.svg') }}">
                    </figure>
                @endfor
            </div>

            <div class="flex flex-wrap items-end justify-between gap-y-8">
                <div class="w-full pb-10 sm:pb-16 lg:w-7/12">
                    <div
                        class="group mb-7 flex mix-blend-luminosity"
                        aria-hidden="true"
                    >
                        @for ($i = 1; $i <= 3; $i++)
                            <figure class="-me-4 transition-all group-hover:me-1">
                                <img
                                    class="rounded-full border-[3px] border-solid border-background"
                                    src="{{ custom_theme_url('assets/landing-page/footer-avatar-' . $i . '.jpg') }}"
                                    width="42"
                                    height="42"
                                >
                            </figure>
                        @endfor
                    </div>
                    <p class="lg:text-[50px]/1em mb-8 font-heading text-5xl font-bold leading-none tracking-[-0.01em] text-background">
                        {{ __($fSetting->footer_text) }}
                    </p>
                    <x-button
                        class="group inline-flex items-center gap-6 rounded-full bg-background py-3.5 pe-4 ps-2.5 text-xl font-medium text-heading-foreground outline-background transition-all hover:scale-105 hover:shadow-lg hover:outline-transparent"
                        variant="outline"
                        href="{{ !empty($fSetting->footer_button_url) ? $fSetting->footer_button_url : '#' }}"
                    >
                        <span
                            class="inline-grid size-12 shrink-0 place-items-center rounded-full border border-heading-foreground/5 bg-background text-heading-foreground group-hover:translate-x-1.5"
                        >
                            <svg
                                widh="20"
                                height="15"
                                viewBox="0 0 20 15"
                            >
                                <use href="#arrow-icon" />
                            </svg>
                        </span>
                        {!! __($fSetting->footer_button_text) !!}
                    </x-button>
                </div>

                <div
                    class="w-full lg:w-4/12"
                    aria-hidden="true"
                >
                    <figure>
                        <img
                            class="mix-blend-luminosity"
                            src="{{ custom_theme_url('assets/landing-page/footer-img-1.png') }}"
                            width="278"
                            height="424"
                        >
                    </figure>
                </div>
            </div>
        </div>

        <div class="relative z-1 bg-[#232323] lg:pb-12">
            <div class="container">
                <div class="flex flex-wrap justify-between gap-y-8 px-3 pt-10 sm:px-5 lg:px-14 lg:pt-24">
                    <div class="w-full md:w-1/3 md:pe-10 lg:w-4/12">
                        <p class="mb-5 inline-flex rounded-full border border-white/15 px-3 py-1.5 text-base leading-none text-white">
                            @lang('About' . ' ' . $setting->site_name)
                        </p>
                        <p class="text-white/70">
                            {{ __('With proven results and industry recognition, our platform is the go-to choice for professionals looking to elevate their social media presence and drive success.') }}
                        </p>
                    </div>

                    <div class="w-1/2 md:w-1/3 lg:w-2/12">
                        <p class="mb-5 inline-flex rounded-full border border-white/15 px-3 py-1.5 text-base leading-none text-white">
                            @lang('Channels')
                        </p>
                        <ul class="space-y-5 text-xs">
                            @foreach (\App\Models\SocialMediaAccounts::where('is_active', true)->get() as $social)
                                <li>
                                    <a
                                        class="relative text-white/70 transition-colors hover:text-primary hover:text-white [&.active]:text-primary"
                                        href="{{ $social['link'] }}"
                                    >
                                        {{ $social['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="w-1/2 md:w-1/3 lg:w-2/12">
                        <p class="mb-5 inline-flex rounded-full border border-white/15 px-3 py-1.5 text-base leading-none text-white">
                            @lang('Links')
                        </p>
                        <ul class="space-y-5 text-xs">
                            @php
                                $setting->menu_options = $setting->menu_options
                                    ? $setting->menu_options
                                    : '[{"title": "Home","url": "#banner","target": false},{"title": "Features","url": "#features","target": false},{"title": "How it Works","url": "#how-it-works","target": false},{"title": "Testimonials","url": "#testimonials","target": false},{"title": "Pricing","url": "#pricing","target": false},{"title": "FAQ","url": "#faq","target": false}]';
                                $menu_options = json_decode($setting->menu_options, true);
                            @endphp
                            @foreach ($menu_options as $menu_item)
                                <li>
                                    <a
                                        class="relative text-white/70 transition-colors hover:text-primary hover:text-white [&.active]:text-primary"
                                        href="{{ Route::currentRouteName() != 'index' ? url('/') . $menu_item['url'] : $menu_item['url'] }}"
                                        target="{{ $menu_item['target'] === false ? '_self' : '_blank' }}"
                                    >
                                        {{ __($menu_item['title']) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="w-full lg:w-3/12">
                        <p class="mb-5 inline-flex rounded-full border border-white/15 px-3 py-1.5 text-base leading-none text-white">
                            @lang('Find Us')
                        </p>
                        <ul class="flex flex-wrap items-center gap-x-6 gap-y-5 text-xs">
                            @foreach (\App\Models\SocialMediaAccounts::where('is_active', true)->get() as $social)
                                <li>
                                    <a
                                        class="inline-flex items-center gap-3 text-white/50 transition-all hover:text-white"
                                        href="{{ $social['link'] }}"
                                    >
                                        <span class="w-5 [&_path:not([fill=none])]:fill-current [&_svg:not([fill=none])]:fill-current [&_svg]:h-auto [&_svg]:w-full">
                                            {!! $social['icon'] !!}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="py-20 text-center">
                    <p class="w-full text-xs text-white/25">
                        {{ date('Y') . ' ' . $setting->site_name . '. ' . __($fSetting->footer_copyright) }}
                    </p>

                    <div class="mx-auto inline-flex">
                        @if (count(explode(',', $settings_two->languages)) > 1)
                            <div class="group relative mt-5 hidden items-center lg:block">
                                <x-button
                                    class="gap-3 text-white/55 before:absolute before:bottom-full before:end-0 before:h-7 before:w-full hover:!bg-none hover:text-white"
                                    variant="link"
                                >
                                    <span class="inline-grid size-10 place-items-center rounded-full border border-white/[8%]">
                                        <x-tabler-world
                                            class="size-6 text-white/30"
                                            stroke-width="1.5"
                                        />
                                    </span>
                                    {{ LaravelLocalization::getCurrentLocaleNative() }}
                                    <x-tabler-chevron-down class="size-4 text-white" />
                                </x-button>
                                <div
                                    class="pointer-events-none absolute bottom-[calc(100%+1rem)] end-0 min-w-[145px] translate-y-2 overflow-hidden rounded-md bg-white/70 text-black opacity-0 shadow-lg backdrop-blur transition-all group-hover:pointer-events-auto group-hover:translate-y-0 group-hover:opacity-100">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        @if (in_array($localeCode, explode(',', $settings_two->languages)))
                                            <a
                                                class="block border-b border-black/5 px-3 py-3 transition-colors last:border-none hover:border-white hover:bg-white"
                                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                                rel="alternate"
                                                hreflang="{{ $localeCode }}"
                                            >
                                                {{ country2flag(substr($properties['regional'], strrpos($properties['regional'], '_') + 1)) }}
                                                {{ $properties['native'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
