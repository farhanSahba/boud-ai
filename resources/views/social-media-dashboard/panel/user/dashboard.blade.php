@php
    use App\Extensions\SocialMedia\System\Models\SocialMediaPost;
    use App\Extensions\SocialMedia\System\Enums\StatusEnum;
    use Illuminate\Support\Carbon;
    use App\Models\Currency;
    use App\Models\Setting;

    $user = Auth::user();
    $list = $user->affiliates;
    $list2 = $user->withdrawals;
    $totalEarnings = 0;
    foreach ($list as $affOrders) {
        $totalEarnings += $affOrders->orders->sum('affiliate_earnings');
    }
    $totalWithdrawal = 0;
    foreach ($list2 as $affWithdrawal) {
        $totalWithdrawal += $affWithdrawal->amount;
    }

    $earnings = $totalEarnings - $totalWithdrawal;
    if ($earnings < 0) {
        $earnings = 0;
    }

    // Get currency
    $currencyId = Setting::getCache()->default_currency ?? 124;
    $currency = Currency::find($currencyId);

    if ($app_is_demo) {
        $premium_features = [__('Unlimited Credits'), __('Smart Schedule'), __('FB, IG, X, Linkedin Channels'), __('Premium Support')];
    } else {
        $premium_features = \App\Models\OpenAIGenerator::query()->where('active', 1)->where('premium', 1)->get()->pluck('title')->toArray();
    }

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
    {{ __('Welcome') }}, {{ auth()->user()->name }}.
@endsection
@section('titlebar_subtitle')
    {{ __('Iâ€™ll help you to create stunning social media content effortlessly.') }}
@endsection

