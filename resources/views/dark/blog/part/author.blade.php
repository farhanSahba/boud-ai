@php
    $user = App\Models\User::find($post->user_id);
    $avatar = !$user->github_token && !$user->google_token && !$user->facebook_token ? '/' . custom_theme_url($user->avatar) : custom_theme_url($user->avatar);
@endphp

<div class="flex items-center space-x-6">
    <div>
        <img
            class="rounded-full"
            width="80"
            height="80"
            src="{{ $avatar }}"
        >
    </div>
    <div class="flex flex-col">
        <a
            class="font-semibold"
            href="{{ url('/blog/author', $post->user_id) }}"
        >{{ App\Models\User::where('id', $post->user_id)->first()->name }}</a>
    </div>
</div>
