<div class="bg-white rounded-lg shadow-sm p-6">
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Personal Information Section -->
        <div>
            <div class="flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="text-h-6 text-neutral-1000">Personal Information</h3>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-b-1 font-medium text-neutral-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                    @error('name')
                        <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-b-1 font-medium text-neutral-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                    @error('email')
                        <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-b-3 text-neutral-600">
                                Your email address is unverified.
                                <button form="send-verification"
                                    class="underline text-primary-500 hover:text-primary-700">
                                    Click here to re-send the verification email.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-b-3 text-green-500">
                                    A new verification link has been sent to your email address.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-b-1 font-medium text-neutral-700 mb-2">Phone</label>
                    <input type="tel" id="phone" name="phone"
                        value="{{ old('phone', $user->phone ?? '+62 812 3456 7890') }}"
                        class="w-full px-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    @error('phone')
                        <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-b-1 font-medium text-neutral-700 mb-2">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $user->location) }}"
                        class="w-full px-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        placeholder="Jakarta, Indonesia">
                    @error('location')
                        <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Title (full width) -->
                @if (Auth::user()->role === 'developer')
                    <div class="col-span-2">
                        <label for="job_title" class="block text-b-1 font-medium text-neutral-700 mb-2">Job
                            Title</label>
                        <input type="text" id="job_title" name="job_title"
                            value="{{ old('job_title', Auth::user()->developerProfile->headline ?? '') }}"
                            class="w-full px-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="e.g. Senior Full-Stack Developer">
                        @error('job_title')
                            <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Bio (full width) -->
                <div class="col-span-2">
                    <label for="bio" class="block text-b-1 font-medium text-neutral-700 mb-2">Bio</label>
                    <textarea id="bio" name="bio" rows="4" maxlength="1500"
                        class="w-full px-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition resize-none"
                        placeholder="Full-stack developer with 5+ years of experience building web and mobile applications. Specialized in React, Node.js, and cloud technologies...">{{ old('bio', $user->bio) }}</textarea>
                    <p class="mt-1 text-b-2 text-neutral-400"><span
                            id="bio-count">{{ strlen($user->bio ?? '') }}</span>/1500 characters</p>
                    @error('bio')
                        <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        @if (Auth::user()->role === 'developer')
            <!-- Professional Details Section -->
            <div class="border-t border-neutral-100 pt-6">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-secondary-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-h-6 text-neutral-1000">Professional Details</h3>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Rate Min -->
                    <div>
                        <label for="rate_min" class="block text-b-1 font-medium text-neutral-700 mb-2">Minimum Rate
                            (IDR/project)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-b-1 text-neutral-500">Rp</span>
                            <input type="text" id="rate_min" name="rate_min"
                                value="{{ old('rate_min', Auth::user()->developerProfile->rate_min_byproject ?? 500000) }}"
                                class="w-full pl-12 pr-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                placeholder="500000">
                        </div>
                        @error('rate_min')
                            <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rate Max -->
                    <div>
                        <label for="rate_max" class="block text-b-1 font-medium text-neutral-700 mb-2">Maximum Rate
                            (IDR/project)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-b-1 text-neutral-500">Rp</span>
                            <input type="text" id="rate_max" name="rate_max"
                                value="{{ old('rate_max', Auth::user()->developerProfile->rate_max_byproject ?? 1000000) }}"
                                class="w-full pl-12 pr-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                placeholder="1000000">
                        </div>
                        @error('rate_max')
                            <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Years of Experience -->
                    <div>
                        <label for="experience_years" class="block text-b-1 font-medium text-neutral-700 mb-2">Years of
                            Experience</label>
                        <input type="number" id="experience_years" name="experience_years"
                            value="{{ old('experience_years', Auth::user()->developerProfile->experience_years ?? 5) }}"
                            class="w-full px-4 py-2.5 text-b-1 text-neutral-700 bg-neutral-50 border-2 border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            min="0" max="50" placeholder="5">
                        @error('experience_years')
                            <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- Save Button -->
        <div class="flex items-center justify-center gap-4 pt-6 border-t border-neutral-100">
            <button type="submit"
                class="w-full px-8 py-3 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 active:bg-primary-700 transition shadow-sm flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Save Changes
            </button>
        </div>
    </form>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
</div>

<script>
    // Bio character counter
    document.getElementById('bio')?.addEventListener('input', function() {
        document.getElementById('bio-count').textContent = this.value.length;
    });
</script>
