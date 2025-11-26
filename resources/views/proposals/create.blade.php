<x-app-layout>
    <x-slot:title>{{ __('Create Proposal - Inofa') }}</x-slot:title>

    <section class="min-h-screen flex bg-neutral-10">
        @include('partials.global-sidebar')

        <div class="flex-1 ml-[18rem] mt-16">
            <div class="max-w-7xl mx-auto px-6 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-4 mb-6">
                            <a href="{{ route('user', ['id' => $toUserId]) }}"
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-neutral-100 transition">
                                <svg class="w-5 h-5 text-neutral-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <div>
                                <h1 class="text-h-5 text-neutral-900">Create Formal Proposal</h1>
                                <p class="text-b-2 text-neutral-500 mt-1">Create a professional proposal to convince
                                    your client</p>
                            </div>
                        </div>

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-b-2">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('proposals.store') }}" method="POST" id="proposalForm">
                            @csrf
                            <input type="hidden" name="to_id" value="{{ $toUserId }}">

                            <div class="bg-white rounded-xl border border-neutral-100 p-6 mb-4">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-100">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-h-6 text-neutral-900">Basic Information</h2>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                            Project Title<span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="project_title" id="project_title"
                                            class="w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                            value="{{ old('project_title') }}"
                                            placeholder="Example: E-Commerce Mobile App Development" required>
                                    </div>

                                    <div>
                                        <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                            Client Name<span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="client_name"
                                            class="w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                            value="{{ old('client_name', $client->name ?? '') }}"
                                            placeholder="Example: Sarah Chen" required>
                                    </div>

                                    <div>
                                        <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                            Project Description<span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="description" id="description" rows="4"
                                            class="w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none"
                                            placeholder="Explain a brief overview of this project" required>{{ old('description') }}</textarea>
                                        <p class="text-b-3 text-neutral-400 mt-1"><span id="desc-counter">0</span>/500
                                            characters</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl border border-neutral-100 p-6 mb-4">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                    <h2 class="text-h-6 text-neutral-900">Project Scope</h2>
                                </div>

                                <div>
                                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                        Detailed Scope of Work<span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="scope_projects" rows="6"
                                        class="w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none"
                                        placeholder="Explain the details of work to be done, technologies used, and scope limitations..." required>{{ old('scope_projects') }}</textarea>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl border border-neutral-100 p-6 mb-4">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-h-6 text-neutral-900">Terms & Conditions</h2>
                                </div>

                                <div>
                                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                        Terms & Conditions<span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="terms" rows="6"
                                        class="w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none"
                                        placeholder="Payment terms, revisions, copyright, etc..." required>{{ old('terms') }}</textarea>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl border border-neutral-100 p-6 mb-4">
                                <div class="flex items-center gap-3 mb-6">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary-100">
                                        <svg class="w-5 h-5 text-secondary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-h-6 text-neutral-900">Price & Timeline</h2>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                            Price Details
                                        </label>
                                        <div id="price-details-container" class="space-y-2">
                                            {{-- Default Item --}}
                                            <div class="price-detail-item">
                                                <div class="grid grid-cols-12 gap-2">
                                                    <div class="col-span-7">
                                                        <input type="text" name="price_details[0][item]"
                                                            class="price-item w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                                            placeholder="Item name (e.g., UI/UX Design)">
                                                    </div>
                                                    <div class="col-span-4">
                                                        <input type="number" name="price_details[0][price]"
                                                            class="price-amount w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                                            placeholder="Price" min="0" step="1000">
                                                    </div>
                                                    <div class="col-span-1 flex items-center">
                                                        <button type="button"
                                                            class="remove-price-detail hidden w-full h-full text-red-500 hover:bg-red-50 rounded-lg transition">
                                                            <svg class="w-5 h-5 mx-auto" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" id="add-price-detail"
                                            class="mt-2 flex items-center gap-2 px-4 py-2 text-b-2 text-primary-500 hover:bg-primary-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add Item
                                        </button>
                                    </div>

                                    <div class="pt-4 border-t border-neutral-100">
                                        <label class="block text-b-2 font-medium text-neutral-900 mb-2">
                                            Total Project Cost (Final Price)
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <span class="text-neutral-500 font-bold">Rp</span>
                                            </div>
                                            {{-- Readonly input for calculation accuracy, but submitted to server --}}
                                            <input type="number" name="final_price" id="final_price"
                                                class="w-full pl-12 pr-4 py-3 bg-neutral-50 border border-neutral-200 rounded-lg text-h-6 font-bold text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition cursor-not-allowed"
                                                placeholder="0" readonly tabindex="-1">
                                        </div>
                                        <p class="text-b-3 text-neutral-400 mt-1">Total calculated automatically based
                                            on item details above.</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                                Start Date<span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" name="start_date" id="start_date"
                                                class="w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                                value="{{ old('start_date', date('Y-m-d')) }}" required>
                                        </div>

                                        <div>
                                            <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                                End Date<span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" name="end_date" id="end_date"
                                                class="w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                                value="{{ old('end_date') }}"
                                                min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl border border-neutral-100 p-6 mb-4">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-100">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-h-6 text-neutral-900">MVP Features (Minimum Viable Product)</h2>
                                </div>

                                <div id="mvp-features-container" class="space-y-3">
                                    <div
                                        class="mvp-feature-item p-4 bg-neutral-10 rounded-lg border border-neutral-200">
                                        <div class="space-y-3">
                                            <div class="grid grid-cols-12 gap-2">
                                                <div class="col-span-9">
                                                    <input type="text" name="mvp_features[0][name]"
                                                        class="w-full px-3 py-2 bg-white border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                                        placeholder="Feature name (e.g., Login System)">
                                                </div>
                                                <div class="col-span-2">
                                                    <input type="number" name="mvp_features[0][priority]"
                                                        class="w-full px-3 py-2 bg-white border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                                        placeholder="Priority" min="1">
                                                </div>
                                                <div class="col-span-1 flex items-center">
                                                    <button type="button"
                                                        class="remove-mvp-feature hidden w-full h-full text-red-500 hover:bg-red-50 rounded-lg transition">
                                                        <svg class="w-5 h-5 mx-auto" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <textarea name="mvp_features[0][description]" rows="2"
                                                class="w-full px-3 py-2 bg-white border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none"
                                                placeholder="Feature description (optional)"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="add-mvp-feature"
                                    class="mt-3 flex items-center gap-2 px-4 py-2 text-b-2 text-primary-500 hover:bg-primary-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add MVP Feature
                                </button>
                            </div>

                            <div class="bg-white rounded-xl border border-neutral-100 p-6 mb-4">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-h-6 text-neutral-900">Client Deliverables</h2>
                                </div>

                                <div>
                                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                                        Deliverables<span class="text-red-500">*</span>
                                    </label>
                                    <div id="deliverables-container" class="space-y-2">
                                        <div class="deliverable-item">
                                            <div class="flex gap-2">
                                                <span class="text-neutral-500 pt-3">•</span>
                                                <input type="text" name="deliverables[]"
                                                    class="flex-1 px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                                    placeholder="Complete source code" required>
                                                <button type="button"
                                                    class="remove-deliverable hidden px-3 py-3 text-red-500 hover:bg-red-50 rounded-lg transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="add-deliverable"
                                        class="mt-2 flex items-center gap-2 px-4 py-2 text-b-2 text-primary-500 hover:bg-primary-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add Deliverable
                                    </button>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-primary-500 hover:bg-primary-600 text-white font-medium text-b-1 rounded-xl transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Send Proposal
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl border border-neutral-100 p-6 mb-4 top-6">
                            <h3 class="text-h-7 text-neutral-900 mb-4">Proposal Preview</h3>

                            <div class="space-y-4 mb-6">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-b-1 font-medium text-neutral-900 mb-1" id="preview-title">
                                            Your Project Title</h4>
                                        <p class="text-b-3 text-neutral-500 line-clamp-2" id="preview-description">
                                            Project description will appear here...</p>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-neutral-100">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-600">Total Price</span>
                                    </div>
                                    <p class="text-h-6 text-primary-500 font-bold" id="preview-price">Rp 0</p>
                                </div>

                                <div class="pt-2 border-t border-neutral-100">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-600">Timeline</span>
                                    </div>
                                    <p class="text-b-2 text-neutral-900" id="preview-timeline">Not set</p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button type="button"
                                    class="flex-1 py-2.5 bg-primary-500 text-white text-b-2 font-medium rounded-lg">
                                    Accept
                                </button>
                                <button type="button"
                                    class="flex-1 py-2.5 bg-white border border-neutral-200 text-neutral-700 text-b-2 font-medium rounded-lg">
                                    Reject
                                </button>
                            </div>

                            <p class="text-b-3 text-neutral-400 text-center mt-3">Preview: What the client will see</p>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m0-2.122">
                                    </path>
                                </svg>
                                <h4 class="text-b-1 font-medium text-neutral-900">Proposal Tips</h4>
                            </div>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2 text-b-2 text-neutral-600">
                                    <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
                                    <span>Explain the scope of work in detail to avoid disputes later.</span>
                                </li>
                                <li class="flex items-start gap-2 text-b-2 text-neutral-600">
                                    <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
                                    <span>Break down the price into smaller components so the client understands the
                                        value they are getting.</span>
                                </li>
                                <li class="flex items-start gap-2 text-b-2 text-neutral-600">
                                    <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
                                    <span>Define MVP (Minimum Viable Product) features so final result expectations are
                                        clear.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

