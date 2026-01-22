<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keanggotaan extends Model
{
    public $timestamps = false;
    
    protected $table = 'keanggotaan';
    
    protected $fillable = [
        'kelas_id',
        'user_id',
        'sebagai',
    ];

    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
        ];
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
