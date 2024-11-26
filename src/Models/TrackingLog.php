<?php

namespace MohsenMhm\LaravelTracking\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingLog extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'method',
        'request_data',
        'response_data',
    ];
}