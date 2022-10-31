<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPricing extends Model
{
    use HasFactory;

    public $table = 'product_pricing';

    protected $fillable = [
        'licenses',
        'price_per_license',
        'is_cluster',
        'journey_comment',
        'left_action_id',
        'left_action_name',
        'right_action_id',
        'right_action_name',
        'created_at',
        'updated_at',
    ];
}
