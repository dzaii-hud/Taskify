<x-admin-layout title="Daftar Pengguna">

    <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">

        <h1 class="text-xl font-semibold text-purple-300 mb-5">Daftar Pengguna</h1>

        <!-- ===== ACTION CARDS (baru) ===== -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            {{-- CARD BENTUK TIM
            <div class="bg-[#252542] p-4 rounded-xl border border-purple-700/20">
                <h3 class="text-purple-300 font-semibold">Bentuk Tim</h3>
                <p class="text-gray-400 text-sm mt-1 mb-3">Buat tim baru dan tambahkan anggota.</p>
                <a href="{{ route('admin.teams.create') }}"
                    class="px-3 py-1 bg-purple-600/30 hover:bg-purple-600/40 text-purple-200 rounded-lg text-xs">
                    Buat Tim Baru
                </a>
            </div> --}}

            {{-- CARD ASSIGN PROYEK --}}
            <div class="bg-[#252542] p-4 rounded-xl border border-purple-700/20">
                <h3 class="text-blue-300 font-semibold">Assign Proyek</h3>
                <p class="text-gray-400 text-sm mt-1 mb-3">Assign proyek ke user secara langsung.</p>
                <a href="{{ route('admin.assign.project.form') }}"
                    class="px-3 py-1 bg-blue-600/30 hover:bg-blue-600/40 text-blue-200 rounded-lg text-xs">
                    Assign Proyek
                </a>
            </div>

            {{-- CARD ASSIGN TUGAS --}}
            <div class="bg-[#252542] p-4 rounded-xl border border-purple-700/20">
                <h3 class="text-yellow-300 font-semibold">Assign Tugas</h3>
                <p class="text-gray-400 text-sm mt-1 mb-3">Buat tugas baru lalu assign ke user.</p>
                <a href="{{ route('admin.assign.task.form') }}"
                    class="px-3 py-1 bg-yellow-600/30 hover:bg-yellow-600/40 text-yellow-200 rounded-lg text-xs">
                    Assign Tugas
                </a>
            </div>

        </div>
        <!-- ===== END ACTION CARDS ===== -->

        <div class="overflow-x-auto rounded-lg border border-purple-700/20">
            <table class="w-full text-left text-gray-300 text-sm">

                <thead class="bg-[#252542]">
                    <tr>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Total Proyek</th>
                        <th class="p-3">Detail</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-purple-700/10">

                            {{-- NAMA --}}
                            <td class="p-3 font-medium">
                                {{ $user->name }}
                            </td>

                            {{-- EMAIL --}}
                            <td class="p-3">
                                {{ $user->email }}
                            </td>

                            {{-- ROLE --}}
                            <td class="p-3">
                                <span
                                    class="px-2 py-1 text-xs rounded-md
                                    {{ $user->role === 'admin' ? 'bg-purple-600/30 text-purple-300' : 'bg-blue-600/30 text-blue-300' }}
                                ">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            {{-- TOTAL PROJECT --}}
                            <td class="p-3">
                                {{ $user->projects_count ?? $user->projects->count() }}
                            </td>

                            {{-- DETAIL BUTTON --}}
                            <td class="p-3">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                    class="px-3 py-1 bg-blue-600/30 hover:bg-blue-600/40 text-blue-200 rounded-lg text-xs">
                                    Detail
                                </a>
                            </td>

                            {{-- AKSI BUTTON --}}
                            <td class="p-3">

                                @if ($user->role !== 'admin' && $user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin mengeluarkan user ini? Semua proyek & tugas terkait akan dihapus!');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-3 py-1 bg-red-600/30 hover:bg-red-600/40 text-red-300 rounded-lg text-xs">
                                            Kick
                                        </button>

                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm">-</span>
                                @endif

                            </td>


                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>

</x-admin-layout>
