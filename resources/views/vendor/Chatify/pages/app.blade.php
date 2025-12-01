<x-app-layout>
    <div class="flex h-screen bg-neutral-10 {{ Auth::user()->role === 'admin' ? '' : 'pt-16' }}">

        {{-- Global Sidebar (only for non-admin users) --}}
        @if(Auth::user()->role !== 'admin')
            @include('partials.global-sidebar')
        @endif

        {{-- Main Chat Container --}}
        <div class="flex flex-1 {{ Auth::user()->role === 'admin' ? '' : 'lg:ml-[18rem]' }}">

            {{-- Contacts List (Middle Panel) --}}
            <div
                class="messenger-listView max-w-[32rem] bg-white border-r border-neutral-100 flex flex-col {{ !!$id ? 'conversation-active' : '' }}">

                {{-- Header --}}
                <div class="m-header px-6 py-6 border-b border-neutral-100">
                    <h1 class="text-h-4 text-neutral-900 mb-2 messenger-headTitle">
                        {{ Auth::user()->role === 'admin' ? 'Complaints' : 'Messages' }}
                    </h1>
                    <p class="text-b-2 text-neutral-500">
                        {{ Auth::user()->role === 'admin' ? 'Review and manage user complaints and reports' : 'Communicate with your clients and manage project discussions' }}
                    </p>

                    {{-- Search Bar --}}
                    <div class="relative mt-4">
                        <input type="text"
                            class="messenger-search w-full pl-12 pr-4 py-2.5 text-b-2 bg-neutral-10 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Search messages..." />
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Contacts List --}}
                <div class="overflow-y-auto flex-1 mt-16">
                    {{-- User Tab --}}
                    <div class="show messenger-tab users-tab app-scroll" data-view="users">
                        {{-- Favorites Section --}}
                        <div class="favorites-section px-4" style="display: none;">
                            <p class="messenger-title px-6 py-2 text-b-3 text-neutral-500 font-semibold">
                                <span>Favorites</span></p>
                            <div class="messenger-favorites app-scroll-hidden"></div>
                        </div>

                        {{-- All Messages --}}
                        <p class="messenger-title px-6 py-2 text-b-3 text-neutral-500 font-semibold"><span>All
                                Messages</span></p>
                        <div class="listOfContacts" style="width: 100%;"></div>
                    </div>

                    {{-- Search Tab (hidden by default) --}}
                    <div class="messenger-tab search-tab app-scroll" data-view="search" style="display: none;">
                        </p>
                        <div class="search-records">
                            <p class="message-hint center-el text-b-3 text-neutral-400 text-center py-8"><span>Type to
                                    search..</span></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chat Messages Area (Right Panel) --}}
            <div class="relative flex-1 flex flex-col messenger-messagingView">

                {{-- Chat Header --}}
                <div class="px-6 py-4 bg-white border-b border-neutral-100 m-header m-header-messaging">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="avatar av-s header-avatar w-10 h-10 rounded-full bg-neutral-200"></div>
                            <div>
                                <a href="#"
                                    class="user-name text-b-1 font-semibold text-neutral-900">{{ config('chatify.name') }}</a>
                                <p class="text-b-3 text-neutral-500 conversation-title-display">
                                    @if(!$conversation)
                                        No conversation
                                    @else
                                        {{ $conversation->title ?? 'No conversation title' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="show-infoSide p-2 hover:bg-neutral-50 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-auto text-neutral-500" fill="currentColor" viewBox="0 0 256 256"><path d="M112,60a16,16,0,1,1,16,16A16,16,0,0,1,112,60Zm16,52a16,16,0,1,0,16,16A16,16,0,0,0,128,112Zm0,68a16,16,0,1,0,16,16A16,16,0,0,0,128,180Z"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Internet Connection Status --}}
                    <div class="internet-connection">
                        <span class="ic-connected">Connected</span>
                        <span class="ic-connecting">Connecting...</span>
                        <span class="ic-noInternet">No internet access</span>
                    </div>
                </div>

                {{-- Project Topic Banner --}}
                @include('Chatify::layouts.projectTopicBanner')

                {{-- Messages Container --}}
                <div class="flex-1 overflow-y-auto bg-neutral-10 p-6 m-body messages-container app-scroll">
                    <div class="messages max-w-4xl mx-auto">
                        <p class="message-hint center-el text-b-2 text-neutral-400 text-center py-8">
                            <span>Please select a chat to start messaging</span>
                        </p>
                    </div>

                    {{-- Typing Indicator --}}
                    <div class="typing-indicator">
                        <div class="message-card typing">
                            <div class="flex items-center gap-2 bg-white px-4 py-3 rounded-2xl shadow-sm max-w-xs">
                                <span class="typing-dots flex gap-1">
                                    <span class="dot dot-1 w-2 h-2 bg-neutral-400 rounded-full animate-bounce"></span>
                                    <span class="dot dot-2 w-2 h-2 bg-neutral-400 rounded-full animate-bounce"
                                        style="animation-delay: 0.1s"></span>
                                    <span class="dot dot-3 w-2 h-2 bg-neutral-400 rounded-full animate-bounce"
                                        style="animation-delay: 0.2s"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Send Message Form --}}
                @include('Chatify::layouts.sendForm')
            </div>

            {{-- Info Sidebar (Hidden by default) --}}
            <div class="messenger-infoView app-scroll w-80 bg-white border-l border-neutral-100 overflow-y-auto absolute right-0 bottom-0 top-0 mt-16" style="display: none;">
                <div class="px-6 py-6">
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-h-6">Details</p>
                        <button class="hide-infoSide text-neutral-400 hover:text-neutral-600 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    {!! view('Chatify::layouts.info', ['conversation' => $conversation ?? null])->render() !!}
                </div>
            </div>
        </div>
    </div>

    @include('Chatify::layouts.modals')
    @include('Chatify::layouts.headLinks')
    @include('Chatify::layouts.footerLinks')
</x-app-layout>
