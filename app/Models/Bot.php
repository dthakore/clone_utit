<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Bot extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;

    public const IS_ACTIVE_SELECT = [
        1 => 'Yes',
        0 => 'No',
    ];

    public $table = 'crypto_bots';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'user_id',
        'user_exchange_id',
        'symbol_id',
        'balance',
        'is_cycle',
        'init_immediate',
        'init_amount',
        'init_buy_at',
        'init_pullback',
        'take_profit_average_percentage',
        'take_profit_average_retracement',
        'take_profit_independent_cover',
        'take_profit_independent_percentage',
        'take_profit_independent_retracement',
        'status',
        'active_session_id',
        'is_simulated',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id','email','product_id','name');
    }

    public function user_exchange()
    {
        return $this->belongsTo(UserExchange::class, 'user_exchange_id');
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class, 'symbol_id');
    }

    public function active_sessions()
    {
        return $this->belongsToMany(Session::class);
    }

    public function covers()
    {
        return $this->hasMany(Cover::class, 'bot_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
