<x-admin-layout title="Assign Proyek">

    <div class="p-6">

        <div class="mb-4">
            <h1 class="text-2xl font-semibold text-purple-300">Assign Proyek</h1>
            <p class="text-gray-400 text-sm">Assign proyek: <strong>{{ $project->display_name }}</strong></p>
        </div>

        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">
            <form action="{{ route('admin.projects.assignMultiple', $project->id) }}" method="POST">

                @csrf

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="text-sm text-gray-300">Assign ke</label>

                        <select name="assigned_to[]" multiple required
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200">

                            @foreach ($users as $u)
                                <option value="{{ $u->id }}" @if ($project->assignedUsers->contains($u->id)) selected @endif>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach

                        </select>

                        <p class="text-xs text-gray-400 mt-1">* Kamu bisa memilih banyak user</p>

                        @error('assigned_to')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded">
                            Assign
                        </button>

                        <a href="{{ route('admin.projects.index') }}" class="ml-3 text-sm text-gray-300">Batal</a>
                    </div>
                </div>
            </form>
        </div>

    </div>

</x-admin-layout>
