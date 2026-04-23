{!! adsense_how_it_works_728x90() !!}
<section
    class="site-section border-b border-heading-foreground/5 pb-16 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="how-it-works"
>
    <div class="container relative">
        <figure
            class="absolute end-0 top-20 hidden lg:block"
            aria-hidden="true"
        >
            <img
                src="{{ custom_theme_url('assets/landing-page/decor-4.png') }}"
                width="144"
                height="144"
                alt="{{ __('Decorative image') }}"
            >
        </figure>

        <div class="mx-auto mb-14 w-full text-center lg:w-1/2 xl:w-1/3">
            <h2 class="mb-5 [&_svg]:inline">
                {!! __($fSectSettings->how_it_works_title) !!}
            </h2>
            <p class="text-xl/[1.3em] opacity-80">
                {!! $fSectSettings->how_it_works_description ?? 'To create content quickly and effectively, <strong>here are the steps you can follow:</strong>' !!}
            </p>
        </div>

        <div class="lg:grid-cols-{{ count($howitWorks) }} grid gap-7 md:grid-cols-1 lg:gap-20 xl:gap-x-52">
            @foreach ($howitWorks as $item)
                @include('landing-page.how-it-works.item')
            @endforeach
        </div>

        @if ($howitWorksDefaults['option'] == 1)
            <div class="mt-20 flex justify-center gap-1.5 [&_a]:text-primary">
                {!! $howitWorksDefaults['html'] !!}
            </div>
        @endif
    </div>
</section>
