<div class="relative flex flex-wrap">
    <svg
        class="absolute end-5 top-1/3 z-0 hidden -translate-y-1/2 transition-all duration-1000 [stroke-dasharray:1550] [stroke-dashoffset:1550] lg:block [&.is-inview]:[stroke-dashoffset:0]"
        width="1292"
        height="291"
        viewBox="0 0 1292 291"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        x-data="{
            inview: false
        }"
        x-intersect="inview = true"
        :class="{ 'is-inview': inview }"
    >
        <path
            d="M-80.449 5.18328C-25.1795 45.5233 106.463 130.974 190.878 150.055C296.396 173.907 340.832 126.038 502.493 166.648C664.153 207.257 763.787 292.473 908.12 268.064C1052.45 243.655 1126.53 220.621 1286.94 285.909"
            stroke="url(#paint0_linear_0_3197)"
            stroke-width="10"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
        <defs>
            <linearGradient
                id="paint0_linear_0_3197"
                x1="170.155"
                y1="23.4562"
                x2="1250.31"
                y2="392.986"
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
                    stop-color="#87CEB0"
                />
            </linearGradient>
        </defs>
    </svg>

    <div class="flex w-full items-end lg:w-7/12 xl:w-1/2">
        <div
            class="px-5 pt-10 max-lg:!opacity-100 lg:px-[--cutout-x] lg:pt-0"
            x-ref="content"
        >
            <figure>
                <img
                    class="size-9 lg:-ms-8 lg:-mt-8"
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

    <div class="relative z-1 hidden w-full justify-center py-40 md:flex lg:w-5/12 xl:w-1/2">
        <figure class="relative">
            <img
                class="absolute -top-32 end-0 z-0 motion-delay-500 [&.is-inview]:motion-preset-rebound-up"
                src="{{ custom_theme_url('/assets/landing-page/decor-3.png') }}"
                alt="{{ $social_media['title'] }}"
                width="200"
                height="200"
                loading="lazy"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
            <img
                class="relative z-1 rounded-2xl shadow-lg [&.is-inview]:motion-preset-expand"
                src="{{ custom_theme_url('/assets/landing-page/card-x.jpg') }}"
                alt="{{ $social_media['title'] }}"
                width="473"
                height="282"
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
