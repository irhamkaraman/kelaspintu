<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class SubModul extends Model
{
    protected $table = 'sub_modul';
    
    protected $fillable = [
        'modul_id',
        'judul',
        'konten',
        'urutan',
        'estimasi_menit',
        'file_path',
        'file_name',
        'link_eksternal'
    ];

    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(ProgressModul::class);
    }

    public function isSelesaiBy($userId): bool
    {
        return $this->progress()
            ->where('user_id', $userId)
            ->where('selesai', true)
            ->exists();
    }

    public function simpanFile($file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('modul-files', $filename, 'public');
        return $path;
    }

    public function hapusFile(): void
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            Storage::disk('public')->delete($this->file_path);
        }
    }

    public function getNextSubModul()
    {
        return SubModul::where('modul_id', $this->modul_id)
            ->where('urutan', '>', $this->urutan)
            ->orderBy('urutan')
            ->first();
    }

    public function getPreviousSubModul()
    {
        return SubModul::where('modul_id', $this->modul_id)
            ->where('urutan', '<', $this->urutan)
            ->orderBy('urutan', 'desc')
            ->first();
    }
}
