
<div x-data="{ open:false }" class="relative">
    <button @click="open=!open" class="px-3 py-2 rounded bg-purple-600 text-white">
        Notifikasi
        @if(isset($pendingPaymentsGlobal) && $pendingPaymentsGlobal>0)
            <span class="ml-2 bg-white text-purple-700 rounded px-2 py-0.5 text-xs">{{ $pendingPaymentsGlobal }}</span>
        @endif
    </button>
    <div x-show="open" @click.outside="open=false" class="absolute right-0 mt-2 w-80 bg-white border rounded shadow">
        <div class="p-2 text-sm text-gray-600">Aktivitas Terbaru</div>
        <ul>
            @forelse(($notifications ?? []) as $n)
                <li class="p-2 border-t text-sm">{{ $n }}</li>
            @empty
                <li class="p-4 text-center text-gray-500">Tidak ada notifikasi</li>
            @endforelse
        </ul>
        <div class="p-2 text-right">
            <a href="#" class="text-xs text-blue-600">Tandai semua terbaca</a>
        </div>
    </div>
</div>
