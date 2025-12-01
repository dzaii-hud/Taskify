<x-admin-layout title="Assign Proyek ke User">

    <div class="p-6">

        <h1 class="text-2xl font-semibold text-purple-300 mb-4">Assign Proyek</h1>

        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">

            {{-- FORM LAMA (SINGLE USER) - TIDAK DIHAPUS --}}
            <form action="{{ route('admin.assign.project') }}" method="POST" class="mb-10">
                @csrf

                <h2 class="text-lg font-semibold text-gray-200 mb-3">Assign ke 1 User</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-300 text-sm">Pilih User</label>
                        <select name="user_id" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-gray-300 text-sm">Pilih Proyek</label>
                        <select name="project_id" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                            <option value="">-- Pilih Proyek --</option>
                            @foreach ($projects as $p)
                                <option value="{{ $p->id }}">{{ $p->display_name }} (Owner:
                                    {{ optional($p->owner)->name ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="px-4 py-2 bg-blue-600 rounded text-white">Assign</button>
                </div>
            </form>


            {{-- FORM BARU (MULTIPLE USER) --}}
            <form action="{{ route('admin.assign.project.multiple') }}" method="POST">
                @csrf

                <h2 class="text-lg font-semibold text-green-300 mb-3">Assign ke Banyak User</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- MULTIPLE USER --}}
                    <div>
                        <label class="text-gray-300 text-sm">Pilih Banyak User</label>
                        <select name="users[]" multiple size="6"
                            class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">* Tekan CTRL untuk memilih banyak user</p>
                    </div>

                    {{-- PROJECT --}}
                    <div>
                        <label class="text-gray-300 text-sm">Pilih Proyek</label>
                        <select name="project_id" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                            <option value="">-- Pilih Proyek --</option>
                            @foreach ($projects as $p)
                                <option value="{{ $p->id }}">{{ $p->display_name }} (Owner:
                                    {{ optional($p->owner)->name ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4">
                    <button class="px-4 py-2 bg-green-600 rounded text-white">Assign Multiple</button>
                </div>

            </form>

        </div>

    </div>

</x-admin-layout>
