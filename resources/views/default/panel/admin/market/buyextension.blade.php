@extends('panel.layout.app')
@section('title', 'Local Marketplace')
@section('titlebar_actions', '')

@section('content')
    <div class="py-10">
        <div class="mx-auto w-full text-center lg:w-6/12 lg:px-9">
            <h2 class="mb-4">
                {{ __('External payments are disabled') }}
            </h2>

            <p class="mx-auto mb-8 lg:w-10/12">
                {{ __('This marketplace is local. Install add-ons and themes from the bundled project files only.') }}
            </p>

            <div class="mx-auto mb-4 rounded-lg border text-heading-foreground">
                <div class="grid grid-cols-2 items-center gap-2 border-b p-4">
                    <p class="mb-0 text-start">
                        {{ $extension->is_theme ? __('Theme') : __('Add-on') }}
                    </p>
                    <p class="mb-0 text-end">
                        {{ $extension->name }}
                    </p>
                </div>
                <div class="grid grid-cols-2 items-center gap-2 p-4">
                    <p class="mb-0 text-start">
                        {{ __('Total') }}:
                    </p>
                    <p class="mb-0 text-end text-xl font-bold">
                        @if (currencyShouldDisplayOnRight(currency()->symbol))
                            {{ $extension->price }}{{ currency()->symbol }}
                        @else
                            {{ currency()->symbol }}{{ $extension->price }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var extension = @json($extension);
    </script>
@endpush
