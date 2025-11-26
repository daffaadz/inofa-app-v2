{{-- resources/views/admin/components/tabs.blade.php --}}
    <div class="flex gap-10">
        <button @click="tab='projects'" class="relative pb-2 text-sm"
            :class="tab==='projects' ? 'text-green-700 font-semibold' : 'text-gray-600'">
            Validasi Proyek
            <span x-show="tab==='projects'" class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-green-600 rounded"></span>
        </button>
        <button @click="tab='payments'" class="relative pb-2 text-sm"
            :class="tab==='payments' ? 'text-green-700 font-semibold' : 'text-gray-600'">
            Validasi Pembayaran
            <span x-show="tab==='payments'" class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-green-600 rounded"></span>
        </button>
        <button @click="tab='complaints'" class="relative pb-2 text-sm"
            :class="tab==='complaints' ? 'text-green-700 font-semibold' : 'text-gray-600'">
            Keluhan Pengguna
            <span x-show="tab==='complaints'" class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-green-600 rounded"></span>
        </button>
    </div>
