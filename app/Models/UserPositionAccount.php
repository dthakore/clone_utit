<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPositionAccount extends Model
{
    use Auditable;
    use HasFactory;

    public const TYPE_SELECT = [
        'Self Funded'      => 'Self Funded',
        'Profit Funded'    => 'Profit Funded',
        'Incubator Funded' => 'Incubator Funded',
    ];

    public $table = 'user_position_accounts';

    public static $searchable = [
        'user_account_num',
        'login',
        'email_address',
    ];

    protected $dates = [
        'added_to_matrix_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_account_num',
        'login',
        'type',
        'email_address',
        'beneficiary',
        'agent_num',
        'balance',
        'equity',
        'max_balance',
        'max_equity',
        'matrix_node_num',
        'matrix',
        'user_ownership',
        'added_to_matrix_at',
        'previous_login',
        'cluster',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getAddedToMatrixAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setAddedToMatrixAtAttribute($value)
    {
        $this->attributes['added_to_matrix_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
