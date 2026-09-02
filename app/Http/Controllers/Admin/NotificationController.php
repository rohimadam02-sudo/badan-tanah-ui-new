<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Get all notifications
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $isAjax = $request->ajax() || $request->wantsJson() || $request->input('ajax') == 1;
        
        // Jika AJAX, ambil langsung tanpa cache
        if ($isAjax) {
            $data = $this->getNotificationsData($limit);
            return response()->json($data);
        }
        
        // Jika bukan AJAX, ambil langsung
        $data = $this->getNotificationsData($limit);
        
        return view('admin.notifications', [
            'notifications' => $data['notifications'],
            'totalCount' => $data['total'],
        ]);
    }

    /**
     * Get notifications data (dipisahkan agar reusable)
     */
    private function getNotificationsData($limit = 10)
    {
        // Notifikasi dari Berita (Menunggu Approval)
        $pendingNews = Berita::where('status_approval', 'Menunggu Approval')
            ->select('id', 'judul as title', 'status_approval as type', 'created_at', DB::raw("'berita' as source"))
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => 'pending_approval',
                    'source' => 'berita',
                    'icon' => 'fa-clock',
                    'icon_color' => 'orange-500',
                    'icon_bg' => 'orange-50',
                    'message' => 'Menunggu approval',
                    'link' => route('admin.berita.edit', $item->id),
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at->toDateTimeString(),
                ];
            })
            ->values()
            ->toArray();

        // Notifikasi dari Kontak (Belum Dibaca)
        $unreadContacts = Kontak::where('is_read', 0)
            ->select('id', 'nama as title', 'pesan as content', 'created_at', DB::raw("'kontak' as source"))
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'content' => $item->content,
                    'type' => 'unread_contact',
                    'source' => 'kontak',
                    'icon' => 'fa-envelope',
                    'icon_color' => 'blue-500',
                    'icon_bg' => 'blue-50',
                    'message' => 'Pesan baru dari ' . $item->title,
                    'link' => route('admin.kontak.show', $item->id),
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at->toDateTimeString(),
                ];
            })
            ->values()
            ->toArray();

        // Gabungkan dan urutkan berdasarkan waktu (array murni)
        $notifications = array_merge($pendingNews, $unreadContacts);

        // Urutkan berdasarkan created_at descending
        usort($notifications, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // Ambil sesuai limit
        $notifications = array_slice($notifications, 0, $limit);

        // Hitung total
        $totalPending = Berita::where('status_approval', 'Menunggu Approval')->count();
        $totalUnread = Kontak::where('is_read', 0)->count();
        $totalCount = $totalPending + $totalUnread;

        return [
            'notifications' => $notifications,
            'total' => $totalCount,
            'pending_news' => $totalPending,
            'unread_contacts' => $totalUnread,
        ];
    }

    /**
     * Get unread count only (for badge)
     */
    public function unreadCount()
    {
        $pendingNews = Berita::where('status_approval', 'Menunggu Approval')->count();
        $unreadContacts = Kontak::where('is_read', 0)->count();
        
        return response()->json([
            'count' => $pendingNews + $unreadContacts,
            'pending_news' => $pendingNews,
            'unread_contacts' => $unreadContacts,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        // Tandai semua kontak sebagai sudah dibaca
        Kontak::where('is_read', 0)->update(['is_read' => 1]);
        
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
        ]);
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead($id, Request $request)
    {
        $type = $request->input('type', 'kontak');

        if ($type == 'kontak') {
            $kontak = Kontak::find($id);
            if ($kontak) {
                $kontak->is_read = 1;
                $kontak->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca'
        ]);
    }
}