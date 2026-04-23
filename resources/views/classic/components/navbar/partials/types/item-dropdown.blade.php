@php
    $href =
        \App\Helpers\Classes\Helper::hasRoute($item['route']) && $item['route_slug']
            ? route($item['route'], $item['route_slug'])
            : route(\App\Helpers\Classes\Helper::hasRoute($item['route']) ? $item['route'] : 'default');

    $is_active = $href === url()->current();

    if (!$is_active) {
        foreach ($item['children'] as $child) {
            if (!Route::has($child['route'])) {
                continue;
            }

            $child_href = $child['route_slug'] ? route($child['route'], $child['route_slug']) : route($child['route']);
            $child_is_active = $child_href === url()->current();

            if ($child_is_active) {
                $is_active = true;
                break;
            }
        }
    }

    // code for apply theme default icons:
    $classicThemeSet = [
        'ext_social_media_dropdown' => [
            'key' => 'ext_social_media_dropdown',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M680-80q-50 0-85-35t-35-85q0-6 3-28L282-392q-16 15-37 23.5t-45 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q24 0 45 8.5t37 23.5l281-164q-2-7-2.5-13.5T560-760q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-24 0-45-8.5T598-672L317-508q2 7 2.5 13.5t.5 14.5q0 8-.5 14.5T317-452l281 164q16-15 37-23.5t45-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Z"/></svg>',
        ],
        'user_management' => [
            'key' => 'user_management',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113Z"/></svg>',
        ],
        'templates' => [
            'key' => 'templates',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M360-160h440q33 0 56.5-23.5T880-240v-80H360v160ZM80-640h200v-160H160q-33 0-56.5 23.5T80-720v80Zm0 240h200v-160H80v160Zm80 240h120v-160H80v80q0 33 23.5 56.5T160-160Zm200-240h520v-160H360v160Zm0-240h520v-80q0-33-23.5-56.5T800-800H360v160Z"/></svg>',
        ],
        'chat_settings' => [
            'key' => 'chat_settings',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M480-680q17 0 28.5-11.5T520-720q0-17-11.5-28.5T480-760q-17 0-28.5 11.5T440-720q0 17 11.5 28.5T480-680Zm-40 320h80v-240h-80v240ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Z"/></svg>',
        ],
        'chat_settings_extension' => [
            'key' => 'chat_settings_extension',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M480-680q17 0 28.5-11.5T520-720q0-17-11.5-28.5T480-760q-17 0-28.5 11.5T440-720q0 17 11.5 28.5T480-680Zm-40 320h80v-240h-80v240ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Z"/></svg>',
        ],
        'frontend' => [
            'key' => 'frontend',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M0-160v-80h160v-40q-33 0-56.5-23.5T80-360v-400q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v400q0 33-23.5 56.5T800-280v40h160v80H0Z"/></svg>',
        ],
        'finance' => [
            'key' => 'finance',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M200-280v-280h80v280h-80Zm240 0v-280h80v280h-80ZM80-120v-80h800v80H80Zm600-160v-280h80v280h-80ZM80-640v-80l400-200 400 200v80H80Z"/></svg>',
        ],
        'settings' => [
            'key' => 'settings',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M300-360h60v-160h-60v50h-60v60h60v50Zm100-50h320v-60H400v60Zm200-110h60v-50h60v-60h-60v-50h-60v160Zm-360-50h320v-60H240v60Zm80 450v-80H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v480q0 33-23.5 56.5T800-200H640v80H320Z"/></svg>',
        ],
        'api_integration' => [
            'key' => 'api_integration',
            'icon' => null,
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m480-400-80-80 80-80 80 80-80 80Zm-85-235L295-735l185-185 185 185-100 100-85-85-85 85ZM225-295 40-480l185-185 100 100-85 85 85 85-100 100Zm510 0L635-395l85-85-85-85 100-100 185 185-185 185ZM480-40 295-225l100-100 85 85 85-85 100 100L480-40Z"/></svg>',
        ],
    ];
    $defaultItems = (new \App\Services\Common\MenuService())->data();
    $defaultItem = data_get($defaultItems, $item['key']);
    if (data_get($defaultItem, 'key') == data_get($item, 'key')) {
        $classicData = data_get($classicThemeSet, $defaultItem['key']);
        if ($classicData) {
            // if the icon didnt change in db from default then keep classic theme default icon, else use the icon that user choosed
            if ($item['icon'] == $defaultItem['icon']) {
                $icon = $classicData['icon'];
                $item['svg'] = $classicData['svg'];
            }
        }
    }
@endphp

<x-navbar.item
    id="{{ data_get($item, 'parent_key') ? data_get($item, 'parent_key') . '-' : '' }}{{ data_get($item, 'key') }}"
    has-dropdown
>
    <x-navbar.link
        class="{{ data_get($item, 'class') }}"
        label="{{ __($item['label']) }}"
        href="{{ $item['route'] }}"
        slug="{{ $item['route_slug'] }}"
        icon="{{ $item['icon'] }}"
        icon-html="{!! $item['svg'] ?? '' !!}"
        active-condition="{{ $is_active }}"
        onclick="{{ data_get($item, 'onclick') ?? '' }}"
        badge="{{ data_get($item, 'badge') ?? '' }}"
        dropdown-trigger
    />
    <x-navbar.dropdown.dropdown open="{{ $is_active }}">
        @foreach ($item['children'] as $child)
            @php
                $key = data_get($child, 'key');
            @endphp

            @if (\App\Helpers\Classes\PlanHelper::planMenuCheck($userPlan, $key))
                @if (data_get($child, 'show_condition', true) && data_get($item, 'is_active'))
                    @php
                        $child_href =
                            $child['route_slug'] && \App\Helpers\Classes\Helper::hasRoute($child['route'])
                                ? route($child['route'], $child['route_slug'])
                                : route(\App\Helpers\Classes\Helper::hasRoute($child['route']) ? $child['route'] : 'default');
                        $child_is_active = $child_href === url()->current();
                    @endphp

                    <x-navbar.dropdown.item>
                        <x-navbar.dropdown.link
                            icon="{{ $child['icon'] ?? '' }}"
                            icon-html="{!! $child['svg'] ?? '' !!}"
                            label="{{ __($child['label']) }}"
                            href="{{ $child['route'] }}"
                            badge="{{ data_get($child, 'badge') ?? '' }}"
                            slug="{{ $child['route_slug'] }}"
                            active-condition="{{ $child_is_active }}"
                        ></x-navbar.dropdown.link>
                    </x-navbar.dropdown.item>
                @endif
            @endif
        @endforeach
    </x-navbar.dropdown.dropdown>
</x-navbar.item>
