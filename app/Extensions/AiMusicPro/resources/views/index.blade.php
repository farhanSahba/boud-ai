@php
	$ai_music_options = [
		'duration' => [
			'' => __('None'),
			'30' => '30 ' . __('seconds'),
			'60' => '1 ' . __('minute'),
			'120' => '2 ' . __('minutes'),
			'180' => '3 ' . __('minutes'),
		],
		'music_style' => [
			'' => __('None'),
			'techno' => 'Techno',
			'lofi' => 'Lo-Fi',
			'pop' => 'Pop',
			'jazz' => 'Jazz',
			'rock' => 'Rock',
			'classical' => 'Classical',
			'hiphop' => 'Hip-Hop/Trap',
			'edm' => 'EDM/House',
			'reggae' => 'Reggae',
			'ambient' => 'Ambient',
			'cozy' => 'Cozy',
			'relaxed' => 'Relaxed',
		]
	];
@endphp

@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('AI Music Pro'))
@section('titlebar_subtitle', __('Create music tracks with AI'))

@section('content')

	<x-card
		class="lqd-voiceover-generator mb-16 bg-[#F2F1FD] shadow-sm dark:bg-foreground/5"
		class:body="pt-3"
		size="lg"
		x-data="{
		prompts: [
			'{{ addslashes(__('Dreamy lo-fi hip hop beat for studying, with soft piano and vinyl crackle.')) }}',
			'{{ addslashes(__('Epic orchestral soundtrack with choirs and cinematic percussion.')) }}',
			'{{ addslashes(__('Futuristic synthwave track inspired by neon cityscapes.')) }}',
			'{{ addslashes(__('Gentle acoustic guitar melody with birds chirping in the background.')) }}',
			'{{ addslashes(__('Dark techno track with deep bass and hypnotic rhythms.')) }}',
			'{{ addslashes(__('Upbeat funk groove with slap bass, brass, and electric guitar.')) }}',
			'{{ addslashes(__('Meditative ambient soundscape with evolving pads and nature sounds.')) }}',
			'{{ addslashes(__('Fast-paced video game chiptune with retro 8-bit sounds.')) }}',
			'{{ addslashes(__('Traditional Japanese koto and shakuhachi with modern electronic fusion.')) }}',
			'{{ addslashes(__('Joyful children\'s song with ukulele, handclaps, and playful whistles.')) }}',
		],
        generateRandomPrompt() {
            return this.prompts[Math.floor(Math.random() * this.prompts.length)];
        },
        prompt: ''
    }"
	>
		<form
			class="workbook-form flex flex-col"
			id="ai_music_generator_form"
			onsubmit="return generateMusic();"
			x-data="{ advancedSettingsShow: false }"
		>
			<x-forms.input
				class="rounded-none border-e-0 border-s-0 border-t-0 border-foreground/10 bg-transparent px-0 py-7 font-serif text-xl focus:outline-none focus:ring-0"
				id="workbook_title"
				placeholder="{{ __('Untitled Song...') }}"
				required
			/>

			<hr class="border-foreground/10" />

			<h5 class="flex w-full flex-wrap items-center gap-2 py-3">
				{{ __('Describe your song') }}
				<button
					class="cursor-pointer underline text-foreground/70 hover:text-foreground"
					type="button"
					@click="prompt = generateRandomPrompt()"
				>
					{{ __('Generate example prompt') }}
				</button>
			</h5>

			<x-forms.input
				class="bg-background w-full placeholder:text-foreground/50"
				size="lg"
				type="textarea"
				id="ai_music_prompt"
				name="ai_music_prompt"
				cols="30"
				rows="3"
				::value="prompt"
				::placeholder="generateRandomPrompt()"
			></x-forms.input>

			<x-button
				class="mt-4 self-start text-3xs font-semibold text-heading-foreground"
				tag="button"
				type="button"
				variant="link"
				@click="advancedSettingsShow = !advancedSettingsShow"
			>
			<span class="inline-flex size-9 items-center justify-center rounded-full bg-background shadow-sm">
				<x-tabler-plus class="size-4" x-show="!advancedSettingsShow" />
				<x-tabler-minus class="size-4" x-show="advancedSettingsShow" />
			</span>
				{{ __('Advanced Settings') }}
			</x-button>

			<div
				class="hidden w-full flex-wrap justify-between gap-3 mt-3"
				x-show="advancedSettingsShow"
				:class="{ 'hidden': !advancedSettingsShow, 'flex': advancedSettingsShow }"
			>
				<x-forms.input
					id="duration"
					container-class="grow"
					label="{{ __('Music Duration') }}"
					type="select"
					name="duration"
					size="lg"
				>
					@foreach ($ai_music_options['duration'] as $value => $label)
						<option value="{{ $value }}">{{ __($label) }}</option>
					@endforeach
				</x-forms.input>

				<x-forms.input
					id="music_style"
					label="{{ __('Music Style') }}"
					name="music_style"
					container-class="grow"
					size="lg"
					type="select"
				>
					@foreach ($ai_music_options['music_style'] as $value => $label)
						<option value="{{ $value }}">{{ __($label) }}</option>
					@endforeach
				</x-forms.input>
			</div>

			<hr class="border-foreground/10 mt-6" />

			<div class="flex pt-3">
				@if($app_is_demo)
					<x-button
						class="py-2.5 w-full"
						id="generate_ai_music_button"
						tag="button"
						type="button"
						onclick="return toastr.info('This feature is disabled in Demo version.')"
						size="lg"
					>
						<x-tabler-plus class="size-5" />
						{{ __('Generate') }}
					</x-button>
				@else
					<x-button
						class="py-2.5 w-full"
						id="generate_ai_music_button"
						tag="button"
						type="submit"
						size="lg"
					>
						<x-tabler-plus class="size-5" />
						{{ __('Generate') }}
					</x-button>
				@endif
			</div>
		</form>
	</x-card>

	<div id="generator_sidebar_table">
		@include('ai-music-pro::components.generator_sidebar_table', ['music' => $music])
	</div>

