<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_num',
        'dealer_id',
        'created_by',
        'release_date',
        'level_1_is_approved',
        'level_1_approved_by',
        'level_1_approved_time',
        'level_2_is_approved',
        'level_2_approved_by',
        'level_2_approved_time',
        'level_3_is_approved',
        'level_3_approved_by',
        'level_3_approved_time',
        'status',
    ];

    public static function generatePONumber(int $dealerCode) : string
    {
        $dealer = Dealer::where('code',$dealerCode)->first();
        $lastPONumber = PurchaseOrder::where('dealer_id',$dealer->id)->orderBy('created_at','desc')->first();
        if(!$lastPONumber){
            $lastPONumber = 0;
        }else{
            $lastPONumber = substr($lastPONumber->po_num,11,4);
            $lastPONumber = (int) $lastPONumber;
        }
        $poNumber = 'PO';
        $poNumber.= str_pad($dealerCode,5,"0",STR_PAD_LEFT);
        $poNumber.= Date('ym');
        $poNumber.= str_pad($lastPONumber+1,4,"0",STR_PAD_LEFT);

        return $poNumber;
    }
}
