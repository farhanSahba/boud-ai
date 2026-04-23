<section
    class="site-section relative border-b py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="social-media"
>
    <div class="container">
        <div class="flex flex-col gap-y-16 lg:gap-y-64">
            @foreach (\App\Models\Frontend\ChannelSetting::query()->get() as $social_media)
                @php
                    $slug = $social_media->key;
                @endphp

                @include('landing-page.social-media.item')
            @endforeach
        </div>
    </div>
</section>

@push('script')
    <script>
        (() => {
            document.addEventListener('alpine:init', () => {
                Alpine.data('cardsAnimations', (
                    options = {
                        totalItems: 4,
                        index: 0
                    }, ) => ({
                    options: {
                        ...(JSON.parse(JSON.stringify(options))),
                    },
                    async init() {
                        this.onWindowScroll = this.onWindowScroll.bind(this);

                        await document.fonts.ready;

                        const rect = this.$el.getBoundingClientRect();

                        this.initialPos = rect.top + window.scrollY;
                        this.animationDistance = 500;

                        this.$el.classList.add('sticky');

                        if (this.$refs.cutout && this.$refs.content) {
                            this.$refs.cutout.style.setProperty('--shape-h', this.$refs.content.offsetHeight + 'px');
                            this.$refs.cutout.style.setProperty('--shape-w', this.$refs.contentInner.offsetWidth + 'px');
                        }

                        this.onWindowScroll();
                    },
                    onWindowScroll() {
                        const content = this.$refs.content;

                        if (!content) return;

                        const scrollPos = window.scrollY;
                        const startFadePos = this.initialPos;
                        const endFadePos = startFadePos + this.animationDistance;
                        const baseScale = 0.9 + (0.03 * this.options.index);

                        if (this.options.index !== this.options.totalItems - 1) {
                            if (scrollPos >= startFadePos && scrollPos <= endFadePos) {
                                const opacity = 1 - ((scrollPos - startFadePos) / (endFadePos - startFadePos));
                                const scale = baseScale + ((1 - baseScale) * opacity);

                                this.setCss(this.$el, 'transform', `scale(${scale})`);
                                this.setCss(content, 'opacity', opacity);
                            } else if (scrollPos < startFadePos) {
                                this.setCss(this.$el, 'transform', 'scale(1)');
                                this.setCss(content, 'opacity', 1);
                            } else {
                                this.setCss(this.$el, 'transform', `scale(${baseScale})`);
                                this.setCss(content, 'opacity', 0);
                            }
                        }
                    },
                    setCss(el, prop, value) {
                        el.animate([{
                            [prop]: value
                        }], {
                            duration: 200,
                            fill: 'forwards',
                            easing: 'ease-out'
                        });
                    }
                }));
            });
        })();
    </script>
@endpush
