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

// Agreement Request Modal function
window.showAgreementRequestModal = function(url) {
    console.log('showAgreementRequestModal called with URL:', url);
    
    if (!url) {
        console.error('URL is missing');
        alert('Error: URL is missing');
        return false;
    }
    
    // Store the URL for later use
    window.agreementRequestUrl = url;
    
    // Show the modal
    const modal = document.querySelector('[data-name="agreement-request"]');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.remove('hidden');
        modal.offsetHeight;
        console.log('Agreement request modal opened');
    } else {
        console.error('Agreement request modal not found');
        alert('Error: Modal not found');
        return false;
    }
    
    return false;
};

// Close agreement request modal
window.closeAgreementRequestModal = function() {
    const modal = document.querySelector('[data-name="agreement-request"]');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
        console.log('Agreement request modal closed');
    }
};

// Confirm and navigate to agreement creation
window.confirmAgreementRequest = function() {
    if (window.agreementRequestUrl) {
        window.location.href = window.agreementRequestUrl;
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
    
    // Agreement request modal handlers
    const cancelAgreementBtn = document.querySelector('.cancel-agreement-request-btn');
    if (cancelAgreementBtn) {
        cancelAgreementBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Cancel agreement request button clicked');
            window.closeAgreementRequestModal();
        });
    }
    
    const confirmAgreementBtn = document.querySelector('.confirm-agreement-request-btn');
    if (confirmAgreementBtn) {
        confirmAgreementBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Confirm agreement request button clicked');
            window.confirmAgreementRequest();
        });
    }
    
    // Also close modal when clicking outside (on the backdrop)
    document.addEventListener('click', function(e) {
        const terminationModal = document.querySelector('[data-name="termination"]');
        if (terminationModal && e.target === terminationModal) {
            window.closeTerminationModal();
        }
        
        const agreementModal = document.querySelector('[data-name="agreement-request"]');
        if (agreementModal && e.target === agreementModal) {
            window.closeAgreementRequestModal();
        }
    });
});

console.log('Termination script loaded');
</script>
