@extends('blog.app')

@section('content')
    @if ($page->titlebar_status)
        <section
            class="site-section relative flex min-h-[200px] items-center justify-center overflow-hidden pb-52 pt-64 text-center text-white max-md:pb-16 max-md:pt-48"
            id="banner"
        >
            <figure
                class="absolute -top-16 start-0 z-1 origin-top-left transition-all duration-500 ease-out"
                aria-hidden="true"
            >
                <img
                    src="{{ custom_theme_url('/assets/img/landing-page/banner-1.png') }}"
                    alt="{{ __('Robot hand') }}"
                    width="612"
                    height="610"
                >
            </figure>
            <div class="container relative">
                <div class="mx-auto flex w-1/2 flex-col items-center max-lg:w-2/3 max-md:w-full">
                    <div class="banner-title-wrap relative">
                        <h1 class="banner-title font-body font-bold -tracking-wide transition-all ease-out">
                            {{ $page->title }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="banner-divider absolute inset-x-0 -bottom-[2px] z-0">
                <svg
                    class="h-auto w-full fill-background"
                    width="1919"
                    height="200"
                    viewBox="0 0 1919 473"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                >
                    <path
                        d="M240.526 0.00775146C142.249 -0.500153 56.5801 23.9957 -0.475952 43.7153V472.5H1919V63.827C1846.63 243.475 1648.54 451.696 1353.63 290.563C983.198 88.1616 979.376 597.655 677.682 224.259C536.267 49.2311 376.38 0.720612 240.526 0.00775146Z"
                        fill="#EFF4F6"
                    />
                </svg>
            </div>
        </section>
    @endif
    <section class="page-content page-single-content">
        <div class="container py-36">
            <div class="row">
                <div class="mx-auto w-full lg:w-10/12 xl:w-8/12">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection
