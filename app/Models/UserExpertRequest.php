<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExpertRequest extends Model
{
    use HasFactory;

    public const STATUS = [
        '1' => 'Processed',
        '0' => 'Pending',
    ];

    public $table = 'user_expert_requests';

    protected $fillable = [
        'user_id',
        'expert_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
