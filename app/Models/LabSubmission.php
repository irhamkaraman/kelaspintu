<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabSubmission extends Model
{
    protected $fillable = [
        'lab_session_id',
        'user_id',
        'source_code',
        'language',
        'status',
        'output',
        'error_message',
        'execution_time',
        'memory_used',
        'score',
        'test_results',
    ];

    protected $casts = [
        'test_results' => 'array',
        'execution_time' => 'float',
        'memory_used' => 'integer',
        'score' => 'integer',
    ];

    /**
     * Get the lab session
     */
    public function labSession(): BelongsTo
    {
        return $this->belongsTo(LabSession::class);
    }

    /**
     * Get the user (mahasiswa) who submitted
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
