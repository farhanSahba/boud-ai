@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('License Disabled'))
@section('titlebar_actions', '')

@section('content')
    <div class="py-10">
        <div class="mx-auto w-full space-y-8 lg:w-1/2">
            <x-alert
                class="justify-center text-center"
                variant="success"
            >
                {{ __('License checks are disabled for this local project.') }}
            </x-alert>
        </div>
    </div>

@endsection
