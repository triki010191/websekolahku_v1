<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniReply extends Model
{
    protected $fillable = ['thread_id', 'user_id', 'content'];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(AlumniThread::class, 'thread_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
