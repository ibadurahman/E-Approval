<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerApproveRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_id',
        'level_1_min_nominal',
        'level_1_position_id',
        'level_2_min_nominal',
        'level_2_position_id',
        'level_3_min_nominal',
        'level_3_position_id',
    ];
}
