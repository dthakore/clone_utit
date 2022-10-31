<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    public const IS_USED = [
        '1' => 'Used',
        '0' => 'Available',
    ];

    public $table = 'ecom_order_subscription';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'invoice_id',
        'order_id',
        'licence_key',
        'user_id',
        'status',
        'cycle_start_at',
        'cycle_end_at',
        'expire_on',
        'product_id',
        'is_used',
        'created_at',
        'updated_at'
    ];
}
