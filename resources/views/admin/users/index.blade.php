<x-admin-layout>
    <div class="px-6 py-6">

        {{-- Header + Filter --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-gray-800">Users</h1>

            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ old('search', $search) }}"
                    placeholder="Search name or email"
                    class="w-64 px-4 py-2 rounded-md border-gray-300 shadow-md focus:border-indigo-500 focus:ring-indigo-500 text-sm" />

                <select name="role"
                    class="rounded-md border-gray-300 shadow-md px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Roles</option>
                    <option value="admin" @selected($selectedRole==='admin')>Admin</option>
                    <option value="developer" @selected($selectedRole==='developer')>Developer</option>
                    <option value="consumer" @selected($selectedRole==='consumer')>Consumer</option>
                </select>

                <button class="px-4 py-2 text-sm font-medium bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                    Filter
                </button>
            </form>
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
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="px-3 py-1 bg-gray-200 text-gray-800 rounded-md text-xs hover:bg-gray-300">
                                View
                            </a>

                            {{-- Suspend / Activate --}}
                            @if($user->status === 'active')
                                <form method="POST" action="{{ route('admin.users.suspend', $user->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-100 text-red-600 rounded-md text-xs hover:bg-red-200">
                                        Suspend
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.users.activate', $user->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-md text-xs hover:bg-emerald-200">
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
</x-admin-layout>