{{-- Script for Dynamic Forms & Live Preview --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. CONFIGURATION ---
        let priceIndex = 1;
        let mvpIndex = 1;

        // --- 2. DYNAMIC FORM FIELDS ---

        // A. Price Details Handler
        document.getElementById('add-price-detail').addEventListener('click', function() {
            const container = document.getElementById('price-details-container');
            const newRow = document.createElement('div');
            newRow.className = 'price-detail-item';
            newRow.innerHTML = `
                <div class="grid grid-cols-12 gap-2 mt-2">
                    <div class="col-span-7">
                        <input type="text" name="price_details[${priceIndex}][item]" 
                            class="price-item w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            placeholder="Additional item name">
                    </div>
                    <div class="col-span-4">
                        <input type="number" name="price_details[${priceIndex}][price]" 
                            class="price-amount w-full px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            placeholder="Price" min="0" step="1000">
                    </div>
                    <div class="col-span-1 flex items-center">
                        <button type="button" class="remove-price-detail w-full h-full text-red-500 hover:bg-red-50 rounded-lg transition flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newRow);
            priceIndex++;
            updateTotalPreview(); // Update total price immediately
        });

        // B. MVP Features Handler
        document.getElementById('add-mvp-feature').addEventListener('click', function() {
            const container = document.getElementById('mvp-features-container');
            const newRow = document.createElement('div');
            newRow.className =
                'mvp-feature-item p-4 bg-neutral-10 rounded-lg border border-neutral-200 mt-3';
            newRow.innerHTML = `
                <div class="space-y-3">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="col-span-9">
                            <input type="text" name="mvp_features[${mvpIndex}][name]" 
                                class="w-full px-3 py-2 bg-white border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                placeholder="Feature name">
                        </div>
                        <div class="col-span-2">
                            <input type="number" name="mvp_features[${mvpIndex}][priority]" 
                                class="w-full px-3 py-2 bg-white border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                                placeholder="Priority" min="1">
                        </div>
                        <div class="col-span-1 flex items-center">
                            <button type="button" class="remove-mvp-feature w-full h-full text-red-500 hover:bg-red-50 rounded-lg transition flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                    <textarea name="mvp_features[${mvpIndex}][description]" rows="2" 
                        class="w-full px-3 py-2 bg-white border border-neutral-200 rounded-lg text-b-2 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none"
                        placeholder="Feature description (optional)"></textarea>
                </div>
            `;
            container.appendChild(newRow);
            mvpIndex++;
        });

        // C. Deliverables Handler
        document.getElementById('add-deliverable').addEventListener('click', function() {
            const container = document.getElementById('deliverables-container');
            const newRow = document.createElement('div');
            newRow.className = 'deliverable-item mt-2';
            newRow.innerHTML = `
                <div class="flex gap-2">
                    <span class="text-neutral-500 pt-3">•</span>
                    <input type="text" name="deliverables[]" 
                        class="flex-1 px-4 py-3 bg-neutral-10 border border-neutral-200 rounded-lg text-b-1 text-neutral-900 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                        placeholder="Other deliverable item">
                    <button type="button" class="remove-deliverable px-3 py-3 text-red-500 hover:bg-red-50 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        });

        // Global Event Delegation for Remove Buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-price-detail')) {
                e.target.closest('.price-detail-item').remove();
                updateTotalPreview();
            }
            if (e.target.closest('.remove-mvp-feature')) {
                e.target.closest('.mvp-feature-item').remove();
            }
            if (e.target.closest('.remove-deliverable')) {
                e.target.closest('.deliverable-item').remove();
            }
        });

        // --- 3. LIVE PREVIEW LOGIC ---

        // A. Title & Description
        const titleInput = document.getElementById('project_title');
        const descInput = document.getElementById('description');
        const previewTitle = document.getElementById('preview-title');
        const previewDesc = document.getElementById('preview-description');
        const charCounter = document.getElementById('desc-counter');

        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value || 'Your Project Title';
        });

        descInput.addEventListener('input', function() {
            previewDesc.textContent = this.value || 'Project description will appear here...';
            charCounter.textContent = this.value.length;
            if (this.value.length > 500) {
                charCounter.classList.add('text-red-500');
            } else {
                charCounter.classList.remove('text-red-500');
            }
        });

        // B. Total Price Calculation
        const priceContainer = document.getElementById('price-details-container');
        const previewPrice = document.getElementById('preview-price');
        const finalPriceInput = document.getElementById('final_price');

        function updateTotalPreview() {
            let total = 0;
            const amounts = priceContainer.querySelectorAll('.price-amount');

            amounts.forEach(input => {
                const val = parseFloat(input.value) || 0;
                total += val;
            });

            // 1. Update Preview Text (IDR Format)
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            previewPrice.textContent = formatter.format(total);

            // 2. Update Input Form Final Price (Pure Number for DB)
            finalPriceInput.value = total;
        }

        // Listen for input changes in price container (using delegation)
        priceContainer.addEventListener('input', function(e) {
            if (e.target.classList.contains('price-amount')) {
                updateTotalPreview();
            }
        });

        // Initial call
        updateTotalPreview();

        // C. Date & Timeline Logic
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const previewTimeline = document.getElementById('preview-timeline');

        function updateTimelinePreview() {
            const start = startDateInput.value;
            const end = endDateInput.value;

            if (start && end) {
                const date1 = new Date(start);
                const date2 = new Date(end);

                // Calculate difference in time
                const diffTime = Math.abs(date2 - date1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                // Format dates in English
                const options = {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                };
                const startStr = date1.toLocaleDateString('en-US', options);
                const endStr = date2.toLocaleDateString('en-US', options);

                previewTimeline.textContent = `${diffDays} Days (${startStr} - ${endStr})`;
            } else {
                previewTimeline.textContent = 'Waiting for date input...';
            }
        }

        startDateInput.addEventListener('change', updateTimelinePreview);
        endDateInput.addEventListener('change', updateTimelinePreview);
    });
</script>