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
                <thead class="text-xs text-gray-500 uppercase border-b">
                    <tr>
                        <th class="py-3 px-2 text-left">Project</th>
                        <th class="py-3 px-2 text-left">Client</th>
                        <th class="py-3 px-2 text-left">Developer</th>
                        <th class="py-3 px-2 text-left">Budget</th>
                        <th class="py-3 px-2 text-left">Timeline</th>
                        <th class="py-3 px-2 text-left">Progress</th>
                        <th class="py-3 px-2 text-left">Status</th>
                        <th class="py-3 px-2 text-left">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($projects as $project)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- PROJECT TITLE --}}
                            <td class="py-3 px-2">
                                <div class="font-medium">{{ $project->name }}</div>
                                <div class="text-xs text-gray-500">{{ $project->category }}</div>
                            </td>

                            {{-- CLIENT --}}
                            <td class="py-3 px-2">
                                <div class="font-medium">
                                    {{ optional($project->client)->name ?? 'No client' }}
                                </div>
                            </td>


                            {{-- DEVELOPER --}}
                            <td class="py-3 px-2">
                                <div class="flex items-center gap-2">
                                    <img src="{{ optional($project->developer)->avatar ?? asset('images/default-avatar.png') }}"
                                        class="w-7 h-7 rounded-full" />

                                    <span>
                                        {{ optional($project->developer)->name ?? 'Unassigned' }}
                                    </span>
                                </div>
                            </td>


                            {{-- BUDGET --}}
                            <td class="py-3 px-2 text-green-600 font-medium">
                                Rp {{ number_format($project->budget) }}
                            </td>

                            {{-- TIMELINE --}}
                            <td class="py-3 px-2 text-gray-600 text-sm">
                                {{ $project->timeline }}
                            </td>

                            {{-- PROGRESS --}}
                            <td class="py-3 px-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-gray-200 rounded-full">
                                        <div class="h-2 bg-green-500 rounded-full" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <span class="text-xs">{{ $project->progress }}%</span>
                                </div>
                            </td>

                            {{-- STATUS BADGE --}}
                            <td class="py-3 px-2">
                                @include('admin.components.status-badge', ['status' => $project->status])
                            </td>

                            {{-- ACTIONS --}}
                            <td class="py-3 px-2">
                                <a href="{{ route('admin.projects.show', $project->id) }}"
                                   class="px-3 py-1 text-sm rounded-lg bg-gray-100 hover:bg-gray-200">
                                    View
                                </a>
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
