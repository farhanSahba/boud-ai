{!! adsense_tools_728x90() !!}
<section class="site-section py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 lg:pb-24 lg:pt-16 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100">
    <div class="container">
        <header class="mx-auto mb-20 w-full text-center lg:w-4/5">
            <h6
                class="relative mb-12 inline-flex translate-y-6 items-center gap-1.5 overflow-hidden rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                <x-tabler-rocket
                    class="size-5"
                    stroke-width="1.5"
                />
                {!! $fSectSettings->tools_subtitle ? __($fSectSettings->tools_subtitle) : __($fSetting->hero_subtitle) !!}
            </h6>
            <h2 class="mb-7">
                {!! $fSectSettings->tools_title ? __($fSectSettings->tools_title) : __('Discover Magic Tools') !!}
            </h2>
            <p class="m-0 mx-auto text-xl/7 lg:w-9/12">
                {!! $fSectSettings->tools_description
                    ? __($fSectSettings->tools_description)
                    : __('Glide gives you the powers of a developer and a code — for designer to create remarkable tools that solve your most challenging business problems.') !!}"
            </p>
        </header>

        <div class="mb-14">
            @foreach ($tools as $item)
                @include('landing-page.tools.item')
            @endforeach
        </div>

        <div class="lqd-tabs flex flex-wrap justify-between gap-3 rounded-3xl border border-white/5 p-2 lg:flex-nowrap lg:rounded-full">
            @foreach ($tools as $item)
                <button
                    data-target="#tools-{{ \Illuminate\Support\Str::slug($item->title) }}"
                    @class([
                        'group/trigger flex text-base max-sm:w-full px-3 py-3.5 rounded-full max-mdbasis-1/3 max-md:grow text-center justify-center transition-all md:px-8 [&.lqd-is-active]:bg-heading-foreground/10 [&.lqd-is-active]:text-heading-foreground hover:text-heading-foreground hover:scale-105',
                        'lqd-is-active' => $loop->first,
                    ])
                >
                    {!! __($item->title) !!}
                </button>
            @endforeach
        </div>
    </div>
</section>
