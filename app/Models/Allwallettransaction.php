<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Allwallettransaction extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;
    
    public const TRANSACTION_TYPE_SELECT = [
        '1' => 'Credit',
        '2' => 'Debit',
    ];

    public const TRANSACTION_STATUS_SELECT = [
        '1' => 'Pending',
        '2' => 'On Hold',
        '3' => 'Approved',
        '4' => 'Rejected',
    ];

    public const PORTAL_SELECT = [
        '1' => 'CBM',
        '2' => 'IrisCall',
        '3' => 'MMC',
        '4' => 'CABAMA',
        '5' => 'Force International',
    ];

    public $table = 'all_wallet_transactions';

    public static $searchable = [
        'transaction_comment',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'wallet_type_id',
        'transaction_type',
        'reference_id',
        'reference_num',
        'transaction_comment',
        'denomination_id',
        'transaction_status',
        'portal',
        'amount',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wallet_type()
    {
        return $this->belongsTo(WalletType::class, 'wallet_type_id');
    }

    public function reference()
    {
        return $this->belongsTo(WalletMetaType::class, 'reference_id');
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
