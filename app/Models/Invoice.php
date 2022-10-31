<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public $table = 'ecom_order_invoices';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'invoice_number',
        'order_id',
        'invoice_date',
        'subscription_id',
        'vat',
        'vat_percentage',
        'vat_number',
        'company',
        'building',
        'street',
        'region',
        'postcode',
        'city',
        'country_id',
        'order_total',
        'discount',
        'net_total',
        'user_name',
        'email',
        'created_at',
        'updated_at',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
