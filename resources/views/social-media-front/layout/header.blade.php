@php
    $menu_items = app(App\Services\Common\FrontMenuService::class)->generate();
@endphp

<header
    @class([
        'site-header group/header relative z-50 transition-[background,shadow] text-sm',
    ])
    x-data="{
        windowScrollY: window.scrollY,
        navbarHeight: $refs.navbar.offsetHeight,
        navbarOffsetTop: $refs.navbar.offsetTop - parseInt(getComputedStyle($refs.navbar).marginTop, 10),
        isSticky: false,
        checkSticky: function() {
            if (this.windowScrollY > this.navbarOffsetTop) {
                this.isSticky = true;
            } else {
                this.isSticky = false;
            }
        },
        checkScroll() {
            this.windowScrollY = window.scrollY;
        }
    }"
    x-init="document.body.style.setProperty('--navbar-height', navbarHeight + 'px');
    checkSticky();"
    @resize.window.debounce.500ms="navbarOffsetTop = $refs.navbar.offsetTop - parseInt(getComputedStyle($refs.navbar).marginTop, 10);"
    @scroll.window="checkSticky(); checkScroll();"
    :class="{ 'lqd-is-sticky': isSticky }"
>
    @includeWhen($fSectSettings->preheader_active, 'landing-page.header.preheader')

    <div
        class="hidden"
        x-ref="navbar-placeholder"
        style="height: var(--navbar-height)"
        :class="{ 'hidden': !isSticky }"
    ></div>

    <div class="site-header-nav-wrap flex flex-col">
        <nav
            class="site-header-nav container relative top-0 z-40 flex items-center justify-between rounded-b-xl bg-background/60 px-6 py-4 text-xs font-medium shadow-[0px_4px_55px_hsl(0_0%_0%/5%)] backdrop-blur-xl backdrop-saturate-[125%] group-[.lqd-is-sticky]/header:fixed group-[.lqd-is-sticky]/header:start-1/2 group-[.lqd-is-sticky]/header:-translate-x-1/2 max-sm:px-2 sm:max-w-[calc(576px-2rem)] md:max-w-[calc(768px-2rem)] lg:max-w-[calc(992px-2rem)] xl:max-w-[calc(1170px-2rem)] min-[1500px]:max-w-[calc(1440px-2rem)]"
            id="frontend-local-navbar"
            x-ref="navbar"
        >
            <a
                class="site-logo relative basis-1/3 max-lg:basis-1/3 max-sm:shrink-0"
                href="{{ route('index') }}"
            >
                @if (isset($setting->logo_sticky))
                    <img
                        class="peer absolute start-0 top-1/2 -translate-y-1/2 translate-x-3 opacity-0 transition-all group-[.lqd-is-sticky]/header:translate-x-0 group-[.lqd-is-sticky]/header:opacity-100"
                        src="{{ custom_theme_url($setting->logo_sticky_path, true) }}"
                        @if (isset($setting->logo_sticky_2x_path)) srcset="/{{ $setting->logo_sticky_2x_path }} 2x" @endif
                        alt="{{ custom_theme_url($setting->site_name) }} logo"
                    >
                @endif
                <img
                    class="transition-all group-[.lqd-is-sticky]/header:peer-first:translate-x-2 group-[.lqd-is-sticky]/header:peer-first:opacity-0"
                    src="{{ custom_theme_url($setting->logo_path, true) }}"
                    @if (isset($setting->logo_2x_path)) srcset="/{{ $setting->logo_2x_path }} 2x" @endif
                    alt="{{ $setting->site_name }} logo"
                >
            </a>
            <div
                class="site-nav-container basis-1/3 transition-all max-lg:absolute max-lg:right-0 max-lg:top-full max-lg:max-h-0 max-lg:w-full max-lg:overflow-hidden max-lg:bg-background [&.lqd-is-active]:max-lg:max-h-[calc(100vh-150px)]">
                <div class="max-lg:max-h-[inherit] max-lg:overflow-y-scroll">
                    <ul class="flex items-center justify-center gap-14 whitespace-nowrap text-center max-xl:gap-10 max-lg:flex-col max-lg:items-start max-lg:gap-5 max-lg:p-10">
                        @foreach ($menu_items as $menu_item)
                            @php
                                $has_children = !empty($menu_item['mega_menu_id']);
                            @endphp
                            <li
                                @class([
                                    'group/li w-full flex flex-wrap items-center gap-2 relative',
                                    'has-children lg:after:absolute lg:after:top-full lg:after:-bottom-7 lg:after:w-full lg:after:start-0' => $has_children,
                                    'has-mega-menu' => !empty($menu_item['mega_menu_id']),
                                ])
                                x-data="{ hover: false }"
                                x-on:mouseover="if(window.innerWidth < 992 ) return; hover = true"
                                x-on:mouseleave="if(window.innerWidth < 992 ) return; hover = false"
                                :class="{ 'is-hover': hover }"
                            >
                                <a
                                    class="font-heading font-medium text-foreground/70 transition-colors group-hover/li:text-heading-foreground group-hover/li:after:origin-left group-hover/li:after:scale-x-100 lg:after:absolute lg:after:bottom-[-24px] lg:after:left-0 lg:after:h-1 lg:after:w-full lg:after:origin-right lg:after:scale-x-0 lg:after:bg-gradient-to-r lg:after:from-[--gradient-from] lg:after:via-[--gradient-via] lg:after:to-[--gradient-to] lg:after:transition-transform lg:[&.active]:text-heading-foreground lg:[&.active]:after:origin-left lg:[&.active]:after:scale-x-100"
                                    href="{{ Route::currentRouteName() != 'index' ? url('/') . $menu_item['url'] : $menu_item['url'] }}"
                                    target="{{ $menu_item['target'] === false ? '_self' : '_blank' }}"
                                >
                                    {{ __($menu_item['title']) }}
                                </a>
                                @if ($has_children)
                                    <span
                                        class="relative ms-auto inline-grid size-8 shrink-0 place-content-center align-middle before:absolute before:inset-0 before:rounded-xl before:bg-current before:opacity-5 lg:hidden"
                                        @click="hover = !hover"
                                    >
                                        <x-tabler-chevron-down class="size-4" />
                                    </span>
                                @endif
                                @if (!empty($menu_item['mega_menu_id']))
                                    @includeFirst(['mega-menu::partials.frontend-megamenu', 'vendor.empty'], ['menu_item' => $menu_item])
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @if (count(explode(',', $settings_two->languages)) > 1)
                        <div class="group relative -mt-3 block border-t border-white/5 px-10 pb-5 pt-6 md:hidden">
                            <p class="mb-3 flex items-center gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                    <path d="M3.6 9h16.8"></path>
                                    <path d="M3.6 15h16.8"></path>
                                    <path d="M11.5 3a17 17 0 0 0 0 18"></path>
                                    <path d="M12.5 3a17 17 0 0 1 0 18"></path>
                                </svg>
                                {{ __('Languages') }}
                            </p>
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                @if (in_array($localeCode, explode(',', $settings_two->languages)))
                                    <a
                                        class="block border-b border-black border-opacity-5 py-3 transition-colors last:border-none hover:bg-black hover:bg-opacity-5"
										href="{{ route('language.change', $localeCode) }}"
                                        rel="alternate"
                                        hreflang="{{ $localeCode }}"
                                    >{{ country2flag(substr($properties['regional'], strrpos($properties['regional'], '_') + 1)) }}
                                        {{ $properties['native'] }}</a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex basis-1/3 justify-end gap-2 max-lg:basis-2/3">
                @if (count(explode(',', $settings_two->languages)) > 1)
                    <div class="group relative me-1 hidden items-center md:flex">
                        <x-button
                            class="before:absolute before:end-0 before:top-full before:h-7 before:w-full hover:!bg-none hover:text-inherit"
                            variant="link"
                        >
                            <x-tabler-world
                                class="size-6 text-heading-foreground"
                                stroke-width="1.5"
                            />
                            <x-tabler-chevron-down class="size-4" />
                        </x-button>
                        <div
                            class="pointer-events-none absolute end-0 top-[calc(100%+1rem)] min-w-[145px] translate-y-2 rounded-md bg-white text-black opacity-0 shadow-lg transition-all group-hover:pointer-events-auto group-hover:translate-y-0 group-hover:opacity-100">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                @if (in_array($localeCode, explode(',', $settings_two->languages)))
                                    <a
                                        class="block border-b border-black border-opacity-5 px-3 py-3 transition-colors last:border-none hover:bg-black hover:bg-opacity-5"
										href="{{ route('language.change', $localeCode) }}"
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

                @auth
                    <x-button href="{{ route('dashboard.index') }}">
                        {{ __('Dashboard') }}
                    </x-button>
                @else
					<x-button
						class="bg-background text-heading-foreground shadow shadow-heading-foreground/5 outline outline-heading-foreground/5"
						variant="outline"
						hover-variant="primary"
						href="{{ route('login') }}"
					>
						{!! __($fSetting->sign_in) !!}
					</x-button>
                @endauth

                <button class="mobile-nav-trigger group flex size-10 shrink-0 items-center justify-center rounded-full bg-foreground/20 lg:hidden">
                    <span class="flex w-4 flex-col gap-1">
                        @for ($i = 0; $i <= 1; $i++)
                            <span
                                class="inline-flex h-[2px] w-full bg-current transition-transform first:origin-left last:origin-right group-[&.lqd-is-active]:first:-translate-y-[2px] group-[&.lqd-is-active]:first:translate-x-[3px] group-[&.lqd-is-active]:first:rotate-45 group-[&.lqd-is-active]:last:-translate-x-[2px] group-[&.lqd-is-active]:last:-translate-y-[8px] group-[&.lqd-is-active]:last:-rotate-45"
                            ></span>
                        @endfor
                    </span>
                </button>
            </div>
        </nav>
    </div>

    @includeWhen($fSetting->floating_button_active, 'landing-page.header.floating-button')
</header>

<script>
    (() => {
        const header = document.querySelector('.site-header');
        document.body.style.setProperty('--header-height', `${header.offsetHeight}px`)
    })();
</script>

@includeWhen($app_is_demo, 'landing-page.header.envato-link')

@includeWhen(in_array($settings_two->chatbot_status && ($settings_two->chatbot_login_require == false || ($settings_two->chatbot_login_require == true && auth()->check())), [
        'frontend',
        'both',
    ]),
    'panel.chatbot.widget',
    ['page' => 'landing-page']
)
