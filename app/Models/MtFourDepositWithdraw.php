<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtFourDepositWithdraw extends Model
{
    use HasFactory;

    public const API_TYPE_SELECT = [
        'deposit'  => 'Deposit',
        'withdraw' => 'Withdraw',
    ];

    public const IS_ACCOUNTED_FOR_SELECT = [
        '0' => 'UnProccessed',
        '1' => 'Proccessed',
    ];

    public $table = 'mt_four_deposit_withdraws';

    protected $dates = [
        'open_time',
        'close_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'login',
        'ticket',
        'symbol',
        'email',
        'api_type',
        'lots',
        'type',
        'open_price',
        'open_time',
        'close_price',
        'close_time',
        'profit',
        'commission',
        'agent_commission',
        'comment',
        'magic_number',
        'stop_loss',
        'take_profit',
        'swap',
        'reason',
        'is_accounted_for',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getOpenTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setOpenTimeAttribute($value)
    {
        $this->attributes['open_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getCloseTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setCloseTimeAttribute($value)
    {
        $this->attributes['close_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
