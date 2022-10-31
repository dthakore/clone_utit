<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionRule extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const AMOUNT_TYPE_RADIO = [
        '0' => 'Fixed',
        '1' => 'Percentage',
    ];

    public const WALLET_STATUS_RADIO = [
        '0' => 'Pending',
        '1' => 'Confirmed',
    ];

    public const USER_LEVEL_SELECT = [
        'User'    => 'User',
        'Level 1' => 'Level 1',
        'Level 2' => 'Level 2',
        'Level 3' => 'Level 3',
        'Level 4' => 'Level 4',
        'Level 5' => 'Level 5',
        'Level 6' => 'Level 6',
        'Level 7' => 'Level 7',
        'Level 8' => 'Level 8',
        'Level 9' => 'Level 9',
        'Level 10' => 'Level 10',
    ];

    public $table = 'commission_rules';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'commission_plan_id',
        'user_level',
        'rank_id',
        'product_id',
        'category_id',
        'amount_type',
        'amount',
        'wallet_type_id',
        'wallet_reference_id',
        'denomination_id',
        'wallet_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function commission_plan()
    {
        return $this->belongsTo(Plan::class, 'commission_plan_id');
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function wallet_type()
    {
        return $this->belongsTo(WalletType::class, 'wallet_type_id');
    }

    public function wallet_reference()
    {
        return $this->belongsTo(WalletMetaType::class, 'wallet_reference_id');
    }

    public function denomination()
    {
        return $this->belongsTo(Denomination::class, 'denomination_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
