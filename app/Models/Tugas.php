<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tugas extends Model
{
    public $timestamps = false;
    
    protected $table = 'tugas';
    
    protected $fillable = [
        'kelas_id',
        'judul',
        'deskripsi',
        'deadline',
        'jenis_file',
        'ukuran_maks_mb',
        'validasi_konten',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'jenis_file' => 'array',
            'validasi_konten' => 'array',
        ];
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class);
    }

    public function sudahDikumpulkan($userId)
    {
        return $this->pengumpulan()->where('user_id', $userId)->first();
    }

    public function sudahLewatDeadline()
    {
        return Carbon::now()->isAfter($this->deadline);
    }
}
