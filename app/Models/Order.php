<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Order extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;

    public const ORDER_STATUS_SELECT = [
        1 => 'Processing',
        2 => 'Completed',
        3 => 'Cancelled',
        4 => 'Shipped',
        5 =>'Pending'
    ];

    public $table = 'ecom_orders';

    protected $dates = [
        'invoice_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'order',
        'user_id',
        'vat',
        'vat_percentage',
        'vat_number',
        'company',
        'order_status',
        'order_origin',
        'building',
        'street',
        'region',
        'postcode',
        'city',
        'country_id',
        'order_total',
        'discount',
        'net_total',
        'invoice_number',
        'invoice_date',
        'is_subscription_enabled',
        'order_comment',
        'user_name',
        'email',
        'voucher_code',
        'voucher_discount',
        'address_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class,'order_id','order');
    }

    public function getInvoiceDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setInvoiceDateAttribute($value)
    {
        $this->attributes['invoice_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getPaymentDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
