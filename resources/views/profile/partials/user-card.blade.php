<div class="bg-white rounded-lg shadow-sm p-6">
    <!-- Avatar with edit badge -->
    <div class="relative w-32 h-32 mx-auto mb-4">
        @php
            $avatarSrc = Auth::user()->getRawOriginal('avatar')
                ? (filter_var(Auth::user()->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                    ? Auth::user()->getRawOriginal('avatar')
                    : asset('storage/' . Auth::user()->getRawOriginal('avatar')))
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=200';
        @endphp
        <img src="{{ $avatarSrc }}" alt="{{ Auth::user()->name }}"
            class="w-32 h-32 rounded-full object-cover border-4 border-primary-500">

        <!-- Verified badge -->
        <div
            class="absolute top-0 right-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center border-2 border-white">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <!-- Edit button -->
        <button
            class="absolute bottom-0 right-0 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center border-2 border-white hover:bg-primary-600 transition">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>
    </div>

    <!-- User Info -->
    <div class="text-center mb-6">
        <h2 class="text-h-6 text-neutral-1000 mb-1">{{ Auth::user()->name }}</h2>
        @if (Auth::user()->role === 'developer' && Auth::user()->developerProfile)
            <p class="text-b-2 text-neutral-500 mb-2">{{ Auth::user()->developerProfile->headline ?? 'Developer' }}</p>
        @else
            <p class="text-b-2 text-neutral-500 mb-2">{{ ucfirst(Auth::user()->role) }}</p>
        @endif
        <div class="flex items-center justify-center gap-1 text-b-3 text-neutral-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ Auth::user()->location ?? 'Jakarta, Indonesia' }}
        </div>
    </div>

    @if (Auth::user()->role === 'developer' && Auth::user()->developerProfile)
        <!-- Developer Stats -->
        <div class="space-y-3 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-500">Hourly Rate</span>
                <span class="text-b-1 font-semibold text-primary-500">
                    Rp {{ number_format(Auth::user()->developerProfile->rate_min_byproject ?? 500000, 0, ',', '.') }}/hr
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-500">Experience</span>
                <span
                    class="text-b-1 font-medium text-neutral-700">{{ Auth::user()->developerProfile->experience_years ?? 0 }}
                    years</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-500">Member Since</span>
                <span class="text-b-1 font-medium text-neutral-700">{{ Auth::user()->created_at->format('M Y') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-500">Availability</span>
                <div class="flex items-center gap-2">
                    @php
                        $availability = Auth::user()->developerProfile->availability ?? 'available';
                        $statusColor =
                            $availability === 'available'
                                ? 'bg-green-500'
                                : ($availability === 'busy'
                                    ? 'bg-yellow-500'
                                    : 'bg-neutral-400');
                    @endphp
                    <div
                        class="relative inline-block w-10 h-6 rounded-full {{ $availability === 'available' ? 'bg-primary-500' : 'bg-neutral-300' }} transition">
                        <span
                            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition {{ $availability === 'available' ? 'translate-x-4' : '' }}"></span>
                    </div>
                    <span
                        class="text-b-2 font-medium {{ $availability === 'available' ? 'text-primary-500' : 'text-neutral-500' }}">
                        {{ ucfirst($availability) }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    <!-- Verification Status -->
    <div class="border-t border-neutral-100 pt-4">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span class="text-b-1 font-medium text-neutral-700">Verification</span>
        </div>
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-b-2 text-neutral-700">Email Verified</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-b-2 text-neutral-700">Phone Verified</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-b-2 text-neutral-700">Identity Verified</span>
            </div>
        </div>
    </div>
</div>
