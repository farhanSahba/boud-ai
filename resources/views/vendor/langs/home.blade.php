@php
    use App\Helpers\Classes\Localization;
    use App\Models\SettingTwo;

    $supportedLocales = Localization::getSupportedLocales();
    $settingsTwo = SettingTwo::query()->first();
    $defaultLanguage = $settingsTwo?->languages_default ?? 'en';
    $enabledLanguages = collect(explode(',', $settingsTwo?->languages ?? ''))
        ->filter()
        ->values()
        ->all();
@endphp

@extends('panel.layout.app')

@section('title', __('Manage Languages'))

@section('content')
    <div class="py-8">
        <div class="mb-5 flex items-center justify-between gap-4 max-md:flex-col max-md:items-start">
            <div>
                <a
                    class="mb-3 inline-flex items-center gap-2 text-2xs font-medium text-heading-foreground/60 transition-colors hover:text-heading-foreground"
                    href="{{ route('dashboard.admin.settings.general') }}"
                >
                    <x-tabler-chevron-left class="size-4" />
                    {{ __('Back to dashboard') }}
                </a>
                <h1 class="mb-0 text-4xl font-semibold tracking-tight">
                    {{ __('Manage Languages') }}
                </h1>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a
                    class="inline-flex items-center justify-center gap-2 rounded-full border border-heading-foreground/10 px-5 py-3 text-2xs font-medium text-heading-foreground transition-all hover:border-heading-foreground/20 hover:bg-foreground/5"
                    href="{{ route('elseyyid.translations.lang.reinstall') }}"
                >
                    <x-tabler-refresh class="size-4" />
                    {{ __('Reinstall Language Files') }}
                </a>
                <a
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-primary px-5 py-3 text-2xs font-medium text-primary-foreground transition-all hover:opacity-90"
                    href="{{ route('elseyyid.translations.lang.publishAll') }}"
                >
                    <x-tabler-files class="size-4" />
                    {{ __('Publish All JSON Files') }}
                </a>
            </div>
        </div>

        <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/[0.04] px-6 py-5 text-2xs text-red-700 dark:text-red-300">
            <div class="font-semibold">
                {{ __('Take a backup before process!') }}
            </div>
            <div class="mt-1 opacity-80">
                {{ __('If you have previously created or edited a language file (JSON), the Generate process will overwrite those files.') }}
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-4 xl:grid-cols-2">
            <form
                action="{{ route('elseyyid.translations.lang.newLang') }}"
                class="rounded-2xl bg-heading-foreground/[3%] p-4"
                method="GET"
                onsubmit="return confirm('{{ __('Are you sure you want to create a new language?') }}')"
            >
                <label class="mb-3 block text-2xs font-medium text-heading-foreground/60">
                    {{ __('Add new language') }}
                </label>
                <div class="flex gap-3 max-sm:flex-col">
                    <input
                        class="w-full rounded-xl border border-input-border bg-background px-4 py-3 text-2xs outline-none transition-colors focus:border-primary"
                        name="newLang"
                        placeholder="{{ __('lang code Ex. es') }}"
                        type="text"
                    >
                    <button
                        class="inline-flex min-w-40 items-center justify-center rounded-xl bg-primary px-5 py-3 text-2xs font-medium text-primary-foreground transition-all hover:opacity-90"
                        type="submit"
                    >
                        {{ __('New Language') }}
                    </button>
                </div>
            </form>

            <div class="rounded-2xl bg-heading-foreground/[3%] p-4">
                <label class="mb-3 block text-2xs font-medium text-heading-foreground/60">
                    {{ __('Default Language') }}
                </label>
                <div class="flex items-center justify-between gap-3 rounded-xl bg-background px-4 py-3 max-sm:flex-col max-sm:items-start">
                    <div class="flex items-center gap-2 text-2xs font-medium">
                        @php
                            $defaultProps = $supportedLocales[$defaultLanguage] ?? null;
                            $defaultFlag = $defaultProps && ! empty($defaultProps['regional'])
                                ? country2flag(substr($defaultProps['regional'], strrpos($defaultProps['regional'], '_') + 1))
                                : strtoupper($defaultLanguage);
                        @endphp
                        <span class="text-lg">{{ $defaultFlag }}</span>
                        <span>
                            {{ $defaultProps['native'] ?? strtoupper($defaultLanguage) }}
                            <span class="ms-1 text-heading-foreground/40">{{ $defaultLanguage }}</span>
                        </span>
                    </div>
                    <span class="rounded-full bg-primary/10 px-3 py-1 text-3xs font-semibold text-primary">
                        {{ __('Default Language') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <form action="{{ route('elseyyid.translations.lang.search') }}" method="GET">
                <div class="flex gap-3 max-sm:flex-col">
                    <input
                        class="w-full rounded-xl border border-input-border bg-background px-4 py-3 text-2xs outline-none transition-colors focus:border-primary"
                        name="search"
                        placeholder="{{ __('Search') }}"
                        type="text"
                    >
                    <button
                        class="inline-flex min-w-40 items-center justify-center rounded-xl bg-green-600 px-5 py-3 text-2xs font-medium text-white transition-all hover:opacity-90"
                        type="submit"
                    >
                        {{ __('Search') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="mb-4">
            <h2 class="mb-0 text-2xl font-semibold">
                {{ __('Available Languages') }}
            </h2>
        </div>

        <div class="space-y-4">
            @foreach ($langs as $lang)
                @php
                    $properties = $supportedLocales[$lang] ?? null;
                    $flag = $properties && ! empty($properties['regional'])
                        ? country2flag(substr($properties['regional'], strrpos($properties['regional'], '_') + 1))
                        : strtoupper($lang);
                    $native = $properties['native'] ?? strtoupper($lang);
                    $isDefault = $defaultLanguage === $lang;
                    $isEnabled = in_array($lang, $enabledLanguages, true);
                @endphp

                <div class="rounded-2xl border border-heading-foreground/10 bg-background px-5 py-4 shadow-sm">
                    <div class="flex items-center justify-between gap-4 max-lg:flex-col max-lg:items-start">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">{{ $flag }}</span>
                            <div>
                                <div class="text-base font-semibold">
                                    {{ $native }}
                                    <span class="ms-2 text-2xs font-normal text-heading-foreground/40">{{ $lang }}</span>
                                </div>
                                <div class="mt-1 text-2xs text-heading-foreground/60">
                                    @if ($isDefault)
                                        {{ __('Default Language') }}
                                    @elseif ($isEnabled)
                                        {{ __('Enabled') }}
                                    @else
                                        {{ __('Installed') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <a
                                class="inline-flex items-center justify-center rounded-full border border-heading-foreground/10 px-4 py-2 text-2xs font-medium transition-colors hover:bg-foreground/5"
                                href="{{ route('elseyyid.translations.lang', $lang) }}"
                            >
                                {{ __('Edit default strings') }}
                            </a>

                            <a
                                class="inline-flex items-center justify-center rounded-full border border-heading-foreground/10 px-4 py-2 text-2xs font-medium transition-colors hover:bg-foreground/5"
                                href="{{ route('elseyyid.translations.lang.generateJson', $lang) }}"
                            >
                                {{ __('Generate JSON File') }}
                            </a>

                            @if (! $isDefault)
                                <form
                                    action="{{ route('elseyyid.translations.lang.setLocale') }}"
                                    method="GET"
                                >
                                    <input
                                        name="setLocale"
                                        type="hidden"
                                        value="{{ $lang }}"
                                    >
                                    <button
                                        class="inline-flex items-center justify-center rounded-full bg-primary px-4 py-2 text-2xs font-medium text-primary-foreground transition-all hover:opacity-90"
                                        type="submit"
                                    >
                                        {{ __('Set as default') }}
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center justify-center rounded-full bg-primary/10 px-4 py-2 text-2xs font-medium text-primary">
                                    {{ __('Default') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
