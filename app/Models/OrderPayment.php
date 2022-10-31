<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    public $table = 'ecom_order_payment';

    public const PAYMENT_STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Cancelled',
        '2' => 'Success',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'total',
        'payment_mode',
        'payment_ref_id',
        'payment_comment',
        'payment_status',
        'payment_date',
        'transaction_mode',
        'denomination_id',
        'order_id',
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
