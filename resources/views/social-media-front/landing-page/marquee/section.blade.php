@php
    $marquee_items_1 = [__('Precision and Speed'), __('Affiliate Marketing'), __('Boost engagement')];
    $marquee_items_2 = [__('Adaptive Intelligence'), __('150% Subscriber Growth'), __('10x Faster Content Creation')];
@endphp

<section
    class="site-section relative overflow-hidden border-b pb-40 pt-14 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="marquee"
>
    <div class="w-full">
        <div
            class="lqd-marquee -sm:rotate-3 sm:-mx-4"
            x-data="marquee"
            style="background-color: #393B42; color: #fff;"
        >
            <div class="lqd-marquee-viewport relative w-full overflow-hidden">
                <div class="lqd-marquee-slider flex w-full items-center gap-6 px-6 py-4">
                    @for ($i = 0; $i < 10; $i++)
                        @foreach ($marquee_items_1 as $item)
                            <p @class([
                                'lqd-marquee-cell leading-none font-heading text-3xl sm:text-[55px] font-bold whitespace-nowrap',
                                'opacity-55' =>
                                    ($i % 2 === 0 && $loop->odd) || ($i % 2 !== 0 && $loop->even),
                            ])>
                                {{ $item }}
                            </p>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="w-full sm:-mt-20">
        <div
            class="lqd-marquee relative z-2 sm:-mx-4 sm:rotate-[5deg]"
            x-data="marquee({ speed: 1 })"
            style="background-color: #EB6434; color: #fff; transform-origin: 10% 50%;"
        >
            <div class="lqd-marquee-viewport relative w-full overflow-hidden">
                <div class="lqd-marquee-slider flex w-full items-center gap-6 px-6 py-4">
                    @for ($i = 0; $i < 10; $i++)
                        @foreach ($marquee_items_2 as $item)
                            <p @class([
                                'lqd-marquee-cell leading-none font-heading text-3xl sm:text-[55px] font-bold whitespace-nowrap',
                                'opacity-55' =>
                                    ($i % 2 === 0 && $loop->odd) || ($i % 2 !== 0 && $loop->even),
                            ])>
                                {{ $item }}
                            </p>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>
