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
{{-- Include Proposal Modal --}}
@include('vendor.Chatify.layouts.proposalModal')
<script src="{{ asset('js/chatify/utils.js') }}"></script>
<script src="{{ asset('js/chatify/code.js') }}"></script>

<script>
// Termination modal function - must be in global scope
window.showTerminationModal = function(agreementId) {
    console.log('showTerminationModal called with ID:', agreementId);
    
    if (!agreementId) {
        console.error('Agreement ID is missing');
        alert('Error: Agreement ID is missing');
        return false;
    }
    
    // Set the form action
    const form = document.getElementById('termination-form');
    if (form) {
        form.action = `/developer/agreements/${agreementId}/terminate`;
        console.log('Form action set to:', form.action);
    } else {
        console.error('Termination form not found');
        alert('Error: Form not found');
        return false;
    }
    
    // Show the modal
    const modal = document.querySelector('[data-name="termination"]');
    if (modal) {
        // Set display to block (not flex to avoid potential conflicts)
        modal.style.display = 'block';
        modal.classList.remove('hidden');
        
        // Force a reflow to ensure styles are applied
        modal.offsetHeight;
        
        console.log('Modal opened - display:', window.getComputedStyle(modal).display);
        console.log('Modal visibility:', window.getComputedStyle(modal).visibility);
        console.log('Modal opacity:', window.getComputedStyle(modal).opacity);
    } else {
        console.error('Termination modal not found');
        alert('Error: Modal not found');
        return false;
    }
    
    return false;
};

// Close termination modal
window.closeTerminationModal = function() {
    const modal = document.querySelector('[data-name="termination"]');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
        console.log('Modal closed');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded - Setting up modal close handlers');
    
    const cancelBtn = document.querySelector('.cancel-termination-btn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Cancel button clicked');
            window.closeTerminationModal();
        });
    } else {
        console.log('Cancel button not found on page load');
    }
    
    // Also close modal when clicking outside (on the backdrop)
    document.addEventListener('click', function(e) {
        const modal = document.querySelector('[data-name="termination"]');
        if (modal && e.target === modal) {
            window.closeTerminationModal();
        }
    });
});

console.log('Termination script loaded');
</script>
