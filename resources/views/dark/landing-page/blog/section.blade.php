<section
    class="site-section py-10 transition-all duration-700 md:translate-y-8 md:opacity-0 lg:py-24 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="blog"
>
    <div class="container">
        <header class="mx-auto mb-20 w-full text-center lg:w-4/5">
            <h6
                class="relative mb-12 inline-flex translate-y-6 items-center gap-1.5 overflow-hidden rounded-full bg-secondary px-5 py-2 text-secondary-foreground shadow-xs shadow-primary">
                <x-tabler-rocket
                    class="size-5"
                    stroke-width="1.5"
                />
                {!! $fSetting->blog_subtitle ? __($fSetting->blog_subtitle) : __($fSetting->hero_subtitle) !!}
            </h6>
            <h2 class="mb-7">
                {!! $fSectSettings->blog_title ? __($fSectSettings->blog_title) : __('AI generator for ultimate technology.') !!}
            </h2>
        </header>

        @foreach ($posts as $post)
            @include('blog.part.card')
        @endforeach

        <div class="mt-20 flex justify-center">
            <a
                class="group/btn flex items-center justify-center gap-2 text-white transition-colors hover:text-primary"
                href="/blog"
            >
                {{ __($fSectSettings->blog_button_text) }}
                <x-tabler-chevron-right class="size-5 transition-transform group-hover/btn:translate-x-1" />
            </a>
        </div>
    </div>
</section>
