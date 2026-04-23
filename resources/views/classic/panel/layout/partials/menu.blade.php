@php
    $items = app(\App\Services\Common\MenuService::class)->generate();

    $isAdmin = \Auth::user()?->isAdmin();

	$user = \Auth::user();
@endphp

@foreach ($items as $key => $item)
    @php
        $theme = $item['type'] === 'item' ? 'classic' : 'default';
    @endphp
    @if (data_get($item, 'is_admin'))
		@if ($isAdmin && $user->checkPermission($key))
            @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
                @if ($item['children_count'])
                    @includeIf($theme . '.components.navbar.partials.types.item-dropdown')
                @else
                    @includeIf($theme . '.components.navbar.partials.types.' . $item['type'])
                @endif
            @endif
        @endif
    @else
        @if (data_get($item, 'show_condition', true) && data_get($item, 'is_active'))
            @if ($item['children_count'])
                @includeIf($theme . '.components.navbar.partials.types.item-dropdown')
            @else
                @includeIf($theme . '.components.navbar.partials.types.' . $item['type'])
            @endif
        @endif
    @endif
@endforeach

{{-- Admin menu items --}}
@if (Auth::user()?->isAdmin())
    @if ($app_is_not_demo)
        <x-navbar.item>
            <x-navbar.link
                label="{{ __('Premium Membership') }}"
                href="#"
                iconHtml='<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m368-630 106-210h12l106 210H368Zm82 474L105-570h345v414Zm60 0v-414h345L510-156Zm148-474L554-840h206l105 210H658Zm-563 0 105-210h206L302-630H95Z"/></svg>'
                trigger-type="modal"
            >
                <x-slot:modal>
                    @includeIf('premium-support.index')
                </x-slot:modal>
            </x-navbar.link>
        </x-navbar.item>
    @endif
@endif

<x-navbar.item>
    <x-navbar.divider />
</x-navbar.item>
