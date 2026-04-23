@extends('panel.layout.app')

@section('title', __('Manage Languages'))

@section('content')
    <div class="py-8">
        <div class="mb-5 flex items-center justify-between gap-4 max-md:flex-col max-md:items-start">
            <div>
                <a
                    class="mb-3 inline-flex items-center gap-2 text-2xs font-medium text-heading-foreground/60 transition-colors hover:text-heading-foreground"
                    href="{{ route('elseyyid.translations.home') }}"
                >
                    <x-tabler-chevron-left class="size-4" />
                    {{ __('Back to dashboard') }}
                </a>
                <h1 class="mb-0 text-4xl font-semibold tracking-tight">
                    {{ __('Language') }} {{ strtoupper($lang) }}
                </h1>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a
                    class="inline-flex items-center justify-center rounded-full border border-heading-foreground/10 px-5 py-3 text-2xs font-medium transition-colors hover:bg-foreground/5"
                    href="{{ route('elseyyid.translations.lang.generateJson', $lang) }}"
                >
                    {{ __('Generate JSON File') }}
                </a>
                <button
                    class="inline-flex items-center justify-center rounded-full bg-primary px-5 py-3 text-2xs font-medium text-primary-foreground transition-all hover:opacity-90"
                    form="lang-update-form"
                    type="submit"
                >
                    {{ __('Save') }}
                </button>
            </div>
        </div>

        <form
            action="{{ route('dashboard.elseyyid.translations.lang.update-all') }}"
            id="lang-update-form"
            method="POST"
        >
            @csrf
            <input
                name="lang"
                type="hidden"
                value="{{ $lang }}"
            >
            <input
                id="lang-json-input"
                name="json"
                type="hidden"
            >

            <div class="overflow-hidden rounded-2xl border border-heading-foreground/10 bg-background shadow-sm">
                <div class="grid grid-cols-[minmax(220px,1fr)_minmax(320px,1.3fr)] gap-0 border-b border-heading-foreground/10 bg-heading-foreground/[2%] px-5 py-4 text-2xs font-semibold max-lg:grid-cols-1">
                    <div>{{ __('Default string') }}</div>
                    <div>{{ __('Translation') }} ({{ strtoupper($lang) }})</div>
                </div>

                <div class="max-h-[70vh] overflow-auto">
                    @foreach ($list as $item)
                        <div class="grid grid-cols-[minmax(220px,1fr)_minmax(320px,1.3fr)] gap-0 border-b border-heading-foreground/10 px-5 py-4 last:border-b-0 max-lg:grid-cols-1">
                            <div class="pe-4 text-2xs font-medium leading-6 text-heading-foreground/70 max-lg:mb-3 max-lg:pe-0">
                                {{ $item->en }}
                            </div>
                            <div>
                                <textarea
                                    class="lang-translation-field min-h-24 w-full rounded-xl border border-input-border bg-background px-4 py-3 text-2xs outline-none transition-colors focus:border-primary"
                                    data-code="{{ $item->code }}"
                                >{{ $item->{$lang} }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('lang-update-form')?.addEventListener('submit', function() {
            const payload = {};

            document.querySelectorAll('.lang-translation-field').forEach(function(field) {
                payload[field.dataset.code] = field.value;
            });

            document.getElementById('lang-json-input').value = JSON.stringify(payload);
        });
    </script>
@endpush
