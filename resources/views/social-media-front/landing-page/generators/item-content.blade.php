<div
    class="lqd-tabs-content {{ !$loop->first ? 'hidden' : '' }}"
    id="{{ \Illuminate\Support\Str::slug($item->menu_title) }}"
>
    <div class="flex flex-wrap justify-between max-md:gap-4">
        <div class="flex w-full lg:w-1/2 lg:pe-20">
            <div class="rounded-[20px] bg-surface-background px-14 py-20">
                <h6 class="relative mb-7 flex items-center gap-4">
                    {!! __($item->subtitle_one) !!}
                    <span class="dot"></span>
                    <span class="opacity-50">
                        {!! __($item->subtitle_two) !!}
                    </span>
                </h6>
                <h2 class="mb-5">
                    {!! __($item->title) !!}
                </h2>
                <div
                    class="text-heading-foreground [&_li]:inline-flex [&_li]:rounded-full [&_li]:bg-heading-foreground/5 [&_li]:px-5 [&_li]:py-2.5 [&_li]:text-heading-foreground [&_ul]:flex [&_ul]:flex-wrap [&_ul]:gap-3 [&_ul]:text-sm">
                    {!! __($item->text) !!}
                </div>
            </div>
        </div>

        <div class="w-full text-center lg:w-1/2">
            <figure class="mb-6 w-full">
                <img
                    class="w-full rounded-[20px]"
                    width="878"
                    height="748"
                    src="{{ custom_theme_url($item->image, true) }}"
                    alt="{{ __($item->image_title) }}"
                >
            </figure>
            <p class="text-lg font-semibold text-heading-foreground">{!! __($item->image_title) !!}</p>
            <p class="text-[12px] text-heading-foreground">{!! __($item->image_subtitle) !!}</p>
        </div>
    </div>
</div>
