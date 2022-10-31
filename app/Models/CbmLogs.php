<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbmLogs extends Model
{
    use HasFactory;

    public $table = 'cbm_logs';

    protected $dates = [
        'created_at',
        'updated_at',
        'date',
    ];

    protected $fillable = [
        'date',
        'log',
        'status',
        'timetaken',
        'total_accounts',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
