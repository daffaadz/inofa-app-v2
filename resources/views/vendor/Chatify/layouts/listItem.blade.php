{{-- -------------------- Saved Messages -------------------- --}}
@if ($get == 'saved')
    <table class="messenger-list-item w-full" data-contact="{{ Auth::user()->id }}">
        <tr data-action="0" class="block hover:bg-neutral-50 cursor-pointer transition border-b border-neutral-50">
            <td class="block px-6 py-3">
                <div class="flex items-center gap-3">
                    <div
                        class="saved-messages avatar av-m w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                        <span class="far fa-bookmark text-primary-500"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-b-1 font-semibold text-neutral-900 truncate" data-id="{{ Auth::user()->id }}"
                            data-type="user">
                            Saved Messages
                        </p>
                        <span class="text-b-3 text-neutral-500 truncate">Save messages secretly</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Contact list -------------------- --}}
@if ($get == 'users' && !!$lastMessage)
    <?php
    $lastMessageBody = mb_convert_encoding($lastMessage->body, 'UTF-8', 'UTF-8');
    $lastMessageBody = strlen($lastMessageBody) > 30 ? mb_substr($lastMessageBody, 0, 30, 'UTF-8') . '..' : $lastMessageBody;
    ?>
    <table class="messenger-list-item w-full" data-contact="{{ $user->id }}">
        <tr data-action="0" class="block hover:bg-neutral-50 cursor-pointer transition border-b border-neutral-50">
            {{-- Avatar side --}}
            <td style="position: relative" class="block px-6 py-4">
                <div class="flex items-start gap-3">
                    <div class="relative flex-shrink-0">
                        @if ($user->active_status)
                            <span
                                class="activeStatus absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        @endif
                        @php
                            $avatarSrc = $user->getRawOriginal('avatar')
                                ? (filter_var($user->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                    ? $user->getRawOriginal('avatar')
                                    : asset('storage/' . $user->getRawOriginal('avatar')))
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
                        @endphp
                        <img src="{{ $avatarSrc }}" alt="Avatar"
                            class="w-12 h-12 rounded-full object-cover border-2 border-primary-300">
                    </div>

                    {{-- center side --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-b-1 font-semibold text-neutral-900 truncate" data-id="{{ $user->id }}"
                                data-type="user">
                                {{ strlen($user->name) > 20 ? trim(substr($user->name, 0, 20)) . '..' : $user->name }}
                            </p>
                            <span class="contact-item-time text-b-4 text-neutral-500 flex-shrink-0 ml-2"
                                data-time="{{ $lastMessage->created_at }}">
                                {{ $lastMessage->timeAgo }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-b-2 text-neutral-500 truncate flex-1">
                                {{-- Last Message user indicator --}}
                                {!! $lastMessage->from_id == Auth::user()->id
                                    ? '<span class="lastMessageIndicator font-medium">You: </span>'
                                    : '' !!}
                                {{-- Last message body --}}
                                @if ($lastMessage->attachment == null)
                                    {!! $lastMessageBody !!}
                                @else
                                    <span class="fas fa-paperclip text-xs"></span> Attachment
                                @endif
                            </span>
                            {{-- New messages counter --}}
                            {!! $unseenCounter > 0
                                ? '<b class="ml-2 flex-shrink-0 w-5 h-5 bg-primary-500 text-white rounded-full flex items-center justify-center text-b-4 font-semibold ">' .
                                    ($unseenCounter > 9 ? '9+' : $unseenCounter) .
                                    '</b>'
                                : '' !!}
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if ($get == 'search_item')
    <table class="messenger-list-item w-full" data-contact="{{ $user->id }}">
        <tr data-action="0" class="block hover:bg-neutral-50 cursor-pointer transition border-b border-neutral-50">
            <td class="block px-6 py-4">
                <div class="flex items-center gap-3">
                    @php
                        $avatarSrc = $user->getRawOriginal('avatar')
                            ? (filter_var($user->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                ? $user->getRawOriginal('avatar')
                                : asset('storage/' . $user->getRawOriginal('avatar')))
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
                    @endphp
                    <img src="{{ $avatarSrc }}" alt="Avatar"
                        class="w-12 h-12 rounded-full object-cover border-2 border-primary-300">

                    <div class="flex-1 min-w-0">
                        <p class="text-b-1 font-semibold text-neutral-900 truncate" data-id="{{ $user->id }}"
                            data-type="user">
                            {{ strlen($user->name) > 20 ? trim(substr($user->name, 0, 20)) . '..' : $user->name }}
                        </p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if ($get == 'sharedPhoto')
    <div class="shared-photo chat-image rounded-xl overflow-hidden w-20 h-20 bg-cover bg-center cursor-pointer hover:opacity-80 transition"
        style="background-image: url('{{ $image }}')"></div>
@endif
