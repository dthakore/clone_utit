<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const IS_ACTIVE_SELECT = [
        '1' => 'Yes',
        '2' => 'No',
    ];

    public const IS_FEATURE_SELECT = [
        '1' => 'Yes',
        '2' => 'No',
    ];

    public const IS_SUBSCRIPTION_ENABLED_SELECT = [
        '1' => 'Yes',
        '2' => 'No',
    ];

    public $table = 'ecom_products';

    public static $searchable = [
        'name',
    ];

    protected $appends = [
        'photo',
    ];

    protected $dates = [
        'sale_start_date',
        'sale_end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'sku',
        'price',
        'short_description',
        'description',
        'agent',
        'licenses',
        'is_active',
        'is_delete',
        'is_featured',
        'tag',
        'is_subscription_enabled',
        'sale_price',
        'sale_start_date',
        'sale_end_date',
        'category_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'level_one_affiliate',
        'level_two_affiliate'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getSaleStartDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setSaleStartDateAttribute($value)
    {
        $this->attributes['sale_start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getSaleEndDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setSaleEndDateAttribute($value)
    {
        $this->attributes['sale_end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function user()
    {
        return $this->hasMany(User::class, 'product_id', 'id');
    }

    public function subscriptionMeta()
    {
        return $this->hasMany(SubscriptionMeta::class, 'plan_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
