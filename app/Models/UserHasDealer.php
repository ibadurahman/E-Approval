<?php

namespace App\Models;

use LDAP\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHasDealer extends Model
{
    use HasFactory;

    protected $table = 'model_has_dealer';

    public static function userHasDealer(int $id) : array 
    {
        $dealers = DB::table('model_has_dealer')->where('user_id',$id)->get();
        $result = [];
        foreach ($dealers as $dealer) {
            $dealerName = Dealer::where('id',$dealer->dealer_id)->first();
            $result[] = $dealerName;
        }
        return $result;
    }
}
