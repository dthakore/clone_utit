<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCreditItems extends Model
{
    use HasFactory;

    public $table = 'ecom_order_credit_items';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'credit_memo_id',
        'order_id',
        'order_line_item_id',
        'product_id',
        'product_sku',
        'product_details',
        'product_name',
        'product_price',
        'product_country_name',
        'order_item_qty',
        'refund_item_qty',
        'created_at',
        'updated_at',
    ];

    public function creditMemo()
    {
        return $this->belongsTo(OrderCreditMemo::class, 'credit_memo_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderLineItem::class, 'order_line_item_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
