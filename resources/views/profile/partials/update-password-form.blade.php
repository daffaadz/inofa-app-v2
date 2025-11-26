<div class="space-y-6">
    <!-- Change Password -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="text-h-6 text-neutral-1000">Change Password</h3>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label for="current_password" class="block text-b-1 font-medium text-neutral-700 mb-2">Current
                    Password</label>
                <div class="relative">
                    <input type="password" id="current_password" name="current_password"
                        class="w-full px-4 py-2.5 pr-12 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                    <button type="button" onclick="togglePassword('current_password')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-b-1 font-medium text-neutral-700 mb-2">New Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2.5 pr-12 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password', 'updatePassword')
                    <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-b-1 font-medium text-neutral-700 mb-2">Confirm New
                    Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-2.5 pr-12 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                    <button type="button" onclick="togglePassword('password_confirmation')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation', 'updatePassword')
                    <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                @if (session('status') === 'password-updated')
                    <p class="text-b-2 text-primary-500 font-medium">Password updated successfully!</p>
                @endif
                <button type="submit"
                    class="px-8 py-3 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Change Password
                </button>
            </div>
        </form>
    </div>

    <!-- Two-Factor Authentication -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-h-6 text-neutral-1000">Two-Factor Authentication</h3>
        </div>

        <p class="text-b-2 text-neutral-600 mb-6">
            Add an extra layer of security to your account by enabling two-factor authentication.
        </p>

        <button type="button"
            class="w-full px-6 py-3 border-2 border-primary-500 text-primary-500 text-b-1 font-medium rounded-lg hover:bg-primary-50 transition">
            Enable 2FA
        </button>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }
    </script>
</div>
