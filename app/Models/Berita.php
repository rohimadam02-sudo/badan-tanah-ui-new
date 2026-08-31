<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

class Berita extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'kategori',
        'penulis',
        'views',
        'status',
        'status_approval',
        'approval_history',
        'gambar',
        'tanggal_publikasi',
    ];

    protected $casts = [
        'approval_history' => 'array',
        'tanggal_publikasi' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'status', 'status_approval', 'kategori'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * =========================================================
     * LARAVEL SCOUT - Searchable Array
     * =========================================================
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'ringkasan' => $this->ringkasan,
            'konten' => strip_tags($this->konten),
            'kategori' => $this->kategori,
            'penulis' => $this->penulis,
            'status' => $this->status,
            'tanggal_publikasi' => $this->tanggal_publikasi?->format('Y-m-d'),
        ];
    }

    public function searchableAs(): string
    {
        return 'berita_index';
    }

    /**
     * Hanya berita yang dipublikasikan yang bisa dicari
     */
    public function shouldBeSearchable(): bool
    {
        return $this->status === 'Dipublikasikan';
    }

    /**
     * =========================================================
     * APPROVAL HISTORY METHODS
     * =========================================================
     */
    public function addApprovalHistory($action, $note = null)
    {
        $history = $this->approval_history ?? [];
        
        $history[] = [
            'action' => $action,
            'user' => auth()->user()->name,
            'role' => auth()->user()->role,
            'note' => $note,
            'timestamp' => now()->toDateTimeString(),
        ];
        
        $this->approval_history = $history;
        $this->save();

        $logMessage = match($action) {
            'created' => 'menambahkan berita "' . $this->judul . '"',
            'updated' => 'mengubah berita "' . $this->judul . '"',
            'deleted' => 'menghapus berita "' . $this->judul . '"',
            'submit' => 'mensubmit berita "' . $this->judul . '" untuk approval',
            'approve' => 'menyetujui berita "' . $this->judul . '"',
            'publish' => 'mempublikasikan berita "' . $this->judul . '"',
            'unpublish' => 'mengarsipkan berita "' . $this->judul . '"',
            default => $action . ' berita "' . $this->judul . '"',
        };

        activity()
            ->performedOn($this)
            ->causedBy(auth()->user())
            ->event($action)
            ->log($logMessage);
    }

    public function getApprovalHistory()
    {
        return $this->approval_history ?? [];
    }

    /**
     * =========================================================
     * SCOPES
     * =========================================================
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'Dipublikasikan');
    }

    public function scopePending($query)
    {
        return $query->where('status_approval', 'Menunggu Approval');
    }

    public function scopeDraft($query)
    {
        return $query->where('status_approval', 'Draft');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_approval', 'Disetujui');
    }

    public function getStatusBadgeColorAttribute()
    {
        return match($this->status_approval) {
            'Draft' => 'bg-yellow-100 text-yellow-700',
            'Menunggu Approval' => 'bg-orange-100 text-orange-700',
            'Disetujui' => 'bg-blue-100 text-blue-700',
            'Dipublikasikan' => 'bg-green-100 text-green-700',
            'Arsip' => 'bg-gray-200 text-gray-600',
            default => 'bg-gray-100 text-gray-500',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status_approval) {
            'Draft' => 'Draft',
            'Menunggu Approval' => 'Menunggu Approval',
            'Disetujui' => 'Disetujui',
            'Dipublikasikan' => 'Dipublikasikan',
            'Arsip' => 'Diarsipkan',
            default => $this->status_approval ?? 'Draft',
        };
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'penulis', 'name');
    }
}