@php
    $plan = Auth::user()->activePlan();
    $plan_type = 'regular';

    if ($plan != null) {
        $plan_type = strtolower($plan->plan_type);
    }

    $titlebar_links = [
        [
            'label' => 'All',
            'link' => '#all',
        ],
        [
            'label' => 'AI Assistant',
            'link' => '#all',
        ],
        [
            'label' => 'Your Plan',
            'link' => '#plan',
        ],
        [
            'label' => 'Overview',
            'link' => '#overview',
        ],
        [
            'label' => 'Favorites',
            'link' => '#favorites',
        ],
        [
            'label' => 'Recent Documents',
            'link' => '#recents',
        ],
    ];

    $premium_features = \App\Models\OpenAIGenerator::query()->where('active', 1)->where('premium', 1)->get()->pluck('title')->toArray();
    $user_is_premium = false;
    $plan = auth()->user()?->relationPlan;
    if ($plan) {
        $planType = strtolower($plan->plan_type ?? 'all');
        if ($plan->plan_type === 'all' || $plan->plan_type === 'premium') {
            $user_is_premium = true;
        }
    }
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('Dashboard'))
@section('titlebar_title')
    {{ __('Welcome') }}, {{ auth()->user()->name }} 👋🏻
@endsection
@section('titlebar_after')
    <ul
        class="lqd-filter-list mt-1 flex list-none flex-wrap items-center gap-x-3 gap-y-2 text-heading-foreground max-sm:gap-3"
        x-data="{}"
    >
        @foreach ($titlebar_links as $link)
            <li>
                <x-button
                    @class([
                        'lqd-filter-btn inline-flex px-2.5 py-0.5 text-2xs leading-tight transition-colors hover:translate-y-0 hover:bg-foreground/5 [&.active]:bg-foreground/5',
                        'active' => $loop->first,
                    ])
                    variant="ghost"
                    href="{{ $link['link'] }}"
                    x-data="{}"
                >
                    @lang($link['label'])
                </x-button>
            </li>
        @endforeach
    </ul>
@endsection

