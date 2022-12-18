<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $table = 'purchase_orders';

    protected $fillable = [
        'level_1_is_approved',
        'level_1_approved_time',
        'level_2_is_approved',
        'level_2_approved_time',
        'level_3_is_approved',
        'level_3_approved_time',
    ];
}
