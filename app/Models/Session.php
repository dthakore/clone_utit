<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const STATUS_SELECT = [
        'OPEN' => 'OPEN',
        'CLOSE' => 'CLOSE',
    ];

    public $table = 'crypto_sessions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bot_id',
        'user_id',
        'status',
        'lowest',
        'highest',
        'last_buy',
        'average_buy',
        'total_buy',
        'cover',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bot()
    {
        return $this->belongsTo(Bot::class, 'bot_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trades() {
        return $this->hasMany(Trade::class, 'session_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
