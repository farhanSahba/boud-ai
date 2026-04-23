{!! adsense_features_728x90() !!}
<section
    class="site-section py-40 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="features"
>
    <div class="container">
        <div class="grid grid-cols-3 justify-between gap-x-20 gap-y-14 max-lg:grid-cols-2 max-lg:gap-10 max-md:grid-cols-1">
            @foreach ($futures as $item)
                @include('landing-page.features.item')
            @endforeach
        </div>
    </div>
</section>
