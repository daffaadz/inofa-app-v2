
    <div class="mb-3 sm:mb-4">
        <h2 class="text-base sm:text-lg font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm sm:text-base md:text-lg">User Complaints</span>
        </h2>
    </div>
    
    <div class="overflow-x-auto rounded-xl border border-gray-200 -mx-4 sm:mx-0">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr class="text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    <th class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">User</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">Email</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 md:py-4">Description</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">Status</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">Submitted</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 md:py-4 text-center whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
            @forelse($items as $complaint)
                <tr class="text-sm hover:bg-primary-50/30 transition-colors">
                    <td class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="flex-shrink-0">
                                @php
                                    $user = $complaint->user;
                                    $userName = $complaint->user_name ?? optional($user)->name ?? 'Unknown';
                                    $avatarSrc = $user && $user->getRawOriginal('avatar')
                                        ? (filter_var($user->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                            ? $user->getRawOriginal('avatar')
                                            : asset('storage/' . $user->getRawOriginal('avatar')))
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($userName);
                                @endphp
                                <img src="{{ $avatarSrc }}" alt="Avatar" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <div class="font-medium text-gray-900 truncate text-xs sm:text-sm">
                                    {{ $userName }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    ID: {{ $complaint->user_id }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 md:py-4 text-gray-600 whitespace-nowrap text-xs sm:text-sm">
                        {{ optional($complaint->user)->email ?? '-' }}
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 md:py-4 max-w-xs">
                        <div class="text-gray-600 line-clamp-2 text-xs sm:text-sm" title="{{ $complaint->description }}">
                            {{ \Illuminate\Support\Str::limit($complaint->description, 100) }}
                        </div>
                        @if($complaint->admin_response)
                            <div class="mt-2 text-xs text-gray-500 italic">
                                <span class="font-semibold">Response:</span> {{ \Illuminate\Support\Str::limit($complaint->admin_response, 80) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        @include('admin.components.status-badge', ['status' => $complaint->status ?? 'in_progress'])
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="text-gray-900 font-medium text-xs sm:text-sm">
                            {{ optional($complaint->created_at)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ optional($complaint->created_at)->format('H:i') }}
                        </div>
                        @if($complaint->responded_at)
                            <div class="text-xs text-green-600 mt-1">
                                ✓ Responded {{ optional($complaint->responded_at)->diffForHumans() }}
                            </div>
                        @endif
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1 sm:gap-2">
                            @if($complaint->status !== 'resolved' && $complaint->status !== 'rejected')
                                <a href="{{ route('admin.complaints.response', $complaint->id) }}" 
                                   class="p-1.5 sm:p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                   title="Response via Chat">
                                    <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </a>
                            @endif
                            @if($complaint->status === 'in_progress')
                                <form action="{{ route('admin.complaints.resolve', $complaint->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-1.5 sm:p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Mark as Resolved">
                                        <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            @if($complaint->status === 'in_progress')
                                <form action="{{ route('admin.complaints.reject', $complaint->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-1.5 sm:p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Reject Complaint">
                                        <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 text-sm font-medium">No user complaints</p>
                            <p class="text-gray-400 text-xs">There are currently no complaints in the system</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
