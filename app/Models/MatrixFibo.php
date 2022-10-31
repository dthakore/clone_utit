<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixFibo extends Model
{
    use HasFactory;

    public $table = 'fibo';

    protected $dates = [
        'created_at'
    ];

    protected $fillable = [
        'accountNum',
        'email',
        'parent',
        'lchild',
        'rchild',
        'active',
        'accountGroup',
        'created_at',
        'user_id'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
