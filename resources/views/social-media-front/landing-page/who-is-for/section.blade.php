<section class="site-section py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100">
    <div class="container">
        <div class="flex flex-wrap items-start justify-between gap-y-8">
            <div
                class="w-full lg:sticky lg:top-24 lg:w-6/12 lg:pe-14"
                x-data="wordsScroll"
                @scroll.window.throttle.50ms="onScroll"
            >
                <h2
                    class="lg:text-[66px]/[0.9em] [&_.lqd-split-word.active]:opacity-100 [&_.lqd-split-word]:bg-none [&_.lqd-split-word]:text-heading-foreground [&_.lqd-split-word]:opacity-20 [&_.lqd-split-word]:transition-all [&_.text-gradient_.lqd-split-word.active]:text-transparent [&_.text-gradient_.lqd-split-word.active]:[background:inherit]"
                    x-data="splitText('words')"
                >
                    {!! $fSetting->join_the_ranks !!}
                </h2>
            </div>

            <div class="w-full overflow-hidden rounded-xl border border-dashed lg:w-1/2">
                <div
                    class="pointer-events-none relative min-h-[565px]"
                    data-lqd-throwable-scene="true"
                    data-throwable-options='{"scrollGravity": true}'
                >
                    @foreach ($who_is_for as $item)
                        <p
                            class="lqd-throwable-element pointer-events-auto absolute start-0 top-0 inline-flex select-none text-sm leading-none text-black opacity-0 md:text-4xl"
                            data-lqd-throwable-el
                        >
                            <span
                                class="lqd-throwable-element-rot inline-flex rounded-full px-9 py-4"
                                style="background-color: {{ $item->color }}"
                            >
                                {!! __($item->title) !!}
                            </span>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        (() => {
            document.addEventListener('alpine:init', () => {
                Alpine.data('wordsScroll', (options = {}) => ({
                    rect: null,
                    initOffsetTop: 0,
                    options: {
                        duration: window.innerHeight * 0.5,
                        ...options
                    },
                    init() {
                        this.onScroll = this.onScroll.bind(this);

                        this.rect = this.$el.getBoundingClientRect();
                        this.initOffsetTop = this.rect.top + window.scrollY;
                    },
                    onScroll(event) {
                        const windowHeight = window.innerHeight;
                        const scrollY = window.scrollY || window.pageYOffset;
                        const elOffsetTop = this.initOffsetTop;

                        const startPoint = elOffsetTop - windowHeight;
                        let scrollProgress = (scrollY - startPoint) / this.options.duration;

                        scrollProgress = Math.max(0, Math.min(1, scrollProgress));

                        const words = this.$el.querySelectorAll('.lqd-split-word');

                        if (words.length) {
                            const wordStep = 1 / words.length;
                            words.forEach((word, index) => {
                                const wordThreshold = wordStep * index;
                                if (scrollProgress >= wordThreshold) {
                                    word.classList.add('active');
                                } else {
                                    word.classList.remove('active');
                                }
                            });
                        }

                        this.$el.style.setProperty('--scroll-progress', scrollProgress);
                    }
                }));
            });
        })();
    </script>
@endpush
