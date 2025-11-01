<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-neutral-50">
        <div class="w-full max-w-2xl bg-white p-8 rounded-2xl shadow-lg border border-neutral-200">
            <h2 class="text-2xl font-semibold text-neutral-800 mb-6">Lengkapi Profil Developer</h2>

            <form method="POST" action="{{ route('developer.information.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="headline" class="block text-sm font-medium text-neutral-700">Headline</label>
                        <input type="text" name="headline" id="headline" value="{{ old('headline') }}"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('headline')" class="mt-1" />
                    </div>

                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-neutral-700">Tahun Pengalaman</label>
                        <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', 0) }}"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('experience_years')" class="mt-1" />
                    </div>

                    <div>
                        <label for="rate_min_byproject" class="block text-sm font-medium text-neutral-700">Rate Min (per projek)</label>
                        <input type="number" name="rate_min_byproject" id="rate_min_byproject" value="{{ old('rate_min_byproject') }}"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('rate_min_byproject')" class="mt-1" />
                    </div>

                    <div>
                        <label for="rate_max_byproject" class="block text-sm font-medium text-neutral-700">Rate Max (per projek)</label>
                        <input type="number" name="rate_max_byproject" id="rate_max_byproject" value="{{ old('rate_max_byproject') }}"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('rate_max_byproject')" class="mt-1" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="availability" class="block text-sm font-medium text-neutral-700">Ketersediaan</label>
                        <select name="availability" id="availability"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="available" selected>Available</option>
                            <option value="busy">Busy</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                        <x-input-error :messages="$errors->get('availability')" class="mt-1" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="experience" class="block text-sm font-medium text-neutral-700">Pengalaman</label>
                        <textarea name="experience" id="experience" rows="3"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('experience') }}</textarea>
                        <x-input-error :messages="$errors->get('experience')" class="mt-1" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="education" class="block text-sm font-medium text-neutral-700">Pendidikan</label>
                        <input type="text" name="education" id="education" value="{{ old('education') }}"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('education')" class="mt-1" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="certifications" class="block text-sm font-medium text-neutral-700">Sertifikasi</label>
                        <textarea name="certifications" id="certifications" rows="2"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('certifications') }}</textarea>
                        <x-input-error :messages="$errors->get('certifications')" class="mt-1" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="portfolio_links" class="block text-sm font-medium text-neutral-700">Link Portfolio (pisahkan dengan koma)</label>
                        <textarea name="portfolio_links" id="portfolio_links" rows="2"
                            class="mt-1 block w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('portfolio_links') }}</textarea>
                        <x-input-error :messages="$errors->get('portfolio_links')" class="mt-1" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Skill</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach($skills as $skill)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                                        class="w-4 h-4 text-blue-600 border-neutral-300 rounded focus:ring-blue-500">
                                    {{ $skill->name }}
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('skills')" class="mt-1" />
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                    Selesaikan Registrasi
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>