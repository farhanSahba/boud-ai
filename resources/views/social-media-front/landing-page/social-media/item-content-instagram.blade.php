<div class="relative flex flex-wrap">
    <svg
        class="absolute end-12 top-1/2 z-0 hidden -translate-y-1/2 md:block"
        width="726"
        height="355"
        viewBox="0 0 726 355"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g filter="url(#filter0_f_0_3243)">
            <path
                d="M661.5 159.5L64.6927 64.7396L281.85 276.843C322.582 342.337 572.685 147.789 661.5 159.5Z"
                fill="#FAA8EC"
            />
        </g>
        <defs>
            <filter
                id="filter0_f_0_3243"
                x="0.692657"
                y="0.739746"
                width="724.808"
                height="353.613"
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
                    stdDeviation="32"
                    result="effect1_foregroundBlur_0_3243"
                />
            </filter>
        </defs>
    </svg>

    <div class="flex w-full items-end lg:w-7/12 xl:w-1/2">
        <div
            class="mt-10 px-5 max-lg:!opacity-100 lg:px-[--cutout-x] lg:pt-0"
            x-ref="content"
        >
            <figure>
                <img
                    class="size-10 lg:-ms-9 lg:-mt-9"
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

    <div class="relative z-1 hidden w-full justify-center py-16 md:flex lg:w-5/12 xl:w-1/2">
        <figure class="relative">
            <img
                class="absolute end-0 top-20 z-2 [&.is-inview]:motion-preset-rebound-up xl:-end-20 [&.is-inview]:motion-delay-300"
                src="{{ custom_theme_url('/assets/landing-page/decor-4.png') }}"
                alt="{{ $social_media['title'] }}"
                width="144"
                height="144"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
            <img
                class="absolute -start-24 -top-10 z-2 [&.is-inview]:motion-preset-rebound-down [&.is-inview]:motion-delay-500"
                src="{{ custom_theme_url('/assets/landing-page/decor-5.png') }}"
                alt="{{ $social_media['title'] }}"
                width="110"
                height="98"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
            <img
                class="absolute end-full top-20 z-0 -me-16 [&.is-inview]:motion-preset-wiggle [&.is-inview]:motion-delay-700"
                src="{{ custom_theme_url('/assets/landing-page/decor-6.png') }}"
                alt="{{ $social_media['title'] }}"
                width="187"
                height="200"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
            <img
                class="relative z-1 rounded-2xl border-[11px] border-solid border-background shadow-lg [&.is-inview]:motion-preset-pop [&.is-inview]:motion-scale-in-95"
                src="{{ custom_theme_url('/assets/landing-page/card-ig.jpg') }}"
                alt="{{ $social_media['title'] }}"
                width="360"
                height="544"
                x-data="{
                    inview: false
                }"
                x-intersect="inview = true"
                :class="{ 'is-inview': inview }"
            >
        </figure>
    </div>
</div>
