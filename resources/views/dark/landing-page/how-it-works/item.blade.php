@php
    $bg_color = $item->bg_color;
    $bg_image = $item->bg_image;
    $text_color = $item->text_color;
    $image = $item->image;

    if (!$bg_color) {
        switch ($loop->index) {
            case 0:
                $bg_color = '#0d0d0d';
                break;
            case 1:
                $bg_color = 'hsl(var(--primary))';
                break;
            case 2:
                $bg_color = '#004e49';
                break;
            default:
                $bg_color = '#0d0d0d';
        }
    }

    if (!$bg_image) {
        switch ($loop->index) {
            case 2:
                $bg_image = '/assets/landing-page/step-3-bg.jpg';
                break;
        }
    }

    if (!$text_color) {
        switch ($loop->index) {
            case 1:
                $text_color = 'hsl(var(--primary-foreground))';
                break;
            default:
                $text_color = 'hsl(var(--heading-foreground))';
        }
    }

    if (!$image) {
        switch ($loop->index) {
            case 0:
                $image = '/assets/landing-page/step-1-img.png';
                break;
            case 1:
                $image = '/assets/landing-page/step-2-img.png';
                break;
            case 2:
                $image = '/assets/landing-page/step-3-img.png';
                break;
        }
    }
@endphp

<div
    class="relative flex flex-col overflow-hidden rounded-3xl bg-cover bg-center px-10 py-10 text-white transition-all hover:-translate-y-1 hover:shadow-xl"
    style="background-color: {{ $bg_color }}; @if ($bg_image) background-image: url({{ custom_theme_url($bg_image) }}); @endif @if ($text_color) color: {{ $text_color }}; @endif"
>
    <span class="absolute end-10 top-10 z-2 text-[18px] font-medium uppercase">
        @lang('Step')
        {{ __($item->order) }}
    </span>
    @if ($image)
        <figure class="my-auto">
            <img
                width="754"
                height="606"
                src="{{ custom_theme_url($image) }}"
                alt="{!! __($item->title) !!}"
            />
        </figure>
    @endif
    <div class="mt-auto text-xl/7">
        <p class="mb-0 mt-8">
            {!! __($item->title) !!}
        </p>
    </div>
</div>
