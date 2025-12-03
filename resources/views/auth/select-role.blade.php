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
                    Welcome to<br>
                    Inofa Platform!
                </h2>
                <p class="font-sans text-b-1 text-neutral-800 text-start mt-4">
                    Choose your role to get started and unlock the full potential of our platform.
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
                    Choose Your Role
                </h1>
                <p class="font-sans text-b-2 text-neutral-600 mb-6">Select how you want to use Inofa</p>

                {{-- FORM --}}
                <form method="POST" action="{{ route('select-role.store') }}" class="space-y-4">
                    @csrf

                    <div class="space-y-4">
                        {{-- Consumer Option --}}
                        <label
                            class="flex items-start gap-4 cursor-pointer border-2 border-neutral-300 rounded-lg p-5 hover:border-primary-500 hover:bg-primary-50 transition-all duration-200 group">
                            <input type="radio" name="role" value="consumer" required
                                class="mt-1 w-5 h-5 text-primary-500 border-neutral-300 focus:ring-primary-500 cursor-pointer">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <div class="font-sans text-b-1 font-semibold text-neutral-800">Consumer</div>
                                </div>
                                <div class="font-sans text-b-2 text-neutral-600">
                                    Saya mencari developer untuk mengerjakan projek saya.
                                </div>
                            </div>
                        </label>

                        {{-- Developer Option --}}
                        <label
                            class="flex items-start gap-4 cursor-pointer border-2 border-neutral-300 rounded-lg p-5 hover:border-primary-500 hover:bg-primary-50 transition-all duration-200 group">
                            <input type="radio" name="role" value="developer" required
                                class="mt-1 w-5 h-5 text-primary-500 border-neutral-300 focus:ring-primary-500 cursor-pointer">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                    <div class="font-sans text-b-1 font-semibold text-neutral-800">Developer</div>
                                </div>
                                <div class="font-sans text-b-2 text-neutral-600">
                                    Saya ingin menawarkan jasa dan keahlian sebagai developer.
                                </div>
                            </div>
                        </label>
                    </div>

                    <x-input-error :messages="$errors->get('role')" class="mt-2" />

                    {{-- CTA Button --}}
                    <button type="submit"
                        class="w-full px-4 py-3 rounded-lg bg-primary-500 font-sans text-b-2 text-white font-semibold hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200 mt-6">
                        Continue
                    </button>

                    {{-- Helper Text --}}
                    <p class="font-sans text-b-3 text-neutral-600 text-center mt-4">
                        You can update your profile information in the next step
                    </p>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>