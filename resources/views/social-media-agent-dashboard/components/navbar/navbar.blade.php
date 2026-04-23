<a
    class="lqd-skip-link pointer-events-none fixed start-7 top-7 z-[9999] rounded-md bg-background px-3 py-1 text-lg opacity-0 shadow-xl focus-visible:pointer-events-auto focus-visible:opacity-100 focus-visible:outline-primary"
    href="#lqd-titlebar"
>
    {{ __('Skip to content') }}
</a>
<aside
    class="lqd-navbar no-scrollbar start-0 top-0 z-[99] w-[--navbar-width] shrink-0 overflow-hidden rounded-ee-navbar-ee rounded-es-navbar-es rounded-se-navbar-se rounded-ss-navbar-ss border-navbar-border bg-navbar-background text-navbar font-medium text-navbar-foreground transition-all max-lg:invisible max-lg:absolute max-lg:left-0 max-lg:top-[65px] max-lg:z-[99] max-lg:max-h-[calc(85vh-2rem)] max-lg:min-h-0 max-lg:w-full max-lg:origin-top max-lg:-translate-y-2 max-lg:scale-95 max-lg:rounded-b max-lg:bg-background max-lg:p-0 max-lg:opacity-0 max-lg:shadow-xl lg:fixed lg:bottom-0 lg:top-0 lg:border-e max-lg:[&.lqd-is-active]:visible max-lg:[&.lqd-is-active]:translate-y-0 max-lg:[&.lqd-is-active]:scale-100 max-lg:[&.lqd-is-active]:opacity-100"
    x-init
    :class="{ 'lqd-is-active': !$store.mobileNav.navCollapse }"
    @click.outside="$store.navbarShrink.toggle('shrink')"
    @mouseleave="$store.navbarShrink.toggle('shrink')"
