{!! adsense_tools_728x90() !!}
<section class="site-section pb-20 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 lg:pb-10 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100">
    <div class="container">
        <div class="mx-auto mb-16 w-full text-center">
            <h2 class="mx-auto mb-5 w-full lg:w-2/3 [&_svg]:inline">
                {!! __($fSectSettings->tools_title) !!}
            </h2>
            <p class="mx-auto mb-1 w-full text-xl/[1.3em] opacity-80 lg:w-1/2">
                {!! __($fSectSettings->tools_description) ?? __('While making content creation effortless for users, it maximizes the quality of the results.') !!}
            </p>
        </div>

        <div
            class="flex flex-wrap justify-between"
            x-data="{
                activeTab: 0,
                setActiveTab(index) {
                    this.activeTab = this.activeTab === index ? null : index
                }
            }"
        >
            <div class="flex w-full flex-col gap-4 lg:w-6/12">
                @foreach ($tools as $item)
                    @include('landing-page.tools.item')
                @endforeach
            </div>

            <div class="hidden w-full place-items-start lg:grid lg:w-5/12">
                @foreach ($tools as $item)
                    <div
                        data-index="{{ $loop->index }}"
                        @class(['sticky top-24 col-start-1 col-end-1 row-start-1 row-end-1'])
                        x-show="(!activeTab && {{ $loop->index }} === 0) || (activeTab == {{ $loop->index }})"
                        @if ($loop->first) x-cloak @endif
                        x-transition
                    >
                        <img
                            src="{{ custom_theme_url($item->image, true) }}"
                            alt="{!! __($item->title) !!}"
                            width="696"
                            height="426"
                        >
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
