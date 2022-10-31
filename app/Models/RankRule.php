<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankRule extends Model
{
    use HasFactory;

    public $table = 'rank_rules';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'rank_id',
        'rule_id',
        'value1',
        'value2',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
