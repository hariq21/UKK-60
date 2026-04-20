<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    use HasFactory;

    public const STATUS_SEDANG_DIVERIFIKASI = 'sedang_diverifikasi';
    public const STATUS_SEDANG_DIKERJAKAN = 'sedang_dikerjakan';
    public const STATUS_SELESAI = 'selesai';

    public const STATUS_LABELS = [
        self::STATUS_SEDANG_DIVERIFIKASI => 'Sedang Diverifikasi',
        self::STATUS_SEDANG_DIKERJAKAN => 'Sedang Dikerjakan',
        self::STATUS_SELESAI => 'Selesai',
    ];

    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'deskripsi',
        'foto',
        'status',
        'umpan_balik',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucwords(str_replace('_', ' ', (string) $this->status));
    }
}
