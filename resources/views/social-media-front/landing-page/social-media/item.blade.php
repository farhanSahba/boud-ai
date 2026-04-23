@php
    $colors = [
        'facebook' => '#BADEFF',
        'x' => '#E6E6E6',
        'instagram' => '#EBB8FB',
        'linkedin' => '#B2DEF4',
    ];

    $color = $colors[$slug] ?? '#E6E6E6';
    $cutout_x = '5rem';
@endphp

@push('css')
    <style>
        .social-media-card-{{ $slug }} {
            --color: {{ $color }};
            --index: {{ $loop->index }};
            --cutout-x: {{ $cutout_x }};
            top: calc(6rem + (var(--index) * 30px));
        }

        .social-media-card-{{ $slug }}-bg {
            background-image: linear-gradient(to bottom, var(--color) 0%, hsl(from var(--color) calc(h - 20) s calc(l + 5)) 100%);
        }
    </style>
@endpush

<div
    class="social-media-card-{{ $slug }} flex origin-top rounded-[20px] bg-background md:min-h-[700px]"
    x-data="cardsAnimations({ totalItems: {{ $loop->count }}, index: {{ $loop->index }} })"
    @scroll.window="onWindowScroll"
>
    <div
        class="social-media-card-{{ $slug }}-bg pointer-events-none absolute inset-0 rounded-[20px]"
        id="social-media-card-{{ $slug }}-bg"
    >
        <x-shape-cutout
            x-ref="cutout"
            width="470px"
            height="250px"
            roundness="35px"
            x="{{ $cutout_x }}"
            position="bl"
            :extended-corner="['r' => '50px']"
            el-id="social-media-card-{{ $slug }}-bg"
        />
    </div>

    @includeFirst(["landing-page.social-media.item-content-{$slug}", 'landing-page.social-media.item-content-others'])
</div>
