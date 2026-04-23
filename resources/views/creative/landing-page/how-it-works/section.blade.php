{!! adsense_how_it_works_728x90() !!}
<section
    class="site-section pb-24 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="how-it-works"
>
    <div class="container">
        <div class="mx-auto mb-24 w-full text-center lg:w-2/3">
            <h6 class="relative mb-7 flex items-center justify-center gap-4 text-2xs font-bold uppercase tracking-[0.26em]">
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
                {!! __('Step by step') !!}
            </h6>
            <h2 class="mb-10">
                {!! __($fSectSettings->how_it_works_title) !!}
            </h2>
            <p class="text-xl leading-7 [&_strong]:font-normal [&_strong]:text-heading-foreground">
                {!! $fSectSettings->how_it_works_description ?? 'To create content quickly and effectively, <strong>here are the steps you can follow:</strong>' !!}
            </p>
        </div>

        <div class="grid-cols-{{ count($howitWorks) }} mb-20 grid gap-7 max-md:grid-cols-1">
            @foreach ($howitWorks as $item)
                @include('landing-page.how-it-works.item')
            @endforeach
        </div>
        @if ($howitWorksDefaults['option'] == 1)
            <div class="flex justify-center gap-1.5 [&_a]:text-primary">
                {!! $howitWorksDefaults['html'] !!}
            </div>
        @endif
    </div>
</section>
