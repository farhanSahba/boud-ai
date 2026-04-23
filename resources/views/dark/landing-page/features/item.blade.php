<div class="transition-all hover:scale-105">
    <h5 class="mb-4 flex items-center gap-6">
        <span class="w-7 [&_svg]:h-auto [&_svg]:w-full">
            {!! $item->image !!}
        </span>
        {!! __($item->title) !!}
    </h5>
    <p class="m-0 lg:ps-12">
        {!! __($item->description) !!}
    </p>
</div>
