<x-admin-layout title="Detail Proyek">

    <div class="p-6 text-white">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">Detail Proyek</h1>
            <p class="text-gray-300">{{ $project->display_name ?? $project->title }}</p>
        </div>

        {{-- Informasi Proyek --}}
        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20 mb-8">
            <h2 class="text-xl font-semibold mb-4">Informasi Proyek</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-400">Nama Proyek</p>
                    <p class="font-medium">{{ $project->display_name ?? $project->title }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Pemilik</p>
                    <p class="font-medium">{{ $project->owner->name ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Assigned Ke</p>
                    <p class="font-medium">{{ $project->assignee->name ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Dibuat Pada</p>
                    <p class="font-medium">{{ $project->created_at->format('Y-m-d') }}</p>
                </div>

                {{-- ================================================= --}}
                {{-- =======  TAMBAHAN BARU: MULTIPLE ASSIGNED  ====== --}}
                {{-- ================================================= --}}
                <div class="col-span-2">
                    <p class="text-sm text-gray-400">Assigned Ke (Multiple User)</p>

                    @if ($project->assignedUsers && $project->assignedUsers->count() > 0)
                        <ul class="list-disc ml-5 mt-1">
                            @foreach ($project->assignedUsers as $user)
                                <li class="text-gray-300">{{ $user->name }} ({{ $user->email }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="font-medium">-</p>
                    @endif
                </div>
                {{-- ================================================= --}}
            </div>
        </div>


        {{-- TUGAS DALAM PROYEK --}}
        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">
            <h2 class="text-xl font-semibold mb-4">Daftar Tugas</h2>

            @if ($project->tasks->isEmpty())
                <p class="text-gray-400">Belum ada tugas dalam proyek ini.</p>
            @else
                <table class="w-full text-left text-gray-300 text-sm">
                    <thead class="bg-[#252542]">
                        <tr>
                            <th class="p-3">Tugas</th>
                            <th class="p-3">Assigned Ke</th>
                            <th class="p-3">Deadline</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($project->tasks as $task)
                            <tr class="border-b border-purple-700/10">

                                <td class="p-3 font-medium">
                                    {{ $task->display_name }}
                                </td>

                                <td class="p-3">
                                    {{ $task->assignee->name ?? '-' }}
                                </td>

                                <td class="p-3">
                                    {{ $task->deadline ? $task->deadline->format('Y-m-d') : '-' }}
                                </td>

                                <td class="p-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded
                                        @if ($task->normalized_status === 'done') bg-green-600/30 text-green-300
                                        @else bg-yellow-600/30 text-yellow-300 @endif
                                    ">
                                        {{ $task->status_label }}
                                    </span>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            @endif
        </div>

    </div>

</x-admin-layout>
