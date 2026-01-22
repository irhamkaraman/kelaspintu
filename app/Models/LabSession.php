<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabSession extends Model
{
    protected $fillable = [
        'kelas_id',
        'judul',
        'deskripsi',
        'bahasa_pemrograman',
        'template_code',
        'test_cases',
        'deadline',
    ];

    protected $casts = [
        'test_cases' => 'array',
        'deadline' => 'datetime',
    ];

    /**
     * Get the kelas that owns the lab session
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get all submissions for this lab session
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(LabSubmission::class);
    }

    /**
     * Check if deadline sudah lewat
     */
    public function sudahLewat(): bool
    {
        return $this->deadline && $this->deadline->isPast();
    }

    /**
     * Get submission dari user tertentu
     */
    public function getUserSubmission($userId)
    {
        return $this->submissions()->where('user_id', $userId)->latest()->first();
    }
}
