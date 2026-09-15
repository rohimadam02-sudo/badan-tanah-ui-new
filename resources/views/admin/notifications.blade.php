@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')

    <div class="max-w-7xl mx-auto">

        {{-- HEADER (MOBILE FRIENDLY) --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-500/20 flex items-center justify-center shrink-0">
                    <i class="fas fa-bell text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Notifikasi</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">Semua notifikasi dan aktivitas
                        terbaru.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-2 sm:gap-3 w-full sm:w-auto">
                @if ($totalCount > 0)
                    <button onclick="markAllAsRead()"
                        class="inline-flex items-center justify-center gap-2 w-full sm:w-auto text-xs sm:text-sm font-semibold text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 px-4 py-3 sm:py-2.5 rounded-lg transition shadow-sm">
                        <i class="fas fa-check-double"></i>
                        <span>{{ $isEnglish ? 'Mark all as read' : 'Tandai semua' }}</span>
                    </button>
                @endif

                <span
                    class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto text-xs text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-4 py-3 sm:py-2.5 rounded-lg">
                    <i class="fas fa-bell text-[10px]"></i>
                    <span>{{ $totalCount }} {{ $isEnglish ? 'notifications' : 'notifikasi' }}</span>
                </span>
            </div>
        </div>

        {{-- NOTIFICATION LIST --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-100">

                @forelse($notifications as $item)
                    @php
                        $icon = $item['icon'] ?? 'fa-circle-info';
                        $iconBg = $item['icon_bg'] ?? 'blue-50';
                        $iconColor = $item['icon_color'] ?? 'blue-600';
                        $type = $item['type'] ?? 'info';
                        $link = $item['link'] ?? '#';
                        $title = $item['title'] ?? 'Notifikasi';
                        $message = $item['message'] ?? ($item['content'] ?? '');
                        $time = $item['time'] ?? '';
                    @endphp

                    <div class="flex items-start gap-4 px-6 py-4 hover:bg-gray-50 transition group">
                        <div
                            class="w-10 h-10 rounded-xl bg-{{ $iconBg }} flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $icon }} text-{{ $iconColor }} text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-semibold text-gray-900">{{ $title }}</p>
                                @if ($type == 'pending_approval')
                                    <span
                                        class="text-[10px] font-bold bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">Menunggu
                                        Approval</span>
                                @elseif($type == 'unread_contact')
                                    <span
                                        class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Pesan
                                        Baru</span>
                                @endif
                            </div>
                            @if ($message)
                                <p class="text-sm text-gray-500 mt-0.5">{{ $message }}</p>
                            @endif
                            <div class="flex items-center gap-4 mt-1.5">
                                <span class="text-xs text-gray-400">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $time }}
                                </span>
                                @if ($link != '#')
                                    <a href="{{ $link }}"
                                        class="text-xs font-semibold text-blue-600 hover:underline">
                                        Lihat Detail <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-[#006400] flex-shrink-0 mt-1.5"></span>
                    </div>

                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                            <i class="fas fa-check-circle text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Semua sudah dibaca</h3>
                        <p class="text-sm text-gray-500 mt-1">Tidak ada notifikasi baru saat ini.</p>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <p class="text-xs text-gray-500">Total Notifikasi</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalCount }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <p class="text-xs text-gray-500">Menunggu Approval</p>
                <p class="text-2xl font-bold text-orange-600">
                    {{ is_array($notifications) ? count(array_filter($notifications, fn($item) => ($item['type'] ?? '') == 'pending_approval')) : $notifications->where('type', 'pending_approval')->count() }}
                </p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <p class="text-xs text-gray-500">Pesan Belum Dibaca</p>
                <p class="text-2xl font-bold text-blue-600">
                    {{ is_array($notifications) ? count(array_filter($notifications, fn($item) => ($item['type'] ?? '') == 'unread_contact')) : $notifications->where('type', 'unread_contact')->count() }}
                </p>
            </div>
        </div>
    </div>

    <script>
        function markAllAsRead() {
            if (!confirm('Tandai semua notifikasi sebagai dibaca?')) return;

            fetch('{{ route('admin.notifications.mark-all-read') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(() => {
                    window.location.reload();
                });
        }
    </script>

@endsection
