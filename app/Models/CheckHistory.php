<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'url',
        'status',
        'result',
        'checked_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'result'     => 'array',
        'checked_at' => 'datetime',
    ];

    /**
     * Get the user that owns this check history entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
