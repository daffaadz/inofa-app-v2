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

{{-- ---------------------- Complaint Modal ---------------------- --}}
<div class="app-modal fixed inset-0 z-50 hidden bg-black/50 items-center justify-center overflow-y-auto"
    data-name="complaint">
    <div class="app-modal-container py-8">
        <div class="app-modal-card bg-white rounded-2xl p-6 max-w-lg w-full mx-4 shadow-xl" data-name="complaint"
            data-modal='0'>
            <div class="app-modal-header flex items-center justify-between mb-6">
                <h3 class="text-h-5 text-neutral-900 font-bold">Form Pengaduan</h3>
                <button type="button"
                    class="close-complaint-modal text-neutral-400 hover:text-neutral-600 transition text-3xl leading-none w-8 h-8 flex items-center justify-center">
                    &times;
                </button>
            </div>

            <form id="complaint-form" action="{{ route('complaints.store') }}" method="POST">
                @csrf

                <div class="app-modal-body space-y-4">
                    {{-- Nama User (readonly) --}}
                    <div>
                        <label class="block text-b-2 font-semibold text-neutral-900 mb-2">Nama</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly
                            class="w-full px-4 py-2.5 bg-neutral-100 border border-neutral-200 rounded-xl text-b-2 text-neutral-600 cursor-not-allowed">
                    </div>

                    {{-- Deskripsi Pengaduan --}}
                    <div>
                        <label class="block text-b-2 font-semibold text-neutral-900 mb-2">
                            Deskripsi Pengaduan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="complaint-description" rows="6" required
                            class="w-full px-4 py-3 border border-neutral-300 rounded-xl text-b-2 text-neutral-900 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition resize-none"
                            placeholder="Jelaskan pengaduan Anda dengan detail (minimal 10 karakter)"></textarea>
                        <p class="text-b-4 text-neutral-600 mt-1.5" id="char-count">0 / 10 karakter minimum</p>
                        <p class="text-b-4 text-red-500 mt-1 hidden" id="description-error"></p>
                    </div>

                    {{-- Terms & Conditions --}}
                    <div class="border-t border-neutral-200 pt-4">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" name="terms_accepted" id="complaint-terms" required
                                class="mt-1 w-5 h-5 text-primary-500 border-neutral-300 rounded focus:ring-primary-500 cursor-pointer">
                            <label for="complaint-terms" class="text-b-3 text-neutral-800 cursor-pointer select-none">
                                Saya menyetujui bahwa informasi yang saya berikan adalah benar dan saya memahami bahwa
                                pengaduan palsu dapat dikenakan sanksi. <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <p class="text-b-4 text-red-500 mt-1 hidden" id="terms-error"></p>
                    </div>
                </div>

                <div class="app-modal-footer flex gap-3 justify-end mt-6 pt-6 border-t border-neutral-200">
                    <button type="button"
                        class="cancel-complaint-btn px-6 py-2.5 bg-neutral-200 hover:bg-neutral-300 text-neutral-800 rounded-xl transition text-b-2 font-semibold">
                        Batal
                    </button>
                    <button type="submit" id="submit-complaint-btn"
                        class="px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition text-b-2 font-semibold disabled:opacity-50 disabled:cursor-not-allowed shadow-sm">
                        Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
