{{-- resources/views/components/profile-card.blade.php --}}
@props(['developer'])

<div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 max-w-2xl w-full">
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-start justify-center gap-6">
            {{-- Profile Image --}}
            @if ($developer->avatar)
                @php
                    $src = Str::startsWith($developer->avatar, 'http')
                        ? $developer->avatar
                        : asset('storage/' . $developer->avatar);
                @endphp
                <div class="relative flex-shrink-0">
                    <img src="{{ $src }}" alt="{{ $developer->name }}"
                        class="w-24 h-auto rounded-2xl object-cover">
                    {{-- Rating Badge on Image --}}
                    @if ($developer->developerProfile && $developer->developerProfile->rating_count > 0)
                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full shadow-md">
                            <svg class="w-4 h-4 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="text-b-3 font-bold text-neutral-1000">
                                {{ number_format($developer->developerProfile->rating_average, 1) }}
                            </span>
                        </div>
                    @else
                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full shadow-md">
                            <svg class="w-4 h-4 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="text-b-3 font-bold text-neutral-1000">0.0</span>
                        </div>
                    @endif
                </div>
            @else
                <div class="relative flex-shrink-0">
                    <div
                        class="w-24 h-24 rounded-2xl bg-primary-200 flex items-center justify-center text-primary-700 font-bold text-h-3">
                        {{ strtoupper(substr($developer->name, 0, 2)) }}
                    </div>
                    {{-- Rating Badge on Avatar --}}
                    <div
                        class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full shadow-md">
                        <svg class="w-4 h-4 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-b-3 font-bold text-neutral-1000">
                            @if ($developer->developerProfile && $developer->developerProfile->rating_count > 0)
                                {{ number_format($developer->developerProfile->rating_average, 1) }}
                            @else
                                0.0
                            @endif
                        </span>
                    </div>
                </div>
            @endif

            {{-- Profile Info --}}
            <div class="flex-1 min-w-0 pt-2">
                <h3 class="text-b-1 leading-tight font-bold text-neutral-1000 mb-2">{{ $developer->name }}</h3>

                {{-- Location --}}
                <div class="flex jusrify-center items-center gap-2 text-b-3 font-normal text-neutral-600 mb-1">
                    <svg class="w-4 h-4" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 5C10 7.4965 7.2305 10.0965 6.3005 10.8995C6.21386 10.9646 6.1084 10.9999 6 10.9999C5.8916 10.9999 5.78614 10.9646 5.6995 10.8995C4.7695 10.0965 2 7.4965 2 5C2 3.93913 2.42143 2.92172 3.17157 2.17157C3.92172 1.42143 4.93913 1 6 1C7.06087 1 8.07828 1.42143 8.82843 2.17157C9.57857 2.92172 10 3.93913 10 5Z"
                            stroke="#6A7282" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M6 6.5C6.82843 6.5 7.5 5.82843 7.5 5C7.5 4.17157 6.82843 3.5 6 3.5C5.17157 3.5 4.5 4.17157 4.5 5C4.5 5.82843 5.17157 6.5 6 6.5Z"
                            stroke="#6A7282" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <span>{{ $developer->location ?? 'Location not specified' }}</span>
                </div>

                {{-- Jobs Count --}}
                <div class="flex jusrify-center items-center gap-2 text-b-3 font-normal text-neutral-800">
                    <svg class="w-4 h-4" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.73838 6.25L8.49588 10.513C8.50436 10.5632 8.49732 10.6148 8.47569 10.6609C8.45406 10.707 8.41887 10.7453 8.37484 10.7709C8.33081 10.7964 8.28002 10.8079 8.22928 10.8039C8.17853 10.7998 8.13025 10.7803 8.09088 10.748L6.30088 9.4045C6.21446 9.33994 6.10949 9.30506 6.00163 9.30506C5.89376 9.30506 5.78879 9.33994 5.70238 9.4045L3.90938 10.7475C3.87004 10.7797 3.82181 10.7992 3.77112 10.8033C3.72044 10.8074 3.66971 10.7959 3.62571 10.7704C3.5817 10.745 3.54651 10.7067 3.52484 10.6607C3.50316 10.6147 3.49602 10.5632 3.50438 10.513L4.26138 6.25"
                            stroke="#108A00" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M6 7C7.65685 7 9 5.65685 9 4C9 2.34315 7.65685 1 6 1C4.34315 1 3 2.34315 3 4C3 5.65685 4.34315 7 6 7Z"
                            stroke="#108A00" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <span>{{ $developer->developerProfile->projects_completed ?? 0 }} jobs</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Bio/Description --}}
    <div class="mb-8">
        @if ($developer->developerProfile && $developer->developerProfile->headline)
            <p class="text-[16px] text-neutral-700 leading-relaxed">
                {{ $developer->developerProfile->headline }}
            </p>
        @elseif($developer->bio)
            <p class="text-[16px] text-neutral-700 leading-relaxed">
                {{ Str::limit($developer->bio, 180) }}
            </p>
        @else
            <p class="text-[16px] text-neutral-700 leading-relaxed">
                Professional developer with {{ $developer->developerProfile->experience_years ?? 0 }}+ years of
                experience in the field, ready to bring your digital projects to life.
            </p>
        @endif
    </div>

    {{-- Top Skills --}}
    <div class="mb-8">
        <h4 class="text-[16px] font-semibold text-neutral-1000 mb-4">Top Skills</h4>

        @if ($developer->skills && $developer->skills->isNotEmpty())
            <div class="flex flex-wrap gap-2.5">
                @foreach ($developer->skills->take(5) as $skill)
                    <span class="px-4 py-2 bg-primary-100 text-primary-700 rounded-lg text-b-2 font-medium">
                        {{ $skill->name }}
                    </span>
                @endforeach
                @if ($developer->skills->count() > 5)
                    <span class="px-4 py-2 bg-neutral-100 text-neutral-700 rounded-lg text-b-2 font-medium">
                        +{{ $developer->skills->count() - 5 }} more
                    </span>
                @endif
            </div>
        @else
            <div class="flex flex-wrap gap-2.5">
                <span class="px-4 py-2 bg-neutral-100 text-neutral-500 rounded-lg text-b-2 font-medium">
                    No skills added yet
                </span>
            </div>
        @endif
    </div>

    {{-- View Full Profile Button --}}
    <a href="{{ route('landing', $developer->id) }}"
        class="block w-full py-4 bg-gradient-to-r from-secondary-500 via-primary-400 to-secondary-600 text-white rounded-xl hover:bg-primary-600 transition-colors font-medium text-b-2 text-center shadow-sm hover:shadow-md">
        View Full Profile
        <span class="ml-1">›</span>
    </a>
</div>
