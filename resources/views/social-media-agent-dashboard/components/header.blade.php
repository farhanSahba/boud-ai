<header class="lqd-header relative flex h-[--header-height] text-xs font-medium transition-colors max-lg:h-[65px]">
    <div @class([
        'lqd-header-container flex w-full grow gap-2 px-4 max-lg:w-full max-lg:max-w-none',
        'container' => !$attributes->get('layout-wide'),
        'container-fluid lg:ps-7 lg:group-[&.focus-mode]/body:ps-4' => $attributes->get(
            'layout-wide'),
        Theme::getSetting('wideLayoutPaddingX', '') =>
            filled(Theme::getSetting('wideLayoutPaddingX', '')) &&
            $attributes->get('layout-wide'),
    ])>

        {{-- Mobile nav toggle and logo --}}
        <div class="mobile-nav-logo flex items-center gap-3 lg:hidden">
            <button
                class="lqd-mobile-nav-toggle flex size-10 items-center justify-center"
                type="button"
                x-init
                @click.prevent="$store.mobileNav.toggleNav()"
                :class="{ 'lqd-is-active': !$store.mobileNav.navCollapse }"
            >
                <span class="lqd-mobile-nav-toggle-icon relative h-[2px] w-5 rounded-xl bg-current"></span>
            </button>
            <x-header-logo />
        </div>

        <div class="hidden items-center group-[&.focus-mode]/body:flex [&_.header-focus-mode-nav-toggle-container>a]:hidden">
            @includeFirst(['focus-mode::header', 'components.includes.ai-tools', 'vendor.empty'])
        </div>

        {{-- Title slot --}}
        @if (view()->hasSection('title') || view()->getSection('titlebar_title_after') || view()->getSection('titlebar_title') || view()->hasSection('titlebar_subtitle'))
            <div class="header-title-container peer/title hidden grow items-center gap-3 lg:flex">
                <p
                    class="header-title m-0 max-w-full shrink-0 truncate text-base font-semibold -tracking-wide"
                    title="{{ view()->getSection('titlebar_title') ?? view()->getSection('title') }}"
                >
                    {{ view()->getSection('titlebar_title') ?? view()->getSection('title') }}
                </p>

                @if (view()->hasSection('titlebar_title_after'))
                    @yield('titlebar_title_after')
                @endif

                @if (view()->hasSection('titlebar_subtitle') && filled(view()->getSection('titlebar_subtitle')))
                    <div class="group relative flex items-center">
                        <x-button
                            class="size-6"
                            @click.prevent="subtitleShow = !subtitleShow"
                            variant="link"
                            title="{{ __('Toggle subtitle') }}"
                        >
                            <x-tabler-dots class="size-6" />
                        </x-button>

                        <div
                            class="invisible absolute start-0 top-full z-10 mt-1 w-max max-w-80 origin-top scale-95 rounded-lg border border-foreground/5 bg-background/80 px-4 py-2 opacity-0 shadow-lg shadow-black/5 backdrop-blur transition before:absolute before:-top-1 before:bottom-full before:start-0 before:w-full group-hover:visible group-hover:scale-100 group-hover:opacity-100">
                            <p class="m-0 text-pretty text-xs font-medium">
                                {{ view()->getSection('titlebar_subtitle') }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="header-actions-container flex grow justify-end gap-2.5 max-lg:basis-2/3 max-lg:gap-2 lg:shrink-0">
            {{-- Action buttons --}}
            @if ($actions ?? false)
                {{ $actions }}
            @else
                <div class="flex items-center gap-2.5 max-lg:hidden">
                    @if (Auth::user()?->isAdmin())
                        <x-update-available />
                    @endif

                    @if (Auth::user()?->isAdmin())
                        @if ($app_is_not_demo)
                            {{-- Upgrade button --}}
                            <x-modal
                                class="max-lg:hidden"
                                type="page"
                            >
                                <x-slot:trigger
                                    custom
                                >
                                    <x-button
                                        class="lqd-header-upgrade-btn"
                                        href="#"
                                        variant="outline"
                                        title="{{ __('Premium Membership') }}"
                                        @click.prevent="toggleModal()"
                                    >
                                        <x-tabler-diamond class="size-5" />
                                        {{ __('Upgrade') }}
                                    </x-button>
                                </x-slot:trigger>
                                <x-slot:modal>
                                    @includeIf('premium-support.index')
                                </x-slot:modal>
                            </x-modal>
                        @else
                            <x-button
                                class="lqd-header-upgrade-btn"
                                href="{{ route('dashboard.user.payment.subscription') }}"
                                variant="outline"
                            >
                                <x-tabler-diamond class="size-5" />
                                {{ __('Upgrade') }}
                            </x-button>
                        @endif
                    @endif
                </div>

                <div class="flex items-center gap-2.5 max-lg:hidden">
                    @if (view()->hasSection('titlebar_actions'))
                        @yield('titlebar_actions')
                    @else
                        @if (request()->routeIs('dashboard.user.openai.documents.all') && !isset($currfolder))
                            <x-modal
                                title="{{ __('New Folder') }}"
                                disable-modal="{{ $app_is_demo }}"
                                disable-modal-message="{{ __('This feature is disabled in Demo version.') }}"
                            >
                                <x-slot:trigger
                                    variant="ghost-shadow"
                                >
                                    <x-tabler-plus class="size-4" />
                                    {{ __('New Folder') }}
                                </x-slot:trigger>
                                <x-slot:modal>
                                    @includeIf('panel.user.openai.components.modals.create-new-folder')
                                </x-slot:modal>
                            </x-modal>
                        @else
                            <x-button
                                variant="ghost-shadow"
                                href="{{ route('dashboard.user.openai.documents.all') }}"
                            >
                                {{ __('My Documents') }}
                            </x-button>
                        @endif

                        @if (\App\Helpers\Classes\MarketplaceHelper::isRegistered('social-media-agent'))
                            <x-button href="{{ route('dashboard.user.social-media.agent.posts') }}">
                                @lang('New Post')
                            </x-button>
                        @else
                            @php
                                $current_url = url()->current();
                                $generator_link = route('dashboard.user.openai.list') === $current_url ? '#lqd-generators-filter-list' : route('dashboard.user.openai.list');
                            @endphp

                            <x-button href="{{ $generator_link }}">
                                <x-tabler-plus class="size-4" />
                                {{ __('New') }}
                            </x-button>
                        @endif
                    @endif
                </div>
            @endif

            <div class="flex items-center gap-2.5">
                {{--                @includeIf('marketing-bot::header.inbox-notification') --}}

                {{--                @includeIf('chatbot-agent::header.inbox-notification') --}}

                @includeIf('social-media-agent::notifications.notifications-drawer')

                <x-header-search
                    class="max-lg:hidden"
                    style="modern"
                />

                {{-- Dark/light switch --}}
                @if (Theme::getSetting('dashboard.supportedColorSchemes') === 'all')
                    <x-light-dark-switch />
                @endif

                @includeFirst(['focus-mode::ai-tools-button', 'components.includes.ai-tools-button', 'vendor.empty'])

                @if (setting('notification_active', 0))
                    {{-- Notifications --}}
                    <x-notifications />
                @endif

                {{-- Language dropdown --}}
                @if (count(explode(',', $settings_two->languages)) > 1)
                    <x-language-dropdown />
                @endif

                <x-button
                    class="size-[34px] bg-foreground/5 text-foreground max-lg:hidden"
                    href="{{ route('dashboard.user.affiliates.index') }}"
                    hover-variant="primary"
                    size="none"
                >
                    <span class="sr-only">
                        {{ __('Affiliate Program') }}
                    </span>
                    <x-tabler-gift class="size-5" />
                </x-button>

                {{-- User menu --}}
                <x-user-dropdown />
            </div>
        </div>
    </div>
</header>
