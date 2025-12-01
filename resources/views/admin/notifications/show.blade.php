<x-admin-layout title="Detail Notifikasi">

    <div class="p-6 bg-[#131325] rounded-lg border border-purple-700/30">

        <h2 class="text-2xl font-bold text-purple-300 mb-4">
            {{ $notif->title }}
        </h2>

        <p class="text-gray-300 text-lg">
            {{ $notif->message }}
        </p>

        <p class="text-sm text-gray-500 mt-4">
            Waktu: {{ $notif->created_at->format('d M Y, H:i') }}
        </p>

        @if ($notif->task_id)
            <div class="mt-6 p-4 bg-[#1a1a2e] rounded-lg border border-purple-700/20">

                <h3 class="text-lg font-semibold text-purple-400 mb-2">Terkait Tugas:</h3>

                <p class="text-gray-300 text-md mb-3">
                    {{ $notif->task->title ?? '—' }}
                </p>

                <a href="{{ route('admin.tasks.show', $notif->task_id) }}"
                    class="px-4 py-2 bg-purple-700 hover:bg-purple-800 rounded-lg text-sm">
                    Lihat Tugas
                </a>
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('admin.notifications.index') }}"
                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-sm">
                ← Kembali
            </a>
        </div>

    </div>

</x-admin-layout>
