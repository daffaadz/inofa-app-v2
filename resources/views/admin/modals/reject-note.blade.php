<div x-data="{ open:false, url:null, reason:'' }" x-on:open-reject.window="open=true; url=$event.detail.url" x-show="open" class="fixed inset-0 bg-black/40 flex items-center justify-center">
    <div class="bg-white rounded p-4 w-96">
        <h3 class="text-lg font-semibold mb-2">Alasan Penolakan</h3>
        <form method="POST" :action="url">
            @csrf
            <textarea name="reason" x-model="reason" class="w-full border rounded p-2" rows="4" placeholder="Tuliskan alasan penolakan" required></textarea>
            <div class="mt-3 flex justify-end gap-2">
                <button type="button" @click="open=false; url=null; reason=''" class="px-3 py-2 border rounded">Batal</button>
                <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Submit</button>
            </div>
        </form>
    </div>
</div>
