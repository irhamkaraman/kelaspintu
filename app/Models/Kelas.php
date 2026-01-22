<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kelas extends Model
{
    public $timestamps = false;
    
    protected $table = 'kelas';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'kode_unik',
        'pembuat_id',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($kelas) {
            if (!$kelas->kode_unik) {
                $kelas->kode_unik = self::generateKodeUnik();
            }
        });
    }

    public static function generateKodeUnik()
    {
        do {
            $kode = strtoupper(Str::random(6));
        } while (self::where('kode_unik', $kode)->exists());
        
        return $kode;
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }

    public function anggota()
    {
        return $this->hasMany(Keanggotaan::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function labSessions()
    {
        return $this->hasMany(LabSession::class);
    }

    public function modul()
    {
        return $this->hasMany(Modul::class)->orderBy('urutan');
    }
}
