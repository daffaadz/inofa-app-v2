<x-app-layout>
    <x-slot name="title">Post a New Project - Budget</x-slot>

    <div class="min-h-screen bg-neutral-10 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 mt-16">
                <h1 class="text-h-3 text-neutral-1000 mb-2">Post a New Project</h1>
                <p class="text-b-1 text-neutral-500">Tell us about your project and we'll help you find the perfect
                    developer</p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-12">
                <div class="flex items-start justify-between max-w-2xl mx-auto">
                    <!-- Step 1 - Completed -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Details</span>
                    </div>

                    <div class="flex-1 h-1 bg-primary-500 mx-4 mt-6"></div>

                    <!-- Step 2 - Completed -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Skills</span>
                    </div>

                    <div class="flex-1 h-1 bg-primary-500 mx-4 mt-6"></div>

                    <!-- Step 3 - Active -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center text-b-1 font-semibold mb-2">
                            3
                        </div>
                        <span class="text-b-2 font-medium text-primary-500 mt-6">Budget</span>
                    </div>

                    <div class="flex-1 h-1 bg-neutral-200 mx-4 mt-6"></div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-neutral-200 text-neutral-500 flex items-center justify-center text-b-1 font-semibold mb-2">
                            4
                        </div>
                        <span class="text-b-2 text-neutral-500 mt-6">Requirements</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                <h2 class="text-h-5 text-neutral-1000 mb-2">Budget & Timeline</h2>
                <p class="text-b-2 text-neutral-500 mb-8">Set your budget and expected delivery date</p>

                <form id="projectBudgetForm" action="{{ route('consumer.project.storeBudget') }}" method="POST">
                    @csrf

                    <!-- Budget Input -->
                    <div class="mb-8">
                        <label for="budget" class="block text-b-1 font-medium text-neutral-800 mb-2">
                            Project Budget (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-b-1 text-neutral-500 font-medium">Rp</span>
                            <input type="number" id="budget" name="budget" min="50000" step="10000"
                                placeholder="1.000.000"
                                class="w-full pl-12 pr-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-b-1 text-neutral-800"
                                required>
                        </div>
                        <p class="text-b-3 text-neutral-500 mt-1">Minimum budget: Rp 50.000</p>
                    </div>

                    <!-- Budget Range Suggestions -->
                    <div class="mb-8">
                        <label class="block text-b-1 font-medium text-neutral-800 mb-4">
                            Or choose a budget range
                        </label>

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button"
                                class="budget-range p-4 border-2 border-neutral-300 bg-white text-neutral-700 rounded-lg text-b-1 font-medium hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="setBudget(500000, this)">
                                Rp 500.000 - Rp 1.000.000
                            </button>
                            <button type="button"
                                class="budget-range p-4 border-2 border-neutral-300 bg-white text-neutral-700 rounded-lg text-b-1 font-medium hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="setBudget(2000000, this)">
                                Rp 1.000.000 - Rp 2.000.000
                            </button>
                            <button type="button"
                                class="budget-range p-4 border-2 border-neutral-300 bg-white text-neutral-700 rounded-lg text-b-1 font-medium hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="setBudget(5000000, this)">
                                Rp 2.000.000 - Rp 5.000.000
                            </button>
                            <button type="button"
                                class="budget-range p-4 border-2 border-neutral-300 bg-white text-neutral-700 rounded-lg text-b-1 font-medium hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="setBudget(10000000, this)">
                                Rp 5.000.000 - Rp 10.000.000
                            </button>
                            <button type="button"
                                class="budget-range col-span-2 p-4 border-2 border-neutral-300 bg-white text-neutral-700 rounded-lg text-b-1 font-medium hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="setBudget(15000000, this)">
                                Rp 10.000.000+
                            </button>
                        </div>
                    </div>

                    <!-- Expected Delivery Date -->
                    <div class="mb-8">
                        <label for="deadline" class="block text-b-1 font-medium text-neutral-800 mb-2">
                            Expected Delivery Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" id="deadline" name="deadline"
                                class="w-full px-4 py-3 pl-12 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-b-1 text-neutral-800"
                                required>
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-b-3 text-neutral-500 mt-1">Deadline must be at least tomorrow</p>
                    </div>

                    <!-- Project Summary -->
                    <div class="bg-green-100 border border-green-200 rounded-lg p-6 mb-8">
                        <h3 class="text-b-1 font-semibold text-neutral-800 mb-4">Project Summary</h3>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-b-2 text-neutral-700">Budget:</span>
                                <span class="text-b-1 font-semibold text-primary-500" id="summaryBudget">-</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-b-2 text-neutral-700">Delivery Date:</span>
                                <span class="text-b-1 font-semibold text-neutral-800" id="summaryDeadline">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('consumer.project.createSkills') }}"
                            class="inline-flex items-center px-6 py-3 border border-primary-500 text-primary-500 rounded-lg text-b-1 font-medium hover:bg-primary-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg text-b-1 font-medium hover:bg-primary-600 transition-colors">
                            Next
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step Indicator -->
            <div class="text-center">
                <p class="text-b-2 text-neutral-500">Step 3 of 4</p>
            </div>
        </div>
    </div>

    <script>
        // Set minimum date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const minDate = tomorrow.toISOString().split('T')[0];
        document.getElementById('deadline').min = minDate;

        function setBudget(amount, button) {
            // Remove active state from all buttons
            document.querySelectorAll('.budget-range').forEach(btn => {
                btn.classList.remove('border-primary-500', 'bg-primary-500', 'text-white');
                btn.classList.add('border-neutral-300', 'bg-white', 'text-neutral-700');
            });

            // Add active state to clicked button
            button.classList.remove('border-neutral-300', 'bg-white', 'text-neutral-700');
            button.classList.add('border-primary-500', 'bg-primary-500', 'text-white');

            // Set budget input
            document.getElementById('budget').value = amount;

            // Update summary
            updateSummary();
        }

        // Update budget summary when typing
        document.getElementById('budget').addEventListener('input', function() {
            // Clear range button selections
            document.querySelectorAll('.budget-range').forEach(btn => {
                btn.classList.remove('border-primary-500', 'bg-primary-500', 'text-white');
                btn.classList.add('border-neutral-300', 'bg-white', 'text-neutral-700');
            });

            updateSummary();
        });

        // Update deadline summary
        document.getElementById('deadline').addEventListener('change', function() {
            updateSummary();
        });

        function updateSummary() {
            const budget = document.getElementById('budget').value;
            const deadline = document.getElementById('deadline').value;

            if (budget) {
                const formattedBudget = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(budget);
                document.getElementById('summaryBudget').textContent = formattedBudget;
            } else {
                document.getElementById('summaryBudget').textContent = '-';
            }

            if (deadline) {
                const date = new Date(deadline);
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const formattedDate = date.toLocaleDateString('en-US', options);
                document.getElementById('summaryDeadline').textContent = formattedDate;
            } else {
                document.getElementById('summaryDeadline').textContent = '-';
            }
        }

        // Form submission
        document.getElementById('projectBudgetForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const budget = document.getElementById('budget').value;
            const deadline = document.getElementById('deadline').value;

            if (!budget || !deadline) {
                alert('Please fill in all required fields');
                return;
            }

            if (parseInt(budget) < 50000) {
                alert('Minimum budget is Rp 50.000');
                return;
            }

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.status) {
                    window.location.href = "{{ route('consumer.project.createRequirements') }}";
                } else {
                    alert('Error: ' + (data.message || 'Failed to save budget'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    </script>
</x-app-layout>
