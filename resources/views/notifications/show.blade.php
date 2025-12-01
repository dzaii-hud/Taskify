<x-dashboard-layout title="Detail Notifikasi">

    <div class="space-y-4">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Detail Notifikasi</h1>

            <a href="{{ route('notifications.index') }}" class="text-sm px-3 py-1 rounded bg-indigo-50 text-indigo-700">
                ← Kembali
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl p-5 shadow">

            <div class="mb-3">
                <div class="text-lg font-semibold">{{ $notification->title }}</div>
                <div class="text-xs text-gray-500 mt-1">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                {{ $notification->message }}
            </div>

            @if ($notification->task_id)
                <div class="mt-3 text-xs text-gray-500">
                    Terkait tugas #{{ $notification->task_id }}
                </div>
            @endif

            @if ($notification->action_url)
                <a href="{{ $notification->action_url }}"
                    class="inline-block mt-4 px-4 py-2 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    Lihat Tindakan
                </a>
            @endif

        </div>

    </div>

</x-dashboard-layout>
