@php
    $search_style = setting('default_search', 'compact');
@endphp

<header
    class="lqd-header relative z-40 flex h-[--header-height] border-b border-header-border bg-header-background text-xs font-medium transition-colors max-lg:h-[65px]"
    @if ($search_style === 'compact') x-data="{
        searchShow: false,
        setSearchShow(status) {
            if (status == null) {
                this.searchShow = !this.searchShow;
            } else {
                this.searchShow = status;
            }

            if (this.searchShow) {
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            }
        }
    }"
    @keyup.esc.window="setSearchShow(false)" @endif
>
    <div @class([
        'lqd-header-container flex w-full grow gap-2 px-4 max-lg:w-full max-lg:max-w-none',
        'container' => !$attributes->get('layout-wide'),
        'container-fluid' => $attributes->get('layout-wide'),
        Theme::getSetting('wideLayoutPaddingX', '') =>
            filled(Theme::getSetting('wideLayoutPaddingX', '')) &&
            $attributes->get('layout-wide'),
    ])>
        {{-- Title slot --}}
        @if ($title ?? false)
            <div class="header-title-container peer/title hidden items-center lg:flex">
                <h1 class="m-0 font-semibold">
                    {{ $title }}
                </h1>
            </div>
        @endif

        @includeFirst(['focus-mode::header', 'components.includes.ai-tools', 'vendor.empty'])

        <div class="header-actions-container flex grow gap-3.5 group-[&.focus-mode]/body:hidden max-lg:hidden max-lg:basis-2/3 max-lg:gap-2 lg:w-1/3">
            {{-- Action buttons --}}
            @if ($actions ?? false)
                {{ $actions }}
            @else
                <div class="flex items-center max-xl:gap-2 xl:gap-3">
                    <x-button
                        class="relative py-2 outline-2 outline-offset-0 max-xl:hidden lg:px-5"
                        variant="outline"
                        href="{{ route('dashboard.user.payment.subscription') }}"
                    >
                        <x-outline-glow class="[--outline-glow-w:2px]" />
                        <svg
                            width="19"
                            height="15"
                            viewBox="0 0 19 15"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M7.75 7L6 5.075L6.525 4.2M4.25 0.875H14.75L17.375 5.25L9.9375 13.5625C9.88047 13.6207 9.8124 13.6669 9.73728 13.6985C9.66215 13.7301 9.58149 13.7463 9.5 13.7463C9.41851 13.7463 9.33785 13.7301 9.26272 13.6985C9.1876 13.6669 9.11953 13.6207 9.0625 13.5625L1.625 5.25L4.25 0.875Z"
                            />
                        </svg>
                        <span class="max-lg:hidden">
                            {{ __('Upgrade') }}
                        </span>
                    </x-button>
                </div>
            @endif
        </div>

        {{-- Mobile nav toggle and logo --}}
        <div class="mobile-nav-logo flex items-center justify-center gap-3 max-lg:-order-1 lg:w-1/3 lg:group-[&.focus-mode]/body:hidden">
            <button
                class="lqd-mobile-nav-toggle flex size-10 items-center justify-center lg:hidden"
                type="button"
                x-init
                @click.prevent="$store.mobileNav.toggleNav()"
                :class="{ 'lqd-is-active': !$store.mobileNav.navCollapse }"
            >
                <span class="lqd-mobile-nav-toggle-icon relative h-[2px] w-5 rounded-xl bg-current"></span>
            </button>
            <x-header-logo />
        </div>

        <div class="header-actions-container relative flex grow items-center justify-end gap-3.5 max-lg:basis-2/3 max-lg:gap-1 lg:w-1/3">

            <x-header-search
                class="hidden size-10 rounded-full border border-button-border bg-transparent lg:flex"
                class:icon="start-1/2 -translate-x-1/2 opacity-100 rtl:translate-x-1/2"
                class:input="p-0 opacity-0 cursor-pointer"
                :show-arrow=false
                :show-kbd=false
                :show-loader=false
                style="modern"
            />

            {{-- Dark/light switch --}}
            @if (Theme::getSetting('dashboard.supportedColorSchemes') === 'all')
                <x-light-dark-switch class="size-10 border border-button-border" />
            @endif

            @includeFirst(['focus-mode::ai-tools-button', 'components.includes.ai-tools-button', 'vendor.empty'], ['class' => 'size-10 border border-button-border'])

            {{-- Notifications --}}
            @if (setting('notification_active', 0))
                <x-notifications class:trigger="size-10 border border-button-border" />
            @endif

            {{-- Language dropdown --}}
            @if (count(explode(',', $settings_two->languages)) > 1)
                <x-language-dropdown class:trigger="size-10 border border-button-border" />
            @endif

            {{-- Upgrade button on mobile --}}
            <x-button
                class="lqd-header-upgrade-btn flex size-10 items-center justify-center rounded-full border p-0 text-current dark:bg-white/[3%] lg:hidden"
                variant="link"
                href="{{ route('dashboard.user.payment.subscription') }}"
            >
                <x-tabler-bolt stroke-width="1.5" />
            </x-button>

            {{-- User menu --}}
            <x-user-dropdown class:trigger="size-10 border">
                <x-slot:trigger>
                    <x-tabler-user-circle
                        class="size-[22px]"
                        stroke-width="1.5"
                    />
                </x-slot:trigger>
            </x-user-dropdown>
        </div>
    </div>
</header>
