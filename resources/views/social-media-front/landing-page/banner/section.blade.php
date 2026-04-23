<section
    class="site-section relative border-b border-solid"
    id="banner"
    style="--section-background: #FBB9B9;"
>
    <div class="container relative py-12">
        <div
            class="relative flex translate-y-10 flex-wrap items-center rounded-xl opacity-0 group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100"
            id="banner-content"
            style="background: radial-gradient(circle, #FBB9B9, #FFE2D8);"
        >
            <div class="w-full px-5 py-12 md:py-20 lg:w-7/12 lg:py-0 lg:ps-16">
                <h6
                    class="mb-7 inline-flex translate-y-5 scale-95 items-center gap-5 rounded-full border border-solid border-heading-foreground/5 py-1.5 pe-4 ps-2 text-[12px] text-foreground opacity-0 transition-all ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100">
                    <span class="rounded-full border border-heading-foreground/5 px-2 py-0.5 leading-tight text-heading-foreground/90">
                        @lang('New')
                    </span>
                    {!! __($fSetting->hero_subtitle) !!}
                </h6>
                <h1
                    class="banner-title mb-6 translate-y-5 scale-95 opacity-0 transition-all delay-[75ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100">
                    {!! __($fSetting->hero_title) !!}
                    @if ($fSetting->hero_title_text_rotator != null)
                        <span class="lqd-text-rotator grid grid-cols-1 grid-rows-1 transition-[width] duration-200">
                            @foreach (explode(',', __($fSetting->hero_title_text_rotator)) as $keyword)
                                <span
                                    class="lqd-text-rotator-item {{ $loop->first ? 'lqd-is-active' : '' }} text-gradient col-start-1 row-start-1 inline-flex translate-y-5 scale-95 opacity-0 blur-sm transition-all duration-300 group-[.page-loaded]/body:scale-100 [&.lqd-is-active]:translate-y-0 [&.lqd-is-active]:opacity-100 [&.lqd-is-active]:blur-0"
                                >
                                    <span>{!! $keyword !!}</span>
                                </span>
                            @endforeach
                        </span>
                    @endif
                    <span class="banner-title-after block">
                        {!! __($fSetting->hero_title_after ?? 'with <u>AI.</u>') !!}
                    </span>
                </h1>
                <p
                    class="mb-7 w-3/4 translate-y-5 scale-95 text-xl leading-[1.25em] text-fuchsia-700 opacity-0 transition-all delay-[150ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:text-foreground group-[.page-loaded]/body:opacity-80 max-sm:w-full">
                    {!! __($fSetting->hero_description) !!}
                </p>
                <div
                    class="flex w-full translate-y-5 scale-95 flex-wrap items-center gap-8 text-lg font-semibold opacity-0 transition-all delay-[225ms] group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100">
                    @if ($fSetting->hero_button_type == 1)
                        <x-button
                            class="group inline-flex items-center gap-6 rounded-full py-3.5 pe-4 ps-2.5 text-xl font-medium text-heading-foreground outline-heading-foreground/5 transition-all hover:scale-105 hover:shadow-lg"
                            variant="outline"
                            href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                        >
                            <span
                                class="bg-gradient inline-grid size-12 shrink-0 place-items-center rounded-full text-primary-foreground group-hover:translate-x-1.5 group-hover:text-black group-hover:[--gradient-from:#fff] group-hover:[--gradient-to:#fff] group-hover:[--gradient-via:#fff]"
                            >
                                <svg
                                    widh="20"
                                    height="15"
                                    viewBox="0 0 20 15"
                                >
                                    <use href="#arrow-icon" />
                                </svg>
                            </span>
                            {!! __($fSetting->hero_button) !!}
                        </x-button>
                    @else
                        <x-button
                            class="group inline-flex items-center gap-6 rounded-full py-3.5 pe-4 ps-2.5 text-xl font-medium text-heading-foreground outline-heading-foreground/5 transition-all hover:scale-105 hover:shadow-lg"
                            data-fslightbox="video-gallery"
                            variant="outline"
                            href="{{ !empty($fSetting->hero_button_url) ? $fSetting->hero_button_url : '#' }}"
                        >
                            <span
                                class="bg-gradient inline-grid size-12 place-items-center rounded-full text-primary-foreground group-hover:translate-x-1.5 group-hover:text-black group-hover:[--gradient-from:#fff] group-hover:[--gradient-to:#fff] group-hover:[--gradient-via:#fff]"
                            >
                                <x-tabler-player-play-filled class="size-4" />
                            </span>
                            {!! __($fSetting->hero_button) !!} &nbsp;
                        </x-button>
                    @endif
                    <a
                        class="transition-all hover:scale-105 hover:text-primary"
                        href="#features"
                    >
                        {!! __($fSetting->hero_scroll_text) !!}
                    </a>
                </div>

                <p
                    class="mt-8 translate-y-5 text-[12px] opacity-0 transition-all delay-[150ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100">
                    {{ $fSetting->no_credit_cart_required }}
                </p>
            </div>

            <div class="w-full px-5 py-[70px] lg:ms-auto lg:w-5/12 lg:px-0 lg:pb-32 lg:pe-16">
                <div
                    class="banner-media-blob relative lg:-me-10 lg:-ms-10"
                    aria-hidden="true"
                >
                    <svg
                        class="absolute end-0 top-1/2 z-0 -translate-x-10 -translate-y-1/2 transition-all delay-[200ms] duration-700 ease-out [stroke-dasharray:780] [stroke-dashoffset:780] group-[.page-loaded]/body:translate-x-0 group-[.page-loaded]/body:[stroke-dashoffset:0] xl:-end-20"
                        width="684"
                        height="247"
                        viewBox="0 0 684 247"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M5.33395 192.157C37.487 212.016 112.259 249.279 154.123 239.46C206.453 227.187 218.627 167.347 299.492 152.383C380.358 137.418 440.449 185.013 502.314 114.383C564.179 43.7531 594.139 -2.4133 678.637 6.33086"
                            stroke="url(#paint0_linear_0_2917)"
                            stroke-width="10"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <defs>
                            <linearGradient
                                id="paint0_linear_0_2917"
                                x1="123.081"
                                y1="126.781"
                                x2="680.118"
                                y2="119.49"
                                gradientUnits="userSpaceOnUse"
                            >
                                <stop
                                    stop-color="white"
                                    stop-opacity="0"
                                />
                                <stop
                                    offset="0.552083"
                                    stop-color="#E91212"
                                />
                                <stop
                                    offset="1"
                                    stop-color="#CE8787"
                                />
                            </linearGradient>
                        </defs>
                    </svg>

                    <figure class="absolute -top-14 start-0 z-2 mix-blend-luminosity motion-translate-y-loop-25 motion-duration-[5s] motion-delay-300 motion-ease-in-out-back">
                        <img
                            class="translate-y-5 opacity-0 transition-all delay-[200ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100"
                            src="{{ custom_theme_url('/assets/landing-page/fb.png') }}"
                            alt="{{ __('Facebook') }}"
                            width="77"
                            height="77"
                        >
                    </figure>
                    <figure class="absolute -top-16 end-28 z-2 mix-blend-luminosity motion-translate-y-loop-25 motion-duration-[5s] motion-ease-in-out-back">
                        <img
                            class="translate-y-5 opacity-0 transition-all delay-[300ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100"
                            src="{{ custom_theme_url('/assets/landing-page/ig.png') }}"
                            alt="{{ __('Instagram') }}"
                            width="72"
                            height="72"
                        >
                    </figure>
                    <figure class="absolute -top-10 end-0 z-2 mix-blend-luminosity motion-translate-y-loop-25 motion-duration-[5s] motion-delay-100 motion-ease-in-out-back">
                        <img
                            class="translate-y-5 opacity-0 transition-all delay-[400ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100"
                            src="{{ custom_theme_url('/assets/landing-page/in.png') }}"
                            alt="{{ __('Linkedin') }}"
                            width="66"
                            height="66"
                        >
                    </figure>
                    <figure
                        class="aspect-square w-full translate-y-5 opacity-0 transition-all delay-[500ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100"
                        style="clip-path: url(#banner-media-mask)"
                    >
                        <img
                            class="h-full w-full object-cover object-center"
                            src="{{ $fSetting->hero_image ?? custom_theme_url('/assets/landing-page/banner-img.jpg') }}"
                            alt="{{ __('Image of ' . $setting->site_name . ' dashboard') }}"
                        >
                    </figure>

                    <svg
                        class="absolute start-0 top-0 max-w-full overflow-visible"
                        width="491"
                        height="470"
                        viewBox="0 0 491 470"
                        fill="#000"
                        xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="none"
                    >
                        <defs>
                            <clipPath
                                id="banner-media-mask"
                                clipPathUnits="objectBoundingBox"
                                transform="scale(0.002)"
                            >
                                <path
                                    vector-effect="non-scaling-stroke"
                                    d="M464.567 133.33C507.424 215.584 495.659 321.039 447.34 384.733C398.601 448.005 313.307 468.675 225.912 469.94C138.517 471.205 49.4411 452.645 15.8276 397.809C-17.3656 343.395 5.32344 253.126 49.8612 169.606C94.8192 86.0864 161.206 9.73754 243.138 0.879379C325.071 -7.97878 422.13 51.0756 464.567 133.33Z"
                                >
                                    <animate
                                        attributeName="d"
                                        values="
										M464.567 133.33C507.424 215.584 495.659 321.039 447.34 384.733C398.601 448.005 313.307 468.675 225.912 469.94C138.517 471.205 49.4411 452.645 15.8276 397.809C-17.3656 343.395 5.32344 253.126 49.8612 169.606C94.8192 86.0864 161.206 9.73754 243.138 0.879379C325.071 -7.97878 422.13 51.0756 464.567 133.33Z;
										M461.434 123.774C495.031 227.385 498.93 324.957 450.61 388.651C401.871 451.924 343.004 466.968 295.25 466.968C247.496 466.968 134.159 421.124 87.0413 346.627C39.9239 272.131 -30.083 146.168 14.4548 62.6486C59.4128 -20.8711 188.963 2.91769 283.152 7.89037C377.341 12.8631 427.838 20.1634 461.434 123.774Z;
										M479.81 69.2893C497.638 119.59 452.996 297.851 404.676 361.545C355.937 424.818 310.441 465.331 208.566 465.331C106.69 465.331 9.27112 388.288 1.63043 306.787C-6.01026 225.286 15.0345 152.809 59.5723 69.2893C104.53 -14.2304 194.604 0.00753927 288.793 4.98023C382.981 9.95291 461.982 18.9882 479.81 69.2893Z;
										M464.567 133.33C507.424 215.584 495.659 321.039 447.34 384.733C398.601 448.005 313.307 468.675 225.912 469.94C138.517 471.205 49.4411 452.645 15.8276 397.809C-17.3656 343.395 5.32344 253.126 49.8612 169.606C94.8192 86.0864 161.206 9.73754 243.138 0.879379C325.071 -7.97878 422.13 51.0756 464.567 133.33Z"
                                        dur="6s"
                                        repeatCount="indefinite"
                                    />
                                </path>
                            </clipPath>
                        </defs>
                    </svg>
                    <p
                        class="absolute bottom-9 end-0 inline-block translate-y-5 rounded-2xl bg-background px-5 py-3.5 text-xs font-medium text-heading-foreground opacity-0 transition-all delay-[600ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100 [&_span]:font-heading [&_span]:text-[1.857em] [&_span]:font-bold [&_span]:leading-none">
                        {!! $fSetting->faster_content_creation !!}
                    </p>
                </div>
            </div>

            <x-shape-cutout
                width="550px"
                height="128px"
                el-id="banner-content"
            />
        </div>

        <div
            class="mt-5 w-full translate-y-5 rounded-xl px-12 py-7 text-center opacity-0 transition-all delay-[500ms] ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:scale-100 group-[.page-loaded]/body:opacity-100 md:px-20 lg:absolute lg:bottom-12 lg:end-4 lg:mt-0 lg:w-[530px]"
            style="background: radial-gradient(circle, #FBB9B9, #FFE2D8);"
        >
            <p class="[&_u]:rounded-full [&_u]:bg-heading-foreground [&_u]:px-2 [&_u]:py-1 [&_u]:text-heading-background [&_u]:no-underline">
                {!! $fSetting->over_5000_businesses !!}
            </p>
        </div>
    </div>
</section>

<div class="fixed bottom-8 start-1/2 z-40 hidden -translate-x-1/2 items-center gap-2.5 rounded-full bg-background p-3 shadow-2xl lg:flex">
    <x-button
        class="relative gap-3 px-7 py-2.5 text-[18px] font-medium leading-none outline outline-2 outline-black/[3%]"
        href="{{  (route('register')) }}"
        variant="outline"
    >
        <x-outline-glow
            class="group-hover:opacity-0"
            style="--outline-glow-w: 2px; --glow-color-primary: 314 58% 46%;"
        />
        <span class="text-gradient group-hover:text-white">
            {{ __('Get Started') }}
        </span>
        <svg
            width="17"
            height="13"
            viewBox="0 0 17 13"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                class="group-hover:fill-primary-foreground"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M15.6823 5.60208C13.4932 5.60208 11.4981 3.60784 11.4981 1.41786V0.519958H9.70225V1.41786C9.70225 3.01073 10.4008 4.50484 11.4972 5.60208H0.417969V7.39788H11.4972C10.4008 8.49511 9.70225 9.98922 9.70225 11.5821V12.48H11.4981V11.5821C11.4981 9.39211 13.4932 7.39788 15.6823 7.39788H16.5802V5.60208H15.6823Z"
                fill="url(#paint0_linear_0_3953)"
            />
            <defs>
                <linearGradient
                    id="paint0_linear_0_3953"
                    x1="0.417969"
                    y1="6.49998"
                    x2="16.5802"
                    y2="6.49998"
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
    </x-button>

    <x-button
        class="relative gap-3 px-7 py-2.5 text-[18px] font-medium leading-none outline outline-2 outline-black/[3%]"
        href="#footer"
        variant="outline"
    >
        {{ __('Contact Us') }}
    </x-button>
</div>
