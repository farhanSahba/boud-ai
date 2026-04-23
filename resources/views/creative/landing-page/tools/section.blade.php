{!! adsense_tools_728x90() !!}
<section class="site-section pb-10 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100">
    <div class="absolute start-0 top-0 z-0 w-full overflow-hidden">
        <svg
            class="-translate-x-1/4"
            width="1181"
            height="1459"
            viewBox="0 0 1181 1459"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                opacity="0.04"
                d="M-340.282 1258.4C-262.65 1422.45 -134.611 1485.55 43.8361 1447.69C222.283 1409.83 358.968 1342.06 453.893 1244.39C548.818 1146.71 690.84 1065.03 879.96 999.324C1069.08 933.623 1168.89 796.824 1179.39 588.928C1189.88 381.032 1108.55 222.478 935.377 113.266C762.208 4.05386 593.187 -21.5578 428.314 36.4307C263.441 94.4192 74.8948 90.5843 -137.324 24.9261C-349.543 -40.7321 -468.037 28.1744 -492.805 231.646C-517.574 435.117 -517.754 616.097 -493.344 774.586C-468.934 933.075 -417.914 1094.34 -340.282 1258.4Z"
                fill="url(#paint0_linear_90_1315)"
            />
            <defs>
                <linearGradient
                    id="paint0_linear_90_1315"
                    x1="308.5"
                    y1="1172.5"
                    x2="-217.393"
                    y2="406.287"
                    gradientUnits="userSpaceOnUse"
                >
                    <stop stop-color="#FAFAFC" />
                    <stop
                        offset="0.200241"
                        stop-color="#1D5580"
                    />
                    <stop
                        offset="0.679077"
                        stop-color="#877FED"
                    />
                    <stop
                        offset="1"
                        stop-color="#348D8F"
                    />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <div class="container relative z-1">
        <div class="mb-24 flex flex-wrap items-end justify-between gap-y-5">
            <div class="w-full md:w-[48%]">
                <h6 class="relative mb-7 flex items-center gap-4 text-2xs font-bold uppercase tracking-[0.26em]">
                    <svg
                        width="21"
                        height="21"
                        viewBox="0 0 21 21"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <rect
                            width="21"
                            height="21"
                            rx="4"
                            fill="url(#paint0_linear_90_1196)"
                        />
                        <path
                            d="M11.4857 4L6 11.5H9.65705V16L15.1427 8.50002H11.4857V4Z"
                            fill="#EDF3F5"
                        />
                        <defs>
                            <linearGradient
                                id="paint0_linear_90_1196"
                                x1="0"
                                y1="10.5"
                                x2="21"
                                y2="10.5"
                                gradientUnits="userSpaceOnUse"
                            >
                                <stop stop-color="#1D5580" />
                                <stop
                                    offset="1"
                                    stop-color="#102E3B"
                                />
                            </linearGradient>
                        </defs>
                    </svg>
                    {!! __('High potential') !!}
                </h6>
                <h2>
                    {!! __($fSectSettings->tools_title) !!}
                </h2>
            </div>
            <div class="w-full md:w-[48%] md:text-end">
                <p class="text-xl">
                    {!! __($fSectSettings->tools_description) ?? __('While making content creation effortless for users, it maximizes the quality of the results.') !!}
                </p>
            </div>
        </div>

        <div
            class="flex flex-col gap-16 lg:flex-row"
            x-data="{
                'activeTab': 0
            }"
        >
            <nav class="min-w-40 flex flex-col gap-2 text-2xs lg:gap-5">
                @foreach ($tools as $item)
                    @include('landing-page.tools.item-trigger')
                @endforeach
            </nav>
            @foreach ($tools as $item)
                <div
                    data-index="{{ $loop->index }}"
                    @class([
                        'hidden' => !$loop->first,
                        'lqd-is-active' => $loop->first,
                    ])
                    x-init
                    :class="{ 'hidden': activeTab != $el.getAttribute('data-index') }"
                >
                    @include('landing-page.tools.item-content')
                </div>
            @endforeach
        </div>
    </div>
</section>
