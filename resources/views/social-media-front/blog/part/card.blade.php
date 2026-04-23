<article class="group relative">
    <figure class="mb-5 overflow-hidden rounded-xl">
        <a href="{{ url('/blog', $post->slug) }}">
            <img
                class="h-60 w-full rounded-xl object-cover transition-all group-hover:scale-110"
                src="{{ custom_theme_url($post->feature_image, true) }}"
                alt="{{ $post->title }}"
            >
        </a>
    </figure>

    <h2 class="mb-4 !text-[26px]/[1.2em] group-hover:underline">
        <a href="{{ url('/blog', $post->slug) }}">
            {{ $post->title }}
            <svg
                class="ms-2 inline -translate-x-2 scale-y-50 align-middle opacity-0 transition-all group-hover:translate-x-0 group-hover:scale-y-110 group-hover:opacity-100"
                widh="20"
                height="15"
                viewBox="0 0 20 15"
            >
                <use href="#arrow-icon" />
            </svg>
        </a>
    </h2>

    <div class="line-clamp-3">
        @php
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($post->content, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $paragraphs = $dom->getElementsByTagName('p');
            $firstParagraph = $paragraphs->length > 0 ? $dom->saveHTML($paragraphs->item(0)) : '';
        @endphp

        {!! $firstParagraph !!}
    </div>

    <a
        class="absolute inset-0 z-2"
        href="{{ url('/blog', $post->slug) }}"
    >
    </a>
</article>
