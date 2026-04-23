@if(\App\Helpers\Classes\Helper::appIsNotDemo())
    <x-button
        class="lqd-image-generator-tabs-trigger py-2 text-2xs font-bold text-heading-foreground hover:shadow-none [&.active]:bg-foreground/10"
        data-generator-name="xai/grok-imagine-image"
        tag="button"
        type="button"
        variant="ghost"
        x-data="{}"
        ::class="{ 'active': activeGenerator === 'xai/grok-imagine-image' }"
        x-bind:data-active="activeGenerator === 'xai/grok-imagine-image'"
        @click="changeActiveGenerator('xai/grok-imagine-image')"
    >
        @lang('Grok Imagine')
    </x-button>
@endif
