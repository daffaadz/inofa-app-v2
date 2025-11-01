<footer class="bg-neutral-800 flex flex-col flex-1 justify-stretch items-center text-gray-400 m-4 rounded-lg">
    <div class="max-w-7xl px-6 md:px-0 py-16 grid md:grid-cols-5 gap-6 md:gap-4 text-sm">

        <div class="col-span-2 pr-12">
            <div class="flex flex-row mb-6 gap-4">
                <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa logo" class="h-8 w-auto">
                <h6 class="font-sans text-h-7 text-neutral-0">Inofa</h6>
            </div>
            <p class="font-sans text-b-1 text-pretty text-neutral-0">
                Inofa connects clients with top developers. A secure,
                transparent, and easy
                process to bring your digital ideas to life.</p>
        </div>

        <div>
            <div class="font-sans text-b-2 text-gray-400 mb-6">Company</div>
            <ul class="font-sans text-b-2 text-neutral-0 space-y-4">
                <li><a href="#" class="hover:text-gray-400">About us</a></li>
                <li><a href="#" class="hover:text-gray-400">Contact us</a></li>
                <li><a href="#" class="hover:text-gray-400">How it Works</a></li>
                <li><a href="#" class="hover:text-gray-400">FAQs</a></li>
            </ul>
        </div>

        <div>
            <div class="font-sans text-b-2 text-gray-400 mb-6">Legal</div>
            <ul class="font-sans text-b-2 text-neutral-0 space-y-4">
                <li><a href="#" class="hover:text-gray-400">Terms & Conditions</a></li>
                <li><a href="#" class="hover:text-gray-400">Privacy Policy</a></li>
            </ul>
        </div>

        <div>
            <div class="font-sans text-b-2 text-gray-400 mb-6">Contact</div>
            <ul class="space-y-4 text-neutral-0">
                <li>hello@inofa.id</li>
                <li>+62 821-1234-5678</li>
                <li>Jakarta, Indonesia</li>
            </ul>
        </div>
    </div>

    {{-- Social Media & Mobile App --}}
    <div class="flex flex-1 felx-row justify-between max-w-7xl w-full border-b border-gray-600 py-6 px-6 md:px-0">
        {{-- Social Media --}}
        <div>
            <h6 class="font-sans text-b-3 text-gray-400">Follow us</h6>
        </div>

        {{-- Mobile App --}}
        <div>
            <h6 class="font-sans text-b-3 text-gray-400">Mobile app</h6>
        </div>
    </div>

    <div class="text-center py-4 text-xs text-gray-400 pb-16">
        © 2025 Inofa. All rights reserved.
    </div>
</footer>
