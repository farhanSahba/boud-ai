@php
    $items = \App\Models\Frontend\Curtain::query()->select('title', 'title_icon', 'sliders')->get()->toArray();

@endphp

<section
    class="site-section py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="vertical-slider"
>
    <div class="container">
        <div class="relative mx-auto mb-20 w-full text-center lg:w-7/12">
            <figure
                class="absolute -end-20 -top-20 hidden lg:block"
                aria-hidden="true"
            >
                <img
                    src="{{ custom_theme_url('assets/landing-page/globe.png') }}"
                    alt="{{ __('Globe') }}"
                    width="260"
                    height="186"
                >
            </figure>
            <h2 class="mb-5 lg:text-[56px]/[1em] [&_svg]:inline">
                {!! __('Reach <span class="text-gradient">global</span> audience') !!}
            </h2>
            <p class="text-xl">
                {!! __('AI translates posts into multiple languages and helps you connect with audiences from different countries and cultures.') !!}
            </p>
        </div>

        <x-curtain :$items />

        <p class="mb-0 mt-11 text-center text-[12px] opacity-70">
            @lang('We stay ahead of the curve by adopting the latest technologies and trends.')
        </p>
    </div>
</section>
