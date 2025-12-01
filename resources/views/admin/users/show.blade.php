<x-admin-layout :title="'Detail User: ' . ($user->name ?? '-')">

    <div class="space-y-10 p-6">

        {{-- INFORMASI USER --}}
        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20 shadow-lg shadow-purple-900/20">
            <h2 class="text-xl font-bold text-purple-300 mb-6">Informasi User</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300 text-sm">

                {{-- Nama --}}
                <div class="p-4 bg-[#252542] rounded-lg border border-purple-700/20">
                    <p class="text-gray-400">Nama</p>
                    <p class="font-semibold text-lg">{{ $user->name ?? '-' }}</p>
                </div>

                {{-- Email --}}
                <div class="p-4 bg-[#252542] rounded-lg border border-purple-700/20">
                    <p class="text-gray-400">Email</p>
                    <p class="font-semibold text-lg">{{ $user->email ?? '-' }}</p>
                </div>

                {{-- Role --}}
                <div class="p-4 bg-[#252542] rounded-lg border border-purple-700/20">
                    <p class="text-gray-400">Role</p>
                    <span
                        class="px-3 py-1 mt-1 inline-block text-xs rounded-md
                        {{ ($user->role ?? '') === 'admin' ? 'bg-purple-600/40 text-purple-200' : 'bg-blue-600/40 text-blue-200' }}">
                        {{ ucfirst($user->role ?? 'user') }}
                    </span>
                </div>

                {{-- Waktu daftar --}}
                <div class="p-4 bg-[#252542] rounded-lg border border-purple-700/20">
                    <p class="text-gray-400">Terdaftar</p>
                    <p class="font-semibold text-lg">
                        {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- PROJECT LIST --}}
        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20 shadow-lg shadow-purple-900/20">
            <h2 class="text-xl font-bold text-purple-300 mb-6">Proyek yang Dibuat</h2>

            @if (!isset($projects) || $projects->count() === 0)
                <p class="text-gray-400 text-sm bg-[#252542] p-4 rounded-lg border border-purple-700/20">
                    User ini belum membuat proyek.
                </p>
            @else
                <div class="space-y-5">
                    @foreach ($projects as $project)
                        <div
                            class="p-5 bg-[#252542] rounded-xl border border-purple-700/20 hover:border-purple-500/40 transition">

                            <div class="flex justify-between items-center mb-2">
                                <p class="font-semibold text-gray-200 text-lg">
                                    {{ $project->display_name ?? ($project->name ?? ($project->title ?? '-')) }}
                                </p>
                                <p class="text-sm text-gray-400">{{ $project->tasks_count ?? 0 }} Tugas</p>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="w-full bg-[#1b1b2f] h-3 rounded-xl overflow-hidden border border-purple-700/20">
                                <div class="h-3 rounded-xl bg-gradient-to-r from-purple-500 to-purple-700"
                                    style="width: {{ intval($project->progress ?? 0) }}%">
                                </div>
                            </div>

                            <p class="text-xs text-gray-400 mt-2">{{ intval($project->progress ?? 0) }}% selesai</p>

                            {{-- Small meta row: status + deadline --}}
                            <div class="mt-3 flex items-center justify-between text-sm text-gray-400">
                                {{-- status badge --}}
                                @php
                                    $pStatus = strtolower($project->normalized_status ?? ($project->status ?? ''));
                                @endphp
                                <div>
                                    <span
                                        class="px-2 py-1 text-xs rounded
                                        {{ $pStatus === 'done' ? 'bg-green-600/30 text-green-300' : 'bg-yellow-600/30 text-yellow-300' }}">
                                        {{ $project->status_label ?? ucfirst($project->status ?? 'on_going') }}
                                    </span>
                                </div>

                                {{-- deadline safe --}}
                                <div>
                                    @if (!empty($project->deadline))
                                        @php
                                            try {
                                                $pd = \Illuminate\Support\Carbon::parse($project->deadline);
                                            } catch (\Exception $e) {
                                                $pd = null;
                                            }
                                        @endphp
                                        {{ $pd ? $pd->format('Y-m-d') : $project->deadline }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- TASK LIST --}}
        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20 shadow-lg shadow-purple-900/20">
            <h2 class="text-xl font-bold text-purple-300 mb-6">Tugas yang Dikerjakan</h2>

            @if (!isset($tasks) || $tasks->count() === 0)
                <p class="text-gray-400 text-sm bg-[#252542] p-4 rounded-lg border border-purple-700/20">
                    User ini belum memiliki tugas.
                </p>
            @else
                <div class="overflow-x-auto rounded-lg border border-purple-700/20">
                    <table class="w-full text-sm text-gray-300">
                        <thead class="bg-[#252542]">
                            <tr>
                                <th class="p-3 text-left">Nama Tugas</th>
                                <th class="p-3 text-left">Proyek</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Deadline</th>
                            </tr>
                        </thead>

                        <tbody class="bg-[#1b1b2f]">
                            @foreach ($tasks as $task)
                                <tr class="border-b border-purple-700/10 hover:bg-purple-600/10 transition">

                                    {{-- Nama Task --}}
                                    <td class="p-3 font-medium">
                                        {{ $task->display_name ?? ($task->title ?? ($task->name ?? '-')) }}
                                        @if (!empty($task->assigned_by) && $task->assigned_by != ($task->assigned_to ?? null))
                                            <small class="text-xs ml-2 text-yellow-300">(Ditugaskan oleh Admin)</small>
                                        @endif
                                    </td>

                                    {{-- Nama Proyek --}}
                                    <td class="p-3 text-gray-400">
                                        {{ optional($task->project)->display_name ?? (optional($task->project)->name ?? (optional($task->project)->title ?? '-')) }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="p-3 capitalize">
                                        @php
                                            $tNorm = strtolower(
                                                $task->normalized_status ?? ($task->status ?? 'on_going'),
                                            );
                                            $statusLabel =
                                                $task->status_label ??
                                                ucfirst(str_replace('_', ' ', $task->status ?? 'on_going'));
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded-md text-xs
                                            {{ $tNorm === 'done' ? 'bg-green-600/30 text-green-300' : ($tNorm === 'on_going' ? 'bg-yellow-600/30 text-yellow-300' : 'bg-gray-600/30 text-gray-300') }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    {{-- Deadline --}}
                                    <td class="p-3">
                                        @if (!empty($task->deadline))
                                            @php
                                                try {
                                                    $td = \Illuminate\Support\Carbon::parse($task->deadline);
                                                } catch (\Exception $e) {
                                                    $td = null;
                                                }
                                            @endphp
                                            {{ $td ? $td->format('Y-m-d') : $task->deadline }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

</x-admin-layout>