>
    <div
        class="lqd-navbar-inner group/navbar-inner no-scrollbar h-full justify-between gap-2 overflow-y-auto overscroll-contain pe-navbar-pe ps-navbar-ps max-lg:max-h-[inherit] lg:group-[&.navbar-shrinked]/body:flex lg:group-[&.navbar-shrinked]/body:flex-col lg:group-[&.navbar-shrinked]/body:items-center lg:group-[&.navbar-shrinked]/body:justify-between">

        <div
            class="lqd-navbar-logo relative grid min-h-[--header-height] max-w-full items-center pe-navbar-link-pe ps-navbar-link-ps group-[.navbar-shrinked]/body:w-full group-[.navbar-shrinked]/body:place-items-center group-[.navbar-shrinked]/body:justify-center group-[.navbar-shrinked]/body:px-0 group-[.navbar-shrinked]/body:text-center max-lg:hidden lg:before:content-none">
            <x-progressive-blur
                class="lqd-navbar-logo-blur hidden lg:-bottom-4 lg:-end-navbar-pe lg:-start-navbar-ps lg:block"
                dir="reverse"
            />

            <a
                class="relative z-1 col-start-1 col-end-1 row-start-1 row-end-1 block w-fit px-0 transition-all group-[.navbar-shrinked]/body:group-hover/navbar-inner:invisible group-[.navbar-shrinked]/body:group-hover/navbar-inner:scale-50 group-[.navbar-shrinked]/body:group-hover/navbar-inner:opacity-0"
                href="{{ route('dashboard.index') }}"
            >
                @if (isset($setting->logo_dashboard))
                    <img
                        class="h-auto w-full group-[.navbar-shrinked]/body:hidden dark:hidden"
                        src="{{ custom_theme_url($setting->logo_dashboard_path, true) }}"
                        @if (isset($setting->logo_dashboard_2x_path) && !empty($setting->logo_dashboard_2x_path)) srcset="/{{ $setting->logo_dashboard_2x_path }} 2x" @endif
                        alt="{{ $setting->site_name }}"
                    >
                    <img
                        class="hidden h-auto w-full group-[.navbar-shrinked]/body:hidden dark:block"
                        src="{{ custom_theme_url($setting->logo_dashboard_dark_path, true) }}"
                        @if (isset($setting->logo_dashboard_dark_2x_path) && !empty($setting->logo_dashboard_dark_2x_path)) srcset="/{{ $setting->logo_dashboard_dark_2x_path }} 2x" @endif
                        alt="{{ $setting->site_name }}"
                    >
                @else
                    <img
                        class="h-auto w-full group-[.navbar-shrinked]/body:hidden dark:hidden"
                        src="{{ custom_theme_url($setting->logo_path, true) }}"
                        @if (isset($setting->logo_2x_path) && !empty($setting->logo_2x_path)) srcset="/{{ $setting->logo_2x_path }} 2x" @endif
                        alt="{{ $setting->site_name }}"
                    >
                    <img
                        class="hidden h-auto w-full group-[.navbar-shrinked]/body:hidden dark:block"
                        src="{{ custom_theme_url($setting->logo_dark_path, true) }}"
                        @if (isset($setting->logo_dark_2x_path) && !empty($setting->logo_dark_2x_path)) srcset="/{{ $setting->logo_dark_2x_path }} 2x" @endif
                        alt="{{ $setting->site_name }}"
                    >
                @endif

                <!-- collapsed -->
                <img
                    class="mx-auto hidden h-auto w-full max-w-10 group-[.navbar-shrinked]/body:block dark:!hidden"
                    src="{{ custom_theme_url($setting->logo_collapsed_path, true) }}"
                    @if (isset($setting->logo_collapsed_2x_path) && !empty($setting->logo_collapsed_2x_path)) srcset="/{{ $setting->logo_collapsed_2x_path }} 2x" @endif
                    alt="{{ $setting->site_name }}"
                >
                <img
                    class="mx-auto hidden h-auto w-full max-w-10 group-[.theme-dark.navbar-shrinked]/body:block"
                    src="{{ custom_theme_url($setting->logo_collapsed_dark_path, true) }}"
                    @if (isset($setting->logo_collapsed_dark_2x_path) && !empty($setting->logo_collapsed_dark_2x_path)) srcset="/{{ $setting->logo_collapsed_dark_2x_path }} 2x" @endif
                    alt="{{ $setting->site_name }}"
                >
            </a>

            <button
                class="lqd-navbar-expander group/expander invisible relative col-start-1 col-end-1 row-start-1 row-end-1 flex scale-50 cursor-pointer flex-col items-center gap-1.5 p-0 text-center text-4xs font-medium opacity-0 transition-all group-[.navbar-shrinked]/body:group-hover/navbar-inner:visible group-[.navbar-shrinked]/body:group-hover/navbar-inner:scale-100 group-[.navbar-shrinked]/body:group-hover/navbar-inner:opacity-100 max-lg:hidden"
                x-init
                @click.prevent="$store.navbarShrink.toggle()"
            >
                <span class="inline-grid place-items-center">
                    <x-tabler-grid-dots class="col-start-1 col-end-1 row-start-1 row-end-1 size-6 shrink-0" />
                </span>
            </button>
        </div>

        @php
            $items = app(\App\Services\Common\MenuService::class)->generate();
            $isAdmin = \Auth::user()?->isAdmin();
            $middle_nav_urls = app(\App\Services\Common\MenuService::class)->boltMenu();
            $bottom_nav_urls = ['support', 'settings', 'affiliates'];
            $middle_nav_items = [];
            $bottom_nav_items = [];

            foreach ($items as $key => $item) {
                if (in_array($key, array_keys($middle_nav_urls))) {
                    $middle_nav_items[$key] = $item;
                } elseif (in_array($key, $bottom_nav_urls)) {
                    $bottom_nav_items[$key] = $item;
                }
            }
        @endphp
        <ul class="hidden w-full flex-col gap-2 lg:group-[&.navbar-shrinked]/body:flex">
            @foreach ($middle_nav_items as $key => $item)
                @if (\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key))
                    @if (data_get($item, 'is_admin'))
                        @if ($isAdmin)
                            @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                @if ($item['children_count'])
                                    @includeIf('default.components.navbar.partials.types.item-dropdown', ['item' => $item])
                                @else
                                    @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                @endif

                                @if ($item['children_count'])
                                    @foreach ($item['children'] as $child)
                                        @if (data_get($child, 'bolt_menu') && data_get($child, 'is_active') && data_get($child, 'show_condition', true))
                                            @php
                                                if (empty($child['icon'])) {
                                                    $child['icon'] = 'tabler-circle-dot';
                                                }
                                            @endphp
                                            @includeIf('default.components.navbar.partials.types.' . $child['type'], ['item' => $child])
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endif
                    @else
                        @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                            @if ($item['children_count'])
                                @includeIf('default.components.navbar.partials.types.item-dropdown', ['item' => $item])
                            @else
                                @includeIf('default.components.navbar.partials.types.' . $item['type'])
                            @endif

                            @if ($item['children_count'])
                                @foreach ($item['children'] as $child)
                                    @if (data_get($child, 'bolt_menu') && data_get($child, 'is_active') && data_get($child, 'show_condition', true))
                                        @php
                                            if (empty($child['icon'])) {
                                                $child['icon'] = 'tabler-circle-dot';
                                            }
                                        @endphp
                                        @includeIf('default.components.navbar.partials.types.' . $child['type'], ['item' => $child])
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
        </ul>

        <div class="hidden w-full flex-col gap-2 lg:group-[&.navbar-shrinked]/body:flex">
            <ul class="lqd-navbar-ul-focus-bottom flex w-full flex-col gap-2">
                @foreach ($bottom_nav_items as $key => $item)
                    @if (\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key))
                        @if (data_get($item, 'is_admin'))
                            @if ($isAdmin)
                                @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                    @if ($item['children_count'])
                                        @includeIf('default.components.navbar.partials.types.item-dropdown')
                                    @else
                                        @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                    @endif
                                @endif
                            @endif
                        @else
                            @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                @if ($item['children_count'])
                                    @includeIf('default.components.navbar.partials.types.item-dropdown')
                                @else
                                    @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>

        <nav
            class="lqd-navbar-nav lg:group-[&.navbar-shrinked]/body:hidden"
            id="navbar-menu"
        >
            <ul class="lqd-navbar-ul">
                @foreach ($items as $key => $item)
                    @if (\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key))
                        @if (data_get($item, 'is_admin'))
                            @if ($isAdmin)
                                @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                    @if ($item['children_count'])
                                        @includeIf('default.components.navbar.partials.types.item-dropdown')
                                    @else
                                        @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                    @endif
                                @endif
                            @endif
                        @else
                            @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                                @if ($item['children_count'])
                                    @includeIf('default.components.navbar.partials.types.item-dropdown')
                                @else
                                    @includeIf('default.components.navbar.partials.types.' . $item['type'])
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach

                {{-- Admin menu items --}}
                @if ($isAdmin)
                    @if ($app_is_not_demo && setting('premium_support', true) && !\App\Helpers\Classes\Helper::isUserVIP())
                        <x-navbar.item>
                            <x-navbar.link
                                label="{{ __('Premium Membership') }}"
                                href="#"
                                trigger-type="modal"
                            >
                                <x-slot:modal>
                                    @includeIf('premium-support.index')
                                </x-slot:modal>
                            </x-navbar.link>
                        </x-navbar.item>
                    @endif
                @endif

                <x-navbar.item>
                    <x-navbar.divider />
                </x-navbar.item>

                <x-navbar.item class="group-[&.navbar-shrinked]/body:hidden">
                    <x-navbar.label>
                        {{ __('Credits') }}
                    </x-navbar.label>
                </x-navbar.item>

                <x-navbar.item class="pb-navbar-link-pb pe-navbar-link-pe ps-navbar-link-ps pt-navbar-link-pt group-[&.navbar-shrinked]/body:hidden">
                    <x-credit-list
                        modal-trigger-pos="block"
                        expanded-modal-trigger="true"
                    />
                </x-navbar.item>

                @if ($setting->feature_affilates)
                    <x-navbar.item class="group-[&.navbar-shrinked]/body:hidden">
                        <x-navbar.divider />
                    </x-navbar.item>

                    <x-navbar.item class="group-[&.navbar-shrinked]/body:hidden">
                        <x-navbar.label>
                            {{ __('Affiliation') }}
                        </x-navbar.label>
                    </x-navbar.item>

                    <x-navbar.item class="pb-navbar-link-pb pe-navbar-link-pe ps-navbar-link-ps pt-navbar-link-pt group-[&.navbar-shrinked]/body:hidden">
                        <div
                            class="lqd-navbar-affiliation inline-block w-full rounded-xl border border-navbar-divider px-8 py-4 text-center text-2xs leading-tight transition-border">
                            <p class="m-0 mb-2 text-[20px] not-italic">🎁</p>
                            <p class="mb-4">{{ __('Invite your friend and get') }}
                                {{ $setting->affiliate_commission_percentage }}%
                                @if ($is_onetime_commission)
                                    {{ __('on their first purchase.') }}
                                @else
                                    {{ __('on all their purchases.') }}
                                @endif
                            </p>
                            <x-button
                                class="text-3xs"
                                href="{{ route('dashboard.user.affiliates.index') }}"
                                variant="ghost-shadow"
                            >
                                {{ __('Invite') }}
                            </x-button>
                        </div>
                    </x-navbar.item>
                @endif
            </ul>
        </nav>
    </div>
</aside>
