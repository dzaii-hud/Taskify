<x-admin-layout title="Notifikasi Admin">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-purple-300">Daftar Notifikasi</h2>

        <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">

            @csrf
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg shadow-md transition">
                Tandai Semua Dibaca
            </button>
        </form>
    </div>

    @if ($notifications->count() == 0)
        <div class="p-6 bg-[#1a1a2e] rounded-lg text-center text-gray-400">
            Belum ada notifikasi untuk Anda.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($notifications as $notif)
                <div
                    class="p-4 rounded-lg border bg-[#131325]
                    {{ $notif->is_read ? 'border-gray-700' : 'border-purple-600 shadow-lg shadow-purple-600/20' }}">

                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-purple-300">
                                {{ $notif->title }}
                            </h3>
                            <p class="text-gray-300 text-sm mt-1">
                                {{ $notif->message }}
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                {{ $notif->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">

                            {{-- Tombol detail --}}
                            <a href="{{ route('admin.notifications.show', $notif->id) }}"
                                class="px-3 py-1 bg-purple-700/40 hover:bg-purple-700/60 rounded-lg text-sm">
                                Detail
                            </a>

                            {{-- Tombol tandai baca --}}
                            @if (!$notif->is_read)
                                <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 bg-green-600 hover:bg-green-700 rounded-lg text-sm">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif

</x-admin-layout>
