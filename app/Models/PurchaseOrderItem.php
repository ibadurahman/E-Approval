<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'item_id',
        'sub_item_id',
        'remarks',
        'qty',
        'price'
    ];

    public function Item(){
        return $this->belongsTo(Item::class);
    }

    public function SubItem(){
        return $this->belongsTo(SubItem::class);
    }
}
