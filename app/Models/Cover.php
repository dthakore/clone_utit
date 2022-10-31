<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cover extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'crypto_covers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bot_id',
        'index',
        'cover_percentage',
        'buy_x_times',
        'cover_pullback',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bot()
    {
        return $this->belongsTo(Bot::class, 'bot_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
