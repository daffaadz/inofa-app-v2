<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-h-6 text-neutral-1000">My Portfolio</h3>
        </div>
        <button type="button" onclick="toggleAddPortfolioModal()"
            class="px-6 py-2.5 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Project
        </button>
    </div>

    @if (session('status') === 'portfolio-added')
        <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-lg text-b-2">
            Portfolio added successfully!
        </div>
    @endif

    @if (session('status') === 'portfolio-deleted')
        <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-lg text-b-2">
            Portfolio deleted successfully!
        </div>
    @endif

    <!-- Portfolio Grid -->
    @if ($user->portfolios && $user->portfolios->count() > 0)
        <div class="grid grid-cols-2 gap-6">
            @foreach ($user->portfolios as $portfolio)
                <div
                    class="group relative bg-white border border-neutral-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <div class="relative h-48 bg-neutral-200 overflow-hidden">
                        @if ($portfolio->image_url)
                            <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-neutral-800">
                                <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        <!-- Hover Actions -->
                        <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                            @if ($portfolio->project_url)
                                <a href="{{ $portfolio->project_url }}" target="_blank"
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-50 transition">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('portfolios.destroy', $portfolio) }}"
                                onsubmit="return confirm('Are you sure you want to delete this portfolio item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="text-b-1 font-semibold text-neutral-1000 mb-2">{{ $portfolio->title }}</h4>
                        <p class="text-b-3 text-neutral-600 mb-3 line-clamp-2">
                            {{ $portfolio->description }}
                        </p>
                        @if ($portfolio->technologies)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($portfolio->technologies as $tech)
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 text-b-4 font-medium rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <p class="text-b-1 text-neutral-500">No portfolio items yet</p>
            <p class="text-b-3 text-neutral-400">Click "Add Project" to showcase your work</p>
        </div>
    @endif

    <!-- Add Portfolio Modal -->
    <div id="addPortfolioModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-h-6 text-neutral-1000 mb-6">Add Portfolio Item</h3>

            <form method="POST" action="{{ route('portfolios.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                        Project Title<span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" placeholder="Enter project title"
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                </div>

                <div>
                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">
                        Description<span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="4" placeholder="Describe your project"
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required></textarea>
                </div>

                <div>
                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">Image</label>
                    <input type="file" name="image_file" accept="image/*"
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    <p class="mt-1 text-b-4 text-neutral-400">Or enter image URL below</p>
                </div>

                <div>
                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">Image URL</label>
                    <input type="url" name="image_url" placeholder="https://example.com/image.jpg"
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                </div>

                <div>
                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">Technologies</label>
                    <input type="text" name="technologies"
                        placeholder="React, Node.js, PostgreSQL (comma separated)"
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                </div>

                <div>
                    <label class="block text-b-2 font-medium text-neutral-700 mb-2">Project Link</label>
                    <input type="url" name="project_url" placeholder="https://project-demo.com"
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="toggleAddPortfolioModal()"
                        class="flex-1 px-6 py-2.5 border border-neutral-200 text-neutral-700 text-b-1 font-medium rounded-lg hover:bg-neutral-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-6 py-2.5 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 transition">
                        Add Project
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleAddPortfolioModal() {
            const modal = document.getElementById('addPortfolioModal');
            modal.classList.toggle('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('addPortfolioModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                toggleAddPortfolioModal();
            }
        });
    </script>
</div>
