<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const SIDE_SELECT = [
        'BUY'  => 'BUY',
        'SELL' => 'SELL',
    ];

    public $table = 'crypto_trades';

    protected $dates = [
        'closed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bot_id',
        'session_id',
        'symbol_id',
        'user_id',
        'requested_amount',
        'side',
        'comment',
        'failure_reason',
        'exchange_order_status',
        'original_orders',
        'exchange_order_ref',
        'exchange_trade_ref',
        'requested_price',
        'requested_quantity',
        'executed_price',
        'executed_amount',
        'executed_quantity',
        'profit_loss',
        'cover_id',
        'status',
        'trade_type',
        'closed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bot()
    {
        return $this->belongsTo(Bot::class, 'bot_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class, 'symbol_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cover()
    {
        return $this->belongsTo(Cover::class, 'cover_id');
    }

    public function getClosedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setClosedAtAttribute($value)
    {
        $this->attributes['closed_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
