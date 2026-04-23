<section
    class="site-section whitespace-nowrap py-20 transition-all duration-700 md:translate-y-8 md:opacity-0 lg:pb-24 lg:pt-36 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
>
    <div class="relative mb-8 flex flex-wrap overflow-hidden">
        <div class="flex basis-full animate-marquee items-center justify-between gap-5 pe-5 [animation-duration:25s] lg:gap-[300px] lg:pe-[300px]">
            @foreach ($who_is_for as $item)
                <h5 class="group/heading inline-flex rounded-2xl bg-[#111114] px-8 py-5 font-medium leading-snug lg:text-3xl">
                    <span
                        class="bg-gradient-to-r from-[#DBDADA] to-[#7A7878] bg-clip-text leading-tight text-transparent group-hover/heading:from-gradient-to group-hover/heading:to-gradient-from"
                    >
                        {!! __($item->title) !!}
                    </span>
                </h5>
            @endforeach
        </div>
        <div class="absolute start-0 top-0 flex animate-marquee-2 items-center justify-between gap-5 pe-5 [animation-duration:25s] lg:gap-[300px] lg:pe-[300px]">
            @foreach ($who_is_for as $item)
                <h5 class="group/heading inline-flex rounded-2xl bg-[#111114] px-8 py-5 font-medium leading-tight lg:text-3xl">
                    <span
                        class="bg-gradient-to-r from-[#DBDADA] to-[#7A7878] bg-clip-text leading-tight text-transparent group-hover/heading:from-gradient-to group-hover/heading:to-gradient-from"
                    >
                        {!! __($item->title) !!}
                    </span>
                </h5>
            @endforeach
        </div>
    </div>
    <div class="relative flex flex-wrap overflow-hidden">
        <div class="flex basis-full animate-marquee-reverse items-center justify-between gap-5 pe-5 [animation-duration:30s] lg:gap-[300px] lg:pe-[300px]">
            @foreach ($who_is_for as $item)
                <h5 class="group/heading inline-flex rounded-2xl bg-[#111114] px-8 py-5 font-medium leading-snug lg:text-3xl">
                    <span
                        class="bg-gradient-to-r from-[#DBDADA] to-[#7A7878] bg-clip-text leading-tight text-transparent group-hover/heading:from-gradient-to group-hover/heading:to-gradient-from"
                    >
                        {!! __($item->title) !!}
                    </span>
                </h5>
            @endforeach
        </div>
        <div class="absolute start-0 top-0 flex animate-marquee-reverse-2 items-center justify-between gap-5 pe-5 [animation-duration:30s] lg:gap-[300px] lg:pe-[300px]">
            @foreach ($who_is_for as $item)
                <h5 class="group/heading inline-flex rounded-2xl bg-[#111114] px-8 py-5 font-medium leading-tight lg:text-3xl">
                    <span
                        class="bg-gradient-to-r from-[#DBDADA] to-[#7A7878] bg-clip-text leading-tight text-transparent group-hover/heading:from-gradient-to group-hover/heading:to-gradient-from"
                    >
                        {!! __($item->title) !!}
                    </span>
                </h5>
            @endforeach
        </div>
    </div>
</section>
