<section
    class="site-section pb-24 pt-24 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="blog"
>
    <div class="absolute inset-x-0 top-0 z-0 w-full overflow-hidden [mask-image:linear-gradient(0deg,transparent,black)]">
        <marquee behavior="alternate">
            <div class="slide-on-scroll flex w-full gap-4">
                @for ($i = 0; $i < 2; $i++)
                    <span class="whitespace-nowrap font-heading text-[15vw] font-extrabold leading-none text-heading-foreground/5">
                        {{ __('Lates news & articles') }}
                    </span>
                @endfor
            </div>
        </marquee>
    </div>
    <div class="container">
        <div class="mb-20 flex flex-wrap items-end justify-between gap-y-8">
            <div class="w-full md:w-[48%]">
                <h6 class="relative mb-7 flex items-center gap-4 text-2xs font-bold uppercase tracking-[0.26em]">
                    <svg
                        width="21"
                        height="21"
                        viewBox="0 0 21 21"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <rect
                            width="21"
                            height="21"
                            rx="4"
                            fill="url(#paint0_linear_90_1196)"
                        />
                        <path
                            d="M11.4857 4L6 11.5H9.65705V16L15.1427 8.50002H11.4857V4Z"
                            fill="#EDF3F5"
                        />
                        <defs>
                            <linearGradient
                                id="paint0_linear_90_1196"
                                x1="0"
                                y1="10.5"
                                x2="21"
                                y2="10.5"
                                gradientUnits="userSpaceOnUse"
                            >
                                <stop stop-color="#1D5580" />
                                <stop
                                    offset="1"
                                    stop-color="#102E3B"
                                />
                            </linearGradient>
                        </defs>
                    </svg>
                    {!! __($fSectSettings->blog_subtitle) !!}
                </h6>
                <h2>
                    {!! __($fSectSettings->blog_title) !!}
                </h2>
            </div>
            <div class="w-full md:w-[30%] md:text-end">
                <p class="text-xl [&_strong]:font-normal [&_strong]:text-heading-foreground">
                    {!! __($fSectSettings->blog_description) ?? __('<strong>We\'ve brought together</strong> the exciting developments for you.') !!}
                </p>
            </div>
        </div>
        <div class="lg:grid-cols-{{ $fSectSettings->blog_posts_per_page }} mb-10 grid grid-cols-1 gap-14 md:grid-cols-2">
            @foreach ($posts as $post)
                @include('blog.part.card')
            @endforeach
        </div>
        <div class="flex justify-center pt-16">
            <a
                class="hove inline-flex items-center gap-1.5 rounded-lg bg-green-800/10 px-3 py-2 text-xs font-semibold leading-none text-green-800 transition-all hover:bg-green-500 hover:text-white"
                href="/blog"
            >
                <x-tabler-plus class="size-4" />
                {{ __($fSectSettings->blog_button_text) }}
            </a>
        </div>
    </div>
</section>
