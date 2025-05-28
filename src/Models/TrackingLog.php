<?php

namespace MohsenMhm\LaravelTracking\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

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

    /**
     * Create a new instance of the model.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Set the connection based on config
        if (config('tracking.database_connection')) {
            $this->connection = config('tracking.database_connection');
        }
    }

    public function resolvedUser()
    {
        return User::on(config('database.default'))->find($this->user_id);
    }
}