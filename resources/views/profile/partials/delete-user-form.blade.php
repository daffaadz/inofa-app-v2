<div class="bg-white rounded-lg shadow-sm p-6 border-2 border-red-200">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <h3 class="text-h-6 text-red-600">Danger Zone</h3>
    </div>

    <p class="text-b-2 text-neutral-600 mb-6">
        Once you delete your account, there is no going back. Please be certain.
    </p>

    <button type="button" onclick="toggleDeleteModal()"
        class="w-full px-6 py-3 bg-red-500 text-white text-b-1 font-medium rounded-lg hover:bg-red-600 transition flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        Delete Account
    </button>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-h-7 text-neutral-1000">Confirm Account Deletion</h3>
                    <p class="text-b-3 text-neutral-500">This action cannot be undone</p>
                </div>
            </div>

            <p class="text-b-2 text-neutral-600 mb-6">
                Are you absolutely sure you want to delete your account? All of your data will be permanently removed
                from our servers forever. This action cannot be undone.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="password" class="block text-b-2 font-medium text-neutral-700 mb-2">
                        Enter your password to confirm
                    </label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                        required>
                    @error('password', 'userDeletion')
                        <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="toggleDeleteModal()"
                        class="flex-1 px-6 py-2.5 border border-neutral-200 text-neutral-700 text-b-1 font-medium rounded-lg hover:bg-neutral-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-2.5 bg-red-500 text-white text-b-1 font-medium rounded-lg hover:bg-red-600 transition">
                        Yes, Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.toggle('hidden');
        }
    </script>
</div>
