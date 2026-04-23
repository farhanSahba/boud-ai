<x-card
	class="lqd-video-generator border-0 bg-[#F2F1FD] dark:bg-surface"
	size="lg"
>
	<form
		class="flex flex-col gap-4"
		id="photo-studio-form"
		method="post"
		action="{{ route('dashboard.user.ai-video-pro.store') }}"
		enctype="multipart/form-data"
		data-ai-video-pro-form
		x-data="{
			selectedAction: '',
			selectedSubModel: '',
			selectedFeature: '',
			formValues: {},
			models: {{ Js::from($models) }},

			init() {
				const firstModel = Object.keys(this.models).find(key => this.models[key].isActive !== false);
				if (firstModel) {
					this.selectedAction = firstModel;
					this.autoSelectSubModel();
					this.autoSelectFeature();
				}
			},

			get currentModel() {
				return this.selectedAction && this.models[this.selectedAction] ? this.models[this.selectedAction] : null;
			},

			get subModels() {
				return this.currentModel?.subModels || {};
			},

			get currentSubModel() {
				return this.selectedSubModel && this.subModels[this.selectedSubModel] ? this.subModels[this.selectedSubModel] : null;
			},

			get features() {
				if (!this.currentSubModel?.features) return [];
				return Object.entries(this.currentSubModel.features).map(([key, value]) => ({
					value: key,
					label: value.label
				}));
			},

			get currentFeature() {
				if (!this.currentSubModel?.features || !this.selectedFeature) return null;
				return this.currentSubModel.features[this.selectedFeature];
			},

			get currentInputs() {
				if (!this.currentFeature?.inputs) return [];
				// Return only non-advanced inputs for main form
				return (this.currentFeature.inputs || []).filter(input => !input.advanced);
			},

			get advancedInputs() {
				if (!this.currentFeature?.inputs) return [];
				// Return only advanced inputs
				return (this.currentFeature.inputs || []).filter(input => input.advanced);
			},

			hasAdvancedInputs() {
				return this.advancedInputs.length > 0;
			},

			get shouldShowSubModels() {
				const subModelKeys = Object.keys(this.subModels);
				if (subModelKeys.length === 0) return false;
				if (subModelKeys.length === 1 && subModelKeys[0].toLowerCase() === this.selectedAction.toLowerCase()) {
					return false;
				}
				return subModelKeys.length > 1;
			},

			get shouldShowFeatures() {
				return this.features.length > 1;
			},

			autoSelectSubModel() {
				const subModelKeys = Object.keys(this.subModels);
				if (subModelKeys.length > 0) {
					this.selectedSubModel = subModelKeys[0];
				}
			},

			autoSelectFeature() {
				if (this.features.length > 0) {
					this.selectedFeature = this.features[0].value;
					this.initializeFormValues();
				}
			},

			initializeFormValues() {
				this.formValues = {};
				// Initialize both regular and advanced inputs
				const allInputs = this.currentFeature?.inputs || [];
				allInputs.forEach(input => {
					if (input.default !== undefined) {
						this.formValues[input.name] = input.default;
					}
				});
			},

			shouldShowInput(input) {
				if (!input.show_if) return true;
				return this.formValues[input.show_if] === true;
			}
		}"
	>
		@csrf

		<h3>{{ __('Choose an AI Model') }}</h3>

		{{-- Main Model Selection --}}
		<x-forms.input
			class="truncate"
			id="action"
			name="action"
			type="select"
			label="{{ __('Select AI Model') }}"
			size="lg"
			x-model="selectedAction"
			@change="selectedSubModel = ''; selectedFeature = ''; autoSelectSubModel(); autoSelectFeature()"
		>
			@foreach ($models ?? [] as $key => $model)
				@if($model['isActive'] ?? false)
					<option value="{{ $key }}">
						{{ $model['label'] }}
					</option>
				@endif
			@endforeach
		</x-forms.input>

		{{-- Sub Model Selection --}}
		<div x-show="selectedAction && shouldShowSubModels" x-cloak>
			<x-forms.input
				class="truncate"
				id="sub_model"
				name="sub_model"
				type="select"
				label="{{ __('Select Model Version') }}"
				size="lg"
				x-model="selectedSubModel"
				@change="selectedFeature = ''; autoSelectFeature()"
			>
				<template x-for="(subModel, key) in subModels" :key="key">
					<option
						:value="key"
						x-show="subModel.isActive !== false"
						x-text="key"
					></option>
				</template>
			</x-forms.input>
		</div>

		{{-- Feature Selection --}}
		<div x-show="selectedSubModel && shouldShowFeatures" x-cloak>
			<x-forms.input
				class="truncate"
				id="feature"
				name="feature"
				type="select"
				label="{{ __('Select Feature') }}"
				size="lg"
				x-model="selectedFeature"
				@change="initializeFormValues()"
			>
				<template x-for="feature in features" :key="feature.value">
					<option
						:value="feature.value"
						x-text="feature.label"
					></option>
				</template>
			</x-forms.input>
		</div>

		{{-- Hidden field for sub_model_value --}}
		<input type="hidden" name="sub_model_value" :value="selectedSubModel">

		{{-- Dynamic Inputs Based on Selected Feature --}}
		<div x-show="currentInputs.length > 0" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-4">
			<template x-for="(input, index) in currentInputs" :key="index">
				<div x-show="shouldShowInput(input)"
					 :style="(input.type === 'textarea' || input.type === 'file') ? 'grid-column: span 2 / span 2;' : ''">

					{{-- Textarea Input --}}
					<template x-if="input.type === 'textarea'">
						<div>
							<label :for="input.name" class="lqd-input-label flex cursor-pointer items-center gap-2 text-2xs font-medium leading-none text-label mb-3">
								<span class="lqd-input-label-txt" x-text="input.label"></span>
							</label>
							<x-forms.input
								::id="input.name"
								::name="input.name"
								type="textarea"
								size="lg"
								::rows="input.rows || 4"
								::placeholder="input.placeholder"
								::required="input.required"
								x-model="formValues[input.name]"
								label=""
							/>
						</div>
					</template>

					{{-- Text Input --}}
					<template x-if="input.type === 'text'">
						<div>
							<label :for="input.name" class="lqd-input-label flex cursor-pointer items-center gap-2 text-2xs font-medium leading-none text-label mb-3">
								<span class="lqd-input-label-txt" x-text="input.label"></span>
							</label>
							<x-forms.input
								::id="input.name"
								::name="input.name"
								type="text"
								size="lg"
								::placeholder="input.placeholder"
								::required="input.required"
								x-model="formValues[input.name]"
								label=""
							/>
						</div>
					</template>

					{{-- Number Input --}}
					<template x-if="input.type === 'number'">
						<div>
							<label :for="input.name" class="lqd-input-label flex cursor-pointer items-center gap-2 text-2xs font-medium leading-none text-label mb-3">
								<span class="lqd-input-label-txt" x-text="input.label"></span>
								<template x-if="input.tooltip">
									<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
										<span class="lqd-tooltip-icon opacity-40">
											<x-tabler-info-circle-filled class="size-4" />
										</span>
										<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
									</span>
								</template>
							</label>
							<x-forms.input
								::id="input.name"
								::name="input.name"
								type="number"
								size="lg"
								::min="input.min"
								::max="input.max"
								::step="input.step"
								::placeholder="input.placeholder"
								::required="input.required"
								x-model="formValues[input.name]"
								label=""
							/>
						</div>
					</template>

					{{-- Select Input --}}
					<template x-if="input.type === 'select'">
						<div>
							<label :for="input.name" class="lqd-input-label flex cursor-pointer items-center gap-2 text-2xs font-medium leading-none text-label mb-3">
								<span class="lqd-input-label-txt" x-text="input.label"></span>
								<template x-if="input.tooltip">
									<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
										<span class="lqd-tooltip-icon opacity-40">
											<x-tabler-info-circle-filled class="size-4" />
										</span>
										<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
									</span>
								</template>
							</label>
							<x-forms.input
								::id="input.name"
								::name="input.name"
								type="select"
								size="lg"
								::required="input.required"
								x-model="formValues[input.name]"
								label=""
							>
								<template x-for="option in input.options" :key="option.value">
									<option
										:value="option.value"
										x-text="option.label"
										:selected="option.value === input.default"
									></option>
								</template>
							</x-forms.input>
						</div>
					</template>

					{{-- Checkbox Input --}}
					<template x-if="input.type === 'checkbox'">
						<div class="flex w-full items-center justify-between rounded-md border p-3">
							<div class="flex gap-3">
								<span class="text-xs font-medium text-heading-foreground" x-text="input.label"></span>
								<template x-if="input.tooltip">
									<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
										<span class="lqd-tooltip-icon opacity-40">
											<x-tabler-info-circle-filled class="size-4" />
										</span>
										<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
									</span>
								</template>
							</div>
							<x-forms.input
								class="bg-foreground/30 checked:bg-primary"
								type="checkbox"
								::name="input.name"
								value="1"
								switcher
								::checked="input.default"
								x-model="formValues[input.name]"
							/>
						</div>
					</template>

					{{-- File Input --}}
					<template x-if="input.type === 'file'">
						<div
							class="flex w-full flex-col gap-2"
							::data-exclude-media-manager="input.excludeMediaManager ? 'true' : undefined"
						>
							<label class="text-xs font-medium text-label">
								<span x-text="input.label"></span>
								<template x-if="input.tooltip">
									<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
										<span class="lqd-tooltip-icon opacity-40">
											<x-tabler-info-circle-filled class="size-4" />
										</span>
										<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
									</span>
								</template>
							</label>
							<label
									class="lqd-filepicker-label flex min-h-34 w-full cursor-pointer flex-col items-center justify-center rounded-card border-2 border-dashed border-foreground/10 bg-background text-center transition-colors hover:bg-background/80"
									:for="input.name.replace(/[\[\]]/g, '_')"
									@drop="dropHandler($event, input.name.replace(/[\[\]]/g, '_'))"
									@dragover.prevent
							>
								<div class="flex flex-col items-center justify-center py-6">
									<x-tabler-cloud-upload class="mb-4 size-11" stroke-width="1.5" />
									<p class="mb-1 text-sm font-semibold">
										{{ __('Drop your file here or browse.') }}
									</p>
									<p class="file-name mb-0 text-2xs">
										<template x-if="input.multiple">
											<span>{{ __('(Upload 1-3 images)') }}</span>
										</template>
										<template x-if="!input.multiple && input.accept && input.accept.includes('image')">
											<span>{{ __('(Only jpg, png accepted)') }}</span>
										</template>
										<template x-if="!input.multiple && input.accept && input.accept.includes('video')">
											<span>{{ __('(Video files accepted)') }}</span>
										</template>
									</p>
								</div>
								<input
										class="hidden"
										:id="input.name.replace(/[\[\]]/g, '_')"
										:name="input.name + (input.multiple ? '[]' : '')"
										type="file"
										:accept="input.accept"
										:multiple="input.multiple"
										:data-required="input.required"
										::data-exclude-media-manager="input.excludeMediaManager ? 'true' : undefined"
										@change="handleFileSelect(input.name.replace(/[\[\]]/g, '_'))"
								/>
							</label>
							<!-- Show selected files count for multiple uploads -->
							<div x-show="input.multiple" class="text-xs text-foreground/60 mt-1" x-data="{ fileCount: 0 }">
								<span x-text="fileCount > 0 ? fileCount + ' file(s) selected' : ''"></span>
							</div>
						</div>
					</template>

					{{-- Range Input --}}
					<template x-if="input.type === 'range'">
						<div>
							<label class="block text-sm font-medium mb-2">
								<span x-text="input.label"></span>
								<span x-text="': ' + (formValues[input.name] || input.default)" class="text-foreground/60"></span>
							</label>
							<input
								type="range"
								:id="input.name"
								:name="input.name"
								:min="input.min"
								:max="input.max"
								:step="input.step"
								:required="input.required"
								x-model="formValues[input.name]"
								class="w-full h-2 bg-foreground/10 rounded-lg appearance-none cursor-pointer"
							/>
							<div class="flex justify-between text-xs text-foreground/60 mt-1">
								<span x-text="input.min"></span>
								<span x-text="input.max"></span>
							</div>
						</div>
					</template>
				</div>
			</template>
		</div>

		{{-- Advanced Options Section --}}
		<div
			x-show="hasAdvancedInputs()"
			x-cloak
			x-data="{ showAdvanced: false }"
			class="mt-4"
		>
			<x-button
				class="flex w-full items-center justify-between gap-7 py-3 text-2xs"
				type="button"
				variant="link"
				@click="showAdvanced = !showAdvanced"
			>
				<span class="h-px grow bg-current opacity-10"></span>
				<span class="flex items-center gap-3">
					{{ __('Advanced Options') }}
					<x-tabler-chevron-down class="size-4 transition"/>
				</span>
				<span class="h-px grow bg-current opacity-10"></span>
			</x-button>

			<div class="pt-5 grid grid-cols-1 md:grid-cols-2 gap-4" x-show="showAdvanced" x-cloak>
				<template x-for="(input, index) in advancedInputs" :key="'adv-' + index">
					<div x-show="shouldShowInput(input)" :class="(input.type === 'textarea' || input.type === 'file') ? 'md:col-span-2' : ''">
						{{-- Textarea Input --}}
						<template x-if="input.type === 'textarea'">
							<div>
								<label :for="input.name" class="lqd-input-label flex cursor-pointer items-center gap-2 text-2xs font-medium leading-none text-label mb-3">
									<span class="lqd-input-label-txt" x-text="input.label"></span>
									<template x-if="input.tooltip">
										<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
											<span class="lqd-tooltip-icon opacity-40">
												<x-tabler-info-circle-filled class="size-4" />
											</span>
											<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
										</span>
									</template>
								</label>
								<x-forms.input
									::id="input.name"
									::name="input.name"
									type="textarea"
									size="lg"
									::rows="input.rows || 3"
									::placeholder="input.placeholder"
									::required="input.required"
									x-model="formValues[input.name]"
									label=""
								/>
							</div>
						</template>

						{{-- Number Input --}}
						<template x-if="input.type === 'number'">
							<div>
								<label :for="input.name" class="lqd-input-label flex cursor-pointer items-center gap-2 text-2xs font-medium leading-none text-label mb-3">
									<span class="lqd-input-label-txt" x-text="input.label"></span>
									<template x-if="input.tooltip">
										<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
											<span class="lqd-tooltip-icon opacity-40">
												<x-tabler-info-circle-filled class="size-4" />
											</span>
											<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
										</span>
									</template>
								</label>
								<x-forms.input
									::id="input.name"
									::name="input.name"
									type="number"
									size="lg"
									::min="input.min"
									::max="input.max"
									::step="input.step"
									::placeholder="input.placeholder"
									::required="input.required"
									x-model="formValues[input.name]"
									label=""
								/>
							</div>
						</template>

						{{-- Checkbox Input --}}
						<template x-if="input.type === 'checkbox'">
							<div class="flex w-full items-center justify-between rounded-md border p-3">
								<div class="flex gap-3">
									<span class="text-xs font-medium text-heading-foreground" x-text="input.label"></span>
									<template x-if="input.tooltip">
										<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
											<span class="lqd-tooltip-icon opacity-40">
												<x-tabler-info-circle-filled class="size-4" />
											</span>
											<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
										</span>
									</template>
								</div>
								<x-forms.input
									class="bg-foreground/30 checked:bg-primary"
									type="checkbox"
									::name="input.name"
									value="1"
									switcher
									::checked="input.default"
									x-model="formValues[input.name]"
								/>
							</div>
						</template>

						{{-- Select Input --}}
						<template x-if="input.type === 'select'">
							<div>
								<label :for="input.name" class="lqd-input-label flex cursor-pointer items-center gap-2 text-2xs font-medium leading-none text-label mb-3">
									<span class="lqd-input-label-txt" x-text="input.label"></span>
									<template x-if="input.tooltip">
										<span class="lqd-tooltip-container group relative inline-flex cursor-default before:absolute before:-start-1.5 before:-top-1.5 before:h-7 before:w-7 [&:hover>.lqd-tooltip-content]:visible [&:hover>.lqd-tooltip-content]:translate-y-0 [&:hover>.lqd-tooltip-content]:opacity-100">
											<span class="lqd-tooltip-icon opacity-40">
												<x-tabler-info-circle-filled class="size-4" />
											</span>
											<span class="lqd-tooltip-content min-w-64 invisible absolute start-1/2 z-50 mb-3 -translate-x-1/2 bottom-full translate-y-1 rounded-xl bg-background/80 px-4 py-3 text-center text-xs leading-normal text-foreground opacity-0 shadow-lg shadow-black/5 backdrop-blur-sm backdrop-saturate-150 transition-all before:absolute before:inset-x-0 before:h-3 before:-top-3" x-text="input.tooltip"></span>
										</span>
									</template>
								</label>
								<x-forms.input
									::id="input.name"
									::name="input.name"
									type="select"
									size="lg"
									::required="input.required"
									x-model="formValues[input.name]"
									label=""
								>
									<template x-for="option in input.options" :key="option.value">
										<option
											:value="option.value"
											x-text="option.label"
											:selected="option.value === input.default"
										></option>
									</template>
								</x-forms.input>
							</div>
						</template>
					</div>
				</template>
			</div>
		</div>

		{{-- Submit Button --}}
		@if (\App\Helpers\Classes\Helper::appIsDemo())
			<x-button
				class="openai_generator_button mt-4 w-full"
				onclick="toastr.info('This feature is disabled in the demo version.')"
				size="lg"
				type="button"
				x-show="selectedAction && selectedFeature"
			>
				{{ __('Generate') }}
				<x-tabler-arrow-right class="size-5" />
			</x-button>
		@else
			<x-button
				class="openai_generator_button mt-4 w-full"
				size="lg"
				type="submit"
				x-show="selectedAction && selectedFeature"
			>
				{{ __('Generate') }}
				<x-tabler-arrow-right class="size-5" />
			</x-button>
		@endif
	</form>
