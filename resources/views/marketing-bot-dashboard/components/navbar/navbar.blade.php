{{-- Cache with registry for bulk invalidation --}}
@php

    $user = auth()->user();
    $cacheKey = 'navbar_data_' . auth()->id() . '_' . app()->getLocale();
    $navbarData = cache()->remember($cacheKey, 3600, function () use ($cacheKey, $user) {
        $registryKey = 'navbar_cache_registry';
        $registry = cache()->get($registryKey, []);
        if (!in_array($cacheKey, $registry, true)) {
            $registry[] = $cacheKey;
            cache()->put($registryKey, $registry, 86400);
        }
        $menuService = app(\App\Services\Common\MenuService::class);
        return [
            'items' => $menuService->generate(),
            'middle_nav_urls' => $menuService->boltMenu(),
            'isAdmin' => $user?->isAdmin(),
            'affiliateStatus' => $user?->affiliate_status,
        ];
    });

    $items = $navbarData['items'];
    $middle_nav_urls = $navbarData['middle_nav_urls'];
    $isAdmin = $navbarData['isAdmin'];
    $bottom_nav_urls = ['support', 'settings', 'affiliates'];
@endphp

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
        class="lqd-navbar-inner no-scrollbar h-full overflow-y-auto overscroll-contain pe-navbar-pe ps-navbar-ps max-lg:max-h-[inherit] lg:group-[&.navbar-shrinked]/body:flex lg:group-[&.navbar-shrinked]/body:flex-col lg:group-[&.navbar-shrinked]/body:items-center lg:group-[&.navbar-shrinked]/body:justify-between">
        <button
            class="lqd-navbar-expander group/expander !visible relative flex cursor-pointer flex-col items-center gap-1.5 p-0 text-center text-4xs font-medium !opacity-100 transition-all max-lg:hidden"
            x-init
            @click.prevent="$store.navbarShrink.toggle()"
        >
            <span class="inline-grid place-items-center">
                <x-tabler-grid-dots
                    class="col-start-1 col-end-1 row-start-1 row-end-1 size-5 shrink-0"
                    x-show="$store.navbarShrink.active"
                />
                <x-tabler-x
                    class="col-start-1 col-end-1 row-start-1 row-end-1 size-5 shrink-0"
                    x-cloak
                    x-show="!$store.navbarShrink.active"
                />
            </span>
            <span
                class="transition"
                :class="{ 'opacity-0': !$store.navbarShrink.active }"
            >
                {{ __('Menu') }}
            </span>
        </button>

        <div class="hidden w-full grow flex-col items-center pb-5 pt-3.5 lg:group-[&.navbar-shrinked]/body:flex">
            @php
                // Optimized: Single pass filtering with early returns
                $middle_nav_items = [];
                $bottom_nav_items = [];

                foreach ($items as $key => $item) {
                    // Skip early if not active or show condition is false
                    if (!data_get($item, 'is_active') || !data_get($item, 'show_condition', true)) {
                        continue;
                    }

                    // Skip admin-only items for non-admins
                    if (data_get($item, 'is_admin') && !$isAdmin) {
                        continue;
                    }

                    // Skip if plan check fails
                    if (!\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key)) {
                        continue;
                    }

                    // Categorize items
                    if (array_key_exists($key, $middle_nav_urls)) {
                        $middle_nav_items[$key] = $item;
                    } elseif (in_array($key, $bottom_nav_urls, true)) {
                        $bottom_nav_items[$key] = $item;
                    }
                }

                // Inline template resolver
                $getItemTemplate = fn($item) => $item['children_count']
                    ? 'default.components.navbar.partials.types.item-dropdown'
                    : 'default.components.navbar.partials.types.' . $item['type'];
            @endphp

            <nav class="flex w-full grow flex-col">
                <ul class="flex flex-col gap-3.5">
                    @foreach ($middle_nav_items as $key => $item)
                        @includeIf($getItemTemplate($item))
                    @endforeach
                </ul>

                <div class="mt-auto flex flex-col items-center">
                    <ul class="lqd-navbar-ul-focus-bottom flex w-full flex-col gap-3.5">
                        @foreach ($bottom_nav_items as $key => $item)
                            @includeIf($getItemTemplate($item))
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>

        <nav
            class="lqd-navbar-nav lg:group-[&.navbar-shrinked]/body:hidden"
            id="navbar-menu"
        >
            <ul class="lqd-navbar-ul">
                {{-- Cache menu with user-specific key --}}
                {!! App\Caches\BladeCache::navMenu(static fn() => view('panel.layout.partials.menu')->render()) !!}

                @if ($isAdmin)
                    @if ($app_is_not_demo && setting('premium_support', true) && !\App\Helpers\Classes\Helper::isUserVIP())
                        <x-navbar.item>
                            <x-navbar.link
                                label="{{ __('Premium Membership') }}"
                                href="#"
                                icon="tabler-diamond"
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

                @if ($setting->feature_affilates && $user?->affiliate_status == 1)
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
