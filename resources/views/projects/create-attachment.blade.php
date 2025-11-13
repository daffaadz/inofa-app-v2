<x-app-layout>
    <x-slot name="title">Post a New Project - Attachments</x-slot>

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

                    <!-- Step 3 - Completed -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Budget</span>
                    </div>

                    <div class="flex-1 h-1 bg-primary-500 mx-4 mt-6"></div>

                    <!-- Step 4 - Active -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center text-b-1 font-semibold mb-2">
                            4
                        </div>
                        <span class="text-b-2 font-medium text-primary-500 mt-6">Attachments</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                <h2 class="text-h-5 text-neutral-1000 mb-2">Upload Attachments</h2>
                <p class="text-b-2 text-neutral-500 mb-8">Add any files that might help developers understand your
                    project (optional)</p>

                <form id="projectAttachmentForm" action="{{ route('consumer.project.storeAttachment') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Upload Area -->
                    <div class="mb-8">
                        <div id="dropZone"
                            class="border-2 border-dashed border-neutral-300 rounded-lg p-12 text-center hover:border-primary-500 hover:bg-primary-50 transition-colors cursor-pointer">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-primary-500 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-b-1 font-medium text-neutral-800 mb-2">Click to upload files</p>
                                <p class="text-b-2 text-neutral-500">PDF, DOC, PNG, JPG, ZIP up to 10MB each</p>
                            </div>
                            <input type="file" id="fileInput" name="attachments[]" multiple class="hidden"
                                accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip">
                        </div>

                        <!-- File List -->
                        <div id="fileList" class="mt-4 space-y-2 hidden">
                            <!-- Files will be listed here -->
                        </div>
                    </div>

                    <!-- Tips Box -->
                    <div class="bg-green-100 border border-green-200 rounded-lg p-6 mb-8">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-b-1 font-semibold text-neutral-800 mb-3">Helpful attachments include:
                                </h3>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-700">Design mockups or wireframes</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-700">Brand guidelines or style guides</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-700">Technical specifications or
                                            requirements</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('consumer.project.createBudget') }}"
                            class="inline-flex items-center px-6 py-3 border border-primary-500 text-primary-500 rounded-lg text-b-1 font-medium hover:bg-primary-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg text-b-1 font-medium hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Post Project
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step Indicator -->
            <div class="text-center">
                <p class="text-b-2 text-neutral-500">Step 4 of 4</p>
            </div>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        let selectedFiles = [];

        // Click to upload
        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-primary-500', 'bg-primary-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-primary-500', 'bg-primary-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary-500', 'bg-primary-50');

            const files = Array.from(e.dataTransfer.files);
            handleFiles(files);
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });

        function handleFiles(files) {
            selectedFiles = [...selectedFiles, ...files];
            displayFiles();
        }

        function displayFiles() {
            if (selectedFiles.length === 0) {
                fileList.classList.add('hidden');
                return;
            }

            fileList.classList.remove('hidden');
            fileList.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className =
                    'flex items-center justify-between p-3 bg-neutral-50 rounded-lg border border-neutral-200';
                fileItem.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-neutral-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div>
                            <p class="text-b-2 font-medium text-neutral-800">${file.name}</p>
                            <p class="text-b-3 text-neutral-500">${formatFileSize(file.size)}</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${index})" class="text-neutral-400 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                `;
                fileList.appendChild(fileItem);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            displayFiles();

            // Update file input
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Form submission
        document.getElementById('projectAttachmentForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Add files to formData
            selectedFiles.forEach((file) => {
                formData.append('attachments[]', file);
            });

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
                    // Final submit to store all data
                    const finalResponse = await fetch("{{ route('consumer.project.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    });

                    const finalData = await finalResponse.json();

                    if (finalData.status) {
                        // Redirect to success page or project list
                        window.location.href = "{{ route('consumer.project.index') }}";
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
</x-app-layout>
