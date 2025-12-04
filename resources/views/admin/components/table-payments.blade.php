
    <div class="mb-4">
        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Payment Validation
            <span class="text-sm font-normal text-gray-500">({{ $payments->count() }} records)</span>
        </h2>
    </div>
    
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr class="text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    <th class="px-6 py-4">Project</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Payment Proof</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
            @forelse($payments as $payment)
                <tr class="text-sm hover:bg-primary-50/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            @if($payment->agreement)
                                {{ $payment->agreement->project->title ?? $payment->agreement->project_title ?? '-' }}
                            @else
                                -
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        @if($payment->agreement && $payment->agreement->consumer)
                            {{ $payment->agreement->consumer->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-900">
                            Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ optional($payment->created_at)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @include('admin.components.status-badge', ['status' => $payment->status])
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($payment->consumer_payment_proof)
                            <button 
                                type="button"
                                onclick="showPaymentProof('{{ asset('storage/' . $payment->consumer_payment_proof) }}')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                View Proof
                            </button>
                        @else
                            <span class="text-xs text-gray-400 italic">No proof available</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            @if($payment->status === 'pending')
                                <button type="button"
                                        onclick="approvePayment({{ $payment->id }}, this)"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 
                                               text-white text-xs font-medium hover:from-green-600 hover:to-green-700 
                                               hover:shadow-lg transition-all duration-200"
                                        title="Approve">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Approve
                                </button>
                                
                                <button type="button"
                                        onclick="rejectPayment({{ $payment->id }}, this)"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-600 
                                               text-white text-xs font-medium hover:from-red-600 hover:to-red-700 
                                               hover:shadow-lg transition-all duration-200"
                                        title="Reject">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reject
                                </button>
                            @elseif($payment->status === 'confirmed')
                                <button type="button"
                                        onclick="transferPayment({{ $payment->id }}, this)"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 
                                               text-white text-xs font-medium hover:from-blue-600 hover:to-blue-700 
                                               hover:shadow-lg transition-all duration-200"
                                        title="Transfer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                    Transfer
                                </button>
                                
                                <button type="button"
                                        onclick="reviewPayment({{ $payment->id }}, this)"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 
                                               text-white text-xs font-medium hover:from-yellow-600 hover:to-orange-600 
                                               hover:shadow-lg transition-all duration-200"
                                        title="Review">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Review
                                </button>
                            @else
                                <button type="button"
                                        onclick="reviewPayment({{ $payment->id }}, this)"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 
                                               text-white text-xs font-medium hover:from-yellow-600 hover:to-orange-600 
                                               hover:shadow-lg transition-all duration-200"
                                        title="Review">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Review
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-gray-500 text-sm font-medium">No payment data available</p>
                            <p class="text-gray-400 text-xs">Try resetting filters or changing search criteria</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal untuk menampilkan bukti pembayaran -->
    <div id="paymentProofModal" class="hidden fixed inset-0 bg-black bg-opacity-70 z-50 items-center justify-center p-4" onclick="closePaymentProof(event)">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Payment Proof
                </h3>
                <button 
                    type="button"
                    onclick="closePaymentProof()"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="flex items-center justify-center bg-gray-50 rounded-xl">
                    <img id="paymentProofImage" src="" alt="Payment Proof" class="max-w-full max-h-[60vh] h-auto w-auto object-contain rounded-lg shadow-lg">
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-4 border-t border-gray-200 bg-gray-50">
                <a id="paymentProofDownload" href="" download class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
                <button 
                    type="button"
                    onclick="closePaymentProof()"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="adminToast" class="hidden fixed top-4 right-4 z-50 max-w-sm">
        <div class="bg-white shadow-lg rounded-lg p-4 border-l-4" id="adminToastContent">
            <div class="flex items-start gap-3">
                <div id="adminToastIcon" class="flex-shrink-0"></div>
                <div class="flex-1">
                    <h4 id="adminToastTitle" class="font-semibold text-sm mb-1"></h4>
                    <p id="adminToastMessage" class="text-sm text-neutral-600"></p>
                </div>
                <button onclick="hideAdminToast()" class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function showPaymentProof(imageUrl) {
            const modal = document.getElementById('paymentProofModal');
            const image = document.getElementById('paymentProofImage');
            const downloadLink = document.getElementById('paymentProofDownload');
            
            image.src = imageUrl;
            downloadLink.href = imageUrl;
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
            
            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
        }

        function closePaymentProof(event) {
            // Check if clicked outside the modal content or close button
            if (!event || event.target.id === 'paymentProofModal' || !event.target.closest('.bg-white')) {
                const modal = document.getElementById('paymentProofModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
                
                // Restore body scroll
                document.body.style.overflow = '';
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePaymentProof();
            }
        });

        // Approve payment function
        async function approvePayment(paymentId, button) {
            if (!confirm('Are you sure you want to approve this payment?')) {
                return;
            }

            button.disabled = true;
            button.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Processing...';

            try {
                const response = await fetch(`/admin/payments/${paymentId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showAdminToast('Success', data.message, 'success');
                    
                    // Update status badge
                    const row = button.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(5)');
                    if (statusCell) {
                        statusCell.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">confirmed</span>';
                    }
                    
                    // Replace with transfer and review buttons
                    const actionsCell = button.closest('td');
                    actionsCell.innerHTML = `
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                    onclick="transferPayment(${paymentId}, this)"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 
                                           text-white text-xs font-medium hover:from-blue-600 hover:to-blue-700 
                                           hover:shadow-lg transition-all duration-200"
                                    title="Transfer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                                Transfer
                            </button>
                            
                            <button type="button"
                                    onclick="reviewPayment(${paymentId}, this)"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 
                                           text-white text-xs font-medium hover:from-yellow-600 hover:to-orange-600 
                                           hover:shadow-lg transition-all duration-200"
                                    title="Review">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Review
                            </button>
                        </div>
                    `;
                } else {
                    showAdminToast('Error', data.message, 'error');
                    button.disabled = false;
                    button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Approve';
                }
            } catch (error) {
                console.error('Error:', error);
                showAdminToast('Error', 'An error occurred while approving payment', 'error');
                button.disabled = false;
                button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Approve';
            }
        }

        // Reject payment function
        async function rejectPayment(paymentId, button) {
            const reason = prompt('Please enter the reason for rejecting this payment:');
            if (!reason || reason.trim() === '') {
                return;
            }

            button.disabled = true;
            button.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Processing...';

            try {
                const response = await fetch(`/admin/payments/${paymentId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ reason: reason })
                });

                const data = await response.json();

                if (data.success) {
                    showAdminToast('Success', data.message, 'success');
                    
                    // Update status badge
                    const row = button.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(5)');
                    if (statusCell) {
                        statusCell.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">failed</span>';
                    }
                    
                    // Replace with review button
                    const actionsCell = button.closest('td');
                    actionsCell.innerHTML = `
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                    onclick="reviewPayment(${paymentId}, this)"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 
                                           text-white text-xs font-medium hover:from-yellow-600 hover:to-orange-600 
                                           hover:shadow-lg transition-all duration-200"
                                    title="Review">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Review
                            </button>
                        </div>
                    `;
                } else {
                    showAdminToast('Error', data.message, 'error');
                    button.disabled = false;
                    button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Reject';
                }
            } catch (error) {
                console.error('Error:', error);
                showAdminToast('Error', 'An error occurred while rejecting payment', 'error');
                button.disabled = false;
                button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Reject';
            }
        }

        // Review payment function - Set status back to pending
        async function reviewPayment(paymentId, button) {
            if (!confirm('Are you sure you want to review this payment? The status will be reset to pending.')) {
                return;
            }

            button.disabled = true;
            button.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Processing...';

            try {
                const response = await fetch(`/admin/payments/${paymentId}/review`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showAdminToast('Success', data.message, 'success');
                    
                    // Update status badge
                    const row = button.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(5)');
                    if (statusCell) {
                        statusCell.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">pending</span>';
                    }
                    
                    // Replace with approve/reject buttons
                    const actionsCell = button.closest('td');
                    actionsCell.innerHTML = `
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                    onclick="approvePayment(${paymentId}, this)"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 
                                           text-white text-xs font-medium hover:from-green-600 hover:to-green-700 
                                           hover:shadow-lg transition-all duration-200"
                                    title="Approve">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Approve
                            </button>
                            
                            <button type="button"
                                    onclick="rejectPayment(${paymentId}, this)"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-600 
                                           text-white text-xs font-medium hover:from-red-600 hover:to-red-700 
                                           hover:shadow-lg transition-all duration-200"
                                    title="Reject">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reject
                            </button>
                        </div>
                    `;
                } else {
                    showAdminToast('Error', data.message, 'error');
                    button.disabled = false;
                    button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Review';
                }
            } catch (error) {
                console.error('Error:', error);
                showAdminToast('Error', 'An error occurred while reviewing payment', 'error');
                button.disabled = false;
                button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Review';
            }
        }

        // Transfer payment function - Change status from confirmed to transferred
        async function transferPayment(paymentId, button) {
            if (!confirm('Are you sure you want to mark this payment as transferred? This will transfer the funds to the developer.')) {
                return;
            }

            button.disabled = true;
            button.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Processing...';

            try {
                const response = await fetch(`/admin/payments/${paymentId}/transfer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showAdminToast('Success', data.message, 'success');
                    
                    // Update status badge
                    const row = button.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(5)');
                    if (statusCell) {
                        statusCell.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">transferred</span>';
                    }
                    
                    // Replace with review button only
                    const actionsCell = button.closest('td');
                    actionsCell.innerHTML = `
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                    onclick="reviewPayment(${paymentId}, this)"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 
                                           text-white text-xs font-medium hover:from-yellow-600 hover:to-orange-600 
                                           hover:shadow-lg transition-all duration-200"
                                    title="Review">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Review
                            </button>
                        </div>
                    `;
                } else {
                    showAdminToast('Error', data.message, 'error');
                    button.disabled = false;
                    button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg> Transfer';
                }
            } catch (error) {
                console.error('Error:', error);
                showAdminToast('Error', 'An error occurred while transferring payment', 'error');
                button.disabled = false;
                button.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg> Transfer';
            }
        }

        // Toast notification function
        function showAdminToast(title, message, type = 'success') {
            const toast = document.getElementById('adminToast');
            const toastContent = document.getElementById('adminToastContent');
            const toastIcon = document.getElementById('adminToastIcon');
            const toastTitle = document.getElementById('adminToastTitle');
            const toastMessage = document.getElementById('adminToastMessage');

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
                hideAdminToast();
            }, 5000);
        }

        function hideAdminToast() {
            document.getElementById('adminToast').classList.add('hidden');
        }
    </script>
