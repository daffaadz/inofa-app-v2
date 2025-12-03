<div class="favorite-list-item mr-3">
    @if ($user)
        @php
            $avatarSrc = $user->getRawOriginal('avatar')
                ? (filter_var($user->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                    ? $user->getRawOriginal('avatar')
                    : asset('storage/' . $user->getRawOriginal('avatar')))
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
        @endphp

        <img src="{{ $avatarSrc }}" alt="Avatar" class="avatar av-m w-8 h-8 rounded-full object-cover">
        <p>{{ strlen($user->name) > 5 ? substr($user->name, 0, 6) . '..' : $user->name }}</p>
    @endif
</div>
