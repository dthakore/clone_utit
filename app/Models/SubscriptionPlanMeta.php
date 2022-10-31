<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanMeta extends Model
{
    use HasFactory;

    protected $table = 'subscription_plan_meta';

    protected $fillable = [
        "title",
        "key",
        "value",
        "plan_id",
        "created_at",
        "updated_at"
    ];
}
