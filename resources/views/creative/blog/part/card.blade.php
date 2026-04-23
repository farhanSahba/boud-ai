<article class="relative flex w-full flex-col rounded-xl bg-white shadow-[0_4px_44px_hsl(0_0%_0%/5%)] transition-all hover:-translate-y-1">
    <figure class="mb-6">
        <a href="{{ url('/blog', $post->slug) }}">
            <img
                class="h-40 w-full rounded-t-2xl object-cover"
                src="{{ custom_theme_url($post->feature_image, true) }}"
                alt="{{ $post->title }}"
            >
        </a>
    </figure>
    <div class="flex min-h-[210px] flex-col p-5 font-medium">
        <div class="mb-3 flex items-center gap-3 text-2xs text-heading-foreground">
            <a
                class="uppercase tracking-wide"
                href="{{ url('/blog/author', $post->user_id) }}"
            >
                {{ App\Models\User::where('id', $post->user_id)->first()->name }}
            </a>
            <div class="size-1 relative rounded-full bg-heading-foreground"></div>
            <time
                class="opacity-50"
                datetime="{{ $post->updated_at }}"
            >
                {{ date('d M', strtotime($post->updated_at)) }}
            </time>
        </div>
        <h2 class="mb-4 text-2xl font-semibold leading-9 tracking-tight underline">
            <a href="{{ url('/blog', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h2>
    </div>
    <a
        class="absolute inset-0 z-1"
        href="{{ url('/blog', $post->slug) }}"
    >
        <span class="sr-only">
            {{ __('Read more') }}
        </span>
    </a>
</article>
