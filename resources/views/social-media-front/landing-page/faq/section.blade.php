{!! adsense_faq_728x90() !!}
<section
    class="site-section border-b pb-24 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="faq"
>
    <div class="container relative">

        <div class="flex flex-wrap items-start justify-between gap-y-20">
            <div class="w-full lg:sticky lg:top-28 lg:w-4/12">
                <figure
                    class="relative mb-5 w-full"
                    aria-hidden="true"
                >
                    <svg
                        class="relative z-0"
                        width="283"
                        height="301"
                        viewBox="0 0 283 301"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M282.655 0.167969H0.65464V271.918H0.5V300.168L30.5427 272.168H282.655V0.167969Z"
                            fill="#E4F3F6"
                        />
                    </svg>
                    <img
                        class="absolute -top-10 start-0 z-1 mix-blend-luminosity saturate-0 lg:start-12"
                        src="{{ custom_theme_url('assets/landing-page/faq-img.png') }}"
                        width="325"
                        height="311"
                    >
                </figure>
                <h3 class="mb-5 text-[40px]">
                    {!! __($fSectSettings->faq_title) !!}
                </h3>
                <p class="text-xl/[1.3em] opacity-80">
                    {!! $fSectSettings->faq_subtitle ?? 'Our support team will get assistance from AI-powered suggestions, making it quicker than ever to handle support requests.' !!}
                </p>
            </div>

            <div class="w-full lg:w-6/12">
                <div
                    class="lqd-accordion w-full space-y-5"
                    x-data="{
                        'activeIndex': 0
                    }"
                >
                    @foreach ($faq as $item)
                        @include('landing-page.faq.item')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
