<section>
    <header>
        <h2 class="text-h-7 text-neutral-1000 mb-2 font-semibold">
            {{ __('Payment Details') }}
        </h2>
        <p class="text-b-1 text-neutral-600 mb-6">
            {{ __('Manage your bank account information for receiving payments.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.payment-details.update') }}" class="space-y-6" id="payment-details-form">
        @csrf
        @method('patch')

        <!-- Bank Selection -->
        <div>
            <label for="bank_name" class="block text-b-2 font-medium text-neutral-800 mb-2">
                {{ __('Bank Name') }} <span class="text-red-500">*</span>
            </label>
            <select id="bank_name" name="bank_name" 
                class="mt-1 block w-full rounded-lg border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-b-2 py-2.5 px-3" 
                required>
                <option value="">{{ __('Select Bank') }}</option>
                <option value="BCA" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                <option value="Mandiri" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                <option value="BRI" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                <option value="BNI" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                <option value="CIMB Niaga" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                <option value="Permata" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'Permata' ? 'selected' : '' }}>Bank Permata</option>
                <option value="Danamon" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'Danamon' ? 'selected' : '' }}>Bank Danamon</option>
                <option value="BTN" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'BTN' ? 'selected' : '' }}>Bank Tabungan Negara (BTN)</option>
                <option value="Panin" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'Panin' ? 'selected' : '' }}>Bank Panin</option>
                <option value="OCBC NISP" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                <option value="Maybank" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'Maybank' ? 'selected' : '' }}>Maybank Indonesia</option>
                <option value="BSI" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'BSI' ? 'selected' : '' }}>Bank Syariah Indonesia (BSI)</option>
                <option value="Jenius" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'Jenius' ? 'selected' : '' }}>Jenius (BTPN)</option>
                <option value="Gopay" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'Gopay' ? 'selected' : '' }}>Gopay</option>
                <option value="OVO" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'OVO' ? 'selected' : '' }}>OVO</option>
                <option value="DANA" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'DANA' ? 'selected' : '' }}>DANA</option>
                <option value="ShopeePay" {{ old('bank_name', $user->developerProfile->bank_name ?? '') == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
        </div>

        <!-- Account Number Input -->
        <div>
            <label for="account_number" class="block text-b-2 font-medium text-neutral-800 mb-2">
                {{ __('Account Number') }} <span class="text-red-500">*</span>
            </label>
            <input id="account_number" 
                name="account_number" 
                type="text" 
                class="mt-1 block w-full rounded-lg border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-b-2 py-2.5 px-3" 
                value="{{ old('account_number', $user->developerProfile->account_number ?? '') }}" 
                placeholder="Enter your account number"
                required 
                pattern="[0-9]+" 
                maxlength="20"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
            <p class="mt-1 text-b-3 text-neutral-500">{{ __('Enter numbers only') }}</p>
            <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="button" 
                onclick="showPaymentConfirmationModal()"
                class="inline-flex items-center px-6 py-2.5 bg-primary-500 border border-transparent rounded-lg font-medium text-b-2 text-white hover:bg-primary-600 focus:bg-primary-600 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Save Payment Details') }}
            </button>

            @if (session('status') === 'payment-details-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-b-2 text-green-600 font-medium">{{ __('Payment details saved successfully.') }}</p>
            @endif
        </div>
    </form>

    <!-- Confirmation Modal -->
    <div id="payment-confirmation-modal" class="fixed inset-0 bg-neutral-900/50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all" onclick="event.stopPropagation()">
                <!-- Modal Header -->
                <div class="p-6 border-b border-neutral-100">
                    <div class="flex items-center gap-4">
                        <div class="bg-primary-50 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-h-7 font-semibold text-neutral-1000">
                                {{ __('Confirm Payment Details') }}
                            </h3>
                            <p class="text-b-3 text-neutral-600 mt-1">
                                {{ __('Please verify your information') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4">
                    <div class="bg-neutral-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between items-start">
                            <span class="text-b-2 text-neutral-600">{{ __('Bank Name:') }}</span>
                            <span class="text-b-2 font-semibold text-neutral-1000" id="confirm-bank-name"></span>
                        </div>
                        <div class="border-t border-neutral-200"></div>
                        <div class="flex justify-between items-start">
                            <span class="text-b-2 text-neutral-600">{{ __('Account Number:') }}</span>
                            <span class="text-b-2 font-semibold text-neutral-1000 font-mono" id="confirm-account-number"></span>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-b-3 text-yellow-800 font-medium">
                                    {{ __('Important Notice') }}
                                </p>
                                <p class="text-b-3 text-yellow-700 mt-1">
                                    {{ __('Please ensure your bank account information is correct. This will be used for receiving project payments.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-6 border-t border-neutral-100 flex gap-3">
                    <button type="button" 
                        onclick="hidePaymentConfirmationModal()"
                        class="flex-1 px-4 py-2.5 bg-neutral-100 border border-neutral-200 rounded-lg font-medium text-b-2 text-neutral-700 hover:bg-neutral-200 focus:outline-none focus:ring-2 focus:ring-neutral-400 transition">
                        {{ __('Cancel') }}
                    </button>
                    <button type="button" 
                        onclick="submitPaymentDetails()"
                        class="flex-1 px-4 py-2.5 bg-primary-500 border border-transparent rounded-lg font-medium text-b-2 text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        {{ __('Confirm & Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPaymentConfirmationModal() {
            const bankName = document.getElementById('bank_name').value;
            const accountNumber = document.getElementById('account_number').value;

            // Validate inputs
            if (!bankName) {
                showToast('Please select a bank', 'error');
                return;
            }

            if (!accountNumber) {
                showToast('Please enter account number', 'error');
                return;
            }

            // Show selected bank name (from option text)
            const bankSelect = document.getElementById('bank_name');
            const bankText = bankSelect.options[bankSelect.selectedIndex].text;
            
            document.getElementById('confirm-bank-name').textContent = bankText;
            document.getElementById('confirm-account-number').textContent = accountNumber;

            // Show modal
            document.getElementById('payment-confirmation-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hidePaymentConfirmationModal() {
            document.getElementById('payment-confirmation-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function submitPaymentDetails() {
            document.getElementById('payment-details-form').submit();
        }

        // Close modal when clicking outside
        document.getElementById('payment-confirmation-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                hidePaymentConfirmationModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hidePaymentConfirmationModal();
            }
        });
    </script>
</section>
