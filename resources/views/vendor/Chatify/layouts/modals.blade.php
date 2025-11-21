{{-- ---------------------- Image modal box ---------------------- --}}
<div id="imageModalBox" class="imageModal fixed inset-0 z-50 hidden bg-black/80 items-center justify-center">
    <span
        class="imageModal-close absolute top-4 right-4 text-white text-4xl cursor-pointer hover:text-neutral-300">&times;</span>
    <img class="imageModal-content max-w-[90%] max-h-[90%] object-contain" id="imageModalBoxSrc">
</div>

{{-- ---------------------- Delete Modal ---------------------- --}}
<div class="app-modal fixed inset-0 z-50 hidden bg-black/50 items-center justify-center" data-name="delete">
    <div class="app-modal-container">
        <div class="app-modal-card bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl" data-name="delete"
            data-modal='0'>
            <div class="app-modal-header text-h-6 text-neutral-900 mb-2">Are you sure you want to delete this?</div>
            <div class="app-modal-body text-b-2 text-neutral-600 mb-6">You can not undo this action</div>
            <div class="app-modal-footer flex gap-3 justify-end">
                <button
                    class="app-btn cancel px-6 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-xl transition text-b-2 font-medium">
                    Cancel
                </button>
                <button
                    class="app-btn delete bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-xl transition text-b-2 font-medium">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ---------------------- Alert Modal ---------------------- --}}
<div class="app-modal fixed inset-0 z-50 hidden bg-black/50 items-center justify-center" data-name="alert">
    <div class="app-modal-container">
        <div class="app-modal-card bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl" data-name="alert"
            data-modal='0'>
            <div class="app-modal-header text-h-6 text-neutral-900 mb-2"></div>
            <div class="app-modal-body text-b-2 text-neutral-600 mb-6"></div>
            <div class="app-modal-footer flex justify-end">
                <button
                    class="app-btn cancel px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition text-b-2 font-medium">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ---------------------- Settings Modal ---------------------- --}}
<div class="app-modal fixed inset-0 z-50 hidden bg-black/50 items-center justify-center overflow-y-auto"
    data-name="settings">
    <div class="app-modal-container py-8">
        <div class="app-modal-card bg-white rounded-2xl p-6 max-w-lg w-full mx-4 shadow-xl" data-name="settings"
            data-modal='0'>
            <form id="update-settings" action="{{ route('avatar.update') }}" enctype="multipart/form-data"
                method="POST">
                @csrf

                <div class="app-modal-body space-y-6">
                    {{-- Upload Avatar --}}
                    <div class="flex flex-col items-center">
                        <div class="avatar av-l upload-avatar-preview w-32 h-32 rounded-full bg-cover bg-center mb-3 border-4 border-neutral-100"
                            style="background-image: url('{{ Chatify::getUserWithAvatar(Auth::user())->avatar }}');">
                        </div>
                        <p class="upload-avatar-details text-b-3 text-neutral-500 mb-3"></p>
                        <label
                            class="app-btn update px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition text-b-2 font-medium cursor-pointer">
                            Upload New
                            <input class="upload-avatar hidden" accept="image/*" name="avatar" type="file" />
                        </label>
                    </div>

                    {{-- Dark Mode Toggle --}}
                    <div class="border-t border-neutral-100 pt-6">
                        <div class="flex items-center justify-between">
                            <p class="text-b-1 font-semibold text-neutral-900">Dark Mode</p>
                            <button type="button"
                                class="{{ Auth::user()->dark_mode > 0 ? 'fas' : 'far' }} fa-moon dark-mode-switch text-2xl text-neutral-400 hover:text-primary-500 transition"
                                data-mode="{{ Auth::user()->dark_mode > 0 ? 1 : 0 }}"></button>
                        </div>
                    </div>

                    {{-- Messenger Color --}}
                    <div class="border-t border-neutral-100 pt-6">
                        <p class="text-b-1 font-semibold text-neutral-900 mb-3">Messenger Color</p>
                        <div class="update-messengerColor flex flex-wrap gap-3">
                            @foreach (config('chatify.colors') as $color)
                                <button type="button" style="background-color: {{ $color }}"
                                    data-color="{{ $color }}"
                                    class="color-btn w-10 h-10 rounded-full border-2 border-neutral-200 hover:scale-110 transition cursor-pointer"></button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="app-modal-footer flex gap-3 justify-end mt-6 pt-6 border-t border-neutral-100">
                    <button type="button"
                        class="app-btn cancel px-6 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-xl transition text-b-2 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="app-btn update px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition text-b-2 font-medium">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
