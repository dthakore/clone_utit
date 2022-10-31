<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExpertIcon extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $table = 'experts_icons';

    protected $fillable = [
        'expert_id',
        'image_url',
        'tooltip',
        'created_at',
        'updated_at',
    ];
}
