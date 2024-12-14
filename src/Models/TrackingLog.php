<?php

namespace MohsenMhm\LaravelTracking\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingLog extends Model
{
    protected $table = 'request_logs';

    protected $fillable = [
        'method',
        'url',
        'headers',
        'body',
        'user_id',
        'ip_address',
        'user_agent',
        'response_status',
    ];

    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}