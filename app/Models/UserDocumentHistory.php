<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentHistory extends Model
{
    use HasFactory;

    public $table = 'user_document_histories';

    protected $fillable = [
        'document_id',
        'status',
        'comment',
        'created_at',
        'updated_at',
    ];
}
