<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pengumpulan extends Model
{
    protected $table = 'pengumpulan';
    
    protected $fillable = [
        'tugas_id',
        'user_id',
        'file_path',
        'link_unduhan',
        'deskripsi_link',
        'status',
        'nilai',
        'feedback',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function simpanFile($file, $tugasId, $userId)
    {
        $timestamp = now()->timestamp;
        $extension = $file->getClientOriginalExtension();
        $filename = "{$userId}_{$tugasId}_{$timestamp}.{$extension}";
        
        $path = $file->storeAs('tugas', $filename, 'local');
        
        return $path;
    }

    public function hapusFile()
    {
        if ($this->file_path && Storage::disk('local')->exists($this->file_path)) {
            Storage::disk('local')->delete($this->file_path);
        }
    }

    public function downloadUrl()
    {
        if ($this->file_path) {
            return route('pengumpulan.download', $this->id);
        }
        return $this->link_unduhan;
    }

    public function namaFile()
    {
        if ($this->file_path) {
            return basename($this->file_path);
        }
        return 'Link eksternal';
    }
}
