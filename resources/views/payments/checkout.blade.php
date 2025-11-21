<x-app-layout>
    <x-slot:title>Complete Your Payment - Inofa</x-slot:title>

    <section class="min-h-screen flex">
        @include('partials.consumer-sidebar')

        <main class="flex-1 ml-[18rem] p-8 bg-neutral-50">

            {{-- TOP BACK LINK --}}
            <a href="{{ route('consumer.payments.offer-detail', $agreement->id) }}"
               class="flex items-center text-neutral-600 mb-6 text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
                Back to Offer Detail
            </a>

            {{-- TITLE --}}
            <h1 class="text-2xl font-bold text-neutral-900 mb-4">Complete Your Payment</h1>
            <p class="text-neutral-600 mb-8">Transfer to Inofa's escrow account for secured transaction</p>

            <div class="grid grid-cols-12 gap-8">

                {{-- LEFT SECTION --}}
                <div class="col-span-8 space-y-6">

                    {{-- SAFETY NOTICE --}}
                    <div class="bg-green-50 border border-green-200 p-4 rounded-xl flex gap-3">
                        <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-neutral-800 text-sm leading-relaxed">
                            Your payment is held safely by Inofa Escrow and will only be released once you confirm project completion.
                        </p>
                    </div>

                    {{-- PAYMENT INSTRUCTIONS --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-200">

                        <h2 class="text-lg font-semibold mb-4">Transfer Instructions</h2>

                        <p class="text-sm text-neutral-600 mb-1">Bank</p>
                        <p class="font-medium mb-4">Bank Central Asia (BCA)</p>

                        <p class="text-sm text-neutral-600 mb-1">Virtual Account Number</p>
                        <div class="flex items-center gap-3">
                            <div class="px-4 py-3 bg-neutral-100 rounded-lg font-mono tracking-wide">
                                8808 0012 3456 7890
                            </div>
                        </div>

                        <p class="text-sm text-neutral-600 mt-4 mb-1">Account Name</p>
                        <p class="font-medium">Inofa Escrow</p>

                        <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
                            Payment deadline: {{ now()->addDay()->format('d M Y, H:i') }} WIB
                        </div>
                    </div>

                    {{-- HOW TO PAY --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-200">
                        <h2 class="text-lg font-semibold mb-4">How to Pay</h2>

                        <ul class="space-y-3 text-sm text-neutral-700">
                            <li>1. Transfer the exact amount using the Virtual Account.</li>
                            <li>2. Save your transfer receipt.</li>
                            <li>3. Upload the payment proof below.</li>
                            <li>4. Click "Confirm Payment".</li>
                        </ul>
                    </div>

                    {{-- UPLOAD PAYMENT PROOF --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-200">
                        <h2 class="text-lg font-semibold mb-4">Upload Payment Proof</h2>

                        @if(session('success'))
                            <div class="p-3 bg-green-100 text-green-700 rounded-lg mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('consumer.payments.confirm', $payment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="border-2 border-dashed border-neutral-300 rounded-xl p-6 text-center">
                                <input type="file" name="proof" class="w-full text-sm mb-3" required>
                                <p class="text-neutral-500 text-sm">JPG, PNG, or PDF (max 5MB)</p>
                            </div>

                            @error('proof')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror

                            <button
                                class="mt-4 w-full bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700">
                                Confirm Payment
                            </button>
                        </form>
                    </div>

                </div>

                {{-- RIGHT SECTION --}}
                <div class="col-span-4">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-200">

                        <h3 class="font-semibold mb-4">Project Summary</h3>

                        <p class="text-sm text-neutral-600">Project</p>
                        <p class="font-medium mb-3">{{ $project->title }}</p>

                        <p class="text-sm text-neutral-600">Developer</p>
                        <p class="font-medium mb-3">{{ $developer->name }}</p>

                        <p class="text-sm text-neutral-600">Order ID</p>
                        <p class="font-mono mb-3">INF-{{ $agreement->id }}</p>

                        <div class="mt-6 border-t pt-4">
                            <p class="text-sm text-neutral-600">Total Amount</p>
                            <p class="text-green-700 font-bold text-xl">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('chat.admin') }}"
                               class="block text-center py-2 rounded-lg bg-neutral-100 hover:bg-neutral-200 text-sm font-medium">
                                Contact Customer Service
                            </a>
                        </div>

                        <div class="mt-6 text-sm text-neutral-600">
                            <p>Payment Deadline: {{ now()->addDay()->format('d M Y, H:i') }} WIB</p>
                            <p>Secure Escrow Protection</p>
                            <p>Verification within 1×24 hours</p>
                        </div>

                    </div>
                </div>

            </div>
        </main>

    </section>
</x-app-layout>
