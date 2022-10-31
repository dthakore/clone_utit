<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationSteps extends Model
{
    use HasFactory;

    public $table = 'registration_steps';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'product_id',
        'step_number',
        'status_name',
        'comment',
        'font_icon_class',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
