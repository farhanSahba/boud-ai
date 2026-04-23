{!! adsense_how_it_works_728x90() !!}
<section
    class="site-section transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="how-it-works"
>
    <div class="container">
        <div class="relative w-full overflow-hidden rounded-3xl bg-black px-5 py-20 md:px-8 lg:px-20 lg:py-24">
            <figure
                class="pointer-events-none absolute start-1/2 top-0 z-0 w-full max-w-none -translate-x-1/2 -translate-y-1/2"
                aria-hidden="true"
            >
                <img
                    width="3110"
                    height="1142"
                    src="{{ custom_theme_url('/assets/landing-page/glow-1.png') }}"
                    alt="{{ __('Glowing blob') }}"
                />
            </figure>
            <figure
                class="pointer-events-none absolute bottom-0 start-0 z-2 w-full max-w-none -translate-x-1/4"
                aria-hidden="true"
            >
                <img
                    width="1602"
                    height="2098"
                    src="{{ custom_theme_url('/assets/landing-page/glow-3.png') }}"
                    alt="{{ __('Glowing blob') }}"
                />
            </figure>

            <div class="mb-24 flex flex-wrap items-end justify-between gap-y-5">
                <div class="w-full lg:w-2/3 lg:pe-8">
                    <h6
                        class="relative mb-14 inline-flex translate-y-6 items-center gap-1.5 rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                        <x-tabler-rocket
                            class="size-5"
                            stroke-width="1.5"
                        />
                        {!! $fSectSettings->how_it_works_subtitle ? __($fSectSettings->how_it_works_subtitle) : __($fSetting->hero_subtitle) !!}
                    </h6>
                    <h2>
                        {!! __($fSectSettings->how_it_works_title) !!}
                    </h2>
                </div>

                <div class="w-full lg:w-1/3">
                    <p class="mb-6">
                        {!! $fSectSettings->how_it_works_description
                            ? __($fSectSettings->how_it_works_description)
                            : __('Content and kickstart your earnings in minutes  kickstart your earnings in minutes') !!}
                    </p>
                    <a
                        class="group inline-flex items-center gap-4 text-sm font-medium text-white hover:text-primary"
                        href="{{ $fSectSettings->how_it_works_link ? $fSectSettings->how_it_works_link : '#' }}"
                    >
                        {!! $fSectSettings->how_it_works_link_label ? __($fSectSettings->how_it_works_link_label) : __('Learn More') !!}
                        <x-tabler-chevron-right class="size-4 transition-all group-hover:translate-x-1" />
                    </a>
                </div>
            </div>

            <div class="grid-cols-{{ count($howitWorks) }} grid gap-7 max-md:grid-cols-1">
                @foreach ($howitWorks as $item)
                    @include('landing-page.how-it-works.item')
                @endforeach
            </div>

            @if ($howitWorksDefaults['option'] == 1)
                <div class="mt-20 flex justify-center">
                    {!! $howitWorksDefaults['html'] !!}
                </div>
            @endif
        </div>
    </div>
</section>
