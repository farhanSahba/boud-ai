<div class="lqd-ai-videos-wrap" id="lqd-ai-videos-wrap">
	<svg width="0" height="0">
		<defs>
			<linearGradient
				id="loader-spinner-gradient"
				x1="0.667969"
				y1="6.10667"
				x2="23.0413"
				y2="25.84"
				gradientUnits="userSpaceOnUse"
			>
				<stop stop-color="#82E2F4" />
				<stop offset="0.502" stop-color="#8A8AED" />
				<stop offset="1" stop-color="#6977DE" />
			</linearGradient>
		</defs>
	</svg>

	@if (filled($list))
		<h3 class="my-8">@lang('My Videos')</h3>
	@else
		<h2 class="col-span-full my-8 flex items-center justify-center">
			@lang('No videos found.')
		</h2>
	@endif

	<div id="videos-container">
		@include('ai-video-pro::partials.videos-list', ['list' => $list])
	</div>
</div>
