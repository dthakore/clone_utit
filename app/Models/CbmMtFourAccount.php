<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbmMtFourAccount extends Model
{
    use HasFactory;

    public $table = 'mt_four_accounts';

    protected $dates = [
        'registration_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $primaryKey = 'login';

    public $incrementing = false;

    protected $fillable = [
        'login',
        'name',
        'currency',
        'balance',
        'prev_balance',
        'equity',
        'prev_equity',
        'email_address',
        'group',
        'agent',
        'brand',
        'registration_date',
        'address',
        'leverage',
        'city',
        'state',
        'postcode',
        'country',
        'phone_number',
        'max_equity',
        'max_balance',
        'broker_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getRegistrationDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setRegistrationDateAttribute($value)
    {
        $this->attributes['registration_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function broker()
    {
        return $this->belongsTo(MtFourBroker::class, 'broker_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
