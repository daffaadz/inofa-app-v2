<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-neutral-50">
        <div class="w-full max-w-lg bg-white p-8 rounded-2xl shadow-lg border border-neutral-200">
            <h2 class="text-2xl font-semibold text-neutral-800 mb-6">Lengkapi Informasi Personal</h2>

            <form method="POST" action="{{ route('personal-information.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-medium text-neutral-700">Bio</label>
                        <textarea name="bio" id="bio" rows="3"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('bio') }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-1" />
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-neutral-700">Lokasi</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('location')" class="mt-1" />
                    </div>

                    <div>
                        <label for="avatar" class="block text-sm font-medium text-neutral-700">Avatar</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*"
                            class="mt-1 block w-full text-sm text-neutral-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                        <x-input-error :messages="$errors->get('avatar')" class="mt-1" />
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                    Simpan & Lanjutkan
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>