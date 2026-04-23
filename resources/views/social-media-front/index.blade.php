@extends('layout.app')

@section('content')
    <svg
        class="pointer-events-none absolute start-1/2 top-0 z-0 hidden -translate-x-1/2 lg:block"
        width="905"
        height="159"
        viewBox="0 0 905 159"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        {{-- blade-formatter-disable --}}
		<g opacity="0.5" filter="url(#filter0_f_0_3946)"> <path d="M493.601 -167.381C370.407 -152.4 297.299 -94.933 330.309 -39.0242C363.318 16.8847 489.946 50.0635 613.139 35.0827C736.333 20.102 809.441 -37.3654 776.431 -93.2742C743.422 -149.183 616.794 -182.362 493.601 -167.381Z" fill="url(#paint0_linear_0_3946)"/> <path d="M407.591 34.7093C566.423 34.7093 695.182 -12.2357 695.182 -70.1453C695.182 -128.055 566.423 -175 407.591 -175C248.759 -175 120 -128.055 120 -70.1453C120 -12.2357 248.759 34.7093 407.591 34.7093Z" fill="url(#paint1_linear_0_3946)"/> </g> <defs> <filter id="filter0_f_0_3946" x="0" y="-295" width="904.357" height="453.68" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/> <feGaussianBlur stdDeviation="60" result="effect1_foregroundBlur_0_3946"/> </filter> <linearGradient id="paint0_linear_0_3946" x1="343.911" y1="-43.2129" x2="758.708" y2="32.5675" gradientUnits="userSpaceOnUse"> <stop stop-color="#001AFF"/> <stop offset="1" stop-color="#6EE5C2"/> </linearGradient> <linearGradient id="paint1_linear_0_3946" x1="159.014" y1="-51.4005" x2="478.041" y2="-270.213" gradientUnits="userSpaceOnUse"> <stop stop-color="#FFC83A"/> <stop offset="0.504191" stop-color="#FF008A"/> <stop offset="1" stop-color="#6100FF"/> </linearGradient> </defs>
		{{-- blade-formatter-enable --}}
    </svg>

    @include('landing-page.banner.section')

    @includeWhen($fSectSettings->testimonials_active == 1, 'landing-page.clients.section')

    @includeWhen($fSectSettings->generators_active == 1, 'landing-page.generators.section')

    @includeWhen($fSectSettings->custom_templates_active == 1, 'landing-page.custom-templates.section')

    @includeWhen($fSectSettings->tools_active == 1, 'landing-page.tools.section')

    @includeWhen($fSectSettings->tools_active == 1, 'landing-page.social-media.section')

    @includeWhen($fSectSettings->features_active == 1, 'landing-page.features.section')

    @includeWhen($fSectSettings->features_active == 1, 'landing-page.collaboration.section')

    @includeWhen($fSectSettings->how_it_works_active == 1, 'landing-page.how-it-works.section')

    @includeWhen($fSectSettings->features_active == 1, 'landing-page.vertical-slider.section')

    @includeWhen($fSectSettings->who_is_for_active == 1, 'landing-page.who-is-for.section')

    @includeWhen($fSectSettings->testimonials_active == 1, 'landing-page.testimonials.section')

    @includeWhen($fSectSettings->testimonials_active == 1, 'landing-page.marquee.section')

    @includeWhen($fSectSettings->pricing_active == 1, 'landing-page.pricing.section')

    @includeWhen($fSectSettings->faq_active == 1, 'landing-page.faq.section')

    @includeWhen($fSectSettings->blog_active == 1, 'landing-page.blog.section')

    @includeWhen($setting->gdpr_status == 1, 'landing-page.gdpr')

    <svg
        class="hidden"
        width="21"
        height="15"
        viewBox="0 0 21 15"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            id="arrow-icon"
            fill="currentColor"
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M19.3889 6.37388C16.68 6.37388 14.2111 3.87274 14.2111 1.12613V0H11.9889V1.12613C11.9889 3.12387 12.8533 4.99774 14.21 6.37388H0.5V8.62613H14.21C12.8533 10.0023 11.9889 11.8761 11.9889 13.8739V15H14.2111V13.8739C14.2111 11.1273 16.68 8.62613 19.3889 8.62613H20.5V6.37388H19.3889Z"
        />
    </svg>
@endsection

@push('script')
    <script>
        const restArguments = function(func, startIndex) {
            startIndex = startIndex == null ? func.length - 1 : +startIndex;
            return function() {
                var length = Math.max(arguments.length - startIndex, 0),
                    rest = Array(length),
                    index = 0;
                for (; index < length; index++) {
                    rest[index] = arguments[index + startIndex];
                }
                switch (startIndex) {
                    case 0:
                        return func.call(this, rest);
                    case 1:
                        return func.call(this, arguments[0], rest);
                    case 2:
                        return func.call(this, arguments[0], arguments[1], rest);
                }
                var args = Array(startIndex + 1);
                for (index = 0; index < startIndex; index++) {
                    args[index] = arguments[index];
                }
                args[startIndex] = rest;
                return func.apply(this, args);
            };
        };
        window.liquidDebounce = function(func, wait, immediate) {
            var timeout, result;

            var later = function(context, args) {
                timeout = null;
                if (args) result = func.apply(context, args);
            };

            var debounced = restArguments(function(args) {
                if (timeout) clearTimeout(timeout);
                if (immediate) {
                    var callNow = !timeout;
                    timeout = setTimeout(later, wait);
                    if (callNow) result = func.apply(this, args);
                } else {
                    timeout = liquidDelay(later, wait, this, args);
                }

                return result;
            });

            debounced.cancel = function() {
                clearTimeout(timeout);
                timeout = null;
            };

            return debounced;
        };
        const liquidDelay = restArguments(function(func, wait, args) {
            return setTimeout(function() {
                return func.apply(null, args);
            }, wait);
        });

        (() => {
            const particlesContainer = document.querySelectorAll('.lqd-particles-container');

            particlesContainer.forEach(el => {
                const io = new IntersectionObserver(([entry]) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('invisible')
                    } else {
                        entry.target.classList.add('invisible')
                    }
                });
                io.observe(el);
            })
        })();
    </script>
    <script src="{{ custom_theme_url('/assets/libs/matter/matter.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/gsap/minified/gsap.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/gsap/minified/SplitText.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/liquid-throwable/liquidThrowable.min.js') }}"></script>
@endpush
