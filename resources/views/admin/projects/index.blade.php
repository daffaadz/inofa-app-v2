{{-- resources/views/admin/projects/index.blade.php --}}
<x-admin-layout title="All Projects">
    {{-- MAIN --}}
    <main class="flex-1 p-8">

        {{-- HEADER --}}
        <div>
            <h1 class="text-3xl font-bold">All Projects</h1>
            <p class="text-gray-500 mt-1">Monitor and manage all projects on the platform</p>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="p-5 bg-white rounded-xl shadow-sm border flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Total Projects</p>
                    <p class="font-semibold text-xl">{{ $stats['total'] }}</p>
                </div>
            </div>

            <div class="p-5 bg-white rounded-xl shadow-sm border flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path d="M12 6v6l4 2"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Ongoing</p>
                    <p class="font-semibold text-xl">{{ $stats['ongoing'] }}</p>
                </div>
            </div>

            <div class="p-5 bg-white rounded-xl shadow-sm border flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Completed</p>
                    <p class="font-semibold text-xl">{{ $stats['completed'] }}</p>
                </div>
            </div>

            <div class="p-5 bg-white rounded-xl shadow-sm border flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path d="M3 3h18v4H3zM3 11h18v10H3z"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Total Budget</p>
                    <p class="font-semibold text-xl">Rp {{ number_format($stats['budget']) }}</p>
                </div>
            </div>
        </div>

        {{-- SEARCH + FILTER --}}
        <div class="mt-6">
            @include('admin.components.filters', ['tab' => 'projects'])
        </div>

        {{-- PROJECT TABLE --}}
        <div class="bg-white rounded-xl shadow-sm border mt-6 p-4">
            <table class="min-w-full">
                <thead class="text-xs text-gray-500 uppercase border-b border-secondary-800 bg-secondary-100 rounded-t-lg">
                    <tr>
                        <th class="py-3 px-2 text-left">Agreement ID</th>
                        <th class="py-3 px-2 text-left">Project</th>
                        <th class="py-3 px-2 text-left">Client</th>
                        <th class="py-3 px-2 text-left">Developer</th>
                        <th class="py-3 px-2 text-left">Budget</th>
                        <th class="py-3 px-2 text-left">Timeline</th>
                        <th class="py-3 px-2 text-left">Status</th>
                        <th class="py-3 px-2 text-left">Payment Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($projects as $project)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- AGREEMENT ID --}}
                            <td class="py-3 px-2">
                                <div class="font-mono text-xs text-gray-600">{{ $project->short_id }}</div>
                                <div class="text-xs text-gray-400">{{ substr($project->id, -8) }}</div>
                            </td>

                            {{-- PROJECT TITLE --}}
                            <td class="py-3 px-2">
                                <div class="font-medium">{{ $project->project_title }}</div>
                                <div class="text-xs text-gray-500">{{ $project->project->title ?? '-' }}</div>
                            </td>

                            {{-- CLIENT --}}
                            <td class="py-3 px-2">
                                <div class="font-medium text-b-2">
                                    {{ $project->consumer->name ?? 'No client' }}
                                </div>
                            </td>

                            {{-- DEVELOPER --}}
                            <td class="py-3 px-2">
                                <div class="flex items-center gap-2">
                                    @php
                                        $avatarSrc = $project->developer
                                            ? ($project->developer->getRawOriginal('avatar')
                                                ? (filter_var($project->developer->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                                    ? $project->developer->getRawOriginal('avatar')
                                                    : asset('storage/' . $project->developer->getRawOriginal('avatar')))
                                                : 'https://ui-avatars.com/api/?name=' . urlencode($project->developer->name))
                                            : 'https://ui-avatars.com/api/?name=Unassigned';
                                    @endphp
                                    <img src="{{ $avatarSrc }}" alt="Avatar" class="w-7 h-7 rounded-full object-cover" />

                                    <span class="text-b-2">
                                        {{ $project->developer->name ?? 'Unassigned' }}
                                    </span>
                                </div>
                            </td>

                            {{-- BUDGET --}}
                            <td class="py-3 px-2 text-green-600 font-medium">
                                @php
                                    $confirmedTotal = $project->payments()->where('status', 'confirmed')->sum('amount');
                                @endphp
                                Rp {{ number_format($confirmedTotal) }}
                            </td>

                            {{-- TIMELINE --}}
                            <td class="py-3 px-2 text-gray-600 text-sm">
                                <div class="text-xs">{{ $project->start_date?->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $project->end_date?->format('d M Y') }}</div>
                            </td>

                            {{-- STATUS BADGE --}}
                            <td class="py-3 px-2">
                                @include('admin.components.status-badge', ['status' => $project->status])
                            </td>

                            {{-- PAYMENT STATUS --}}
                            <td class="py-3 px-2">
                                @php
                                    $latestPayment = $project->payments()->latest()->first();
                                    $paymentStatus = $latestPayment ? $latestPayment->status : 'No Payment';
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-green-100 text-green-700',
                                        'transferred' => 'bg-blue-100 text-blue-700',
                                        'failed' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusColor = $statusColors[$paymentStatus] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 text-xs rounded-full {{ $statusColor }}">
                                    {{ ucfirst($paymentStatus) }}
                                </span>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $projects->links() }}
            </div>
        </div>

    </main>
</div>

</x-admin-layout>
