<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressModul extends Model
{
    protected $table = 'progress_modul';
    
    protected $fillable = [
        'user_id',
        'sub_modul_id',
        'selesai',
        'waktu_selesai'
    ];

    protected $casts = [
        'selesai' => 'boolean',
        'waktu_selesai' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subModul(): BelongsTo
    {
        return $this->belongsTo(SubModul::class);
    }
}
