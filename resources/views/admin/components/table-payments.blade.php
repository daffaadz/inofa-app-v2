
    <div class="p-4 border-b font-semibold text-sm">Validasi Pembayaran</div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-sm">
                    <th class="p-2">Project</th>
                    <th class="p-2">Client</th>
                    <th class="p-2">Amount</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $payment)
                <tr class="border-t text-sm hover:bg-gray-50">
                    <td class="p-2">{{ optional($payment->agreement->project ?? null)->title ?? '-' }}</td>
                    <td class="p-2">{{ optional($payment->agreement->consumer ?? null)->name ?? '-' }}</td>
                    <td class="p-2">{{ number_format($payment->amount ?? 0) }}</td>
                    <td class="p-2">{{ optional($payment->created_at)->format('Y-m-d') }}</td>
                    <td class="p-2">@include('admin.components.status-badge', ['status' => $payment->status])</td>
                    <td class="p-2">
                        @include('admin.components.action-buttons', [
                            'viewUrl' => route('admin.payments.show', $payment->id),
                            'approveUrl' => route('admin.payments.approve', $payment->id),
                            'rejectUrl' => route('admin.payments.reject', $payment->id),
                        ])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-gray-400 text-sm">Tidak ada data. Coba reset filter.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
