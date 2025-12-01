<x-app-layout>
    <x-slot:title>Complete Your Payment - Inofa</x-slot:title>

    <section class="min-h-screen flex">
        @include('partials.global-sidebar')

        <main class="flex-1 lg:ml-[18rem] mt-16 p-8 bg-neutral-50">

            {{-- TOP BACK LINK --}}
            <a href="javascript:history.back()"
               class="flex items-center text-neutral-600 mb-6 text-sm hover:text-neutral-800 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
                Back to Previous
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

                        @if($payment->isProofUploaded())
                            {{-- SUDAH UPLOAD - TAMPILKAN STATUS --}}
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-neutral-800 mb-2">Payment Proof Uploaded</h3>
                                <p class="text-neutral-600 mb-4">Your payment proof has been submitted and is awaiting admin verification.</p>
                                
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                    <p class="text-sm text-yellow-800">
                                        <strong>Status:</strong> Pending Verification<br>
                                        <span class="text-xs text-yellow-700">Verification typically takes 1-24 hours</span>
                                    </p>
                                </div>

                                <div class="flex justify-center gap-3">
                                    <a href="{{ asset('storage/' . $payment->consumer_payment_proof) }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg text-sm font-medium transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Proof
                                    </a>
                                </div>
                            </div>
                        @else
                            {{-- BELUM UPLOAD - TAMPILKAN FORM --}}
                            <form id="paymentProofForm" enctype="multipart/form-data">
                                @csrf

                                <div class="border-2 border-dashed border-neutral-300 rounded-xl p-6 text-center">
                                    <input type="file" name="proof" id="proofInput" class="w-full text-sm mb-3" accept=".jpg,.jpeg,.png,.pdf" required>
                                    <p class="text-neutral-500 text-sm">JPG, PNG, or PDF (max 5MB)</p>
                                </div>

                                <div id="errorMessage" class="hidden mt-3 p-3 bg-red-100 text-red-700 rounded-lg text-sm"></div>

                                <button type="button"
                                        id="confirmPaymentBtn"
                                        class="mt-4 w-full bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                                    Confirm Payment
                                </button>
                            </form>
                        @endif
                    </div>

                </div>

                {{-- RIGHT SECTION --}}
                <div class="col-span-4">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-200">

                        <h3 class="font-semibold mb-4">Project Summary</h3>

                        <p class="text-sm text-neutral-600">Project</p>
                        <p class="font-medium mb-3">{{ $agreement->project_title }}</p>

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

    {{-- Toast Notification --}}
    <div id="toast" class="hidden fixed top-4 right-4 z-50 max-w-sm">
        <div class="bg-white shadow-lg rounded-lg p-4 border-l-4" id="toastContent">
            <div class="flex items-start gap-3">
                <div id="toastIcon" class="flex-shrink-0"></div>
                <div class="flex-1">
                    <h4 id="toastTitle" class="font-semibold text-sm mb-1"></h4>
                    <p id="toastMessage" class="text-sm text-neutral-600"></p>
                </div>
                <button onclick="hideToast()" class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-full mb-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-neutral-800 mb-2">Confirm Payment Upload</h3>
                <p class="text-sm text-neutral-600">Are you sure you want to upload this payment proof? Once uploaded, you cannot change it.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="cancelConfirm()" class="flex-1 px-4 py-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg font-medium transition">
                    Cancel
                </button>
                <button onclick="submitPaymentProof()" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                    Yes, Upload
                </button>
            </div>
        </div>
    </div>

    <script>
        const confirmBtn = document.getElementById('confirmPaymentBtn');
        const confirmModal = document.getElementById('confirmModal');
        const paymentForm = document.getElementById('paymentProofForm');
        const proofInput = document.getElementById('proofInput');
        const errorMessage = document.getElementById('errorMessage');

        // Show confirmation modal
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!proofInput.files || !proofInput.files[0]) {
                    showToast('Error', 'Please select a file to upload', 'error');
                    return;
                }

                // Validate file size (5MB)
                const file = proofInput.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                
                if (file.size > maxSize) {
                    showToast('Error', 'File size must not exceed 5MB', 'error');
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!allowedTypes.includes(file.type)) {
                    showToast('Error', 'Only JPG, PNG, and PDF files are allowed', 'error');
                    return;
                }

                confirmModal.style.display = 'flex';
                confirmModal.classList.remove('hidden');
            });
        }

        // Cancel confirmation
        function cancelConfirm() {
            confirmModal.style.display = 'none';
            confirmModal.classList.add('hidden');
        }

        // Submit payment proof via AJAX
        function submitPaymentProof() {
            const formData = new FormData(paymentForm);
            const submitUrl = "{{ route('consumer.payments.confirm', $payment->id) }}";

            // Disable button
            confirmBtn.disabled = true;
            confirmBtn.textContent = 'Uploading...';
            confirmModal.style.display = 'none';
            confirmModal.classList.add('hidden');

            fetch(submitUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Success', data.message, 'success');
                    
                    // Reload page after 2 seconds to show updated UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showToast('Error', data.message, 'error');
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Confirm Payment';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'An error occurred while uploading. Please try again.', 'error');
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Confirm Payment';
            });
        }

        // Toast notification function
        function showToast(title, message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastContent = document.getElementById('toastContent');
            const toastIcon = document.getElementById('toastIcon');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');

            // Set icon and color based on type
            if (type === 'success') {
                toastContent.className = 'bg-white shadow-lg rounded-lg p-4 border-l-4 border-green-500';
                toastIcon.innerHTML = `
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                `;
            } else if (type === 'error') {
                toastContent.className = 'bg-white shadow-lg rounded-lg p-4 border-l-4 border-red-500';
                toastIcon.innerHTML = `
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                `;
            }

            toastTitle.textContent = title;
            toastMessage.textContent = message;

            toast.classList.remove('hidden');

            // Auto hide after 5 seconds
            setTimeout(() => {
                hideToast();
            }, 5000);
        }

        function hideToast() {
            document.getElementById('toast').classList.add('hidden');
        }
    </script>
</x-app-layout>
