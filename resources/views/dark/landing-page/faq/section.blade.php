{!! adsense_faq_728x90() !!}
<section
    class="site-section py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 lg:py-36 lg:pb-24 lg:pt-16 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="faq"
>
    <div class="container">
        <div class="relative w-full overflow-hidden rounded-3xl bg-black px-5 py-20 md:px-8 lg:flex lg:min-h-[70vh] lg:items-center lg:px-20 lg:py-36">
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

            <div class="relative z-2 flex w-full flex-wrap justify-between">
                <header class="mb-7 w-full lg:w-5/12">
                    <h6
                        class="relative mb-12 inline-flex translate-y-6 items-center gap-1.5 overflow-hidden rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                        <x-tabler-rocket
                            class="size-5"
                            stroke-width="1.5"
                        />
                        {!! $fSectSettings->faq_text_one ? __($fSectSettings->faq_text_one) : __($fSetting->hero_subtitle) !!}
                    </h6>
                    <h2 class="mb-7">
                        {!! $fSectSettings->faq_title ? __($fSectSettings->faq_title) : __('Have any question? Find answer here.') !!}
                    </h2>
                    <p class="m-0">
                        {!! $fSectSettings->faq_subtitle ? __($fSectSettings->faq_subtitle) : __('Some frequently asked questions about our AI software dashboard.') !!}"
                    </p>
                </header>

                <div class="lqd-accordion flex w-full flex-col gap-7 lg:w-6/12">
                    @foreach ($faq as $item)
                        @include('landing-page.faq.item')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
