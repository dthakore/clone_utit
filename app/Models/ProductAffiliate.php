<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAffiliate extends Model
{
    use HasFactory;

    public $table = 'ecom_product_affiliate';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'aff_level',
        'amount',
        'type_User_FAN',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
