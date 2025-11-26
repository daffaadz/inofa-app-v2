
    <div class="p-4 border-b font-semibold text-sm">Validasi Proyek</div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-sm">
                    <th class="p-2">Project</th>
                    <th class="p-2">Client</th>
                    <th class="p-2">Developer</th>
                    <th class="p-2">Price</th>
                    <th class="p-2">Timeline</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $project)
                <tr class="border-t text-sm hover:bg-gray-50">
                    <td class="p-2">{{ $project->title ?? $project->name }}</td>
                    <td class="p-2">{{ $project->consumer->name ?? '-' }}</td>
                    <td class="p-2">{{ optional(optional($project->agreement)->developer)->name ?? '-' }}</td>
                    <td class="p-2">{{ number_format($project->budget ?? 0) }}</td>
                    <td class="p-2">{{ $project->timeline ?? '-' }}</td>
                    <td class="p-2">@include('admin.components.status-badge', ['status' => $project->status])</td>
                    <td class="p-2">
                        @include('admin.components.action-buttons', [
                            'viewUrl' => route('admin.projects.show', $project->id),
                            'approveUrl' => route('admin.projects.approve', $project->id),
                            'rejectUrl' => route('admin.projects.reject', $project->id),
                        ])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-10 text-center text-gray-400 text-sm">Tidak ada data. Coba reset filter.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
