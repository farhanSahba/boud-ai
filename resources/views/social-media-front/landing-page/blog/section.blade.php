<section
    class="site-section pb-24 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="blog"
>
    <div class="container">
        <div class="mx-auto mb-20 w-full text-center">
            <h2 class="mx-auto mb-5 w-full lg:w-2/3 lg:text-[56px] [&_svg]:inline">
                {!! __($fSectSettings->blog_title) !!}
            </h2>
            <p class="mx-auto mb-0 w-full text-xl/[1.3em] opacity-60 lg:w-1/2">
                {!! __($fSectSettings->blog_description) ?? __('Our blog provides expert advice, how-to guides, and inspiration to help you maximize your digital presence.') !!}
            </p>
        </div>

        <div class="lg:grid-cols-{{ $fSectSettings->blog_posts_per_page }} grid grid-cols-1 gap-14 md:grid-cols-2 lg:gap-16">
            @foreach ($posts as $post)
                @include('blog.part.card')
            @endforeach
        </div>

        <div class="flex justify-center pt-16">
            <x-button
                class="group mb-6 inline-flex items-center justify-center gap-6 rounded-full py-3.5 pe-5 ps-4 text-xl font-medium text-heading-foreground outline-heading-foreground/5 transition-all hover:scale-105 hover:shadow-lg"
                variant="outline"
                href="/blog"
            >
                <span
                    class="bg-gradient inline-grid size-12 shrink-0 place-items-center rounded-full text-primary-foreground transition-all group-hover:translate-x-1.5 group-hover:border-transparent group-hover:bg-background group-hover:text-black group-hover:text-heading-foreground group-hover:shadow-lg group-hover:[--gradient-from:#fff] group-hover:[--gradient-to:#fff] group-hover:[--gradient-via:#fff]"
                >
                    <svg
                        widh="20"
                        height="15"
                        viewBox="0 0 20 15"
                    >
                        <use href="#arrow-icon" />
                    </svg>
                </span>
                {{ __($fSectSettings->blog_button_text) }}
            </x-button>
        </div>
    </div>
</section>
