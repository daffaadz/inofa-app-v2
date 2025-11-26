<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script>
    // Gloabl Chatify variables from PHP to JS
    window.chatify = {
        name: "{{ config('chatify.name') }}",
        sounds: {!! json_encode(config('chatify.sounds')) !!},
        allowedImages: {!! json_encode(config('chatify.attachments.allowed_images')) !!},
        allowedFiles: {!! json_encode(config('chatify.attachments.allowed_files')) !!},
        maxUploadSize: {{ Chatify::getMaxUploadSize() }},
        pusher: {!! json_encode(config('chatify.pusher')) !!},
        pusherAuthEndpoint: '{{ route('pusher.auth') }}'
    };
    window.chatify.allAllowedExtensions = chatify.allowedImages.concat(chatify.allowedFiles);
</script>
{{-- JS PROPOSAL ACTION --}}
<script>
    document.addEventListener('click', function(e) {
        // Accept Proposal
        if (e.target.closest('.accept-proposal-btn')) {
            const button = e.target.closest('.accept-proposal-btn');
            const agreementId = button.dataset.agreementId;

            if (confirm('Apakah Anda yakin ingin menerima proposal ini?')) {
                button.disabled = true;
                const originalHtml = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

                fetch(`/proposals/${agreementId}/accept`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload agar status berubah
                        } else {
                            alert(data.message || 'Terjadi kesalahan');
                            button.disabled = false;
                            button.innerHTML = originalHtml;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses proposal');
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                    });
            }
        }

        // Reject Proposal
        if (e.target.closest('.reject-proposal-btn')) {
            const button = e.target.closest('.reject-proposal-btn');
            const agreementId = button.dataset.agreementId;

            if (confirm('Apakah Anda yakin ingin menolak proposal ini?')) {
                button.disabled = true;
                const originalHtml = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

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
                            location.reload();
                        } else {
                            alert(data.message || 'Terjadi kesalahan');
                            button.disabled = false;
                            button.innerHTML = originalHtml;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses proposal');
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                    });
            }
        }
    });
</script>
<script src="{{ asset('js/chatify/utils.js') }}"></script>
<script src="{{ asset('js/chatify/code.js') }}"></script>
