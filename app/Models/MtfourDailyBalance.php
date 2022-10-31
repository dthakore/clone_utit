<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtfourDailyBalance extends Model
{
    use HasFactory;

    public $table = 'mt_four_daily_balances';

    protected $fillable = [
        'account',
        'email',
        'agent',
        'group',
        'balance',
        'equity',
        'created_at',
        'updated_at',
    ];
}
