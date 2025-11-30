{{-- resources/views/payments/agreement-detail.blade.php --}}
<x-app-layout>
    <x-slot:title>Agreement Detail - Inofa</x-slot:title>

    <section class="min-h-screen flex">

        {{-- SIDEBAR --}}
        @include('partials.global-sidebar')

        <main class="flex-1 ml-[18rem] mt-16 bg-neutral-10 min-h-screen px-8 py-6">

            {{-- Back button --}}
            <a href="javascript:history.back()" class="flex items-center text-neutral-600 hover:text-neutral-800 mb-6 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Previous
            </a>

            {{-- TITLE SECTION --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-neutral-200 mb-6">
                <div class="flex items-center gap-4 mb-3">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg font-semibold">
                        ID: INF-{{ substr($agreement->id, 0, 8) }}
                    </span>
                </div>

                <h1 class="text-h-6 font-semibold text-neutral-900 mb-2">Offer Detail</h1>

                <p class="text-neutral-500 text-sm leading-relaxed">
                    Created on {{ $agreement->created_at->translatedFormat('F d, Y') }}
                </p>
            </div>

            <div class="grid grid-cols-12 gap-6">

                {{-- LEFT SIDE --}}
                <div class="col-span-8 space-y-6">

                    {{-- SUMMARY --}}
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Project Summary</h2>

                        <p class="text-neutral-500 text-sm">Project Title</p>
                        <p class="font-semibold text-neutral-900 mb-4">{{ $agreement->project_title }}</p>

                        <p class="text-neutral-500 text-sm">Client Name</p>
                        <p class="font-medium text-neutral-900 mb-4">{{ $agreement->client_name }}</p>

                        <p class="text-neutral-500 text-sm">Developer</p>
                        <div class="flex items-center gap-3 mt-1">
                            @php
                                $avatarSrc = $developer->getRawOriginal('avatar')
                                    ? (filter_var($developer->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                        ? $developer->getRawOriginal('avatar')
                                        : asset('storage/' . $developer->getRawOriginal('avatar')))
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($developer->name);
                            @endphp
                            <img src="{{ $avatarSrc }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-semibold text-neutral-900">{{ $developer->name }}</p>
                                @if($developer->developerProfile)
                                    <p class="text-neutral-500 text-sm">{{ $developer->developerProfile->title ?? 'Developer' }}</p>
                                @else
                                    <p class="text-neutral-500 text-sm">Developer</p>
                                @endif
                            </div>
                        </div>
                    </x-card>

                    {{-- SCOPE OF PROJECTS --}}
                    @if($agreement->scope_projects)
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Scope of Work</h2>
                        <div class="prose prose-sm max-w-none">
                            <p class="text-neutral-700 text-sm leading-relaxed whitespace-pre-line">{{ $agreement->scope_projects }}</p>
                        </div>
                    </x-card>
                    @endif

                    {{-- MVP FEATURES --}}
                    @if($agreement->projects_mvp && count($agreement->projects_mvp) > 0)
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Project MVP Features</h2>
                        <div class="space-y-3">
                            @foreach($agreement->projects_mvp as $mvp)
                                <div class="flex items-start gap-3 p-3 bg-neutral-50 rounded-lg">
                                    <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-semibold">
                                        {{ $mvp['priority'] ?? '1' }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-neutral-900">{{ $mvp['name'] ?? '' }}</p>
                                        @if(isset($mvp['description']))
                                            <p class="text-neutral-600 text-sm mt-1">{{ $mvp['description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                    @endif

                    {{-- DELIVERABLES --}}
                    @if($agreement->deliverables && count($agreement->deliverables) > 0)
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Deliverables</h2>
                        <ul class="space-y-3">
                            @foreach($agreement->deliverables as $deliverable)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-800 text-sm">{{ $deliverable }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </x-card>
                    @endif

                    {{-- TIMELINE --}}
                    <x-card class="hover:shadow-lg transition">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h2 class="text-h-7 font-semibold">Project Timeline</h2>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">Start Date:</span>
                                <span class="font-medium text-neutral-900">{{ $agreement->start_date->translatedFormat('F d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">End Date:</span>
                                <span class="font-medium text-neutral-900">{{ $agreement->end_date->translatedFormat('F d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm pt-2 border-t border-neutral-200">
                                <span class="text-neutral-600">Duration:</span>
                                <span class="font-semibold text-green-600">{{ $agreement->start_date->diffInDays($agreement->end_date) }} Days</span>
                            </div>
                        </div>
                    </x-card>

                    {{-- TERMS --}}
                    @if($agreement->terms)
                    <x-card class="hover:shadow-lg transition">
                        <h2 class="text-h-7 font-semibold mb-4">Payment Terms</h2>
                        <div class="prose prose-sm max-w-none">
                            <p class="text-neutral-700 text-sm leading-relaxed whitespace-pre-line">{{ $agreement->terms }}</p>
                        </div>
                    </x-card>
                    @endif

                </div>

                {{-- RIGHT SIDE --}}
                <div class="col-span-4 space-y-6">

                    {{-- PRICE BREAKDOWN --}}
                    <x-card class="hover:shadow-lg transition">
                        <h3 class="text-h-7 font-semibold mb-4">Cost Breakdown</h3>

                        @if(count($totalCostBreakdown) > 0)
                            <ul class="text-sm space-y-3">
                                @foreach ($totalCostBreakdown as $cost)
                                    <li class="flex justify-between">
                                        <span class="text-neutral-600">{{ $cost['label'] }}</span>
                                        <span class="font-medium text-neutral-900">Rp {{ number_format($cost['amount'], 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="border-t border-neutral-200 mt-4 pt-4 flex justify-between font-semibold text-lg">
                                <span>Total Cost</span>
                                <span class="text-green-600">
                                    Rp {{ number_format($agreement->final_price, 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-2xl font-bold text-green-600 mb-1">
                                    Rp {{ number_format($agreement->final_price, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-neutral-500">Total Project Cost</p>
                            </div>
                        @endif

                        <div class="mt-5 space-y-3">
                            @if($agreement->status === 'accepted')
                                {{-- Show Go to Payment button only --}}
                                <a href="{{ route('consumer.payments.create', $agreement->id) }}"
                                    class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                                    Go to Payment
                                </a>
                            @else
                                {{-- Show Accept and Request Changes buttons --}}
                                <button type="button"
                                    class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition accept-agreement-btn"
                                    data-agreement-id="{{ $agreement->id }}">
                                    Accept & Proceed to Payment
                                </button>

                                <a href="{{ route('user', ['id' => $developer->id]) }}"
                                    class="block w-full text-center border border-neutral-300 text-neutral-700 py-3 rounded-lg font-semibold hover:bg-neutral-50 transition">
                                    Request Changes
                                </a>
                            @endif
                        </div>
                    </x-card>

                    {{-- QUICK INFO --}}
                    <x-card class="hover:shadow-lg transition">
                        <h3 class="text-h-7 font-semibold mb-3">Agreement Info</h3>

                        <ul class="text-sm text-neutral-700 space-y-2">
                            <li class="flex justify-between">
                                <span class="text-neutral-500">Status:</span>
                                <span class="font-medium capitalize px-2 py-1 rounded 
                                    @if($agreement->status === 'accepted') bg-green-100 text-green-700
                                    @elseif($agreement->status === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-neutral-100 text-neutral-700
                                    @endif">

                                    @if($agreement->status === 'accepted')
                                        Waiting for Payment
                                    @elseif($agreement->status === 'pending')
                                        Pending
                                    @else
                                        Rejected
                                    @endif
                                </span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-neutral-500">Created:</span>
                                <span class="font-medium">{{ $agreement->created_at->translatedFormat('M d, Y') }}</span>
                            </li>
                            @if($agreement->signed_at)
                            <li class="flex justify-between">
                                <span class="text-neutral-500">Signed:</span>
                                <span class="font-medium">{{ $agreement->signed_at->translatedFormat('M d, Y') }}</span>
                            </li>
                            @endif
                            <li class="flex justify-between pt-2 border-t border-neutral-200">
                                <span class="text-neutral-500">Total:</span>
                                <span class="text-green-600 font-semibold">
                                    Rp {{ number_format($agreement->final_price, 0, ',', '.') }}
                                </span>
                            </li>
                        </ul>
                    </x-card>

                </div>

            </div>

        </main>
    </section>

    {{-- Include Proposal Modal --}}
    @include('vendor.Chatify.layouts.proposalModal')

    {{-- Script to handle accept button --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Agreement detail page loaded');
            
            // Handler for accept button
            document.addEventListener('click', function(e) {
                if (e.target.closest('.accept-agreement-btn')) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('Accept button clicked');
                    
                    const button = e.target.closest('.accept-agreement-btn');
                    const agreementId = button.dataset.agreementId;

                    console.log('Agreement ID:', agreementId);

                    if (!agreementId || agreementId === '' || agreementId === 'null') {
                        console.error('Invalid agreement ID:', agreementId);
                        alert('Agreement ID is invalid. Please refresh the page and try again.');
                        return;
                    }

                    // Show the proposal modal
                    const modal = document.getElementById('proposalModal');
                    const icon = document.getElementById('modalIcon');
                    const title = document.getElementById('modalTitle');
                    const msg = document.getElementById('modalMessage');
                    const confirmBtn = document.getElementById('modalConfirmBtn');

                    // Clear any existing event listeners by cloning
                    const newConfirmBtn = confirmBtn.cloneNode(true);
                    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

                    icon.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10';
                    icon.innerHTML = '<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                    title.textContent = 'Accept Agreement';
                    msg.textContent = 'Are you sure you want to accept this agreement? You will be redirected to the payment page.';
                    newConfirmBtn.textContent = 'Yes, Accept';
                    newConfirmBtn.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-primary-500 text-b-2 font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors';

                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';

                    // Add click handler to new confirm button
                    newConfirmBtn.addEventListener('click', function() {
                        console.log('Confirm button clicked, processing...');
                        
                        const originalHtml = button.innerHTML;
                        button.disabled = true;
                        button.innerHTML = '<svg class="animate-spin h-4 w-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';

                        // Close modal
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';

                        console.log('Sending request to:', `/proposals/${agreementId}/accept`);
                        
                        fetch(`/proposals/${agreementId}/accept`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            console.log('Response headers:', [...response.headers.entries()]);
                            
                            const contentType = response.headers.get('content-type');
                            if (!contentType || !contentType.includes('application/json')) {
                                return response.text().then(text => {
                                    console.error('Non-JSON response:', text);
                                    throw new Error('Server returned non-JSON response: ' + text.substring(0, 200));
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                console.log('Success! Redirecting to payment page...');
                                window.location.href = `/consumer/payments/create/${agreementId}`;
                            } else {
                                console.error('Request failed:', data.message);
                                alert(data.message || 'An error occurred');
                                button.disabled = false;
                                button.innerHTML = originalHtml;
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                            alert('An error occurred while processing the agreement: ' + error.message);
                            button.disabled = false;
                            button.innerHTML = originalHtml;
                        });
                    });
                }
            });
        });
    </script>

</x-app-layout>
