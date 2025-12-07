<x-admin-layout>
    <div class="px-6 py-6">

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-semibold text-gray-800">Users</h1>
        </div>

        {{-- Stats Widgets --}}
        <div class="grid grid-cols-4 gap-4 mb-6">

            <div class="p-4 bg-white rounded-lg shadow">
                <p class="text-sm text-gray-500">Total Users</p>
                <p class="text-xl font-semibold">{{ $totalUsers }}</p>
            </div>

            <div class="p-4 bg-white rounded-lg shadow">
                <p class="text-sm text-gray-500">Active Users</p>
                <p class="text-xl font-semibold">{{ $activeUsers }}</p>
            </div>

            <div class="p-4 bg-white rounded-lg shadow">
                <p class="text-sm text-gray-500">Developers</p>
                <p class="text-xl font-semibold">{{ $developers }}</p>
            </div>

            <div class="p-4 bg-white rounded-lg shadow">
                <p class="text-sm text-gray-500">Clients</p>
                <p class="text-xl font-semibold">{{ $clients }}</p>
            </div>

        </div>

        {{-- Search Bar --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name or email..."
                        class="w-full px-4 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-xl text-sm
                               focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                               transition-all hover:border-gray-300">
                </div>
                <button type="submit"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-xl text-sm font-medium
                           hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search
                </button>
            </form>
        </div>

        {{-- Advanced Filters --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-6">
            {{-- Header --}}
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800">Advanced Filters</h3>
            </div>

            <form method="GET" action="{{ route('admin.users.index') }}"
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">

                {{-- ROLE --}}
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Role</label>
                    <select name="role"
                        class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                               focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                               transition-all cursor-pointer hover:border-gray-300">
                        <option value="">All Roles</option>
                        <option value="admin" @selected(request('role')==='admin')>Admin</option>
                        <option value="developer" @selected(request('role')==='developer')>Developer</option>
                        <option value="consumer" @selected(request('role')==='consumer')>Consumer</option>
                    </select>
                </div>

                {{-- STATUS --}}
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Status</label>
                    <select name="status"
                        class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                               focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                               transition-all cursor-pointer hover:border-gray-300">
                        <option value="">All Status</option>
                        <option value="active" @selected(request('status')==='active')>Active</option>
                        <option value="suspended" @selected(request('status')==='suspended')>Suspended</option>
                    </select>
                </div>

                {{-- DATE FROM --}}
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                                  focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                                  transition-all hover:border-gray-300">
                </div>

                {{-- DATE TO --}}
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                                  focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                                  transition-all hover:border-gray-300">
                </div>

                {{-- SORT --}}
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Sort</label>
                    <select name="sort"
                        class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                               focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                               transition-all cursor-pointer hover:border-gray-300">
                        <option value="newest" @selected(request('sort','newest')==='newest')>Newest</option>
                        <option value="oldest" @selected(request('sort')==='oldest')>Oldest</option>
                    </select>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="sm:col-span-2 lg:col-span-3 xl:col-span-5 flex flex-col sm:flex-row justify-end items-stretch sm:items-center gap-3 mt-4 pt-4 border-t border-gray-100">

                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center justify-center gap-2 text-gray-700 px-6 py-2.5 border-2 border-gray-300 rounded-xl text-sm font-medium
                              hover:bg-gray-50 hover:border-gray-400 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                       Reset
                    </a>

                    <button type="submit"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-xl text-sm font-medium
                               hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        {{-- User Table --}}
        <div class="bg-white rounded-lg shadow ring-1 ring-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Joined</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $user->id }}</td>

                        <td class="px-4 py-2 text-sm text-gray-900 font-medium">{{ $user->name }}</td>

                        <td class="px-4 py-2 text-sm text-gray-700">{{ $user->email }}</td>

                        {{-- Role Badge --}}
                        <td class="px-4 py-2 text-sm">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                @class([
                                    'bg-indigo-100 text-indigo-700' => $user->role === 'admin',
                                    'bg-emerald-100 text-emerald-700' => $user->role === 'developer',
                                    'bg-blue-100 text-blue-700' => $user->role === 'consumer',
                                    'bg-gray-100 text-gray-600' => !in_array($user->role,['admin','developer','consumer'])
                                ])">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-4 py-2 text-sm">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                @class([
                                    'bg-green-100 text-green-700' => $user->status === 'active',
                                    'bg-red-100 text-red-700' => $user->status === 'suspended'
                                ])">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $user->created_at?->format('Y-m-d') }}
                        </td>

                        {{-- Action Buttons --}}
                        <td class="px-4 py-2 text-sm flex gap-2">

                            {{-- VIEW --}}
                            <button onclick="viewUserDetail({{ $user->id }})"
                                class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-xs font-medium hover:from-blue-600 hover:to-blue-700 transition-all shadow-sm hover:shadow-md">
                                <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </button>

                            {{-- Suspend / Activate --}}
                            @if($user->status === 'active')
                                <form method="POST" action="{{ route('admin.users.suspend', $user->id) }}" onsubmit="return confirm('⚠️ Are you sure you want to SUSPEND this user?\n\nThis user will NOT be able to login.')">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg text-xs font-medium hover:from-red-600 hover:to-red-700 transition-all shadow-sm hover:shadow-md">
                                        <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                        Suspend
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.users.activate', $user->id) }}" onsubmit="return confirm('✓ Are you sure you want to ACTIVATE this user?\n\nThis user will be able to login again.')">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg text-xs font-medium hover:from-emerald-600 hover:to-emerald-700 transition-all shadow-sm hover:shadow-md">
                                        <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Activate
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
                            No users found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="px-4 py-3 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-500">
                    Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                </p>
                {{ $users->links() }}
            </div>

        </div>
    </div>

    {{-- User Detail Modal --}}
    <div id="userDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 p-4" style="display: none;">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-4 flex justify-between items-center rounded-t-2xl">
                    <h3 class="text-xl font-bold text-white">User Details</h3>
                    <button onclick="closeUserModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Content -->
                <div id="userDetailContent" class="p-6">
                    <div class="flex justify-center items-center py-8">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewUserDetail(userId) {
            const modal = document.getElementById('userDetailModal');
            const content = document.getElementById('userDetailContent');
            
            modal.style.display = 'block';
            
            // Show loading
            content.innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary-500"></div>
                </div>
            `;
            
            // Fetch user data
            fetch(`/admin/users/${userId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const user = data.user;
                const stats = data.stats;
                
                // Handle avatar URL
                let avatarHtml = '';
                if (user.avatar) {
                    // Check if it's a full URL or storage path
                    const avatarSrc = user.avatar.startsWith('http') 
                        ? user.avatar 
                        : '/storage/' + user.avatar;
                    avatarHtml = `<img src="${avatarSrc}" class="w-20 h-20 rounded-full border-4 border-primary-100 object-cover" alt="Avatar" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&size=80'">`;
                } else {
                    avatarHtml = `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&size=80" class="w-20 h-20 rounded-full border-4 border-primary-100 object-cover" alt="Avatar">`;
                }
                
                let html = `
                    <!-- User Header -->
                    <div class="flex items-center gap-4 mb-4 pb-4 border-b-2 border-gray-100">
                        ${avatarHtml}
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-gray-900">${user.name}</h4>
                            <p class="text-sm text-gray-600">${user.email}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    ${user.role === 'developer' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700'}">
                                    ${user.role.toUpperCase()}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    ${user.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                    ● ${user.status.toUpperCase()}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-3 rounded-xl border border-blue-200">
                            <p class="text-xs text-blue-600 font-medium">Projects</p>
                            <p class="text-2xl font-bold text-blue-700">${stats.total_projects || 0}</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-3 rounded-xl border border-green-200">
                            <p class="text-xs text-green-600 font-medium">Completed</p>
                            <p class="text-2xl font-bold text-green-700">${stats.completed_projects || 0}</p>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-3 rounded-xl border border-yellow-200">
                            <p class="text-xs text-yellow-600 font-medium">Rating</p>
                            <p class="text-2xl font-bold text-yellow-700">${stats.average_rating ? stats.average_rating.toFixed(1) + '★' : 'N/A'}</p>
                        </div>
                    </div>
                `;

                // Developer-specific info with bank details
                if (user.role === 'developer' && user.developer_profile) {
                    html += `
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-4 rounded-xl border border-indigo-200 mb-3">
                            <h5 class="font-semibold text-indigo-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Payment Details
                            </h5>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Bank Name</p>
                                    <p class="font-semibold text-gray-900">${user.developer_profile.bank_name || 'Not set'}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Account Number</p>
                                    <p class="font-semibold text-gray-900">${user.developer_profile.account_number || 'Not set'}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Total Earned</p>
                                    <p class="font-bold text-green-600">Rp ${(stats.total_earned || 0).toLocaleString('id-ID')}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Experience</p>
                                    <p class="font-semibold text-gray-900">${user.developer_profile.experience_years || 0} years</p>
                                </div>
                            </div>
                    `;

                    // Skills
                    if (user.skills && user.skills.length > 0) {
                        html += `
                            <div class="mt-3">
                                <p class="text-xs text-gray-600 mb-2 font-medium">Skills:</p>
                                <div class="flex flex-wrap gap-1.5">
                                    ${user.skills.slice(0, 8).map(skill => `
                                        <span class="px-2 py-1 bg-white text-indigo-700 rounded-md text-xs font-medium shadow-sm border border-indigo-200">
                                            ${skill.name}
                                        </span>
                                    `).join('')}
                                    ${user.skills.length > 8 ? `<span class="px-2 py-1 text-xs text-gray-500">+${user.skills.length - 8} more</span>` : ''}
                                </div>
                            </div>
                        `;
                    }

                    html += `</div>`;
                }

                // Additional Info
                html += `
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>${user.location || 'Location not set'}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Joined ${new Date(user.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })}</span>
                        </div>
                    </div>
                `;

                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-600 font-medium">Failed to load user details</p>
                    </div>
                `;
                console.error('Error:', error);
            });
        }

        function closeUserModal() {
            document.getElementById('userDetailModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('userDetailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserModal();
            }
        });
    </script>
</x-admin-layout>
