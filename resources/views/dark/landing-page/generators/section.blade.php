<section
    class="site-section transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="generators"
>
    <div class="container">
        <header class="mx-auto mb-24 w-full text-center lg:w-4/5">
            <h6
                class="relative mb-12 inline-flex translate-y-6 items-center gap-1.5 overflow-hidden rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                <x-tabler-rocket
                    class="size-5"
                    stroke-width="1.5"
                />
                {!! $fSectSettings->features_subtitle ? __($fSectSettings->features_subtitle) : __($fSetting->hero_subtitle) !!}
            </h6>
            <h2 class="mb-7">
                {!! $fSectSettings->features_title ? __($fSectSettings->features_title) : __('AI generator for ultimate technology.') !!}
            </h2>
            <p class="m-0 mx-auto text-xl/7 lg:w-8/12">
                {!! $fSectSettings->features_description
                    ? __($fSectSettings->features_description)
                    : __('Glide gives you the powers of a developer and a code — for designer to create remarkable tools that solve your most challenging business problems.') !!}"
            </p>
        </header>

        <div class="relative w-full overflow-hidden rounded-3xl bg-black px-5 py-16 md:px-8 lg:pe-0 lg:ps-14">
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

            <div class="lqd-tabs flex flex-wrap items-center justify-between gap-y-20">
                <div class="lqd-tabs-triggers flex flex-col gap-12 lg:w-4/12">
                    @foreach ($generatorsList as $item)
                        @include('landing-page.generators.item-trigger')
                    @endforeach
                </div>
                <div class="lqd-tabs-content-wrap max-lg:hidden lg:w-7/12">
                    @foreach ($generatorsList as $item)
                        @include('landing-page.generators.item-content')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
