<x-app-layout>
    <x-slot name="title">{{ $developer->name }} - Developer Profile</x-slot>

    <div class="bg-neutral-10 min-h-screen">
        <!-- Developer Header Section -->
        <div class="bg-white border-b border-neutral-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-row gap-6 mt-16">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        @php
                            $src = Str::startsWith($developer->avatar, 'http')
                                ? $developer->avatar
                                : asset('storage/' . $developer->avatar);
                        @endphp
                        <img src="{{ $developer->avatar ? $src : 'https://ui-avatars.com/api/?name=' . urlencode($developer->name) . '&size=120' }}"
                            alt="{{ $developer->name }}"
                            class="w-40 h-40 rounded-lg object-cover border-4 border-primary-400">
                    </div>

                    <!-- Developer Info -->
                    <div class="flex-grow">
                        <h1 class="text-h-2 font-bold text-neutral-900 mb-1">{{ $developer->name }}</h1>
                        <p class="text-h-7 text-neutral-600 mb-3">
                            {{ $developer->developerProfile->headline ?? 'Senior Full-Stack Developer' }}
                        </p>

                        <div class="flex flex-col items-start justify-center gap-4 mb-4">
                            <div class="flex flex-row gap-4">
                                <!-- Location -->
                                @if ($developer->location)
                                    <div class="flex items-center gap-1 text-b-2 text-neutral-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $developer->location }}
                                    </div>
                                @endif

                                <!-- Member Since -->
                                <div class="flex items-center gap-1 text-b-2 text-neutral-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Member since {{ $developer->created_at->format('Y') }}
                                </div>
                            </div>

                            <div class="flex flex-row gap-4">
                                <!-- Rating -->
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= floor($averageRating ?? 0) ? 'text-yellow-500' : 'text-neutral-200' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span
                                        class="text-b-2 text-neutral-700 font-medium">{{ number_format($averageRating ?? 0, 1) }}</span>
                                    <span class="text-b-2 text-neutral-500">({{ $totalReviews }} reviews)</span>
                                </div>

                                <!-- Availability Badge -->
                                @if ($developer->developerProfile)
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full text-b-3 font-medium
                                   {{ $developer->developerProfile->availability === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                   {{ $developer->developerProfile->availability === 'busy' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                   {{ $developer->developerProfile->availability === 'unavailable' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($developer->developerProfile->availability) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <button
                                class="inline-flex gap-2 items-center px-6 py-3 bg-primary-500 text-white text-b-2 font-medium rounded-lg hover:bg-primary-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-auto" fill="currentColor"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M128,24A104,104,0,0,0,36.18,176.88L24.83,210.93a16,16,0,0,0,20.24,20.24l34.05-11.35A104,104,0,1,0,128,24Zm0,192a87.87,87.87,0,0,1-44.06-11.81,8,8,0,0,0-6.54-.67L40,216,52.47,178.6a8,8,0,0,0-.66-6.54A88,88,0,1,1,128,216Z">
                                    </path>
                                </svg>
                                Send Message
                            </button>
                            <button
                                class="inline-flex items-center px-6 py-2.5 bg-white text-primary-500 text-b-2 font-medium rounded-lg border-2 border-primary-500 hover:bg-primary-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-auto mr-2" fill="currentColor"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z">
                                    </path>
                                </svg>
                                Contact
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- About Section -->
            <section class="p-6 mb-6">
                <h2 class="text-h-4 text-neutral-900 mb-4">About</h2>
                <p class="text-b-1 text-neutral-700 leading-relaxed mb-12 max-w-4xl">
                    {{ $developer->bio ?? "I'm a passionate full-stack developer with over 5 years of experience building scalable web applications. My expertise spans across creative JavaScript frameworks, backend development, and cloud infrastructure. I specialize in React, Node.js and Laravel. I'm committed to delivering high-quality code and exceptional user experiences." }}
                </p>

                <!-- Experience Highlights -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Experience Years -->
                    <div class="bg-white rounded-xl border-2 border-neutral-200 text-start p-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-h-7 text-neutral-900 mb-1">
                            {{ $developer->developerProfile->experience_years ?? 5 }} Years Experience</h3>
                        <p class="text-b-2 text-neutral-600">Create and develop projects</p>
                    </div>

                    <!-- Full-Stack -->
                    <div class="bg-white rounded-xl border-2 border-neutral-200 text-start p-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-500" fill="currentColor"
                                stroke="currentColor" viewBox="0 0 256 256">
                                <path
                                    d="M251.76,88.94l-120-64a8,8,0,0,0-7.52,0l-120,64a8,8,0,0,0,0,14.12L32,117.87v48.42a15.91,15.91,0,0,0,4.06,10.65C49.16,191.53,78.51,216,128,216a130,130,0,0,0,48-8.76V240a8,8,0,0,0,16,0V199.51a115.63,115.63,0,0,0,27.94-22.57A15.91,15.91,0,0,0,224,166.29V117.87l27.76-14.81a8,8,0,0,0,0-14.12ZM128,200c-43.27,0-68.72-21.14-80-33.71V126.4l76.24,40.66a8,8,0,0,0,7.52,0L176,143.47v46.34C163.4,195.69,147.52,200,128,200Zm80-33.75a97.83,97.83,0,0,1-16,14.25V134.93l16-8.53ZM188,118.94l-.22-.13-56-29.87a8,8,0,0,0-7.52,14.12L171,128l-43,22.93L25,96,128,41.07,231,96Z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-h-7 text-neutral-900 mb-1">Educations</h3>
                        <p class="text-b-2 text-neutral-600">{{ $educations }}</p>
                    </div>

                    <!-- Clean Code -->
                    <div class="bg-white rounded-xl border-2 border-neutral-200 text-start p-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-500" fill="currentColor"
                                stroke="currentColor" viewBox="0 0 256 256">
                                <path
                                    d="M128,88a40,40,0,1,0,40,40A40,40,0,0,0,128,88Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,152ZM240,56H16a8,8,0,0,0-8,8V192a8,8,0,0,0,8,8H240a8,8,0,0,0,8-8V64A8,8,0,0,0,240,56ZM193.65,184H62.35A56.78,56.78,0,0,0,24,145.65v-35.3A56.78,56.78,0,0,0,62.35,72h131.3A56.78,56.78,0,0,0,232,110.35v35.3A56.78,56.78,0,0,0,193.65,184ZM232,93.37A40.81,40.81,0,0,1,210.63,72H232ZM45.37,72A40.81,40.81,0,0,1,24,93.37V72ZM24,162.63A40.81,40.81,0,0,1,45.37,184H24ZM210.63,184A40.81,40.81,0,0,1,232,162.63V184Z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-h-7 text-neutral-900 mb-1">My Rate Range</h3>
                        <p class="text-b-2 text-neutral-600">Rp{{ number_format($rateMin, 0, ',', '.') }} -
                            Rp{{ number_format($rateMax, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- Skills & Expertise -->
            <section
                class="bg-gradient-to-br from-secondary-100 via-white to-secondary-100 rounded-lg shadow-sm p-8 mb-6">
                <div class="flex items-center justify-between mb-12">
                    <h2 class="text-h-4 text-neutral-900">Skills & Expertise</h2>
                    <button
                        class="flex flex-row justify-start items-center gap-2 text-b-2 mr-4 text-primary-500 font-medium hover:text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-auto" fill="currentColor"
                            stroke="currentColor" viewBox="0 0 256 256">
                            <path
                                d="M225.86,102.82c-3.77-3.94-7.67-8-9.14-11.57-1.36-3.27-1.44-8.69-1.52-13.94-.15-9.76-.31-20.82-8-28.51s-18.75-7.85-28.51-8c-5.25-.08-10.67-.16-13.94-1.52-3.56-1.47-7.63-5.37-11.57-9.14C146.28,23.51,138.44,16,128,16s-18.27,7.51-25.18,14.14c-3.94,3.77-8,7.67-11.57,9.14C88,40.64,82.56,40.72,77.31,40.8c-9.76.15-20.82.31-28.51,8S41,67.55,40.8,77.31c-.08,5.25-.16,10.67-1.52,13.94-1.47,3.56-5.37,7.63-9.14,11.57C23.51,109.72,16,117.56,16,128s7.51,18.27,14.14,25.18c3.77,3.94,7.67,8,9.14,11.57,1.36,3.27,1.44,8.69,1.52,13.94.15,9.76.31,20.82,8,28.51s18.75,7.85,28.51,8c5.25.08,10.67.16,13.94,1.52,3.56,1.47,7.63,5.37,11.57,9.14C109.72,232.49,117.56,240,128,240s18.27-7.51,25.18-14.14c3.94-3.77,8-7.67,11.57-9.14,3.27-1.36,8.69-1.44,13.94-1.52,9.76-.15,20.82-.31,28.51-8s7.85-18.75,8-28.51c.08-5.25.16-10.67,1.52-13.94,1.47-3.56,5.37-7.63,9.14-11.57C232.49,146.28,240,138.44,240,128S232.49,109.73,225.86,102.82Zm-11.55,39.29c-4.79,5-9.75,10.17-12.38,16.52-2.52,6.1-2.63,13.07-2.73,19.82-.1,7-.21,14.33-3.32,17.43s-10.39,3.22-17.43,3.32c-6.75.1-13.72.21-19.82,2.73-6.35,2.63-11.52,7.59-16.52,12.38S132,224,128,224s-9.15-4.92-14.11-9.69-10.17-9.75-16.52-12.38c-6.1-2.52-13.07-2.63-19.82-2.73-7-.1-14.33-.21-17.43-3.32s-3.22-10.39-3.32-17.43c-.1-6.75-.21-13.72-2.73-19.82-2.63-6.35-7.59-11.52-12.38-16.52S32,132,32,128s4.92-9.15,9.69-14.11,9.75-10.17,12.38-16.52c2.52-6.1,2.63-13.07,2.73-19.82.1-7,.21-14.33,3.32-17.43S70.51,56.9,77.55,56.8c6.75-.1,13.72-.21,19.82-2.73,6.35-2.63,11.52-7.59,16.52-12.38S124,32,128,32s9.15,4.92,14.11,9.69,10.17,9.75,16.52,12.38c6.1,2.52,13.07,2.63,19.82,2.73,7,.1,14.33.21,17.43,3.32s3.22,10.39,3.32,17.43c.1,6.75.21,13.72,2.73,19.82,2.63,6.35,7.59,11.52,12.38,16.52S224,124,224,128,219.08,137.15,214.31,142.11ZM173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34Z">
                            </path>
                        </svg> Verified</button>
                </div>

                <!-- Skills -->
                @if ($skills->count() > 0)
                    <div class="mb-6">
                        <div class="flex flex-wrap max-w-3xl gap-4">
                            @foreach ($skills as $skill)
                                <span
                                    class="inline-flex items-center px-6 py-3 bg-transparent border border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white transition-all duration-500 text-h-7 font-normal rounded-full">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Certifications -->
                @if (!empty($certifications) && is_array($certifications) && count($certifications) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        @foreach ($certifications as $cert)
                            <div class="flex items-center gap-2 text-b-2 text-neutral-700">
                                <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $cert }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- I Deliver Results -->
            <section class="p-6 mb-6">
                <h2 class="text-h-4 text-neutral-900 text-center mb-16">My Journey on Inofa</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Projects -->
                    <div class="bg-white border-2 border-neutral-200 rounded-xl p-8 text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-h-4 text-neutral-900 font-bold mb-1">{{ number_format($projectsCompleted) }}+
                        </div>
                        <p class="text-b-1 text-neutral-600">Projects Successfully Completed</p>
                    </div>

                    <!-- Satisfaction -->
                    <div class="bg-white border-2 border-neutral-200 rounded-xl p-8 text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                                </path>
                            </svg>
                        </div>
                        <div class="text-h-4 text-neutral-900 font-bold mb-1">{{ number_format($totalReviews) }}+
                        </div>
                        <p class="text-b-1 text-neutral-600">Total Client Reviews</p>
                    </div>

                    <!-- Delivery -->
                    <div class="bg-white border-2 border-neutral-200 rounded-xl p-8 text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="text-h-4 text-neutral-900 font-bold mb-1">
                            {{ number_format($stats['success_rate']) }}%</div>
                        <p class="text-b-1 text-neutral-600">Project Complete over Total Projects</p>
                    </div>
                </div>
            </section>

            <!-- Portfolio -->
            <section class="p-6 mb-6">
                <h2 class="text-h-4 text-neutral-900 mb-6">Portfolio</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($developer->portfolios as $portfolio)
                        <div class="group">
                            <div class="relative overflow-hidden rounded-lg mb-4 aspect-video bg-neutral-100">
                                @if ($portfolio->image_url)
                                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-neutral-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-h-7 text-neutral-900 mb-2">{{ $portfolio->title }}</h3>
                            <p class="text-b-2 text-neutral-600 mb-3 line-clamp-2">{{ $portfolio->description }}</p>

                            @if ($portfolio->technologies)
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach (json_decode($portfolio->technologies, true) ?? [] as $tech)
                                        <span
                                            class="px-2 py-1 bg-neutral-100 text-neutral-700 text-b-3 rounded">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if ($portfolio->project_url)
                                <a href="{{ $portfolio->project_url }}" target="_blank"
                                    class="inline-flex items-center text-b-2 text-primary-500 font-medium hover:text-primary-600">
                                    View Portfolio
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-xl border-2 border-neutral-200 col-span-2 text-center py-8">
                            <p class="text-b-1 text-neutral-500">No portfolio items yet.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Client Reviews -->
            <section class="p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-h-4 text-neutral-900">Client Reviews</h2>
                    <span class="text-b-1 font-bold mr-2 text-primary-500">{{ $totalReviews }} reviews</span>
                </div>

                <div class="space-y-6">
                    @forelse($reviews as $review)
                        <div class="bg-white border-l-4 border-primary-500 rounded-xl p-6 shadow-sm">
                            <div class="flex items-start gap-4">
                                <!-- Avatar -->
                                <img src="{{ $review->consumer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->consumer->name) . '&size=48' }}"
                                    alt="{{ $review->consumer->name }}" class="w-12 h-12 rounded-full flex-shrink-0">

                                <div class="flex-grow">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <h4 class="text-b-1 font-semibold text-neutral-900">
                                                {{ $review->consumer->name }}</h4>
                                            <p class="text-b-3 text-neutral-500">
                                                {{ $review->created_at->format('F Y') }}</p>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-neutral-200' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>

                                    <p class="text-b-2 text-neutral-700">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border-2 border-neutral-200 rounded-xl text-center py-8">
                            <p class="text-b-1 text-neutral-500">No reviews yet.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- CTA --}}
            <section class="my-8">
                <div
                    class="mx-4 max-w-8xl bg-gradient-to-br from-primary-400 to-primary-500 rounded-2xl px-6 py-16 sm:py-20 text-center">
                    <h2 class="text-h-2 text-white mb-4">Let's Build Something Impactful</h2>
                    <p class="text-b-1 text-white mb-6 max-w-2xl mx-auto">
                        Have an exciting project in mind? Let's collaborate and bring your vision to life. High-quality,
                        100% satisfaction guaranteed.
                    </p>
                    <button
                        class="inline-flex items-center px-8 py-3 bg-white text-primary-500 text-b-1 font-semibold rounded-lg hover:bg-neutral-10 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Start a Project Consultation
                    </button>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
