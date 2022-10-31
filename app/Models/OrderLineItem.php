<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLineItem extends Model
{
    use HasFactory;

    public $table = 'ecom_order_line_item';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'product_name',
        'item_qty',
        'item_disc',
        'item_price',
        'product_sku',
        'comment',
        'order_id',
        'product_id',
        'created_at',
        'updated_at',
        'licence_key',
        'cycle_ends_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
