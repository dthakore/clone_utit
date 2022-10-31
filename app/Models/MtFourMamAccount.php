<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CbmMtFourAccount;

class MtFourMamAccount extends Model
{
    use HasFactory;

    public $table = 'mt_four_mam_accounts';

    protected $fillable = [
        'account_id',
        'login',
        'agent',
        'group',
        'broker',
        'asset_manager',
        'agent_name',
        'minimum_deposit',
        'parent_agent',
        'brand_name',
        'created_at',
        'updated_at',
    ];

    public function account()
    {
        return $this->hasMany(CbmMtFourAccount::class, 'category_id', 'id');
    }
}