@section('content')
    <div class="flex flex-wrap justify-between gap-y-8 pt-10">
        <div
            class="grid w-full grid-cols-1 gap-10"
            id="all"
        >
            @if (setting('announcement_active', 0) && !auth()->user()->dash_notify_seen)
                <div
                    class="lqd-announcement"
                    x-data="{ show: !localStorage.getItem('lqd-announcement-dismissed') }"
                    x-ref="announcement"
                >
                    <script>
                        const announcementDismissed = localStorage.getItem('lqd-announcement-dismissed');
                        if (announcementDismissed) {
                            document.querySelector('.lqd-announcement').style.display = 'none';
                        }
                    </script>

                    <x-card
                        class="lqd-announcement-card relative bg-cover bg-center"
                        size="lg"
                        x-ref="announcementCard"
                    >
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h3 class="mb-3">
                                    @lang(setting('announcement_title', 'Welcome'))
                                </h3>
                                <p class="mb-4">
                                    @lang(setting('announcement_description', 'We are excited to have you here. Explore the marketplace to find the best AI models for your needs.'))
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <x-button
                                        class="font-medium"
                                        href="{{ setting('announcement_url', '#') }}"
                                    >
                                        <x-tabler-plus class="size-4" />
                                        {{ setting('announcement_button_text', 'Try it Now') }}
                                    </x-button>
                                    <x-button
                                        class="font-medium"
                                        href="javascript:void(0)"
                                        variant="ghost-shadow"
                                        hover-variant="danger"
                                        @click.prevent="dismiss()"
                                    >
                                        @lang('Dismiss')
                                    </x-button>
                                </div>
                            </div>
                            @if (setting('announcement_image_dark'))
                                <img
                                    class="announcement-img announcement-img-dark peer hidden w-28 shrink-0 dark:block"
                                    src="{{ setting('announcement_image_dark', '/upload/images/speaker.png') }}"
                                    alt="@lang(setting('announcement_title', 'Welcome to MagicAI!'))"
                                >
                            @endif
                            <img
                                class="announcement-img announcement-img-light w-28 shrink-0 dark:peer-[&.announcement-img-dark]:hidden"
                                src="{{ setting('announcement_image', '/upload/images/speaker.png') }}"
                                alt="@lang(setting('announcement_title', 'Welcome to MagicAI!'))"
                            >
                        </div>
                    </x-card>
                </div>
            @endif
            <x-card size="lg">
                <h3 class="mb-6 flex items-center gap-3">
                    {{-- blade-formatter-disable --}}
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" > <path fill-rule="evenodd" clip-rule="evenodd" d="M18.7588 7.85618L17.1437 8.18336V8.18568C16.3659 8.34353 15.6517 8.72701 15.0905 9.28825C14.5292 9.8495 14.1458 10.5636 13.9879 11.3415L13.6607 12.9565C13.6262 13.1155 13.5383 13.2578 13.4117 13.3599C13.285 13.462 13.1273 13.5177 12.9646 13.5177C12.8019 13.5177 12.6442 13.462 12.5175 13.3599C12.3909 13.2578 12.303 13.1155 12.2685 12.9565L11.9413 11.3415C11.7837 10.5635 11.4003 9.84922 10.839 9.28793C10.2777 8.72663 9.56345 8.34324 8.78546 8.18568L7.17042 7.8585C7.00937 7.82552 6.86464 7.73795 6.76071 7.61058C6.65678 7.48321 6.60001 7.32386 6.60001 7.15946C6.60001 6.99507 6.65678 6.83572 6.76071 6.70835C6.86464 6.58098 7.00937 6.4934 7.17042 6.46043L8.78546 6.13324C9.56339 5.97554 10.2776 5.5921 10.8389 5.03084C11.4001 4.46957 11.7836 3.75536 11.9413 2.97743L12.2685 1.36239C12.303 1.20344 12.3909 1.06109 12.5175 0.959015C12.6442 0.856935 12.8019 0.80127 12.9646 0.80127C13.1273 0.80127 13.285 0.856935 13.4117 0.959015C13.5383 1.06109 13.6262 1.20344 13.6607 1.36239L13.9879 2.97743C14.1458 3.75529 14.5292 4.46943 15.0905 5.03067C15.6517 5.59192 16.3659 5.9754 17.1437 6.13324L18.7588 6.45811C18.9198 6.49108 19.0645 6.57866 19.1685 6.70603C19.2724 6.8334 19.3292 6.99275 19.3292 7.15714C19.3292 7.32154 19.2724 7.48089 19.1685 7.60826C19.0645 7.73563 18.9198 7.8232 18.7588 7.85618ZM6.94895 16.0393L6.51038 16.1286C5.96946 16.2383 5.47282 16.5037 5.08244 16.8939C4.69206 17.2841 4.42523 17.7806 4.31524 18.3214L4.2259 18.76C4.202 18.8835 4.13584 18.9949 4.03877 19.075C3.9417 19.1551 3.81978 19.1989 3.69394 19.1989C3.56809 19.1989 3.44617 19.1551 3.3491 19.075C3.25204 18.9949 3.18587 18.8835 3.16197 18.76L3.07263 18.3214C2.96278 17.7805 2.69599 17.2839 2.30559 16.8937C1.91518 16.5035 1.41847 16.237 0.877485 16.1274L0.43892 16.0381C0.315366 16.0142 0.203985 15.948 0.123895 15.851C0.0438042 15.7539 0 15.632 0 15.5061C0 15.3803 0.0438042 15.2584 0.123895 15.1613C0.203985 15.0642 0.315366 14.9981 0.43892 14.9742L0.877485 14.8848C1.41862 14.7752 1.91545 14.5085 2.30587 14.1181C2.69629 13.7276 2.96299 13.2308 3.07263 12.6897L3.16197 12.2511C3.18587 12.1276 3.25204 12.0162 3.3491 11.9361C3.44617 11.856 3.56809 11.8122 3.69394 11.8122C3.81978 11.8122 3.9417 11.856 4.03877 11.9361C4.13584 12.0162 4.202 12.1276 4.2259 12.2511L4.31524 12.6897C4.42482 13.231 4.69148 13.728 5.08189 14.1186C5.4723 14.5092 5.96915 14.7761 6.51038 14.886L6.94895 14.9753C7.0725 14.9992 7.18388 15.0654 7.26397 15.1625C7.34407 15.2595 7.38787 15.3814 7.38787 15.5073C7.38787 15.6331 7.34407 15.7551 7.26397 15.8521C7.18388 15.9492 7.0725 16.0154 6.94895 16.0393Z" fill="url(#paint0_linear_213_525)" /> <defs> <linearGradient id="paint0_linear_213_525" x1="1.1976e-07" y1="4.55439" x2="15.5124" y2="18.9291" gradientUnits="userSpaceOnUse" > <stop stop-color="#82E2F4" /> <stop offset="0.502" stop-color="#8A8AED" /> <stop offset="1" stop-color="#6977DE" /> </linearGradient> </defs> </svg>
					{{-- blade-formatter-enable --}}
                    @lang('Hey, How can I help you?')
                </h3>
                <x-header-search
                    class="mb-5 w-full"
                    class:input="bg-background border-none h-12 text-heading-foreground shadow-[0_4px_8px_rgba(0,0,0,0.05)] placeholder:text-heading-foreground"
                    size="lg"
                    :show-arrow=false
                    :show-icon=false
                    :show-kbd=false
                    :outline-glow=true
                />
                <x-button
                    class="group text-[12px] font-medium text-heading-foreground"
                    variant="link"
                    href="{{ $setting->feature_ai_advanced_editor ? route('dashboard.user.generator.index') : route('dashboard.user.openai.list') }}"
                >
                    @lang('Create a Blank Document')
                    <span
                        class="inline-flex size-9 items-center justify-center rounded-button bg-background shadow transition-all group-hover:scale-110 group-hover:bg-heading-foreground group-hover:text-header-background"
                    >
                        <x-tabler-plus class="size-4" />
                    </span>
                </x-button>
            </x-card>
        </div>

        <div
            class="w-full xl:w-1/3 2xl:w-[30%]"
            id="plan"
        >
            @include('panel.user.finance.subscriptionStatus')
        </div>

        @if ($ongoingPayments != null)
            <div class="w-full">
                @include('panel.user.finance.ongoingPayments')
            </div>
        @endif

        @if (!$user_is_premium)
            <x-card
                class="relative flex w-full flex-col justify-center bg-cover bg-top text-center xl:w-[65%] 2xl:w-[67%]"
                class:body="flex flex-col only:grow-0 py-8 xl:px-20 static"
            >
                <figure
                    class="pointer-events-none absolute start-0 top-0 z-0 h-full w-full overflow-hidden transition-opacity dark:opacity-60"
                    aria-hidden="true"
                >
                    <img
                        class="w-full blur-[3px]"
                        src="{{ custom_theme_url('/assets/img/bg/premium-card-bg.jpg') }}"
                        alt="{{ __('Premium Features') }}"
                        width="1244"
                        height="481"
                    />
                </figure>
                <div class="relative z-1 flex flex-col">
                    <h4 class="mb-5 text-lg">
                        @lang('Premium Advantages')
                    </h4>
                    <p class="mb-8 text-xs font-medium opacity-60">
                        @lang('Upgrade your plan to unlock new AI capabilities.')
                    </p>
                    <ul class="mb-11 space-y-4 self-center text-xs font-medium text-heading-foreground">
                        @foreach ($premium_features as $feature)
                            <li class="flex items-center gap-3.5">
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 16 16"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M2.09635 7.37072C1.80296 7.37154 1.51579 7.45542 1.26807 7.61264C1.02035 7.76986 0.822208 7.994 0.696564 8.25914C0.570919 8.52427 0.522908 8.81956 0.558084 9.11084C0.59326 9.40212 0.710186 9.67749 0.895335 9.9051L4.84228 14.7401C4.98301 14.9148 5.1634 15.0535 5.36847 15.1445C5.57353 15.2355 5.79736 15.2763 6.02136 15.2635C6.50043 15.2377 6.93295 14.9815 7.20871 14.5601L15.4075 1.35593C15.4089 1.35373 15.4103 1.35154 15.4117 1.34939C15.4886 1.23127 15.4637 0.997192 15.3049 0.850142C15.2613 0.809761 15.2099 0.778736 15.1538 0.75898C15.0977 0.739223 15.0382 0.731153 14.9789 0.735266C14.9196 0.739379 14.8618 0.755589 14.809 0.782896C14.7562 0.810204 14.7095 0.848031 14.6719 0.894048C14.669 0.897666 14.6659 0.90123 14.6628 0.904739L6.39421 10.247C6.36275 10.2826 6.32454 10.3115 6.28179 10.3322C6.23905 10.3528 6.19263 10.3648 6.14522 10.3674C6.09782 10.3699 6.05038 10.363 6.00565 10.3471C5.96093 10.3312 5.91982 10.3065 5.88471 10.2746L3.14051 7.77735C2.8555 7.51608 2.48299 7.37102 2.09635 7.37072Z"
                                        fill="url(#paint0_linear_9208_560_{{ $loop->index }})"
                                    />
                                    <defs>
                                        <linearGradient
                                            id="paint0_linear_9208_560_{{ $loop->index }}"
                                            x1="0.546875"
                                            y1="3.69866"
                                            x2="12.7738"
                                            y2="14.7613"
                                            gradientUnits="userSpaceOnUse"
                                        >
                                            <stop stop-color="hsl(var(--gradient-from))" />
                                            <stop
                                                offset="0.502"
                                                stop-color="hsl(var(--gradient-via))"
                                            />
                                            <stop
                                                offset="1"
                                                stop-color="hsl(var(--gradient-to))"
                                            />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <x-button
                        class="py-5 text-[18px] font-bold shadow-[0_14px_44px_rgba(0,0,0,0.07)] hover:shadow-2xl hover:shadow-primary/30 dark:hover:bg-primary"
                        href="{{ route('dashboard.user.payment.subscription') }}"
                        variant="ghost-shadow"
                    >
                        <span
                            class="bg-gradient-to-r from-gradient-from via-gradient-via to-gradient-to bg-clip-text text-transparent group-hover:from-white group-hover:via-white group-hover:to-white/80"
                        >
                            @lang('Upgrade Your Plan')
                        </span>
                    </x-button>
                </div>
            </x-card>
        @endif

        <div
            id="overview"
            @class(['w-full', 'xl:w-[65%] 2xl:w-[67%]' => $user_is_premium])
        >
            <x-card
                class="flex min-h-full flex-col text-xs"
                class:head="border-b-0 pt-8 pb-0 px-8"
                class:body="flex flex-wrap px-8 pt-5 pb-8 grow"
                size="lg"
            >
                <x-slot:head
                    class="flex items-center justify-between gap-2"
                >
                    <h2 class="m-0 flex items-center gap-4">
                        {{-- blade-formatter-disable --}}
						<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="40" height="40" rx="8" fill="#6FB3C9" fill-opacity="0.12"/>
							<path d="M14.83 21.3522C13.1525 21.3522 11.7775 22.718 11.7775 24.4047C11.7775 26.0913 13.1434 27.4572 14.83 27.4572C16.5075 27.4572 17.8825 26.0913 17.8825 24.4047C17.8825 22.718 16.5075 21.3522 14.83 21.3522Z" fill="#B6D8E5"/>
							<path d="M24.2351 24.643C22.8143 24.643 21.6593 25.798 21.6593 27.2188C21.6593 28.6397 22.8143 29.7947 24.2351 29.7947C25.6559 29.7947 26.8109 28.6397 26.8109 27.2188C26.8109 25.798 25.6559 24.643 24.2351 24.643Z" fill="#B6D8E5"/>
							<path d="M23.2908 10.6042C20.5683 10.6042 18.3592 12.8134 18.3592 15.5359C18.3592 18.2584 20.5683 20.4675 23.2908 20.4675C26.0133 20.4675 28.2225 18.2584 28.2225 15.5359C28.2225 12.8134 26.0133 10.6042 23.2908 10.6042Z" fill="#6FB3C9"/>
						</svg>
						{{-- blade-formatter-enable --}}
                        {{ __('Overview') }}
                    </h2>
                    <x-badge class="px-5 py-2.5 text-2xs text-foreground max-md:hidden">
                        @lang('Your Document Values')
                    </x-badge>
                </x-slot:head>

                <div class="mb-5 lg:w-1/2">
                    <p>
                        @lang('Understand and manage your projects better. Dig deeper into relevant details.')
                    </p>
                </div>

                <div class="mb-6 flex w-full border-b pb-6 max-md:flex-col">
                    <x-card class="lqd-generator-remaining-credits">
                        <h5 class="mb-3 text-xs font-normal">
                            {{ __('Remaining Credits') }}
                        </h5>

                        <x-credit-list class:modal-trigger="text-black dark:text-white hover:text-black dark:hover:text-white" />
                    </x-card>
                    <div class="grow basis-0 px-9 transition-colors max-md:w-full max-md:p-0">
                        <p class="mb-4 font-semibold text-foreground/70">
                            {{ __('Hours Saved') }}
                        </p>
                        <p class="text-3xl font-semibold leading-none text-heading-foreground">
                            {{ number_format(($total_words * 0.5) / 60) }}</p>
                    </div>
                </div>

                <div class="w-full">
                    <p class="mb-6 font-medium">
                        {{ __('Your Documents') }}
                    </p>
                    <x-total-docs class="[&_.lqd-progress]:h-4" />
                </div>
            </x-card>
        </div>

        <div
            class="w-full"
            id="favorites"
        >
            <x-card
                class="flex min-h-full flex-col text-xs"
                class:head="pt-8 px-0 mx-8 border-border"
                class:body="flex flex-wrap px-8 pt-2 pb-8 grow"
                size="lg"
            >
                <x-slot:head
                    class="flex items-center justify-between gap-2"
                >
                    <h2 class="m-0 flex items-center gap-4">
                        {{-- blade-formatter-disable --}}
						<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="40" height="40" rx="8" fill="#6FB3C9" fill-opacity="0.12"/>
							<path d="M21.1917 16.4343L22.4017 18.8543C22.5667 19.1843 23.0067 19.5143 23.3733 19.5693L25.5642 19.9359C26.9667 20.1743 27.2967 21.1826 26.2883 22.1909L24.5833 23.8959C24.2992 24.1801 24.1342 24.7393 24.2258 25.1426L24.7117 27.2601C25.0967 28.9284 24.2075 29.5793 22.7317 28.7084L20.6783 27.4893C20.3025 27.2693 19.6975 27.2693 19.3217 27.4893L17.2683 28.7084C15.7925 29.5793 14.9033 28.9284 15.2883 27.2601L15.7742 25.1426C15.8658 24.7484 15.7008 24.1893 15.4166 23.8959L13.7117 22.1909C12.7033 21.1826 13.0333 20.1651 14.4358 19.9359L16.6266 19.5693C16.9933 19.5051 17.4333 19.1843 17.5983 18.8543L18.8083 16.4343C19.4592 15.1234 20.5408 15.1234 21.1917 16.4343Z" fill="#6FB3C9"/>
							<path d="M14.5 17.9375C14.1242 17.9375 13.8125 17.6258 13.8125 17.25V10.8333C13.8125 10.4575 14.1242 10.1458 14.5 10.1458C14.8758 10.1458 15.1875 10.4575 15.1875 10.8333V17.25C15.1875 17.6258 14.8758 17.9375 14.5 17.9375Z" fill="#B6D8E5"/>
							<path d="M25.5 17.9375C25.1242 17.9375 24.8125 17.6258 24.8125 17.25V10.8333C24.8125 10.4575 25.1242 10.1458 25.5 10.1458C25.8758 10.1458 26.1875 10.4575 26.1875 10.8333V17.25C26.1875 17.6258 25.8758 17.9375 25.5 17.9375Z" fill="#B6D8E5"/>
							<path d="M20 13.3542C19.6242 13.3542 19.3125 13.0425 19.3125 12.6667V10.8333C19.3125 10.4575 19.6242 10.1458 20 10.1458C20.3758 10.1458 20.6875 10.4575 20.6875 10.8333V12.6667C20.6875 13.0425 20.3758 13.3542 20 13.3542Z" fill="#B6D8E5"/>
						</svg>
						{{-- blade-formatter-enable --}}
                        {{ __('Favorite Documents') }}
                    </h2>

                    <a
                        class="text-2xs underline max-md:hidden"
                        href="{{ route('dashboard.user.openai.documents.all') }}"
                    >
                        @lang('See All Documents')
                    </a>
                </x-slot:head>

                <x-table
                    class="text-xs"
                    variant="none"
                >

                    <x-slot:body
                        class="[&_td]:px-0"
                    >
                        @foreach (\App\Models\UserDocsFavorite::getFavoriteDocs(auth()->user()->id) as $entry)
                            @if ($entry->generator != null)
                                <x-documents.item :$entry />
                            @endif
                        @endforeach

                    </x-slot:body>
                </x-table>
            </x-card>
        </div>

        <div
            class="w-full"
            id="recents"
        >
            <x-card
                class="flex min-h-full flex-col text-xs"
                class:head="pt-8 px-0 mx-8 border-border"
                class:body="flex flex-wrap px-8 pt-2 pb-8 grow"
                size="lg"
            >
                <x-slot:head
                    class="flex items-center justify-between gap-2"
                >
                    <h2 class="m-0 flex items-center gap-4">
                        {{-- blade-formatter-disable --}}
						<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="40" height="40" rx="8" fill="#6FB3C9" fill-opacity="0.12"/>
							<path d="M25.8213 27.0825C25.3171 28.375 24.0888 29.2092 22.7046 29.2092H17.2963C15.9029 29.2092 14.6838 28.375 14.1796 27.0825C13.6754 25.7809 14.0238 24.3417 15.0504 23.4067L18.763 20.0425H21.2471L24.9505 23.4067C25.9771 24.3417 26.3163 25.7809 25.8213 27.0825Z" fill="#B6D8E5"/>
							<path d="M21.6683 25.6283H18.3317C17.9833 25.6283 17.7083 25.3442 17.7083 25.005C17.7083 24.6567 17.9925 24.3817 18.3317 24.3817H21.6683C22.0167 24.3817 22.2917 24.6658 22.2917 25.005C22.2917 25.3442 22.0075 25.6283 21.6683 25.6283Z" fill="#6FB3C9"/>
							<path d="M25.8206 12.96C25.3164 11.6675 24.0881 10.8333 22.7039 10.8333H17.2955C15.9114 10.8333 14.683 11.6675 14.1789 12.96C13.6839 14.2617 14.023 15.7008 15.0589 16.6358L18.7622 20H21.2464L24.9497 16.6358C25.9764 15.7008 26.3156 14.2617 25.8206 12.96ZM21.6681 15.6275H18.3314C17.983 15.6275 17.708 15.3433 17.708 15.0042C17.708 14.665 17.9922 14.3808 18.3314 14.3808H21.6681C22.0164 14.3808 22.2914 14.665 22.2914 15.0042C22.2914 15.3433 22.0072 15.6275 21.6681 15.6275Z" fill="#6FB3C9"/>
						</svg>
						{{-- blade-formatter-enable --}}
                        {{ __('Recently Launched Documents') }}
                    </h2>

                    <a
                        class="text-2xs underline max-md:hidden"
                        href="{{ route('dashboard.user.openai.documents.all') }}"
                    >
                        @lang('See All Documents')
                    </a>
                </x-slot:head>

                <x-table
                    class="text-xs"
                    variant="none"
                >
                    <x-slot:head
                        class="text-xs font-normal normal-case tracking-normal text-foreground [&_th]:font-normal [&_th]:first:ps-0 [&_th]:last:pe-0"
                    >
                        <th>
                            @lang('Templates Information')
                        </th>
                        <th>
                            @lang('Category')
                        </th>
                        <th>
                            @lang('In')
                        </th>
                        <th>
                            @lang('Date')
                        </th>
                    </x-slot:head>
                    <x-slot:body
                        class="[&_td]:px-0"
                    >
                        @foreach (Auth::user()->openai()->orderBy('created_at', 'desc')->take(4)->get() as $entry)
                            @if ($entry->generator != null)
                                <tr class="relative transition-colors hover:bg-foreground/5">
                                    <td>
                                        <a
                                            class="flex items-center gap-2"
                                            href="{{ route('dashboard.user.openai.documents.single', $entry->slug) }}"
                                        >
                                            <x-lqd-icon
                                                size="sm"
                                                style="background: {{ $entry->generator->color }}"
                                            >
                                                <span class="flex size-3.5">
                                                    @if ($entry->generator->image !== 'none')
                                                        {!! html_entity_decode($entry->generator->image) !!}
                                                    @endif
                                                </span>
                                            </x-lqd-icon>
                                            <span class="block text-xs text-heading-foreground">
                                                {{ __($entry->generator->title) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ @ucfirst($entry->generator->type) }}
                                    </td>
                                    <td class="text-heading-foreground">
                                        @lang('In Workbook')
                                    </td>
                                    <td>
                                        <span class="opacity-80">
                                            {{ $entry->created_at->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td
                                        class="w-0 p-0"
                                        colspan="0"
                                    >
                                        <a
                                            class="absolute inset-0 max-sm:hidden"
                                            href="{{ route('dashboard.user.openai.documents.single', $entry->slug) }}"
                                        >
                                            <span class="sr-only">
                                                {{ __('View') }}
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </x-slot:body>
                </x-table>
            </x-card>
        </div>
    </div>
@endsection

@push('script')
    @includeFirst(['onboarding::include.introduction', 'panel.admin.onboarding.include.introduction', 'vendor.empty'])
    @includeFirst(['onboarding-pro::include.introduction', 'panel.admin.onboarding-pro.include.introduction', 'vendor.empty'])
    <script>
        function dismiss() {
            // localStorage.setItem('lqd-announcement-dismissed', true);
            document.querySelector('.lqd-announcement').style.display = 'none';
            $.ajax({
                url: '{{ route('dashboard.user.dash_notify_seen') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    /* console.log(response); */
                }
            });
        }
    </script>
@endpush