@endsection

@push('script')
	<script src="{{ custom_theme_url('/assets/libs/wavesurfer/wavesurfer.js') }}"></script>
	<script src="{{ custom_theme_url('/assets/js/panel/voiceover.js') }}"></script>

	<script>
		function generateMusic(ev) {
			ev?.preventDefault();
			ev?.stopPropagation();

			const generateBtn = document.querySelector('#generate_ai_music_button');
			if (generateBtn) {
				generateBtn.disabled = true;
				generateBtn.innerHTML = "{{__('Please wait...')}}";
			}

			// Show loading indicator if Alpine store exists
			if (typeof Alpine !== 'undefined' && Alpine.store('appLoadingIndicator')) {
				Alpine.store('appLoadingIndicator').show();
			}

			const formData = new FormData();
			formData.append('workbook_title', document.getElementById('workbook_title').value);
			formData.append('ai_music_prompt', document.getElementById('ai_music_prompt').value);
			formData.append('duration', document.getElementById('duration').value);
			formData.append('music_style', document.getElementById('music_style').value);

			$.ajax({
				type: "post",
				headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' },
				url: "/dashboard/user/ai-music-pro/generate",
				data: formData,
				contentType: false,
				processData: false,
				success: function(res) {
					if (res.status !== 'success') {
						if (typeof toastr !== 'undefined') {
							toastr.error(res.message ?? "{{ __('Something went wrong')}}");
						}
					} else {
						if (typeof toastr !== 'undefined') {
							toastr.success(res.message);
						}

						$("#generator_sidebar_table").html(res?.html2);
						const audioElements = document.querySelectorAll('.data-audio');
						if (audioElements.length) {
							audioElements.forEach(generateWaveForm);
						}
					}

					resetGenerateButton(generateBtn);
				},
				error: function(data) {
					resetGenerateButton(generateBtn);

					if (typeof toastr !== 'undefined') {
						if (data.responseJSON?.errors) {
							$.each(data.responseJSON.errors, function(index, value) {
								toastr.error(value);
							});
						} else if (data.responseJSON?.message) {
							toastr.error(data.responseJSON.message);
						} else {
							toastr.error("Something went wrong");
						}
					}
				}
			});

			return false;
		}

		function resetGenerateButton(generateBtn) {
			if (generateBtn) {
				generateBtn.disabled = false;
				generateBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg> {{__('Generate')}}';
			}

			// Hide loading indicator if Alpine store exists
			if (typeof Alpine !== 'undefined' && Alpine.store('appLoadingIndicator')) {
				Alpine.store('appLoadingIndicator').hide();
			}
		}

	</script>
@endpush
