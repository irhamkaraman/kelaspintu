<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modul extends Model
{
    protected $table = 'modul';
    
    protected $fillable = [
        'kelas_id',
        'judul',
        'deskripsi',
        'urutan',
        'status'
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function subModul(): HasMany
    {
        return $this->hasMany(SubModul::class)->orderBy('urutan');
    }

    public function totalSubModul(): int
    {
        return $this->subModul()->count();
    }

    public function progressUser($userId): int
    {
        return $this->subModul()
            ->whereHas('progress', fn($q) => $q->where('user_id', $userId)->where('selesai', true))
            ->count();
    }

    public function persentaseProgress($userId): int
    {
        $total = $this->totalSubModul();
        if ($total === 0) return 0;
        
        $selesai = $this->progressUser($userId);
        return (int) (($selesai / $total) * 100);
    }
}
