<x-guest-layout>
    {{-- PAGE WRAPPER --}}
    <div class="min-h-screen grid md:grid-cols-2 py-16 px-2 md:px-0 md:py-0">

        {{-- LEFT PANEL : ILLUSTRATION --}}
        <div
            class="hidden md:flex md:sticky md:top-0 items-center justify-center bg-gradient-to-br from-primary-200 via-primary-100 to-primary-200 md:max-h-screen p-6">

            {{-- Logo --}}
            <div class="absolute left-24 top-12 mb-10">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-4">
                    <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa" class="h-8 w-auto">
                    <span class="text-neutral-800 text-h-5 font-sans">Inofa</span>
                </a>
            </div>

            <div class="max-w-xl text-start">
                <h2 class="font-sans text-h-2 leading-[3.5rem] text-start text-neutral-800 mb-4 tracking-tight">
                    Join Indonesia's<br>
                    Trusted Platform for<br>
                    Tech Talent.
                </h2>
                <ul class="my-6 space-y-3 font-sans text-h-7 text-neutral-800 text-left">
                    <li class="flex items-start gap-3">
                        <span class="text-nautral-800 mt-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="black" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        Access vetted opportunities
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-nautral-800 mt-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="black" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        Connect with innovative companies
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-nautral-800 mt-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="black" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        Build your professional portfolio
                    </li>
                </ul>
                <h6 class="font-sans text-h-7">Already have an Inofa account? <a href="{{ route('login') }}"
                        class="text-primary-500 underline hover:no-underline !transition-all duration-200">Log in</a>
                </h6>
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
        <div class="flex items-center justify-center p-4 sm:p-6">
            <div class="w-full max-w-lg">

                {{-- Mobile Logo --}}
                <div class="md:hidden mb-6">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa" class="h-8 w-auto">
                        <span class="text-neutral-800 text-h-5 font-sans">Inofa</span>
                    </a>
                </div>

                {{-- Heading --}}
                <h1 class="font-sans text-h-5 sm:text-h-4 text-neutral-800 mb-2">
                    Create your Inofa account
                </h1>

                {{-- Mobile Login Link --}}
                <p class="md:hidden font-sans text-b-2 text-neutral-600 mb-4">
                    Already have an account? <a href="{{ route('login') }}"
                        class="text-primary-500 underline hover:no-underline">Log in</a>
                </p>

                {{-- Google sign-up --}}
                <a href="{{ route('social.redirect', ['driver' => 'google']) }}"
                    class="mt-4 sm:mt-6 flex items-center justify-center gap-3
                      w-full px-4 py-3 sm:py-4 rounded-xl border border-neutral-300
                      font-sans text-b-2 text-neutral-0 bg-blue-500 hover:bg-blue-400">
                    {{-- minimal Google icon --}}
                    <svg class="h-4 w-4" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_517_511)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M20.1 10.2273C20.1 9.51819 20.0364 8.83638 19.9182 8.18183H10.5V12.05H15.8818C15.65 13.3 14.9455 14.3591 13.8864 15.0682V17.5773H17.1182C19.0091 15.8364 20.1 13.2727 20.1 10.2273Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.5001 20C13.2001 20 15.4637 19.1045 17.1183 17.5773L13.8864 15.0682C12.991 15.6682 11.8455 16.0227 10.5001 16.0227C7.89554 16.0227 5.69099 14.2636 4.90463 11.9H1.56372V14.4909C3.20918 17.7591 6.59099 20 10.5001 20Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.90455 11.9C4.70455 11.3 4.59091 10.6591 4.59091 10C4.59091 9.34092 4.70455 8.70001 4.90455 8.10001V5.5091H1.56364C0.886364 6.8591 0.5 8.38637 0.5 10C0.5 11.6136 0.886364 13.1409 1.56364 14.4909L4.90455 11.9Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.5001 3.97727C11.9683 3.97727 13.2864 4.48182 14.3228 5.47273L17.191 2.60455C15.4592 0.990909 13.1955 0 10.5001 0C6.59099 0 3.20918 2.24091 1.56372 5.50909L4.90463 8.1C5.69099 5.73636 7.89554 3.97727 10.5001 3.97727Z"
                                fill="currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_517_511">
                                <rect width="20" height="20" fill="white" transform="translate(0.5)" />
                            </clipPath>
                        </defs>
                    </svg>
                    Continue with Google
                </a>

                {{-- Divider --}}
                <div class="relative my-3">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-neutral-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white font-sans text-b-2 text-neutral-500">or</span>
                    </div>
                </div>

                {{-- FORM --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-2">
                    @csrf

                    {{-- Full name --}}
                    <div>
                        <x-input-label for="name" value="Full name" class="font-sans text-b-3 text-neutral-700" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')"
                            class="mt-1 block w-full px-3 sm:px-4 py-2 rounded-lg border border-neutral-300
                                     font-sans text-b-2 sm:text-b-1 placeholder-neutral-400
                                     focus:ring-2 focus:ring-primary-500" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" value="Email" class="font-sans text-b-3 text-neutral-700" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')"
                            class="mt-1 block w-full px-3 sm:px-4 py-2 rounded-lg border border-neutral-300
                                     font-sans text-b-2 sm:text-b-1 placeholder-neutral-400
                                     focus:ring-2 focus:ring-primary-500" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Password + hints --}}
                    <div x-data="{ pwd: '', pwdC: '' }">
                        {{-- Password --}}
                        <div>
                            <x-input-label for="password" value="Password"
                                class="font-sans text-b-3 text-neutral-700" />
                            <x-text-input id="password" type="password" name="password" x-model="pwd"
                                class="mt-1 block w-full px-3 sm:px-4 py-2 rounded-lg border border-neutral-300
                             font-sans text-b-2 sm:text-b-1 placeholder-neutral-400
                             focus:ring-2 focus:ring-primary-500" />
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mt-3">
                            <x-input-label for="password_confirmation" value="Confirm Password"
                                class="font-sans text-b-3 text-neutral-700" />
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                x-model="pwdC"
                                class="mt-1 block w-full px-3 sm:px-4 py-2 rounded-lg border border-neutral-300
                             font-sans text-b-2 sm:text-b-1 placeholder-neutral-400
                             focus:ring-2 focus:ring-primary-500" />
                        </div>

                        {{-- Hint list (muncul hanya jika ada input tapi belum valid) --}}
                        <ul x-show="pwd && !(/[A-Z]/.test(pwd) && /\d/.test(pwd) && pwd.length >= 8)" x-transition
                            class="mt-2 space-y-1 font-sans text-b-3 text-neutral-600">
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-auto text-primary-500/65" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M7.5 12L10.5 15L16.5 9M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                At least 1 uppercase
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-auto text-primary-500/65" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M7.5 12L10.5 15L16.5 9M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                At least 1 number
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-auto text-primary-500/65" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M7.5 12L10.5 15L16.5 9M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                At least 8 characters
                            </li>
                        </ul>

                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    {{-- Role radios --}}
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 sm:gap-4 cursor-pointer border border-neutral-400 rounded-lg p-3 sm:p-4">
                            <input type="radio" name="role" value="consumer" required
                                class="mt-1 w-4 h-4 text-primary-500 border border-neutral-300 focus:ring-primary-500">
                            <div>
                                <div class="font-sans text-b-2 text-neutral-800">I want to find developers for projects
                                    (as a Client)
                                </div>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 sm:gap-6 cursor-pointer border border-neutral-400 rounded-lg p-3 sm:p-4">
                            <input type="radio" name="role" value="developer" required
                                class="mt-1 w-4 h-4 text-primary-500 border border-neutral-300 focus:ring-primary-500">
                            <div>
                                <div class="font-sans text-b-2 text-neutral-800">I want to offer services as a
                                    developer (as a Developer) </div>
                            </div>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />

                    {{-- TOS line --}}
                    <p class="font-sans text-b-3 text-neutral-600">
                        By creating an account, you agree to Inofa's
                        <a href="#" class="text-primary-500 hover:underline">Terms of Use</a> and
                        <a href="#" class="text-primary-500 hover:underline">Privacy Policy</a>.
                    </p>

                    {{-- CTA --}}
                    <button type="submit"
                        class="w-full px-4 py-2 rounded-lg bg-primary-500
                           font-sans text-b-2 text-white font-semibold
                           hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        Create Account
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-guest-layout>
