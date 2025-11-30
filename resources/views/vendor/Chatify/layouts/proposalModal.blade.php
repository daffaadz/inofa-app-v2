{{-- Proposal Action Modal --}}
<div id="proposalModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-neutral-900 bg-opacity-50" onclick="closeProposalModal()"></div>

        <!-- Modal panel -->
        <div
            class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div id="modalIcon"
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                        <h3 id="modalTitle" class="text-h-6 leading-6 font-semibold text-neutral-800">
                            Terima Proposal
                        </h3>
                        <div class="mt-2">
                            <p id="modalMessage" class="text-b-2 text-neutral-600">
                                Apakah Anda yakin ingin menerima proposal ini? Anda akan diarahkan ke halaman pembayaran
                                setelah menerima.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-neutral-10 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <button id="modalConfirmBtn" type="button"
                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-primary-500 text-b-2 font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                    Ya, Terima
                </button>
                <button type="button" onclick="closeProposalModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-xl border border-neutral-300 shadow-sm px-4 py-2.5 bg-white text-b-2 font-medium text-neutral-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentAgreementId = null;
    let currentButton = null;
    let currentProposalCard = null;

    function showProposalModal(agreementId, button, proposalCard) {
        currentAgreementId = agreementId;
        currentButton = button;
        currentProposalCard = proposalCard;
        document.getElementById('proposalModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeProposalModal() {
        document.getElementById('proposalModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentAgreementId = null;
        currentButton = null;
        currentProposalCard = null;
    }

    function showSuccessModal(message, paymentUrl) {
        const modal = document.getElementById('proposalModal');
        const icon = document.getElementById('modalIcon');
        const title = document.getElementById('modalTitle');
        const msg = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');

        icon.className =
            'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10';
        icon.innerHTML =
            '<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
        title.textContent = 'Berhasil!';
        msg.textContent = message;
        confirmBtn.textContent = 'Lanjut ke Pembayaran';
        confirmBtn.onclick = () => window.location.href = paymentUrl;

        modal.classList.remove('hidden');
    }

    function showErrorModal(message) {
        const modal = document.getElementById('proposalModal');
        const icon = document.getElementById('modalIcon');
        const title = document.getElementById('modalTitle');
        const msg = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');

        icon.className =
            'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10';
        icon.innerHTML =
            '<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
        title.textContent = 'Gagal';
        msg.textContent = message;
        confirmBtn.textContent = 'Tutup';
        confirmBtn.onclick = closeProposalModal;

        modal.classList.remove('hidden');
    }

    document.getElementById('modalConfirmBtn').addEventListener('click', function() {
        if (!currentAgreementId || currentAgreementId === '' || currentAgreementId === 'null') {
            showErrorModal('Agreement ID tidak valid');
            return;
        }

        // Save references before closing modal
        const agreementId = currentAgreementId;
        const button = currentButton;
        const proposalCard = currentProposalCard;

        if (!button) {
            showErrorModal('Button reference lost');
            return;
        }

        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML =
            '<svg class="animate-spin h-4 w-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';

        closeProposalModal();

        console.log('Sending accept request for agreementId:', agreementId);

        fetch(`/proposals/${agreementId}/accept`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    console.error('Response is not JSON:', contentType);
                    return response.text().then(text => {
                        console.error('Response text:', text);
                        throw new Error('Server returned non-JSON response');
                    });
                }
                
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update card status
                    if (proposalCard) {
                        proposalCard.setAttribute('data-status', 'accepted');

                        // Update action area for client - show payment button
                        const actionArea = proposalCard.querySelector('.proposal-action-area');
                        if (actionArea) {
                            actionArea.innerHTML = `
                                <a href="/consumer/payments/create/${agreementId}"
                                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-b-2 font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-4" fill="currentColor" viewBox="0 0 256 256">
                                        <path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z"></path>
                                    </svg>
                                    Lanjut ke Pembayaran
                                </a>
                            `;
                        }
                    }

                    // Show success modal
                    showSuccessModal('Proposal berhasil diterima!',
                        `/consumer/payments/create/${agreementId}`);
                } else {
                    showErrorModal(data.message || 'Terjadi kesalahan');
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorModal('Terjadi kesalahan saat memproses proposal');
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalHtml;
                }
            });
    });

    document.addEventListener('click', function(e) {
        // Accept Proposal
        if (e.target.closest('.accept-proposal-btn')) {
            const button = e.target.closest('.accept-proposal-btn');
            const agreementId = button.dataset.agreementId;
            const proposalCard = button.closest('.proposal-message');

            // Debug logging
            console.log('Accept button clicked:', {
                agreementId: agreementId,
                buttonDataset: button.dataset,
                proposalCard: proposalCard
            });

            // Validate agreementId
            if (!agreementId || agreementId === '' || agreementId === 'null') {
                console.error('Invalid agreement ID:', agreementId);
                showErrorModal('Agreement ID tidak valid. Silakan refresh halaman dan coba lagi.');
                return;
            }

            showProposalModal(agreementId, button, proposalCard);
        }

        // Reject Proposal
        if (e.target.closest('.reject-proposal-btn')) {
            const button = e.target.closest('.reject-proposal-btn');
            const agreementId = button.dataset.agreementId;
            const proposalCard = button.closest('.proposal-message');

            // Debug logging
            console.log('Reject button clicked:', {
                agreementId: agreementId,
                buttonDataset: button.dataset,
                proposalCard: proposalCard
            });

            // Validate agreementId
            if (!agreementId || agreementId === '' || agreementId === 'null') {
                console.error('Invalid agreement ID:', agreementId);
                showErrorModal('Agreement ID tidak valid. Silakan refresh halaman dan coba lagi.');
                return;
            }

            // Use custom modal for reject too
            const modal = document.getElementById('proposalModal');
            const icon = document.getElementById('modalIcon');
            const title = document.getElementById('modalTitle');
            const msg = document.getElementById('modalMessage');
            const confirmBtn = document.getElementById('modalConfirmBtn');

            icon.className =
                'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10';
            icon.innerHTML =
                '<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
            title.textContent = 'Tolak Proposal';
            msg.textContent =
                'Apakah Anda yakin ingin menolak proposal ini? Tindakan ini tidak dapat dibatalkan.';
            confirmBtn.textContent = 'Ya, Tolak';
            confirmBtn.className =
                'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-red-500 text-b-2 font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors';

            modal.classList.remove('hidden');

            confirmBtn.onclick = function() {
                const originalHtml = button.innerHTML;
                button.disabled = true;
                button.innerHTML =
                    '<svg class="animate-spin h-4 w-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';

                closeProposalModal();

                fetch(`/proposals/${agreementId}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update card status
                            if (proposalCard) {
                                proposalCard.setAttribute('data-status', 'rejected');

                                // Update action area - show rejected status
                                const actionArea = proposalCard.querySelector('.proposal-action-area');
                                if (actionArea) {
                                    actionArea.innerHTML = `
                                        <div class="flex items-center gap-2 px-3 py-2.5 bg-red-100 text-red-800 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-4" fill="currentColor" viewBox="0 0 256 256">
                                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"></path>
                                            </svg>
                                            <span class="text-b-3 font-medium">Proposal Ditolak</span>
                                        </div>
                                    `;
                                }
                            }

                            // Show success notification
                            icon.className =
                                'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10';
                            icon.innerHTML =
                                '<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                            title.textContent = 'Berhasil';
                            msg.textContent = 'Proposal telah ditolak';
                            confirmBtn.textContent = 'Tutup';
                            confirmBtn.className =
                                'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-primary-500 text-b-2 font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors';
                            confirmBtn.onclick = closeProposalModal;
                            modal.classList.remove('hidden');
                        } else {
                            showErrorModal(data.message || 'Terjadi kesalahan');
                            button.disabled = false;
                            button.innerHTML = originalHtml;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showErrorModal('Terjadi kesalahan saat memproses proposal');
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                    });
            };
        }
    });

    // Listen for Pusher events to update proposal cards in real-time
    @if (config('chatify.pusher.enabled'))
        if (window.Echo) {
            window.Echo.private('App.Models.User.{{ auth()->id() }}')
                .notification((notification) => {
                    if (notification.type === 'App\\Notifications\\ProposalStatusUpdated') {
                        const agreementId = notification.agreement_id;
                        const status = notification.status;

                        // Find and update the proposal card
                        const proposalCard = document.querySelector(
                            `.proposal-message[data-agreement-id="${agreementId}"]`);
                        if (proposalCard) {
                            proposalCard.setAttribute('data-status', status);
                            const actionArea = proposalCard.querySelector('.proposal-action-area');

                            if (status === 'accepted') {
                                // For developer: show waiting payment status
                                if (actionArea) {
                                    actionArea.innerHTML = `
                                    <div class="alert alert-info mb-0 d-flex align-items-center" style="font-size: 13px; padding: 10px; border-radius: 8px; background-color: #d1ecf1; border: none;">
                                        <i class="fas fa-clock me-2"></i>
                                        <span>⏳ Menunggu Pembayaran dari Client</span>
                                    </div>
                                `;
                                }
                            } else if (status === 'rejected' || status === 'terminated') {
                                if (actionArea) {
                                    actionArea.innerHTML = `
                                    <div class="alert alert-danger mb-0 d-flex align-items-center" style="font-size: 13px; padding: 10px; border-radius: 8px; background-color: #f8d7da; border: none;">
                                        <i class="fas fa-times-circle me-2"></i>
                                        <span>❌ Proposal Ditolak</span>
                                    </div>
                                `;
                                }
                            }
                        }
                    }
                });
        }
    @endif
</script>
