<div class="bg-white rounded-xl shadow-md p-6">
    <!-- Avatar with badges -->
    <div class="relative w-40 h-40 mx-auto mb-4">
        @php
            $avatarSrc = Auth::user()->getRawOriginal('avatar')
                ? (filter_var(Auth::user()->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                    ? Auth::user()->getRawOriginal('avatar')
                    : asset('storage/' . Auth::user()->getRawOriginal('avatar')))
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=200';
        @endphp
        <div class="relative w-40 h-40 rounded-full border-4 border-primary-500">
            <img id="avatar-preview" src="{{ $avatarSrc }}" alt="{{ Auth::user()->name }}"
                class="w-full h-full rounded-full object-cover">
            
            <!-- Availability Indicator (top right) -->
            @if (Auth::user()->role === 'developer')
                @php
                    $availability = Auth::user()->developerProfile?->availability ?? 'available';
                    $availabilityColors = [
                        'available' => 'bg-green-500',
                        'busy' => 'bg-yellow-500',
                        'unavailable' => 'bg-red-500'
                    ];
                @endphp
                <div id="availability-badge" class="absolute -top-1 -right-1 w-8 h-8 {{ $availabilityColors[$availability] }} rounded-full flex items-center justify-center border-2 border-white shadow-sm" title="{{ ucfirst($availability) }}">
                    @if($availability === 'available')
                        <!-- Check icon -->
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    @elseif($availability === 'busy')
                        <!-- Code icon -->
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M71.68,97.22,34.74,128l36.94,30.78a12,12,0,1,1-15.36,18.44l-48-40a12,12,0,0,1,0-18.44l48-40A12,12,0,0,1,71.68,97.22Zm176,21.56-48-40a12,12,0,1,0-15.36,18.44L221.26,128l-36.94,30.78a12,12,0,1,0,15.36,18.44l48-40a12,12,0,0,0,0-18.44ZM164.1,28.72a12,12,0,0,0-15.38,7.18l-64,176a12,12,0,0,0,7.18,15.37A11.79,11.79,0,0,0,96,228a12,12,0,0,0,11.28-7.9l64-176A12,12,0,0,0,164.1,28.72Z"/>
                        </svg>
                    @else
                        <!-- X icon -->
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    @endif
                </div>
            @else
                <!-- Verified Badge for non-developers -->
                <div class="absolute -top-1 -right-1 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            @endif

            <!-- Camera/Edit button (bottom right) - Only show in profile tab -->
            <form id="avatar-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="avatar-upload-btn">
                @csrf
                <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden" onchange="handleAvatarChange(this)">
                <button type="button" onclick="document.getElementById('avatar-input').click()" id="camera-btn"
                    class="absolute -bottom-1 -right-1 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center border-2 border-white hover:bg-primary-600 transition shadow-sm">
                    <svg id="camera-icon" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <!-- Loading spinner (hidden by default) -->
                    <svg id="loading-spinner" class="w-4 h-4 text-white animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- User Info -->
    <div class="text-center mb-6">
        <h2 class="text-h-6 font-semibold text-neutral-1000 mb-1">{{ Auth::user()->name }}</h2>
        @if (Auth::user()->role === 'developer')
            <p class="text-b-2 text-neutral-600 mb-2">{{ Auth::user()->developerProfile?->headline ?? 'Developer' }}</p>
        @else
            <p class="text-b-2 text-neutral-600 mb-2">{{ ucfirst(Auth::user()->role) }}</p>
        @endif
        <div class="flex items-center justify-center gap-1 text-b-3 text-neutral-500">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ Auth::user()->location ?? 'Jakarta, Indonesia' }}
        </div>
    </div>

    @if (Auth::user()->role === 'developer')
        <!-- Developer Stats -->
        <div class="space-y-3 mb-6 pb-6 border-b border-neutral-100">
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-600">Rate Range</span>
                <span class="text-b-2 font-semibold text-primary-500">
                    @php
                        $rateMin = Auth::user()->developerProfile?->rate_min_byproject ?? 500000;
                        $rateMax = Auth::user()->developerProfile?->rate_max_byproject ?? 1000000;
                        
                        // Function to format rate in K/M format
                        function formatRate($amount) {
                            if ($amount >= 1000000) {
                                $formatted = $amount / 1000000;
                                return number_format($formatted, $formatted == floor($formatted) ? 0 : 1) . 'M';
                            } elseif ($amount >= 1000) {
                                $formatted = $amount / 1000;
                                return number_format($formatted, $formatted == floor($formatted) ? 0 : 1) . 'K';
                            }
                            return number_format($amount, 0);
                        }
                    @endphp
                    Rp {{ formatRate($rateMin) }} - Rp {{ formatRate($rateMax) }}/project
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-600">Experience</span>
                <span class="text-b-2 font-medium text-neutral-1000">{{ Auth::user()->developerProfile?->experience_years ?? 5 }} years</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-600">Member Since</span>
                <span class="text-b-2 font-medium text-neutral-1000">{{ Auth::user()->created_at->format('M Y') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-600">Availability</span>
                <div class="relative">
                    @php
                        $availability = Auth::user()->developerProfile?->availability ?? 'available';
                        $availabilityConfig = [
                            'available' => ['color' => 'text-green-600', 'bg' => 'bg-green-100', 'label' => 'Available'],
                            'busy' => ['color' => 'text-yellow-600', 'bg' => 'bg-yellow-100', 'label' => 'Busy'],
                            'unavailable' => ['color' => 'text-red-600', 'bg' => 'bg-red-100', 'label' => 'Unavailable']
                        ];
                    @endphp
                    <button type="button" id="availability-toggle" class="flex items-center gap-2 px-3 py-1.5 rounded-lg {{ $availabilityConfig[$availability]['bg'] }} hover:opacity-80 transition">
                        <span class="w-2 h-2 rounded-full {{ $availability === 'available' ? 'bg-green-600' : ($availability === 'busy' ? 'bg-yellow-600' : 'bg-red-600') }}"></span>
                        <span id="availability-text" class="text-b-3 font-medium {{ $availabilityConfig[$availability]['color'] }}">
                            {{ $availabilityConfig[$availability]['label'] }}
                        </span>
                        <svg class="w-3 h-3 {{ $availabilityConfig[$availability]['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="availability-dropdown" class="hidden absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-neutral-200 z-10">
                        <button type="button" data-availability="available" class="availability-option w-full flex items-center gap-2 px-3 py-2 hover:bg-green-50 transition {{ $availability === 'available' ? 'bg-green-50' : '' }} rounded-t-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-b-3 text-green-600 font-medium">Available</span>
                        </button>
                        <button type="button" data-availability="busy" class="availability-option w-full flex items-center gap-2 px-3 py-2 hover:bg-yellow-50 transition {{ $availability === 'busy' ? 'bg-yellow-50' : '' }}">
                            <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M71.68,97.22,34.74,128l36.94,30.78a12,12,0,1,1-15.36,18.44l-48-40a12,12,0,0,1,0-18.44l48-40A12,12,0,0,1,71.68,97.22Zm176,21.56-48-40a12,12,0,1,0-15.36,18.44L221.26,128l-36.94,30.78a12,12,0,1,0,15.36,18.44l48-40a12,12,0,0,0,0-18.44ZM164.1,28.72a12,12,0,0,0-15.38,7.18l-64,176a12,12,0,0,0,7.18,15.37A11.79,11.79,0,0,0,96,228a12,12,0,0,0,11.28-7.9l64-176A12,12,0,0,0,164.1,28.72Z"/>
                            </svg>
                            <span class="text-b-3 text-yellow-600 font-medium">Busy</span>
                        </button>
                        <button type="button" data-availability="unavailable" class="availability-option w-full flex items-center gap-2 px-3 py-2 hover:bg-red-50 transition {{ $availability === 'unavailable' ? 'bg-red-50' : '' }} rounded-b-lg">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="text-b-3 text-red-600 font-medium">Unavailable</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Customer Stats -->
        <div class="space-y-3 mb-6 pb-6 border-b border-neutral-100">
            <div class="flex justify-between items-center">
                <span class="text-b-2 text-neutral-600">Member Since</span>
                <span class="text-b-2 font-medium text-neutral-1000">{{ Auth::user()->created_at->format('M Y') }}</span>
            </div>
        </div>
    @endif

    <!-- Verification Status -->
    <div>
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-6 h-6 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span class="text-b-1 font-medium text-neutral-700">Verification</span>
        </div>
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                @if(Auth::user()->email_verified_at)
                    <svg class="w-6 h-6 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-b-2 text-neutral-700">Email Verified</span>
                @else
                    <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-b-2 text-neutral-400">Email Not Verified</span>
                @endif
            </div>
        </div>
    </div>

    <script>
        function handleAvatarChange(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (max 2MB)
                if (file.size > 2048 * 1024) {
                    if (typeof showToast === 'function') {
                        showToast('File size must be less than 2MB', 'error');
                    } else {
                        alert('File size must be less than 2MB');
                    }
                    input.value = '';
                    return;
                }
                
                // Validate file type
                if (!file.type.match('image.*')) {
                    if (typeof showToast === 'function') {
                        showToast('Please select an image file', 'error');
                    } else {
                        alert('Please select an image file');
                    }
                    input.value = '';
                    return;
                }
                
                // Show loading state
                const cameraBtn = document.getElementById('camera-btn');
                const cameraIcon = document.getElementById('camera-icon');
                const loadingSpinner = document.getElementById('loading-spinner');
                
                cameraBtn.disabled = true;
                cameraIcon.classList.add('hidden');
                loadingSpinner.classList.remove('hidden');
                
                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
                
                // Submit via AJAX
                const formData = new FormData(document.getElementById('avatar-form'));
                
                fetch('{{ route('profile.avatar.update') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    cameraBtn.disabled = false;
                    cameraIcon.classList.remove('hidden');
                    loadingSpinner.classList.add('hidden');
                    
                    if (data.success) {
                        if (typeof showToast === 'function') {
                            showToast('Avatar updated successfully!', 'success');
                        }
                        // Update avatar URL
                        document.getElementById('avatar-preview').src = data.avatar_url;
                    } else {
                        // Revert preview on error
                        document.getElementById('avatar-preview').src = '{{ $avatarSrc }}';
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Failed to update avatar', 'error');
                        }
                    }
                    
                    // Clear input
                    input.value = '';
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset button state
                    cameraBtn.disabled = false;
                    cameraIcon.classList.remove('hidden');
                    loadingSpinner.classList.add('hidden');
                    
                    // Revert preview
                    document.getElementById('avatar-preview').src = '{{ $avatarSrc }}';
                    
                    if (typeof showToast === 'function') {
                        showToast('Failed to upload avatar. Please try again.', 'error');
                    }
                    
                    input.value = '';
                });
            }
        }

        // Show/hide camera button based on active tab
        function updateCameraButtonVisibility() {
            const avatarUploadBtn = document.querySelector('.avatar-upload-btn');
            const profileTabActive = !document.getElementById('content-profile').classList.contains('hidden');
            
            if (avatarUploadBtn) {
                avatarUploadBtn.style.display = profileTabActive ? 'block' : 'none';
            }
        }

        // Initial check
        document.addEventListener('DOMContentLoaded', updateCameraButtonVisibility);

        // Availability toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const availabilityToggle = document.getElementById('availability-toggle');
            const availabilityDropdown = document.getElementById('availability-dropdown');
            const availabilityOptions = document.querySelectorAll('.availability-option');
            const availabilityText = document.getElementById('availability-text');
            const availabilityBadge = document.getElementById('availability-badge');
            
            if (!availabilityToggle) return;
            
            // Toggle dropdown
            availabilityToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                availabilityDropdown.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!availabilityToggle.contains(e.target) && !availabilityDropdown.contains(e.target)) {
                    availabilityDropdown.classList.add('hidden');
                }
            });
            
            // Handle availability change
            availabilityOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const newAvailability = this.getAttribute('data-availability');
                    updateAvailability(newAvailability);
                });
            });
            
            function updateAvailability(availability) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                
                fetch('{{ route('profile.availability.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ availability: availability })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI
                        const config = {
                            'available': {
                                label: 'Available',
                                color: 'text-green-600',
                                bg: 'bg-green-100',
                                badgeBg: 'bg-green-500',
                                hoverBg: 'hover:opacity-80'
                            },
                            'busy': {
                                label: 'Busy',
                                color: 'text-yellow-600',
                                bg: 'bg-yellow-100',
                                badgeBg: 'bg-yellow-500',
                                hoverBg: 'hover:opacity-80'
                            },
                            'unavailable': {
                                label: 'Unavailable',
                                color: 'text-red-600',
                                bg: 'bg-red-100',
                                badgeBg: 'bg-red-500',
                                hoverBg: 'hover:opacity-80'
                            }
                        };
                        
                        const current = config[availability];
                        
                        // Update button
                        availabilityToggle.className = `flex items-center gap-2 px-3 py-1.5 rounded-lg ${current.bg} ${current.hoverBg} transition`;
                        
                        // Update text
                        availabilityText.textContent = current.label;
                        availabilityText.className = `text-b-3 font-medium ${current.color}`;
                        
                        // Update dot in button
                        const dot = availabilityToggle.querySelector('span.w-2');
                        if (dot) {
                            dot.className = `w-2 h-2 rounded-full ${current.badgeBg.replace('bg-', 'bg-').replace('-500', '-600')}`;
                        }
                        
                        // Update arrow icon color
                        const arrow = availabilityToggle.querySelector('svg');
                        if (arrow) {
                            arrow.className = `w-3 h-3 ${current.color}`;
                        }
                        
                        // Update badge indicator
                        if (availabilityBadge) {
                            availabilityBadge.className = `absolute -top-1 -right-1 w-8 h-8 ${current.badgeBg} rounded-full flex items-center justify-center border-2 border-white shadow-sm`;
                            availabilityBadge.setAttribute('title', current.label);
                            
                            // Update badge icon
                            let iconSvg = '';
                            if (availability === 'available') {
                                iconSvg = '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
                            } else if (availability === 'busy') {
                                iconSvg = '<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 256 256"><path d="M71.68,97.22,34.74,128l36.94,30.78a12,12,0,1,1-15.36,18.44l-48-40a12,12,0,0,1,0-18.44l48-40A12,12,0,0,1,71.68,97.22Zm176,21.56-48-40a12,12,0,1,0-15.36,18.44L221.26,128l-36.94,30.78a12,12,0,1,0,15.36,18.44l48-40a12,12,0,0,0,0-18.44ZM164.1,28.72a12,12,0,0,0-15.38,7.18l-64,176a12,12,0,0,0,7.18,15.37A11.79,11.79,0,0,0,96,228a12,12,0,0,0,11.28-7.9l64-176A12,12,0,0,0,164.1,28.72Z"/></svg>';
                            } else {
                                iconSvg = '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>';
                            }
                            availabilityBadge.innerHTML = iconSvg;
                        }
                        
                        // Update active state in dropdown
                        availabilityOptions.forEach(opt => {
                            const optAvail = opt.getAttribute('data-availability');
                            opt.classList.remove('bg-green-50', 'bg-yellow-50', 'bg-red-50');
                            if (optAvail === availability) {
                                const bgClass = availability === 'available' ? 'bg-green-50' : (availability === 'busy' ? 'bg-yellow-50' : 'bg-red-50');
                                opt.classList.add(bgClass);
                            }
                        });
                        
                        // Close dropdown
                        availabilityDropdown.classList.add('hidden');
                        
                        // Show success message
                        if (typeof showToast === 'function') {
                            showToast(`Availability updated to ${current.label}`, 'success');
                        }
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Failed to update availability', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showToast === 'function') {
                        showToast('Failed to update availability. Please try again.', 'error');
                    }
                });
            }
        });
    </script>
</div>
