<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankRuleSMap extends Model
{
    use HasFactory;

    public $table = 'rank_rules_mapping';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'rank_id',
        'key',
        'value',
        'comment',
        'created_at',
        'updated_at',
    ];

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
