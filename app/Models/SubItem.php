<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'name'
    ];

    public function purchaseOrderItems(){
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
