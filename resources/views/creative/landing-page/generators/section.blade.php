<section class="site-section pb-14 pt-14 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100">
    <div class="container">
        <div class="lqd-tabs">
            <div class="lqd-tabs-triggers mb-24 flex justify-between border-b-[3px] border-b-heading-foreground/10 text-xl font-semibold max-lg:flex-wrap">
                @foreach ($generatorsList as $item)
                    @include('landing-page.generators.item-trigger')
                @endforeach
            </div>
            <div class="lqd-tabs-content-wrap">
                @foreach ($generatorsList as $item)
                    @include('landing-page.generators.item-content')
                @endforeach
            </div>
        </div>
    </div>
</section>
