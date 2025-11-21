{{-- resources/views/payments/offer-detail.blade.php --}}
<x-app-layout>
    <x-slot:title>Offer Detail - Inofa</x-slot:title>

    <section class="min-h-screen flex">
        
        {{-- SIDEBAR --}}
        @include('partials.consumer-sidebar')

        <main class="flex-1 ml-[18rem] bg-neutral-10 min-h-screen px-8 py-6">

            {{-- Back button --}}
            <a href="javascript:history.back()" class="flex items-center text-neutral-600 mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
                Back to Messages
            </a>

            {{-- TITLE SECTION --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-neutral-200 mb-6">
                <div class="flex items-center gap-4 mb-3">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg font-semibold">
                        ID: {{ $agreement->project->code ?? 'INF-' . $agreement->id }}
                    </span>
                </div>

                <h1 class="text-h-6 font-semibold text-neutral-900 mb-2">Offer Detail</h1>

                <p class="text-neutral-500 text-sm leading-relaxed">
                    Created on {{ $agreement->created_at->translatedFormat('F d, Y') }} <br>
                    Valid until: {{ $agreement->created_at->addDays(7)->translatedFormat('F d, Y') }}
                </p>
            </div>

            <div class="grid grid-cols-12 gap-6">

                {{-- LEFT SIDE --}}
                <div class="col-span-8 space-y-6">

                    {{-- SUMMARY --}}
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Project Summary</h2>

                        <p class="text-neutral-500 text-sm">Project Title</p>
                        <p class="font-semibold text-neutral-900 mb-4">{{ $project->title }}</p>

                        <p class="text-neutral-500 text-sm">Developer</p>
                        <div class="flex items-center gap-3 mt-1">
                            <img src="{{ $developer->avatar }}"
                                 class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-semibold text-neutral-900">{{ $developer->name }}</p>
                                <p class="text-neutral-500 text-sm">Full-stack Developer</p>
                            </div>
                        </div>
                    </x-card>

                    {{-- SCOPE OF WORK --}}
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Scope of Work</h2>

                        <ul class="space-y-3">
                            @foreach($scopeOfWork as $task)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-800 text-sm">{{ $task }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </x-card>

                    {{-- ESTIMATION --}}
                    <x-card class="hover:shadow-lg transition">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h2 class="text-h-7 font-semibold">Estimated Timeline</h2>
                        </div>

                        <p class="font-semibold text-neutral-900 text-lg">
                            {{ $agreement->project->estimated_duration ?? '6–8 Weeks' }}
                        </p>
                        <p class="text-neutral-500 text-sm mt-2">
                            Timeline may vary depending on revisions and complexity.
                        </p>
                    </x-card>

                    {{-- TERMS --}}
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Payment Terms</h2>

                        <ul class="space-y-3 text-sm text-neutral-700">
                            <li>Payments are processed through Inofa’s secure escrow system.</li>
                            <li>Funds are released after the project is completed and approved.</li>
                            <li>100% refund if the developer does not start within 3 business days.</li>
                            <li>Minor revisions are included.</li>
                            <li>Major revisions may require additional fees.</li>
                        </ul>
                    </x-card>

                </div>

                {{-- RIGHT SIDE --}}
                <div class="col-span-4 space-y-6">

                    {{-- PRICE BREAKDOWN --}}
                    <x-card class="hover:shadow-lg transition">
                        <h3 class="text-h-7 font-semibold mb-4">Cost Breakdown</h3>

                        <ul class="text-sm space-y-3">
                            @foreach($totalCostBreakdown as $cost)
                                <li class="flex justify-between">
                                    <span>{{ $cost['label'] }}</span>
                                    <span>Rp {{ number_format($cost['amount'], 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="border-t border-neutral-200 mt-4 pt-4 flex justify-between font-semibold text-lg">
                            <span>Total Cost</span>
                            <span class="text-green-600">
                                Rp {{ number_format($agreement->final_price, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="mt-5 space-y-3">
                            <a href="{{ route('consumer.payments.create', $agreement->id) }}"
                                class="block text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold">
                                    Accept & Proceed to Payment
                            </a>

                            <button class="w-full border border-red-500 text-red-500 py-3 rounded-lg font-semibold hover:bg-red-50">
                                Reject Offer
                            </button>
                        </div>
                    </x-card>

                    {{-- QUICK INFO --}}
                    <x-card class="hover:shadow-lg transition">
                        <h3 class="text-h-7 font-semibold mb-3">Quick Info</h3>

                        <ul class="text-sm text-neutral-700 space-y-2">
                            <li>Created: {{ $agreement->created_at->translatedFormat('F d, Y') }}</li>
                            <li>Duration: 6–8 Weeks</li>
                            <li class="text-green-600 font-semibold">
                                Total: Rp {{ number_format($agreement->final_price, 0, ',', '.') }}
                            </li>
                        </ul>
                    </x-card>

                </div>

            </div>

            {{-- FOOTER --}}
            @include('partials.footer')

        </main>
    </section>

</x-app-layout>
