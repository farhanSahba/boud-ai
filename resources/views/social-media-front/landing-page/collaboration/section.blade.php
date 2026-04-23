@php
	$items = \App\Models\Frontend\ContentBox::query()->get()->toArray();
@endphp

<section
    class="site-section py-16 transition-all duration-700 md:translate-y-8 md:opacity-0 [&.lqd-is-in-view]:translate-y-0 [&.lqd-is-in-view]:opacity-100"
    id="collaboration"
>
    <div class="container">
        <div class="rounded-[28px] bg-[#232323] px-6 py-24 text-white lg:px-24 lg:py-32 xl:px-36">
            <div class="mx-auto mb-12 w-full text-center lg:w-2/3">
                <h2 class="mb-5 text-current sm:text-[56px] [&_span]:opacity-60">
                    {!! __('Built for <span>collaboration</span>') !!}
                </h2>
                <p class="mb-0 text-xl/[1.3em] opacity-80">
                    {!! __('Collaborate seamlessly with your team, wherever they are. Our platform allows you to create, edit, and manage content together, making teamwork effortless.') !!}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-3.5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    @include('landing-page.collaboration.item')
                @endforeach
            </div>
        </div>
    </div>
</section>
