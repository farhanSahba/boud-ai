@extends('panel.layout.app', ['layout_wide' => true, 'wide_layout_px' => 'px-0'])

@push('css')
    <style>
        .lqd-auth-content h1 {
            text-align: center
        }

        .lqd-auth-content .lqd-auth-form-foot-text {
            margin-top: 42px;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <header class="absolute left-0 right-0 top-0 z-2 flex items-center justify-between px-5 pt-6 lg:px-8 lg:pt-8">
        <a
            class="navbar-brand"
            href="{{ route('index') }}"
        >
            @if (isset($setting->logo_dashboard))
                <img
                    class="dark:hidden"
                    src="{{ custom_theme_url($setting->logo_dashboard_path, true) }}"
                    @if (isset($setting->logo_dashboard_2x_path) && !empty($setting->logo_dashboard_2x_path)) srcset="/{{ $setting->logo_dashboard_2x_path }} 2x" @endif
                    alt="{{ $setting->site_name }}"
                >
                <img
                    class="hidden dark:block"
                    src="{{ custom_theme_url($setting->logo_dashboard_dark_path, true) }}"
                    @if (isset($setting->logo_dashboard_dark_2x_path) && !empty($setting->logo_dashboard_dark_2x_path)) srcset="/{{ $setting->logo_dashboard_dark_2x_path }} 2x" @endif
                    alt="{{ $setting->site_name }}"
                >
            @else
                <img
                    class="dark:hidden"
                    src="{{ custom_theme_url($setting->logo_path, true) }}"
                    @if (isset($setting->logo_2x_path) && !empty($setting->logo_2x_path)) srcset="/{{ $setting->logo_2x_path }} 2x" @endif
                    alt="{{ $setting->site_name }}"
                >
                <img
                    class="hidden dark:block"
                    src="{{ custom_theme_url($setting->logo_dark_path, true) }}"
                    @if (isset($setting->logo_dark_2x_path) && !empty($setting->logo_dark_2x_path)) srcset="/{{ $setting->logo_dark_2x_path }} 2x" @endif
                    alt="{{ $setting->site_name }}"
                >
            @endif
        </a>

        <a
            class="inline-flex items-center gap-1 text-foreground no-underline hover:underline"
            href="{{ route('index') }}"
        >
            <x-tabler-chevron-left class="w-4" />
            {{ __('Back to Home') }}
        </a>
    </header>

    <div class="relative flex min-h-screen w-screen flex-col items-center justify-center py-20">
        <div class="mx-auto flex w-[min(calc(100vw-40px),460px)] justify-center px-5">
            <figure class="auth-page-decorations relative -mb-5 block">
                <img
                    class="relative z-1"
                    src="{{ custom_theme_url('assets/img/img-1.png') }}"
                    alt="{{ __('Decorative image') }}"
                    aria-hidden="true"
                    width="289"
                    height="286"
                >
                <img
                    class="absolute start-0 top-8 z-0 blur-[2px] motion-translate-y-loop-25 motion-duration-[4s] motion-delay-500 motion-ease lg:-start-7"
                    src="{{ custom_theme_url('assets/img/img-2.png') }}"
                    alt="{{ __('Decorative image') }}"
                    aria-hidden="true"
                    width="84.5"
                    height="84"
                >
                <img
                    class="absolute end-0 top-0 z-2 blur-sm motion-translate-y-loop-25 motion-duration-[7s] motion-ease lg:-end-10"
                    src="{{ custom_theme_url('assets/img/img-3.png') }}"
                    alt="{{ __('Decorative image') }}"
                    aria-hidden="true"
                    width="89"
                    height="87"
                >
            </figure>
        </div>
        <div class="lqd-auth-content relative z-2 w-[min(calc(100vw-40px),460px)] rounded-[20px] bg-card-background p-8 shadow-xl shadow-black/5 md:px-8 md:py-10">
            @yield('form')
        </div>
    </div>
@endsection
