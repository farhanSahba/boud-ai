<div class="relative flex flex-wrap">
    <svg
        class="absolute end-12 top-1/2 z-0 hidden -translate-y-1/2 md:block"
        width="916"
        height="160"
        viewBox="0 0 916 160"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M5.2467 81.8345C44.5585 106.987 137.196 156.644 193.252 154.05C263.322 150.807 287.403 93.5977 395.136 92.5507C502.869 91.5038 574.907 148.895 665.407 89.4628C755.907 30.0307 801.367 -10.6016 910.61 12.4586"
            stroke="url(#paint0_linear_0_3272)"
            stroke-width="10"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
        <defs>
            <linearGradient
                id="paint0_linear_0_3272"
                x1="168.065"
                y1="37.1295"
                x2="897.096"
                y2="124.818"
                gradientUnits="userSpaceOnUse"
            >
                <stop
                    stop-color="white"
                    stop-opacity="0"
                />
                <stop
                    offset="0.552083"
                    stop-color="#1281E9"
                />
                <stop
                    offset="1"
                    stop-color="#6BBFEF"
                />
            </linearGradient>
        </defs>
    </svg>

    <svg
        class="absolute end-12 top-1/2 z-0 hidden -translate-y-1/2 md:block"
        width="420"
        height="478"
        viewBox="0 0 420 478"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g
            style="mix-blend-mode:darken"
            filter="url(#filter0_f_0_3276)"
        >
            <path
                d="M337.908 102.601C308.484 60.2402 230.121 93.8909 162.726 128.186L107.455 395.811L337.908 102.601Z"
                fill="#4764E6"
            />
        </g>
        <defs>
            <filter
                id="filter0_f_0_3276"
                x="25.455"
                y="0.785645"
                width="394.453"
                height="477.025"
                filterUnits="userSpaceOnUse"
                color-interpolation-filters="sRGB"
            >
                <feFlood
                    flood-opacity="0"
                    result="BackgroundImageFix"
                />
                <feBlend
                    mode="normal"
                    in="SourceGraphic"
                    in2="BackgroundImageFix"
                    result="shape"
                />
                <feGaussianBlur
                    stdDeviation="41"
                    result="effect1_foregroundBlur_0_3276"
                />
            </filter>
        </defs>
    </svg>

    <div class="flex w-full items-end lg:w-7/12 xl:w-1/2">
        <div
            class="px-5 pt-10 max-lg:!opacity-100 lg:px-[--cutout-x] lg:pt-0"
            x-ref="content"
        >
            <figure>
                <img
                    class="size-14 lg:-ms-10 lg:-mt-10"
                    src="{{ custom_theme_url($social_media['logo']) }}"
                    alt="{{ $social_media['title'] }}"
                >
            </figure>
            <div
                class="py-8 lg:px-6 xl:px-14"
                x-ref="contentInner"
            >
                <h3 class="mb-6">
                    @lang($social_media['title'])
                </h3>
                <p class="m-0 text-heading-foreground">
                    @lang($social_media['description'])
                </p>
            </div>
        </div>
    </div>

    <div class="relative z-1 hidden w-full items-center justify-center py-32 md:flex lg:w-5/12 xl:w-1/2">
        <figure class="relative">
            <img
                class="absolute -top-32 end-full z-0 -me-20 [&.is-inview]:motion-preset-bounce [&.is-inview]:motion-delay-300"
                src="{{ custom_theme_url('/assets/landing-page/decor-7.png') }}"
                alt="{{ $social_media['title'] }}"
                width="226"
                height="256"
                loading="lazy"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
            <img
                class="relative z-1 rounded-2xl shadow-lg [&.is-inview]:motion-preset-blur-up [&.is-inview]:motion-scale-in-90"
                src="{{ custom_theme_url('/assets/landing-page/card-in.jpg') }}"
                alt="{{ $social_media['title'] }}"
                width="457"
                height="220"
                loading="lazy"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
        </figure>
    </div>
</div>