</x-card>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const form = document.getElementById('photo-studio-form');

		if (form) {
			// Form validation handler
			form.addEventListener('submit', function(e) {
				// Inject checkbox values from Alpine formValues before submit
				const alpineRoot = form.closest('[x-data]');
				if (alpineRoot && typeof Alpine !== 'undefined') {
					const data = Alpine.$data(alpineRoot);
					if (data?.formValues && data?.currentFeature?.inputs) {
						const checkboxNames = data.currentFeature.inputs
							.filter(i => i.type === 'checkbox')
							.map(i => i.name);
						checkboxNames.forEach(name => {
							form.querySelectorAll(`input[name="${name}"]`).forEach(el => el.remove());
							const input = document.createElement('input');
							input.type = 'hidden';
							input.name = name;
							input.value = data.formValues[name] ? '1' : '0';
							form.appendChild(input);
						});
					}
				}

				// Find all file inputs with data-required attribute
				const fileInputs = form.querySelectorAll('input[type="file"][data-required="true"]');

				let hasError = false;

				fileInputs.forEach(input => {
					// Check if the input's container is visible (part of current feature)
					const container = input.closest('[x-show]');
					const isVisible = !container || container.style.display !== 'none';

					if (isVisible) {
						// Check if file is selected
						if (!input.files || input.files.length === 0) {
							if (!hasError) { // Only prevent once and show first error
								e.preventDefault();
								e.stopPropagation();
								hasError = true;

								// Get label text
								const labelElement = input.closest('.flex')?.querySelector('label.text-xs');
								const labelText = labelElement?.textContent?.trim() || 'a file';

								// Show user-friendly alert
								toastr.error(`Please select ${labelText} before generating.`);

								// Scroll to the file input
								const scrollTarget = input.closest('.flex') || input.closest('div');
								scrollTarget?.scrollIntoView({
									behavior: 'smooth',
									block: 'center'
								});

								// Highlight the drop zone
								const dropZone = input.closest('label.lqd-filepicker-label');
								if (dropZone) {
									dropZone.style.borderColor = '#ef4444';
									dropZone.style.backgroundColor = '#fef2f2';

									setTimeout(() => {
										dropZone.style.borderColor = '';
										dropZone.style.backgroundColor = '';
									}, 3000);
								}
							}
						}
					}
				});

				if (hasError) {
					return false;
				}
			});

			// Check for pre-loaded image from photoshoots
			const videoImageData = sessionStorage.getItem('videoImageData');
			if (videoImageData) {
				try {
					const data = JSON.parse(videoImageData);

					// Wait a bit for Alpine.js to initialize
					setTimeout(async () => {
						// Find the file input for the image/video
						const fileInput = form.querySelector('input[type="file"][accept*="image"]');

						if (fileInput) {
							// Fetch the image and convert to File object
							const response = await fetch(data.url);
							const blob = await response.blob();
							const file = new File([blob], data.fileName, { type: blob.type });

							// Create a DataTransfer to set the file
							const dataTransfer = new DataTransfer();
							dataTransfer.items.add(file);
							fileInput.files = dataTransfer.files;

							// Trigger change event to update UI
							const event = new Event('change', { bubbles: true });
							fileInput.dispatchEvent(event);

							// Update the label to show file is selected
							const label = fileInput.closest('label.lqd-filepicker-label');
							if (label) {
								const fileNameElement = label.querySelector('.file-name');
								if (fileNameElement) {
									fileNameElement.innerHTML = `<span class="text-primary font-medium">${data.fileName}</span>`;
								}
							}

							toastr.success('Image loaded from photoshoot!');
						}

						// Clear the session storage
						sessionStorage.removeItem('videoImageData');
					}, 500);

				} catch (error) {
					console.error('Failed to load pre-selected image:', error);
					toastr.error('Failed to load selected image');
					sessionStorage.removeItem('videoImageData');
				}
			}
		}
	});
</script>
