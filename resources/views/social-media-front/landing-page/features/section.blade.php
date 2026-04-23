{!! adsense_features_728x90() !!}
<section
    class="site-section relative pb-20 pt-44 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="features"
>
    <div class="container relative z-1">
        <div class="mx-auto mb-16 w-full text-center">
            <h2 class="mx-auto mb-5 w-full lg:w-2/3 [&_svg]:inline">
                {!! __($fSectSettings->features_title) !!}
            </h2>
            <p class="mx-auto mb-7 w-full text-xl/[1.3em] opacity-80 lg:w-1/2">
                {!! __(
                    $fSectSettings->features_description ??
                        "Easily design, schedule, and publish posts from anywhere, anytime—ensuring you stay productive and connected no matter what device you're on.",
                ) !!}
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <p class="m-0 text-sm font-bold text-heading-foreground">
                    @lang('Download for')
                </p>

                <a
                    class="inline-grid size-11 place-items-center rounded-full border border-heading-foreground/5 text-heading-foreground transition-all hover:bg-heading-foreground hover:text-background"
                    href="#"
                >
                    <svg
                        width="23"
                        height="23"
                        viewBox="0 0 23 23"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M11.0957 5.07617L11.5449 4.40234C11.7695 3.95312 12.3535 3.81836 12.7578 4.04297C13.207 4.3125 13.3867 4.85156 13.1172 5.30078L9.16406 12.1289H12.0391C12.9375 12.1289 13.4766 13.207 13.0723 13.9258H4.7168C4.22266 13.9258 3.81836 13.5215 3.81836 13.0273C3.81836 12.5332 4.22266 12.1289 4.7168 12.1289H7.05273L10.0625 6.91797L9.11914 5.30078C8.89453 4.85156 9.0293 4.3125 9.47852 4.04297C9.88281 3.81836 10.4668 3.95312 10.7363 4.40234L11.0957 5.07617ZM7.5918 14.8691L6.69336 16.3965C6.46875 16.8457 5.88477 16.9805 5.43555 16.7559C4.98633 16.4863 4.85156 15.9473 5.12109 15.498L5.75 14.375C6.51367 14.1504 7.09766 14.3301 7.5918 14.8691ZM15.1836 12.1289H17.5645C18.0586 12.1289 18.4629 12.5332 18.4629 13.0273C18.4629 13.5215 18.0586 13.9258 17.5645 13.9258H16.2168L17.1152 15.498C17.3848 15.9473 17.2051 16.4863 16.8008 16.7559C16.3516 16.9805 15.7676 16.8457 15.543 16.3965C14.0156 13.791 12.8926 11.8594 12.1289 10.5566C11.3652 9.20898 11.9043 7.90625 12.4883 7.45703C13.0723 8.49023 13.9707 10.0176 15.1836 12.1289ZM11.1406 0C17.2949 0 22.2812 4.98633 22.2812 11.1406C22.2812 17.2949 17.2949 22.2812 11.1406 22.2812C4.98633 22.2812 0 17.2949 0 11.1406C0 4.98633 4.98633 0 11.1406 0ZM20.8438 11.1406C20.8438 5.79492 16.4414 1.4375 11.1406 1.4375C5.75 1.4375 1.4375 5.83984 1.4375 11.1406C1.4375 16.5312 5.79492 20.8438 11.1406 20.8438C16.4863 20.8438 20.8438 16.4863 20.8438 11.1406Z"
                        />
                    </svg>
                </a>

                <a
                    class="inline-grid size-11 place-items-center rounded-full border border-heading-foreground/5 text-heading-foreground transition-all hover:bg-heading-foreground hover:text-background"
                    href="#"
                >
                    <svg
                        width="21"
                        height="22"
                        viewBox="0 0 21 22"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M13.1719 10.0676L3.68867 0.558594L15.7543 7.48516L13.1719 10.0676ZM1.21367 0C0.655078 0.292188 0.28125 0.825 0.28125 1.5168V20.4789C0.28125 21.1707 0.655078 21.7035 1.21367 21.9957L12.2395 10.9957L1.21367 0ZM19.484 9.69375L16.9531 8.22852L14.1301 11L16.9531 13.7715L19.5355 12.3062C20.309 11.6918 20.309 10.3082 19.484 9.69375ZM3.68867 21.4414L15.7543 14.5148L13.1719 11.9324L3.68867 21.4414Z"
                        />
                    </svg>
                </a>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-y-3">
            <div class="flex w-full flex-wrap gap-4 lg:w-1/4 lg:flex-col lg:flex-nowrap lg:gap-11">
                @foreach ($futures->take($futures->count() / 2) as $item)
                    @include('landing-page.features.item')
                @endforeach
            </div>

            <div class="hidden w-full items-center justify-center lg:flex lg:w-1/3">
                <figure>
                    <img
                        src="{{ custom_theme_url('assets/landing-page/robot.png') }}"
                        alt="{{ __('Robot') }}"
                        width="417"
                        height="334"
                    />
                </figure>
            </div>

            <div class="flex w-full flex-wrap gap-4 lg:w-1/4 lg:flex-col lg:flex-nowrap lg:gap-11">
                @foreach ($futures->skip(ceil($futures->count() / 2)) as $item)
                    @include('landing-page.features.item')
                @endforeach
            </div>
        </div>
    </div>
</section>
