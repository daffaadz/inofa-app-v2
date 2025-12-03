{{-- resources/views/components/project-card.blade.php --}}
@props(['project'])

<div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 max-w-2xl w-full">
    {{-- Header Section --}}
    <div class="mb-6">
        <div class="flex items-start justify-between gap-4">
            {{-- Project Title & Consumer Info --}}
            <div class="flex-1 min-w-0">
                <h3 class="text-b-1 leading-tight font-bold text-neutral-1000 mb-3">{{ Str::limit($project->title, 60) }}</h3>
                
                {{-- Consumer Info --}}
                @if($project->consumer)
                <div class="flex items-center gap-2 mb-2">
                    @php
                        $avatarSrc = $project->consumer->getRawOriginal('avatar')
                            ? (filter_var($project->consumer->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                ? $project->consumer->getRawOriginal('avatar')
                                : asset('storage/' . $project->consumer->getRawOriginal('avatar')))
                            : 'https://ui-avatars.com/api/?name=' . urlencode($project->consumer->name);
                    @endphp
                    <img src="{{ $avatarSrc }}" alt="{{ $project->consumer->name }}"
                        class="w-6 h-6 rounded-full object-cover">
                    <span class="text-b-3 text-neutral-600">{{ $project->consumer->name }}</span>
                </div>
                @endif
            </div>

            {{-- Budget Badge --}}
            <div class="flex-shrink-0">
                <div class="inline-flex items-center gap-1.5 bg-primary-100 border border-primary-500 px-4 py-2 rounded-full">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-b-3 font-bold text-primary-500">
                        Rp {{ number_format($project->budget, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Description --}}
    <div class="mb-6">
        <p class="text-[16px] text-neutral-700 leading-relaxed">
            {{ Str::limit($project->description, 150) }}
        </p>
    </div>

    {{-- Project Details --}}
    <div class="mb-6 grid grid-cols-2 gap-4">
        {{-- Deadline --}}
        @if($project->deadline)
        <div class="flex items-center gap-2 text-b-3 text-neutral-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>{{ $project->deadline->format('M d, Y') }}</span>
        </div>
        @endif

        {{-- Status --}}
        <div class="flex items-center gap-2 text-b-3">
            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="capitalize {{ $project->status === 'open' ? 'text-primary-500 font-semibold' : 'text-neutral-600' }}">
                {{ $project->status }}
            </span>
        </div>
    </div>

    {{-- Required Skills --}}
    <div class="mb-8">
        <h4 class="text-[16px] font-semibold text-neutral-1000 mb-4">Required Skills</h4>

        @if ($project->skills && $project->skills->isNotEmpty())
            <div class="flex flex-wrap gap-2.5">
                @foreach ($project->skills->take(5) as $skill)
                    <span class="px-4 py-2 bg-primary-100 text-primary-500 border border-primary-500 rounded-2xl text-b-2 font-medium">
                        {{ $skill->name }}
                    </span>
                @endforeach
                @if ($project->skills->count() > 5)
                    <span class="px-4 py-2 bg-neutral-100 text-neutral-700 rounded-lg text-b-2 font-medium">
                        +{{ $project->skills->count() - 5 }} more
                    </span>
                @endif
            </div>
        @else
            <div class="flex flex-wrap gap-2.5">
                <span class="px-4 py-2 bg-neutral-100 text-neutral-500 border border-neutral-500 rounded-2xl text-b-2 font-medium">
                    No specific skills required
                </span>
            </div>
        @endif
    </div>

    {{-- View Project Button --}}
    <a href="{{ route('search.projects.show', $project->id) }}"
        class="block w-full py-4 bg-gradient-to-r from-secondary-500 via-primary-400 to-secondary-600 text-white rounded-xl hover:bg-primary-600 transition-colors font-medium text-b-2 text-center shadow-sm hover:shadow-md">
        View Project Details
        <span class="ml-1">›</span>
    </a>
</div>
