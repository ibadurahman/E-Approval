<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosePurchaseOrder extends Model
{
    use HasFactory;

    public $table = 'close_purchase_orders';

    protected $fillable = [
        'actual_qty',
        'actual_price',
        'remarks'
    ];
}
