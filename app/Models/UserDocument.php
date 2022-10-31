<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    public const TYPE = [
        '1' => 'LPOA',
        '2' => 'B2B',
    ];

    public const STATUS = [
        '1' => 'Admin generated',
        '2' => 'User Processed',
        '3' => 'Email Sent'
    ];

    public $table = 'user_documents';

    protected $fillable = [
        'name',
        'user_id',
        'path',
        'type',
        'status',
        'comment',
        'account_number',
        'created_at',
        'updated_at',
    ];
}
