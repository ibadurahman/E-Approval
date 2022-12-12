<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerApproveOrganization extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_id',
        'level_1_position_id',
        'level_1_user_id',
        'level_2_position_id',
        'level_2_user_id',
        'level_3_position_id',
        'level_3_user_id'
    ];
}
