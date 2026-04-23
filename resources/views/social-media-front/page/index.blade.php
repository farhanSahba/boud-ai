@extends('blog.app')

@section('content')
    @if ($page->titlebar_status)
        <section
            class="site-section relative flex items-center justify-center pb-20 pt-20 text-center"
            id="banner"
        >
            <div class="container relative">
                <div class="mx-auto flex w-1/2 flex-col items-center max-lg:w-2/3 max-md:w-full">
                    <div class="banner-title-wrap relative">
                        <h1
                            class="banner-title translate-y-7 font-body font-bold -tracking-wide opacity-0 transition-all ease-out group-[.page-loaded]/body:translate-y-0 group-[.page-loaded]/body:opacity-100">
                            {{ $page->title }}
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="page-content page-single-content">
        <div @class(['container pb-36', 'pt-20' => !$page->titlebar_status])>
            <div class="row">
                <div class="mx-auto w-full lg:w-10/12 xl:w-8/12">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection
