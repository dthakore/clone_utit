<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    public const EXPERT_TYPE = [
        '1' => 'MAM',
        '2' => 'COPIER MASTER',
        '3' => 'FUND'
    ];

    public const BROKER_TYPE = [
        '1' => 'Euro Trader',
        '2' => 'Domus FX',
    ];

    public const ASSET_MANAGER = [
        '1' => 'Asset 1',
        '2' => 'Asset 2',
    ];

    public const IS_FOREX = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const IS_VERIFIED = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const IS_MANUAL_TRADER = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const CURRENCY = [
        '1' => 'EUR',
        '0' => 'USD',
    ];

    public $table = 'experts';

    protected $fillable = [
        'name',
        'account',
        'type',
        'agent',
        'agent_name',
        'group',
        'broker',
        'asset_manager',
        'minimum_deposit',
        'asset_type',
        'setting',
        'total_investors',
        'aum',
        'is_forex',
        'is_verified',
        'is_manual_trader',
        'currency',
        'performance_fee',
        'abs_gain',
        'max_dd',
        'created_at',
        'updated_at',
    ];
}
