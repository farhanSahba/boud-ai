<div
    class="lqd-tabs-content {{ !$loop->first ? 'hidden' : '' }}"
    id="{{ \Illuminate\Support\Str::slug($item->menu_title) }}"
>
    <figure class="w-full lg:flex lg:justify-end">
        <img
            class="w-full"
            width="878"
            height="748"
            src="{{ custom_theme_url($item->image, true) }}"
            alt="{{ __($item->image_title) }}"
        >
    </figure>
</div>
