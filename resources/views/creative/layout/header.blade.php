@php
    $menu_items = app(App\Services\Common\FrontMenuService::class)->generate();
@endphp

<header
    @class([
        'site-header group/header absolute inset-x-0 top-0 z-50 transition-[background,shadow] text-sm',
    ])
    x-data="{ navOffsetTop: $refs.navbar.offsetTop - parseInt(getComputedStyle($refs.navbar).marginTop, 10), isSticky: false }"
    x-init="window.scrollY > navOffsetTop && (isSticky = true)"
    @resize.window.debounce.500ms="navOffsetTop = $refs.navbar.offsetTop - parseInt(getComputedStyle($refs.navbar).marginTop, 10)"
    @scroll.window="window.scrollY > navOffsetTop ? (isSticky = true) : (isSticky = false)"
    :class="{ 'lqd-is-sticky': isSticky }"
>
    @includeWhen($fSectSettings->preheader_active, 'landing-page.header.preheader')

    <div class="site-header-nav-wrap flex flex-col">
        <div class="site-header-nav-secondary mx-auto w-full px-4 pb-3 pt-6 xl:w-[calc(80vw-1rem)] xl:px-0">
            <div class="flex items-center justify-between gap-2">
                <div class="basis-1/2">
                    <ul class="site-header-socials relative z-10 flex flex-wrap items-center gap-6">
                        <li>
                            <a
                                href="#"
                                title="{{ __('Facebook') }}"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 16 16"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M13.6562 0H2.34375C1.05151 0 0 1.05151 0 2.34375V13.6562C0 14.9485 1.05151 16 2.34375 16H7.0625V10.3438H5.1875V7.53125H7.0625V5.625C7.0625 4.0741 8.3241 2.8125 9.875 2.8125H12.7188V5.625H9.875V7.53125H12.7188L12.25 10.3438H9.875V16H13.6562C14.9485 16 16 14.9485 16 13.6562V2.34375C16 1.05151 14.9485 0 13.6562 0Z"
                                    />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                title="{{ __('Twitter') }}"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 16 16"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M16 3.039C15.405 3.3 14.771 3.473 14.11 3.557C14.79 3.151 15.309 2.513 15.553 1.744C14.919 2.122 14.219 2.389 13.473 2.538C12.871 1.897 12.013 1.5 11.077 1.5C9.261 1.5 7.799 2.974 7.799 4.781C7.799 5.041 7.821 5.291 7.875 5.529C5.148 5.396 2.735 4.089 1.114 2.098C0.831 2.589 0.665 3.151 0.665 3.756C0.665 4.892 1.25 5.899 2.122 6.482C1.595 6.472 1.078 6.319 0.64 6.078C0.64 6.088 0.64 6.101 0.64 6.114C0.64 7.708 1.777 9.032 3.268 9.337C3.001 9.41 2.71 9.445 2.408 9.445C2.198 9.445 1.986 9.433 1.787 9.389C2.212 10.688 3.418 11.643 4.852 11.674C3.736 12.547 2.319 13.073 0.785 13.073C0.516 13.073 0.258 13.061 0 13.028C1.453 13.965 3.175 14.5 5.032 14.5C11.068 14.5 14.368 9.5 14.368 5.166C14.368 5.021 14.363 4.881 14.356 4.742C15.007 4.28 15.554 3.703 16 3.039Z"
                                    />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                title="{{ __('Instagram') }}"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 16 16"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M11.5844 0H4.4153C1.98071 0 0 1.9808 0 4.4154V11.5845C0 14.0192 1.98071 15.9999 4.4153 15.9999H11.5844C14.0192 15.9999 15.9999 14.0191 15.9999 11.5845V4.4154C16 1.9808 14.0192 0 11.5844 0ZM14.5804 11.5845C14.5804 13.2364 13.2364 14.5803 11.5845 14.5803H4.4153C2.76347 14.5804 1.41959 13.2364 1.41959 11.5845V4.4154C1.41959 2.76356 2.76347 1.41959 4.4153 1.41959H11.5844C13.2363 1.41959 14.5803 2.76356 14.5803 4.4154V11.5845H14.5804Z"
                                    />
                                    <path
                                        d="M7.99972 3.87695C5.72639 3.87695 3.87695 5.72639 3.87695 7.99972C3.87695 10.273 5.72639 12.1223 7.99972 12.1223C10.2731 12.1223 12.1225 10.273 12.1225 7.99972C12.1225 5.72639 10.2731 3.87695 7.99972 3.87695ZM7.99972 10.7026C6.50925 10.7026 5.29654 9.4901 5.29654 7.99963C5.29654 6.50906 6.50916 5.29645 7.99972 5.29645C9.49029 5.29645 10.7029 6.50906 10.7029 7.99963C10.7029 9.4901 9.4902 10.7026 7.99972 10.7026Z"
                                    />
                                    <path
                                        d="M12.2949 2.67383C12.0214 2.67383 11.7528 2.78456 11.5596 2.97857C11.3655 3.17163 11.2539 3.44041 11.2539 3.71486C11.2539 3.98846 11.3656 4.25714 11.5596 4.45115C11.7527 4.64422 12.0214 4.75589 12.2949 4.75589C12.5694 4.75589 12.8372 4.64422 13.0312 4.45115C13.2252 4.25714 13.336 3.98837 13.336 3.71486C13.336 3.44041 13.2252 3.17163 13.0312 2.97857C12.8382 2.78456 12.5694 2.67383 12.2949 2.67383Z"
                                    />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="basis-1/2 text-end font-medium text-heading-foreground">
                    <div class="flex items-center justify-end gap-4">
                        @if (!auth()->check())
                            <a
                                class="relative inline-flex items-center"
                                href="{{  (route('login')) }}"
                            >
                                {!! __($fSetting->sign_in) !!}
                            </a>
                        @endif
                        @if (count(explode(',', $settings_two->languages)) > 1)
                            <div class="group relative z-50">
                                <button
                                    class="relative z-50 inline-flex items-center justify-center before:absolute before:end-0 before:top-full before:h-4 before:w-full group-hover:!border-opacity-100"
                                >
                                    <span class="flex items-center gap-1.5">
                                        {{ country2flag(substr(LaravelLocalization::getCurrentLocaleRegional(), strrpos(LaravelLocalization::getCurrentLocaleRegional(), '_') + 1)) }}
                                        {{ LaravelLocalization::getCurrentLocaleName() }}
                                    </span>
                                </button>
                                <div
                                    class="pointer-events-none absolute end-0 top-[calc(100%+0.8rem)] z-50 min-w-[145px] translate-y-2 rounded-md bg-white text-black opacity-0 shadow-lg transition-all group-hover:pointer-events-auto group-hover:translate-y-0 group-hover:opacity-100">
                                    @foreach (\App\Helpers\Classes\Localization::getSupportedLocales() as $localeCode => $properties)
                                        @if (in_array($localeCode, explode(',', $settings_two->languages)))
                                            <a
                                                class="block border-b border-black border-opacity-5 px-3 py-3 transition-colors last:border-none hover:bg-black hover:bg-opacity-5"
												rel="alternate"
												hreflang="{{ $localeCode }}"
												href="{{ route('language.change', $localeCode) }}"
                                            >
                                                {{ country2flag(substr($properties['regional'], strrpos($properties['regional'], '_') + 1)) }}
                                                {{ $properties['native'] }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <nav
            class="site-header-nav relative top-0 z-40 mx-auto mt-3 flex w-[calc(100%-1rem)] items-center justify-between rounded-xl bg-background/95 px-6 py-4 text-xs font-medium shadow-[0px_4px_40px_hsl(0_0%_0%/8%)] backdrop-blur-sm group-[.lqd-is-sticky]/header:fixed group-[.lqd-is-sticky]/header:start-1/2 group-[.lqd-is-sticky]/header:-translate-x-1/2 max-sm:px-2 xl:w-[calc(80vw-1rem)]"
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
                                    'group/li w-full relative flex flex-wrap items-center gap-2 after:pointer-events-none after:absolute after:-inset-x-4 after:bottom-[calc(var(--sub-offset,0)*-1)] after:top-full [&.is-hover]:after:pointer-events-auto',
                                    'has-children' => $has_children,
                                    'has-mega-menu' => !empty($menu_item['mega_menu_id']),
                                ])
                                x-data="{ hover: false }"
                                x-on:mouseover="if(window.innerWidth < 992 ) return; hover = true"
                                x-on:mouseleave="if(window.innerWidth < 992 ) return; hover = false"
                                :class="{ 'is-hover': hover }"
                            >
                                <a
                                    class="relative transition-colors hover:text-primary [&.active]:text-primary"
                                    href="{{ Route::currentRouteName() != 'index' ? url('/') . $menu_item['url'] : $menu_item['url'] }}"
                                    target="{{ $menu_item['target'] === false ? '_self' : '_blank' }}"
                                >
                                    <small>
                                        {{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </small>
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
                </div>
            </div>
            <div class="flex basis-1/3 justify-end gap-2 max-lg:basis-2/3">
                @auth
                    <div>
                        <x-button href="{{ route('dashboard.index') }}">
                            {{ __('Dashboard') }}
                        </x-button>
                    </div>
                @else
                    <x-button href="{{ route('register') }}">
                        {!! __($fSetting->join_hub) !!}
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

@includeWhen($app_is_demo, 'landing-page.header.envato-link')

@includeWhen(in_array($settings_two->chatbot_status && ($settings_two->chatbot_login_require == false || ($settings_two->chatbot_login_require == true && auth()->check())), [
        'frontend',
        'both',
    ]),
    'panel.chatbot.widget',
    ['page' => 'landing-page']
)
