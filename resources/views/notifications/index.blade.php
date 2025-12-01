<x-dashboard-layout title="Notifikasi">
    <div class="space-y-4">
        <h1 class="text-2xl font-bold">Notifikasi</h1>

        <div class="flex justify-end">
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button class="text-sm px-3 py-1 rounded bg-indigo-50 text-indigo-700">Tandai semua dibaca</button>
            </form>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            @forelse ($notifications as $n)
                <div class="border-b py-3 flex justify-between items-start">
                    <div>
                        <div class="text-sm font-medium">{{ $n->title }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $n->message }}</div>
                        @if ($n->task_id)
                            <div class="text-xs text-gray-400 mt-1">Terkait tugas #{{ $n->task_id }}</div>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-400">{{ $n->created_at->diffForHumans() }}</div>

                        @if (!$n->is_read)
                            <form action="{{ route('notifications.read', $n) }}" method="POST" class="mt-2">
                                @csrf
                                <button class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Tandai
                                    dibaca</button>
                            </form>
                        @else
                            <div class="text-xs text-gray-400 mt-2">Sudah dibaca</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-sm text-gray-500">Belum ada notifikasi.</div>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-dashboard-layout>
