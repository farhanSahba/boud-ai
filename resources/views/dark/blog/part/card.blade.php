<article class="group relative flex w-full flex-wrap items-center justify-between gap-y-5 border-b border-white/10 py-9 text-white opacity-60 transition-opacity hover:opacity-100">
    <figure class="h-56 w-full lg:w-4/12">
        <a
            class="block h-full w-full"
            href="{{ url('/blog', $post->slug) }}"
        >
            <img
                class="h-full w-full rounded-3xl object-cover object-center"
                src="{{ custom_theme_url($post->feature_image, true) }}"
                alt="{{ $post->title }}"
            >
        </a>
    </figure>

    <div class="w-full lg:w-5/12">
        <h2 class="mb-11 text-[32px] font-normal leading-[1.1875em]">
            <a href="{{ url('/blog', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h2>
        <div class="flex items-center gap-4 leading-none">
            @if ($post->category)
                @foreach (Str::of($post->category)->explode(',') as $category)
                    @break($loop->index == 1)
                    <span class="rounded-full bg-heading-foreground/10 px-5 py-2 text-xs font-medium uppercase">
                        <span class="inline-block bg-gradient-to-r from-heading-foreground to-heading-foreground/60 bg-clip-text text-transparent">
                            {{ $category }}
                        </span>
                    </span>
                @endforeach
            @endif
            <time
                class="rounded-full border border-heading-foreground/10 px-5 py-2 text-xs font-medium"
                datetime="{{ $post->updated_at }}"
            >
                {{ date('d M', strtotime($post->updated_at)) }}
            </time>
        </div>
    </div>

    <div class="w-full text-end lg:w-2/12">
        <a
            class="mt-auto flex items-center gap-3 text-sm lg:justify-end"
            href="{{ url('/blog', $post->slug) }}"
        >
            {{ __('Read More') }}
            <x-tabler-chevron-right class="size-5 transition-transform group-hover:translate-x-1" />
        </a>
    </div>
</article>
