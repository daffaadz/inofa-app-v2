@props(['name' => 'file'])

<label class="flex flex-col items-center justify-center border-2 border-dashed
    border-neutral-300 rounded-xl py-16 cursor-pointer hover:border-primary-400
    transition text-center">

    <input type="file" name="{{ $name }}" class="hidden" {{ $attributes }}>

    <svg class="w-12 h-12 text-neutral-500 mb-4" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M7 16a4 4 0 01-.88-7.876A6 6 0 0118.004 9h1.992A4 4 0 0120 16m-6-4v8m0 0l-3-3m3 3l3-3" />
    </svg>

    <p class="text-neutral-600 font-sans text-b-3">Unggah Bukti Pembayaran</p>
    <p class="text-neutral-400 text-xs">JPG, PNG, atau PDF (maks 5MB)</p>
</label>
