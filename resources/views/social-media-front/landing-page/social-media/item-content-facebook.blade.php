<div class="relative flex flex-wrap">
    <svg
        class="absolute end-0 top-1/3 z-0 hidden -translate-y-1/2 transition-all duration-1000 [stroke-dasharray:1550] [stroke-dashoffset:1550] lg:block xl:-end-20 [&.is-inview]:[stroke-dashoffset:0]"
        width="1346"
        height="254"
        viewBox="0 0 1346 254"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        x-data="{
            inview: false
        }"
        x-intersect="inview = true"
        :class="{ 'is-inview': inview }"
    >
        <path
            d="M-106.166 201.773C-37.5231 221.154 122.24 257.305 212.149 246.857C324.535 233.798 351.533 173.764 525.144 157.586C698.754 141.407 826.883 188.112 960.588 116.541C1094.29 44.971 1159.22 -1.65313 1340.27 5.82734"
            stroke="url(#paint0_linear_0_3157)"
            stroke-width="10"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
        <defs>
            <linearGradient
                id="paint0_linear_0_3157"
                x1="147.277"
                y1="134.621"
                x2="1341.75"
                y2="118.987"
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
                    stop-color="#CE8787"
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
                    class="size-12 lg:-ms-9 lg:-mt-9"
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

    <div class="relative z-1 hidden w-full justify-center py-28 md:flex lg:w-5/12 xl:w-1/2">
        <figure class="relative">
            <img
                class="absolute end-full top-20 motion-delay-200 [&.is-inview]:motion-preset-expand"
                src="{{ custom_theme_url('/assets/landing-page/decor-2.png') }}"
                alt="{{ $social_media['title'] }}"
                width="202"
                height="204"
                loading="lazy"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
            <img
                class="rounded-2xl shadow-lg [&.is-inview]:motion-preset-expand"
                src="{{ custom_theme_url('/assets/landing-page/card-fb.jpg') }}"
                alt="{{ $social_media['title'] }}"
                width="365"
                height="393"
                loading="lazy"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
            <img
                class="absolute -top-24 end-0 motion-delay-500 [&.is-inview]:motion-preset-expand xl:end-auto xl:start-full"
                src="{{ custom_theme_url('/assets/landing-page/decor-1.png') }}"
                alt="{{ $social_media['title'] }}"
                width="202"
                height="204"
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