@section('content')
    <div class="py-10">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <x-card
                class="col-span-full rounded-2xl border-none p-1"
                class:body="p-0 bg-card-background"
                x-data="{
                    searchString: '',
                    setSearchString(value) {
                        this.searchString = value;
                        this.$refs.searchInput.value = value;
                        this.$refs.searchInput.focus();
                        this.$refs.searchInput.dispatchEvent(new CustomEvent('keyup', { bubbles: true, detail: { inputFocused: true } }));
                        this.$nextTick(() => {
                            this.$refs.searchInput.closest('.header-search').classList.add('is-searching');
                        })
                    }
                }"
            >
                <div class="header-search-border pointer-events-none absolute -inset-1 z-0 overflow-hidden rounded-2xl bg-heading-foreground/5">
                    <div class="header-search-border-play absolute left-1/2 top-1/2 aspect-square min-h-[125%] min-w-[125%] -translate-x-1/2 -translate-y-1/2 rounded-[inherit]">
                        <div
                            class="header-search-border-play-inner absolute min-h-full min-w-full opacity-0 [--color-1:hsl(var(--gradient-via))!important] [--color-2:hsl(var(--gradient-to))!important]">
                        </div>
                    </div>
                </div>

                <div class="relative z-2 rounded-xl bg-card-background px-5 py-8 sm:px-8 sm:py-10">
                    <h3 class="mb-5">
                        {{ __('Letâ€™s get started ًںڑ€') }}
                    </h3>

                    <div class="relative mb-5 flex gap-3">
                        <x-button
                            class="relative size-[53px] hover:scale-105 hover:text-primary-foreground hover:shadow-none"
                            size="none"
                            variant="none"
                            title="{{ __('Create new document') }}"
                            href="{{ route('dashboard.user.openai.list') }}"
                        >
                            <svg
                                class="absolute start-0 top-0 size-full fill-heading-foreground/5 transition-all group-hover:fill-primary"
                                width="54"
                                height="54"
                                viewBox="0 0 54 54"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M53.6503 26.8251C53.6503 21.6837 53.4267 16.9893 52.5326 14.3067C51.6384 11.1771 50.5207 8.27108 47.8382 5.58857C44.485 2.45897 41.579 1.5648 37.1081 0.670628C33.9785 0.223543 30.1783 0 27.9428 0C27.2722 0 26.6016 0 25.931 0C23.472 0 19.8953 0.223543 16.5422 0.670628C12.0713 1.5648 8.94171 2.68251 5.81211 5.58857C2.90606 8.27108 2.01189 11.1771 1.11771 14.3067C0.223543 16.9893 0 21.6837 0 26.8251C0 31.9666 0.223543 36.661 1.11771 39.3435C2.01189 42.4731 3.1296 45.3792 5.81211 48.0617C9.16525 51.1913 12.0713 52.0855 16.5422 52.9796C20.1189 53.6503 24.5897 53.6503 26.8251 53.6503C29.0606 53.6503 33.5314 53.6503 37.3316 52.9796C41.579 52.0855 44.7086 51.1913 48.0617 48.0617C50.7442 45.6027 51.8619 42.6967 52.7561 39.3435C53.4267 36.661 53.6503 31.9666 53.6503 26.8251Z"
                                />
                            </svg>
                            <x-tabler-plus class="relative z-1 size-5" />
                        </x-button>

                        <div class="flex w-full">
                            <x-header-search
                                class:input="xs:text-base h-full bg-heading-foreground/5 pe-12 ps-6 placeholder:text-heading-foreground ps-10"
                                class:input-wrap="h-full"
                                class:input-container="h-full"
                                class="static w-full"
                                x-ref="searchInput"
                                :show-arrow=false
                                :show-kbd=false
                            />
                            <svg
                                class="absolute end-5 top-1/2 z-1 -translate-y-1/2"
                                width="21"
                                height="16"
                                viewBox="0 0 21 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M19.8768 6.87689C17.1386 6.87689 14.643 4.38241 14.643 1.64311V0.519989H12.3968V1.64311C12.3968 3.63554 13.2706 5.50442 14.6419 6.87689H0.783691V9.12314H14.6419C13.2706 10.4956 12.3968 12.3645 12.3968 14.3569V15.48H14.643V14.3569C14.643 11.6176 17.1386 9.12314 19.8768 9.12314H20.9999V6.87689H19.8768Z"
                                    fill="url(#paint0_linear_2140_837)"
                                />
                                <defs>
                                    <linearGradient
                                        id="paint0_linear_2140_837"
                                        x1="0.783691"
                                        y1="8.00001"
                                        x2="20.9999"
                                        y2="8.00001"
                                        gradientUnits="userSpaceOnUse"
                                    >
                                        <stop stop-color="#EB6434" />
                                        <stop
                                            offset="0.545"
                                            stop-color="#BB2D9F"
                                        />
                                        <stop
                                            offset="0.98"
                                            stop-color="#BB802D"
                                        />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>

                    @php
                        $search_words = [__('content repurpose'), __('marketing email'), __('article generator'), __('ad script'), __('viral ideas'), __('tiktok video script')];
                    @endphp

                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        @foreach ($search_words as $word)
                            <button
                                class="before:px4 relative rounded-full border px-4 py-1 text-xs transition-all duration-300 before:absolute before:start-0 before:top-0 before:z-1 before:flex before:h-full before:w-full before:items-center before:justify-center before:bg-gradient-to-r before:from-gradient-from before:via-gradient-via before:to-gradient-to before:bg-clip-text before:text-center before:text-transparent before:opacity-0 before:transition-all before:duration-300 before:content-[attr(data-txt)] hover:scale-110 hover:scale-110 hover:text-transparent hover:before:opacity-100"
                                data-txt="{{ $word }}"
                                type="button"
                                @click.prevent="setSearchString($event.target.getAttribute('data-txt'))"
                            >
                                {{ $word }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </x-card>

            @if (setting('announcement_active', 0) && !auth()->user()->dash_notify_seen)
                <div
                    class="lqd-announcement col-span-full"
                    data-name="{{ \App\Enums\Introduction::DASHBOARD_FIRST }}"
                    x-data="{ show: true }"
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
                        size="none"
                        x-ref="announcementCard"
                    >
                        <div class="flex flex-wrap justify-between gap-4 lg:flex-nowrap">
                            <div class="w-full px-8 py-6 lg:w-2/3">
                                <h3 class="mb-3">
                                    @lang(setting('announcement_title', 'Welcome'))
                                </h3>
                                <p class="mb-4">
                                    @lang(setting('announcement_description', 'We are excited to have you here. Explore the marketplace to find the best AI models for your needs.'))
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @if (setting('announcement_url', '#') !== '#')
                                        <x-button
                                            class="font-medium"
                                            href="{{ setting('announcement_url', '#') }}"
                                        >
                                            <x-tabler-plus class="size-4" />
                                            {{ setting('announcement_button_text', 'Try it Now') }}
                                        </x-button>
                                    @endif
                                    <x-button
                                        class="font-medium"
                                        href="javascript:void(0)"
                                        variant="ghost-shadow"
                                        hover-variant="danger"
                                        @click.prevent="{{ $app_is_demo ? 'toastr.info(\'This feature is disabled in Demo version.\')' : ' dismiss()' }}"
                                    >
                                        @lang('Dismiss')
                                    </x-button>
                                </div>
                            </div>
                            <div class="flex w-full items-center justify-center px-4 lg:w-1/3">
                                @if (setting('announcement_image_dark'))
                                    <img
                                        class="announcement-img announcement-img-dark w-3/12 peer hidden shrink-0 dark:block"
                                        src="{{ setting('announcement_image_dark', '/upload/images/speaker.png') }}"
                                        alt="@lang(setting('announcement_title', 'Welcome to Bued AI!'))"
                                    >
                                @endif
                                <img
                                    class="announcement-img announcement-img-light shrink-0 w-3/12 dark:peer-[&.announcement-img-dark]:hidden"
                                    src="{{ setting('announcement_image', '/upload/images/speaker.png') }}"
                                    alt="@lang(setting('announcement_title', 'Welcome to Bued AI!'))"
                                >
                            </div>
                        </div>
                    </x-card>
                </div>
            @endif

            <x-card
                class="text-center"
                class:body="md:px-10 px-5"
                id="plan"
                data-name="{{ \App\Enums\Introduction::DASHBOARD_THREE }}"
                size="lg"
            >
                @include('panel.user.finance.subscriptionStatus')
            </x-card>

            @if (!$user_is_premium)
                <x-card
                    class="relative flex w-full flex-col justify-center text-center"
                    size="lg"
                >
                    <h4 class="mb-10 flex items-center gap-4">
                        <span class="h-px grow bg-border"></span>
                        @lang('Special Offer ًں¥³')
                        <span class="h-px grow bg-border"></span>
                    </h4>

                    <div class="relative z-1 flex flex-col">
                        <h4 class="mb-2.5 text-lg">
                            @lang('Limited offer to upgrade your package.')
                        </h4>
                        <p class="mb-6">
                            @lang('Select a premium plan and start growing your social media.')
                        </p>

                        <ul class="mb-11 space-y-4 self-center text-xs font-medium text-heading-foreground">
                            @foreach ($premium_features as $feature)
                                <li class="flex items-center gap-4">
                                    <svg
                                        class="shrink-0"
                                        width="19"
                                        height="19"
                                        viewBox="0 0 19 19"
                                        fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M18.0728 6.9362C17.2313 3.32368 14.3485 0.613514 10.544 0.468277C9.36481 0.438545 8.19279 0.66027 7.10594 1.1187C6.01909 1.57713 5.04233 2.26176 4.24063 3.12703C1.64076 5.82151 -0.163742 9.71705 1.01563 13.4735C1.97511 16.5297 5.01407 18.6326 8.16126 18.8247C8.45168 18.8417 8.74284 18.8421 9.03332 18.8261C12.7406 18.6311 16.4386 16.3612 17.7561 12.7984C18.427 10.9162 18.5371 8.87973 18.0728 6.9362ZM16.1263 9.93564C15.9727 11.9906 14.9871 14.3132 13.1276 15.4388C10.7526 16.8763 7.98081 17.5433 5.29592 15.8335C0.644195 12.871 3.39201 5.78484 7.26197 3.51736C12.1718 0.84339 16.4697 4.78682 16.1263 9.93564ZM13.8476 6.09826C13.6017 5.94113 13.3157 5.85829 13.0239 5.8597C12.7322 5.86111 12.447 5.94671 12.2026 6.10621C11.4822 6.54564 11.0096 7.28686 10.4566 7.90246C9.63013 8.82245 8.94066 9.57496 8.1274 10.5114C7.78363 10.9073 7.76278 10.8031 7.62351 10.5864C7.24033 9.99016 6.82828 9.15766 6.27887 8.70613C6.10053 8.56364 5.88015 8.48399 5.65193 8.47954C5.4237 8.47508 5.20038 8.54607 5.01662 8.68149C4.83286 8.81691 4.69892 9.00919 4.63559 9.2285C4.57226 9.44781 4.58308 9.68189 4.66637 9.89443C5.11654 10.8764 5.62533 11.8304 6.18999 12.7513C6.58794 13.4566 7.20385 14.3103 8.01812 14.1887C8.75061 14.0794 9.56983 12.9076 10.065 12.22C10.7051 11.331 11.4013 10.539 12.065 9.70442C12.5488 9.09605 13.0956 8.43196 13.6288 7.8674C13.8977 7.61364 14.0954 7.29379 14.2021 6.93976C14.2355 6.7801 14.2195 6.61403 14.1562 6.46369C14.0929 6.31335 13.9852 6.18588 13.8476 6.09826Z"
                                        />
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <x-button
                            class="text-sm font-bold shadow-[0_14px_44px_rgba(0,0,0,0.07)] hover:bg-gradient-to-r hover:from-gradient-from hover:via-gradient-via hover:to-gradient-to hover:shadow-2xl hover:shadow-primary/30 dark:hover:text-primary-foreground"
                            href="{{ route('dashboard.user.payment.subscription') }}"
                            size="lg"
                            variant="ghost-shadow"
                        >
                            @lang('Select a Plan')
                        </x-button>
                    </div>
                </x-card>
            @endif

            @if (showTeamFunctionality())
                <x-card
                    class="w-full"
                    id="team"
                    size="lg"
                >
                    <h4 class="mb-11 flex items-center gap-4">
                        <span class="h-px grow bg-border"></span>
                        @lang('Invite Team Members')
                        <span class="h-px grow bg-border"></span>
                    </h4>
                    @if ($team && $team?->allow_seats > 0)
                        <figure class="mb-8">
                            <img
                                class="mx-auto"
                                src="{{ custom_theme_url('assets/img/team/team.png') }}"
                                width="211"
                                height="92"
                                alt="{{ __('Team') }}"
                            >
                        </figure>
                        <p class="mb-8 text-center font-semibold">
                            @lang('Invite your colleagues and collaborators to join a team.')
                        </p>
                        <form
                            class="flex flex-col gap-3"
                            action="{{ route('dashboard.user.team.invitation.store', $team->id) }}"
                            method="post"
                        >
                            @csrf
                            <input
                                type="hidden"
                                name="team_id"
                                value="{{ $team?->id }}"
                            >
                            <x-forms.input
                                id="email"
                                size="lg"
                                type="email"
                                name="email"
                                placeholder="{{ __('Email address') }}"
                                required
                            >
                                <x-slot:icon>
                                    <x-tabler-mail class="absolute end-3 top-1/2 size-5 -translate-y-1/2" />
                                </x-slot:icon>
                            </x-forms.input>
                            @if ($app_is_demo)
                                <x-button onclick="return toastr.info('This feature is disabled in Demo version.')">
                                    @lang('Invite Friends')
                                </x-button>
                            @else
                                <x-button
                                    data-name="{{ \App\Enums\Introduction::AFFILIATE_SEND }}"
                                    type="submit"
                                    size="lg"
                                >
                                    @lang('Send Invitation')
                                    <x-tabler-circle-chevron-right class="size-4" />
                                </x-button>
                            @endif
                        </form>
                    @else
                        <h3 class="mb-6">
                            {{ __('How it Works') }}
                        </h3>

                        <ol class="mb-12 flex flex-col gap-4 text-heading-foreground">
                            <li>
                                <span class="me-2 inline-flex size-7 items-center justify-center rounded-full bg-primary/10 font-extrabold text-primary">
                                    1
                                </span>
                                {!! __('You <strong>send your invitation link</strong> to your friends.') !!}
                            </li>
                            <li>
                                <span class="me-2 inline-flex size-7 items-center justify-center rounded-full bg-primary/10 font-extrabold text-primary">
                                    2
                                </span>
                                {!! __('<strong>They subscribe</strong> to a paid plan by using your refferral link.') !!}
                            </li>
                            <li>
                                <span class="me-2 inline-flex size-7 items-center justify-center rounded-full bg-primary/10 font-extrabold text-primary">
                                    3
                                </span>
                                @if ($is_onetime_commission)
                                    {!! __('From their first purchase, you will begin <strong>earning one-time commissions</strong>.') !!}
                                @else
                                    {!! __('From their first purchase, you will begin <strong>earning recurring commissions</strong>.') !!}
                                @endif
                            </li>
                        </ol>

                        <form
                            class="flex flex-col gap-3"
                            id="send_invitation_form"
                            onsubmit="return sendInvitationForm();"
                        >
                            <x-forms.input
                                class:label="text-heading-foreground"
                                id="to_mail"
                                label="{{ __('Affiliate Link') }}"
                                size="sm"
                                type="email"
                                name="to_mail"
                                placeholder="{{ __('Email address') }}"
                                required
                            >
                                <x-slot:icon>
                                    <x-tabler-mail class="absolute end-3 top-1/2 size-5 -translate-y-1/2" />
                                </x-slot:icon>
                            </x-forms.input>

                            <x-button
                                class="w-full"
                                id="send_invitation_button"
                                type="submit"
                                form="send_invitation_form"
                            >
                                {{ __('Send') }}
                            </x-button>
                        </form>
                    @endif
                </x-card>
            @endif

            @if ($setting->feature_affilates)
                <x-card
                    class="flex text-center"
                    class:body="flex flex-col"
                    size="lg"
                >
                    <h4 class="mb-10 flex items-center gap-4">
                        <span class="h-px grow bg-border"></span>
                        @lang('Referral Link')
                        <span class="h-px grow bg-border"></span>
                    </h4>

                    <div class="mb-6 flex items-center justify-center">
                        <div class="flex size-[58px] items-center justify-center rounded-full bg-gradient-to-b from-gradient-from via-gradient-via to-gradient-to p-[3px]">
                            <div class="inline-flex size-full items-center justify-center rounded-full bg-background text-3xl/none">
                                ًںژپ
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">
                        {{ __('Refer new users and earn commissions.') }}
                    </h4>

                    <p class="mb-6 font-semibold">
                        {{ __('Simply share your referral link and have your friends sign up through it.') }}
                    </p>

                    <div class="mt-auto rounded-lg border text-start">
                        <div class="flex items-center justify-between gap-2 px-4 py-2.5">
                            <p class="m-0 text-[18px]/tight font-bold">
                                {{ __('Referral Earnings') }}
                            </p>

                            <p class="m-0 text-2xl/none font-black">
                                @if (currencyShouldDisplayOnRight(currency()->symbol))
                                    {{ $totalEarnings - $totalWithdrawal }}{{ currency()->symbol }}
                                @else
                                    {{ currency()->symbol }}{{ $totalEarnings - $totalWithdrawal }}
                                @endif
                            </p>
                        </div>
                        <div
                            class="relative flex items-center justify-between gap-2 bg-heading-foreground/5 px-4 py-3.5"
                            x-data="{}"
                        >
                            <x-forms.input
                                class:container="hidden"
                                type="hidden"
                                disabled
                                value="{{ url('/') . '/register?aff=' . \Illuminate\Support\Facades\Auth::user()->affiliate_code }}"
                                x-ref="referralLink"
                            />
                            <p class="m-0 opacity-70">
                                {{ str()->limit(url('/') . '/register?aff=' . \Illuminate\Support\Facades\Auth::user()->affiliate_code, 60) }}
                            </p>
                            <x-button
                                class="relative before:absolute before:start-1/2 before:top-1/2 before:size-12 before:-translate-x-1/2 before:-translate-y-1/2 hover:scale-110"
                                variant="link"
                                size="none"
                                @click.prevent="navigator.clipboard.writeText($refs.referralLink.value); toastr.success('{{ __('Copied To Clipboard.') }}')"
                            >
                                <x-tabler-copy class="size-5" />
                            </x-button>
                        </div>
                    </div>
                </x-card>
            @endif

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-10">
                @includeFirst(['social-media::theme.platforms', 'vendor.empty'])
            </div>

            @includeFirst(['social-media::theme.scheduled', 'vendor.empty'])
            @includeFirst(['social-media::theme.posts', 'vendor.empty'])
            <div class="col-span-full grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 lg:py-2.5">
                <div class="col-span-full flex items-center gap-7">
                    <h3 class="m-0">
                        @lang('Documents')
                    </h3>

                    <span class="inline-flex h-px grow bg-border"></span>

                    <x-button
                        class="!text-2xs"
                        variant="link"
                        href="{{ route('dashboard.user.openai.documents.all') }}"
                    >
                        {{ __('View All') }}
                        <x-tabler-circle-chevron-right
                            class="size-5"
                            stroke-width="1.5"
                        />
                    </x-button>
                </div>

                @forelse (Auth::user()->openai()->with('generator')->take(4)->get() as $entry)
                    @if ($entry->generator != null)
                        <x-card
                            class:body="p-5 flex gap-2"
                            class="hover:-translate-y-1"
                        >
                            <div class="grow">

                                <p
                                    class="mb-2 inline-flex rounded-full px-2 py-0.5 text-xs/tight text-heading-foreground"
                                    style="background-color: {{ $entry->generator->color }}"
                                >
                                    {{ $entry->generator->title }}
                                </p>

                                @if (filled($entry->title))
                                    <h5 class="mb-1.5">
                                        {{ str()->words($entry->title, 5) }}
                                    </h5>
                                @endif

                                <p class="mb-0">
                                    {{ str()->words(__($entry->generator->description), 8) }}
                                </p>
                            </div>

                            <div class="shrink-0 lg:ps-4">
                                <span
                                    class="inline-grid size-9 place-items-center rounded-full border shadow-[0_1px_0_hsl(var(--background)),0_2px_0_hsl(var(--border))] transition-all group-hover/card:shadow-[0_1px_0_hsl(var(--border)),0_2px_0_hsl(var(--border))]"
                                >
                                    <span class="size-5 text-foreground [&_svg]:h-auto [&_svg]:max-h-full [&_svg]:w-full [&_svg]:fill-current">
                                        @if ($entry->generator->image !== 'none')
                                            {!! html_entity_decode($entry->generator->image) !!}
                                        @endif
                                    </span>
                                </span>
                            </div>

                            <a
                                class="absolute left-0 top-0 z-[2] h-full w-full"
                                href="{{ route('dashboard.user.openai.documents.single', $entry->slug) }}"
                                title="{{ __('View and edit') }}"
                            ></a>
                        </x-card>
                    @endif
                @empty
                    <h4 class="col-span-full text-lg">
                        @lang('No documents have been created yet.')
                    </h4>
                @endforelse
            </div>
            @includeFirst(['advanced-image::shared-components.templates', 'vendor.empty'])
        </div>
    </div>

    {{-- blade-formatter-disable --}}
	<svg class="absolute h-0 w-0" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" > <defs> <linearGradient id="social-posts-overview-gradient" x1="9.16667" y1="15.1507" x2="32.6556" y2="31.9835" gradientUnits="userSpaceOnUse" > <stop stop-color="hsl(var(--gradient-from))" /> <stop offset="0.502" stop-color="hsl(var(--gradient-via))" /> <stop offset="1" stop-color="hsl(var(--gradient-to))" /> </linearGradient> </defs> </svg>
	{{-- blade-formatter-enable --}}
@endsection
