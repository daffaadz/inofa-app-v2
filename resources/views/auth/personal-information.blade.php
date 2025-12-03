<x-guest-layout>
    {{-- PAGE WRAPPER --}}
    <div class="min-h-screen grid md:grid-cols-2">

        {{-- LEFT PANEL : ILLUSTRATION --}}
        <div
            class="hidden md:flex sticky top-0 items-center justify-center bg-gradient-to-br from-primary-200 via-primary-100 to-primary-200 max-h-screen p-6">

            {{-- Logo --}}
            <div class="absolute left-24 top-12 mb-10">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-4">
                    <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa" class="h-8 w-auto">
                    <span class="text-neutral-800 text-h-5 font-sans">Inofa</span>
                </a>
            </div>

            <div class="max-w-xl text-center">
                <h2 class="font-sans text-h-3 text-start text-neutral-800 mb-3 tracking-tight">
                    Let's Get to<br>
                    Know You Better!
                </h2>
                <p class="font-sans text-b-1 text-neutral-800 text-start mt-4">
                    Complete your profile to unlock the full Inofa experience.
                </p>
            </div>

            {{-- FOOTER --}}
            <footer class="absolute left-1/4 bottom-6 py-6 text-center border-t border-neutral-200">
                <p class="font-sans text-b-2 text-neutral-500">
                    © 2025 Inofa. All rights reserved.
                    <a href="#" class="text-primary-500 hover:underline">Terms of Use</a> &
                    <a href="#" class="text-primary-500 hover:underline">Privacy Policy</a>
                </p>
            </footer>
        </div>

        {{-- RIGHT PANEL : FORM --}}
        <div class="flex items-center justify-center p-6 overflow-y-auto">
            <div class="w-full max-w-lg">

                {{-- Heading --}}
                <h1 class="font-sans text-h-5 text-neutral-800 mb-1">
                    Complete Your Profile
                </h1>
                <p class="font-sans text-b-2 text-neutral-600 mb-4">Tell us more about yourself</p>

                {{-- FORM --}}
                <form method="POST" action="{{ route('personal-information.store') }}" enctype="multipart/form-data" class="space-y-3">
                    @csrf

                    {{-- Avatar Upload Section --}}
                    <div class="flex flex-col items-center py-4 border-b border-neutral-200">
                        <div class="mb-3">
                            <div class="relative">
                                {{-- Avatar Preview --}}
                                <div id="avatar-preview"
                                    class="w-24 h-24 rounded-full border-4 border-neutral-200 overflow-hidden bg-neutral-100 flex items-center justify-center">
                                    @php
                                        $avatarSrc = auth()->user()->getRawOriginal('avatar')
                                            ? (filter_var(auth()->user()->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                                ? auth()->user()->getRawOriginal('avatar')
                                                : asset('storage/' . auth()->user()->getRawOriginal('avatar')))
                                            : null;
                                    @endphp
                                    @if ($avatarSrc)
                                        <img src="{{ $avatarSrc }}" alt="Current avatar"
                                            class="w-full h-full object-cover" id="preview-image">
                                    @else
                                        <svg class="w-12 h-12 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" id="placeholder-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <img src="" alt="Avatar preview"
                                            class="w-full h-full object-cover hidden" id="preview-image">
                                    @endif
                                </div>

                                {{-- Upload Button Overlay --}}
                                <label for="avatar"
                                    class="absolute bottom-0 right-0 bg-primary-500 text-white p-2 rounded-full cursor-pointer hover:bg-primary-600 transition-colors shadow-lg">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                            </div>
                        </div>

                        <div class="text-center">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                            <p class="font-sans text-b-3 text-neutral-600">Upload your profile photo (Max 2MB)</p>
                            <button type="button" id="remove-avatar"
                                class="mt-1 font-sans text-b-3 text-red-500 hover:text-red-600 hidden">
                                Remove Photo
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('avatar')" class="mt-1" />
                    </div>

                    {{-- Full Name --}}
                    <div>
                        <label for="name" class="font-sans text-b-3 text-neutral-700">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', auth()->user()->name) }}" required
                            placeholder="Enter your full name"
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- Bio --}}
                    <div>
                        <label for="bio" class="font-sans text-b-3 text-neutral-700">
                            Bio
                        </label>
                        <textarea name="bio" id="bio" rows="3"
                            placeholder="Tell us about yourself, your interests, or what you do..."
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500 resize-none">{{ old('bio') }}</textarea>
                        <p class="mt-1 font-sans text-b-3 text-neutral-600">Max 1000 characters</p>
                        <x-input-error :messages="$errors->get('bio')" class="mt-1" />
                    </div>

                    {{-- Location --}}
                    <div>
                        <label for="location" class="font-sans text-b-3 text-neutral-700">
                            Location
                        </label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                placeholder="e.g., Jakarta, Indonesia"
                                class="block w-full pl-10 pr-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500">
                        </div>
                        <x-input-error :messages="$errors->get('location')" class="mt-1" />
                    </div>

                    {{-- CTA --}}
                    <button type="submit"
                        class="w-full px-4 py-2 rounded-lg bg-primary-500 font-sans text-b-2 text-white font-semibold hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 mt-1">
                        Save & Continue
                    </button>
                    
                    {{-- Helper Text --}}
                    <p class="font-sans text-b-3 text-neutral-600 text-center">
                        This information will be visible on your profile
                    </p>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Avatar Preview Functionality
        const avatarInput = document.getElementById('avatar');
        const previewImage = document.getElementById('preview-image');
        const placeholderIcon = document.getElementById('placeholder-icon');
        const removeButton = document.getElementById('remove-avatar');
        let currentFile = null;

        // Handle file selection
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    avatarInput.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    avatarInput.value = '';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    if (placeholderIcon) {
                        placeholderIcon.classList.add('hidden');
                    }
                    removeButton.classList.remove('hidden');
                    currentFile = file;
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle remove avatar
        removeButton.addEventListener('click', function() {
            avatarInput.value = '';
            previewImage.src = '';
            previewImage.classList.add('hidden');
            if (placeholderIcon) {
                placeholderIcon.classList.remove('hidden');
            }
            removeButton.classList.add('hidden');
            currentFile = null;
        });

        // Character counter for bio
        const bioTextarea = document.getElementById('bio');
        const maxLength = 1000;

        bioTextarea.addEventListener('input', function() {
            const remaining = maxLength - this.value.length;
            const counterText = this.parentElement.querySelector('.text-b-3');

            if (remaining < 0) {
                counterText.textContent = `${Math.abs(remaining)} characters over limit`;
                counterText.classList.remove('text-neutral-600');
                counterText.classList.add('text-red-600');
            } else {
                counterText.textContent = `${remaining} characters remaining`;
                counterText.classList.remove('text-red-600');
                counterText.classList.add('text-neutral-600');
            }
        });
    </script>
</x-guest-layout>

