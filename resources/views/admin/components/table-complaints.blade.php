
    <div class="p-4 border-b font-semibold text-sm">Keluhan Pengguna</div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-sm">
                    <th class="p-2">User</th>
                    <th class="p-2">Complainant</th>
                    <th class="p-2">Category</th>
                    <th class="p-2">Description</th>
                    <th class="p-2">Priority</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $complaint)
                <tr class="border-t text-sm hover:bg-gray-50">
                    <td class="p-2">{{ optional($complaint->user)->name ?? '-' }}</td>
                    <td class="p-2">{{ $complaint->complainant ?? '-' }}</td>
                    <td class="p-2">{{ $complaint->category ?? '-' }}</td>
                    <td class="p-2">
                        <span title="{{ $complaint->description }}">{{ \Illuminate\Support\Str::limit($complaint->description, 40) }}</span>
                    </td>
                    <td class="p-2">{{ ucfirst($complaint->priority ?? 'normal') }}</td>
                    <td class="p-2">@include('admin.components.status-badge', ['status' => $complaint->status ?? 'pending'])</td>
                    <td class="p-2">
                        @include('admin.components.action-buttons', [
                            'viewUrl' => route('admin.complaints.show', $complaint->id),
                            'approveUrl' => route('admin.complaints.process', $complaint->id),
                            'rejectUrl' => route('admin.complaints.close', $complaint->id),
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
</div>
