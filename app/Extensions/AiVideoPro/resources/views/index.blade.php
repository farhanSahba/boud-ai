@extends('panel.layout.app')
@section('title', __('AI Video Pro'))
@section('titlebar_subtitle', __('You can create amazing videos with AI Video Pro'))
@section('titlebar_actions', __(''))

@section('content')
	<div class="py-10">
		@include('ai-video-pro::sections.input-section')
		@include('ai-video-pro::sections.videos-section')
	</div>
@endsection

@push('script')
	@include('ai-video-pro::scripts.check-video-status')
	@include('ai-video-pro::scripts.image-handler')
@endpush
