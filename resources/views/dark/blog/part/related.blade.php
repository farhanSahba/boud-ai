@if ($relatedPosts && $relatedPosts->count() > 0)
    <div class="mt-20 [&_h2]:text-[32px] [&_h2]:font-normal">
        <h3 class="mb-16 mt-32 text-center text-[25px]">
            {{ __('You may also like') }}
        </h3>
        @foreach ($relatedPosts as $post)
            @include('blog.part.card')
        @endforeach
    </div>
@endif
