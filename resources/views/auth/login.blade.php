<x-guest-layout>
    {{-- PAGE WRAPPER --}}
    <div class="min-h-screen grid md:grid-cols-2 px-2 md:px-0">

        {{-- LEFT PANEL : ILLUSTRATION --}}
        <div
            class="hidden md:flex relative items-center justify-center bg-gradient-to-br from-primary-200 via-primary-100 to-primary-200 p-6 md:max-h-screen md:sticky md:top-0">

            {{-- Logo --}}
            <div class="absolute left-24 top-12 mb-10">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-4">
                    <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa" class="h-8 w-auto">
                    <span class="text-neutral-800 text-h-5 font-sans">Inofa</span>
                </a>
            </div>

            <div class="max-w-xl text-center">
                <h2 class="font-sans text-h-2 text-start text-neutral-800 mb-4">
                    Welcome Back!
                </h2>
                <h6 class="font-sans text-h-7">Don't have an Inofa account? <a href="{{ route('register') }}"
                        class="text-primary-500 underline hover:no-underline !transition-all duration-200">Create
                        account</a></h6>
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
                <div class="md:hidden mb-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa" class="h-8 w-auto">
                        <span class="text-neutral-800 text-h-5 font-sans">Inofa</span>
                    </a>
                </div>

                {{-- Heading --}}
                <h1 class="font-sans text-h-5 sm:text-h-4 text-neutral-800 mb-2">
                    Sign in to your account
                </h1>

                {{-- Mobile Register Link --}}
                <p class="md:hidden font-sans text-b-2 text-neutral-600 mb-6">
                    Don't have an account? <a href="{{ route('register') }}"
                        class="text-primary-500 underline hover:no-underline">Create account</a>
                </p>

                {{-- Google sign-in --}}
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
                <form method="POST" action="{{ route('login') }}" class="space-y-2">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" value="Email" class="font-sans text-b-3 text-neutral-700" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')"
                            class="mt-1 block w-full px-3 sm:px-4 py-2 rounded-lg border border-neutral-300
                                     font-sans text-b-2 sm:text-b-1 placeholder-neutral-400
                                     focus:ring-1 focus:ring-primary-500" />
                        @if($errors->get('email'))
                            @foreach($errors->get('email') as $error)
                                @if(str_contains($error, 'suspended'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            showSuspendedModal();
                                        });
                                    </script>
                                @endif
                            @endforeach
                        @endif
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Password + hints --}}
                    <div>
                        <x-input-label for="password" value="Password" class="font-sans text-b-3 text-neutral-700" />
                        <x-text-input id="password" type="password" name="password"
                            class="mt-1 block w-full px-3 sm:px-4 py-2 rounded-lg border border-neutral-300
                                     font-sans text-b-2 sm:text-b-1 placeholder-neutral-400
                                     focus:ring-1 focus:ring-primary-500" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    {{-- TOS line --}}
                    <p class="font-sans text-b-3 text-neutral-600 pt-2">
                        By creating an account, you agree to Inofa's
                        <a href="#" class="text-primary-500 hover:underline">Terms of Use</a> and
                        <a href="#" class="text-primary-500 hover:underline">Privacy Policy</a>.
                    </p>

                    {{-- CTA --}}
                    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 pt-2">
                        <a href="{{ route('password.request') }}"
                            class="text-primary-500 font-sans text-b-2 sm:text-b-1 underline hover:no-underline text-center sm:text-left"> Forgot
                            password?</a>

                        <button type="submit"
                            class="w-full sm:w-fit px-8 py-2 rounded-lg bg-primary-500
                               font-sans text-b-2 text-white font-semibold
                               hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- Suspended Account Modal --}}
    <div id="suspendedModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 p-4" style="display: none;">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <!-- Header -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center gap-3 text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h3 class="text-xl font-bold">Account Suspended</h3>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2">Your account has been suspended</h4>
                                <p class="text-sm text-gray-600">
                                    You cannot access your account at this time. This action was taken by our administration team.
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="font-semibold text-sm text-gray-900 mb-2">What should I do?</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 mt-0.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <span>Contact our support team for more information</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 mt-0.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <span>Review our terms of service</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 mt-0.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <span>Wait for administrator to review your account</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <button onclick="closeSuspendedModal()"
                        class="w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        I Understand
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSuspendedModal() {
            document.getElementById('suspendedModal').style.display = 'block';
        }

        function closeSuspendedModal() {
            document.getElementById('suspendedModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('suspendedModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuspendedModal();
            }
        });
    </script>

</x-guest-layout>