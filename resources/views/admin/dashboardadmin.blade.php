<x-admin-layout title="Dashboard Admin">

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="p-6 bg-[#1b1b2f] rounded-xl shadow-lg border border-purple-700/20">
            <p class="text-gray-400">Total User</p>
            <p class="text-4xl font-bold text-purple-300 mt-2">{{ $totalUsers }}</p>
        </div>

        <div class="p-6 bg-[#1b1b2f] rounded-xl shadow-lg border border-purple-700/20">
            <p class="text-gray-400">Total Proyek</p>
            <p class="text-4xl font-bold text-blue-300 mt-2">{{ $totalProjects }}</p>
        </div>

        <div class="p-6 bg-[#1b1b2f] rounded-xl shadow-lg border border-purple-700/20">
            <p class="text-gray-400">Total Tugas</p>
            <p class="text-4xl font-bold text-green-300 mt-2">{{ $totalTasks }}</p>
        </div>

    </div>

    {{-- Pengguna Terbaru --}}
    <h2 class="mt-10 text-xl font-semibold text-purple-300">Pengguna Terbaru</h2>

    <div class="mt-4 bg-[#1b1b2f] rounded-xl overflow-hidden border border-purple-700/20">
        <table class="w-full text-left text-gray-300 text-sm">
            <thead class="bg-[#252542] text-gray-300">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Terdaftar</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($latestUsers as $user)
                    <tr class="border-b border-purple-700/10">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-md text-xs
                                {{ $user->role === 'admin' ? 'bg-purple-600/40 text-purple-200' : 'bg-blue-600/30 text-blue-200' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Proyek Terbaru --}}
    <h2 class="mt-10 text-xl font-semibold text-purple-300">Proyek Terbaru</h2>

    <div class="mt-4 space-y-3">
        @foreach ($latestProjects as $project)
            <div class="p-4 bg-[#1b1b2f] border border-purple-700/20 rounded-xl shadow">
                <p class="text-lg font-semibold">{{ $project->name }}</p>
                <p class="text-sm text-gray-400">
                    Dibuat oleh: {{ $project->owner->name }} • {{ $project->created_at->diffForHumans() }}
                </p>
            </div>
        @endforeach
    </div>

</x-admin-layout>
