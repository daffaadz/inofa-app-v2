<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-neutral-10 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-h-3 text-neutral-900 mb-2">Complete Your Personal Information</h2>
                <p class="text-b-1 text-neutral-600">Tell us more about yourself</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md border border-neutral-200 p-8">
                <form method="POST" action="{{ route('personal-information.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Avatar Upload Section -->
                    <div class="mb-8 flex flex-col items-center">
                        <div class="mb-4">
                            <div class="relative">
                                <!-- Avatar Preview -->
                                <div id="avatar-preview"
                                    class="w-32 h-32 rounded-full border-4 border-neutral-200 overflow-hidden bg-neutral-100 flex items-center justify-center">
                                    @if (auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Current avatar"
                                            class="w-full h-full object-cover" id="preview-image">
                                    @else
                                        <svg class="w-16 h-16 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" id="placeholder-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <img src="" alt="Avatar preview"
                                            class="w-full h-full object-cover hidden" id="preview-image">
                                    @endif
                                </div>

                                <!-- Upload Button Overlay -->
                                <label for="avatar"
                                    class="absolute bottom-0 right-0 bg-primary-500 text-white p-2.5 rounded-full cursor-pointer hover:bg-primary-600 transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <p class="text-b-2 text-neutral-600 mb-1">Upload your profile photo</p>
                            <p class="text-b-3 text-neutral-500">JPG, PNG or GIF. Max size 2MB</p>
                            <button type="button" id="remove-avatar"
                                class="mt-2 text-b-3 text-red-600 hover:text-red-700 hidden">
                                Remove Photo
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                    </div>

                    <!-- Personal Information Fields -->
                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', auth()->user()->name) }}" required
                                placeholder="Enter your full name"
                                class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                Bio
                            </label>
                            <textarea name="bio" id="bio" rows="4"
                                placeholder="Tell us about yourself, your interests, or what you do..."
                                class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none">{{ old('bio') }}</textarea>
                            <p class="mt-1 text-b-3 text-neutral-600">Maximum 1000 characters</p>
                            <x-input-error :messages="$errors->get('bio')" class="mt-1" />
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                Location
                            </label>
                            <div class="relative">
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
                                    class="w-full pl-10 pr-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            </div>
                            <x-input-error :messages="$errors->get('location')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex gap-4">
                        <button type="submit"
                            class="flex-1 px-6 py-3.5 bg-primary-500 text-white text-b-1 font-semibold rounded-lg hover:bg-primary-600 transition-colors shadow-sm hover:shadow-md">
                            Save & Continue
                        </button>
                    </div>
                </form>
            </div>

            <!-- Helper Text -->
            <p class="text-center text-b-2 text-neutral-600 mt-6">
                This information will be visible on your profile
            </p>
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
