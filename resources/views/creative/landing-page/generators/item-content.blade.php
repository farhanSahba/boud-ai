<div
    class="lqd-tabs-content {{ !$loop->first ? 'hidden' : '' }}"
    id="{{ \Illuminate\Support\Str::slug($item->menu_title) }}"
>
    <div class="flex flex-wrap items-center justify-between max-md:gap-4">
        <div class="w-full lg:w-1/2 lg:pe-20">
            <h6 class="relative mb-8 flex items-center gap-4 text-2xs font-bold uppercase tracking-[0.26em]">
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
                {!! __($item->subtitle_one) !!}
                <span class="dot"></span>
                <span class="opacity-50">
                    {!! __($item->subtitle_two) !!}
                </span>
            </h6>
            <h2 class="mb-10">
                {!! __($item->title) !!}
            </h2>
            <p class="text-lg leading-7 [&_strong]:font-normal [&_strong]:text-black">
                {!! __($item->text) !!}
            </p>
        </div>
        <div class="w-full text-center lg:w-1/2">
            <figure class="mb-6 w-full">
                <img
                    class="w-full"
                    width="878"
                    height="748"
                    src="{{ custom_theme_url($item->image, true) }}"
                    alt="{{ __($item->image_title) }}"
                >
            </figure>
            <p class="text-lg font-semibold text-heading-foreground">{!! __($item->image_title) !!}</p>
            <p class="text-[12px] text-heading-foreground">{!! __($item->image_subtitle) !!}</p>
        </div>
    </div>
</div>
