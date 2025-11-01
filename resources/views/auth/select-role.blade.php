<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-neutral-50">
        <div class="w-full max-w-lg bg-white p-8 rounded-2xl shadow-lg border border-neutral-200">
            <h2 class="text-2xl font-semibold text-neutral-800 mb-6">Pilih Role Anda</h2>

            <form method="POST" action="{{ route('select-role.store') }}">
                @csrf

                <div class="space-y-4">
                    <label class="flex items-start gap-4 cursor-pointer border border-neutral-300 rounded-lg p-4 hover:bg-neutral-50">
                        <input type="radio" name="role" value="consumer" required
                            class="mt-1 w-4 h-4 text-blue-600 border-neutral-300 focus:ring-blue-500">
                        <div>
                            <div class="font-medium text-neutral-800">Consumer</div>
                            <div class="text-sm text-neutral-600">Saya mencari developer untuk projek saya.</div>
                        </div>
                    </label>

                    <label class="flex items-start gap-4 cursor-pointer border border-neutral-300 rounded-lg p-4 hover:bg-neutral-50">
                        <input type="radio" name="role" value="developer" required
                            class="mt-1 w-4 h-4 text-blue-600 border-neutral-300 focus:ring-blue-500">
                        <div>
                            <div class="font-medium text-neutral-800">Developer</div>
                            <div class="text-sm text-neutral-600">Saya ingin menawarkan jasa sebagai developer.</div>
                        </div>
                    </label>
                </div>

                <x-input-error :messages="$errors->get('role')" class="mt-2" />

                <button type="submit" class="w-full mt-6 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                    Lanjutkan
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>