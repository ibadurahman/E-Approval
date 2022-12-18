<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Dealer;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\ClosePurchaseOrder;
use Illuminate\Support\Facades\DB;
use App\DataTables\ClosePurchaseOrderDataTable;

class ClosePurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClosePurchaseOrderDataTable $dataTable)
    {
        return $dataTable->render('closePurchaseOrder.index',[
            'title' => 'Close Purchase Order',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Dealer $dealer, PurchaseOrder $purchaseOrder)
    {
        $approvals = [
            'level_1_position'  => null,
            'level_1_name'      => null,
            'level_2_position'  => null,
            'level_2_name'      => null,
            'level_3_position'  => null,
            'level_3_name'      => null,
        ];
        if(!is_null($purchaseOrder->level_1_approved_by)){
            $approvals['level_1_position']  = call_user_func(function() use($purchaseOrder){
                $positionId = DB::table('model_has_position')->where('user_id',$purchaseOrder->level_1_approved_by)->first();
                return Position::where('id',$positionId->position_id)->first()->name;
            });
            $approvals['level_1_name']      = call_user_func(function() use($purchaseOrder){
                $user = User::where('id',$purchaseOrder->level_1_approved_by)->first();
                return $user->name;
            });;
        }
        if(!is_null($purchaseOrder->level_2_approved_by)){
            $approvals['level_2_position']  = call_user_func(function() use($purchaseOrder){
                $positionId = DB::table('model_has_position')->where('user_id',$purchaseOrder->level_2_approved_by)->first();
                return Position::where('id',$positionId->position_id)->first()->name;
            });
            $approvals['level_2_name']      = call_user_func(function() use($purchaseOrder){
                $user = User::where('id',$purchaseOrder->level_2_approved_by)->first();
                return $user->name;
            });;
        }
        if(!is_null($purchaseOrder->level_3_approved_by)){
            $approvals['level_3_position']  = call_user_func(function() use($purchaseOrder){
                $positionId = DB::table('model_has_position')->where('user_id',$purchaseOrder->level_3_approved_by)->first();
                return Position::where('id',$positionId->position_id)->first()->name;
            });
            $approvals['level_3_name']      = call_user_func(function() use($purchaseOrder){
                $user = User::where('id',$purchaseOrder->level_3_approved_by)->first();
                return $user->name;
            });;
        }

        $is_approved = [
            'level_1_approved_by'   => null,
            'level_1_approved_sign' => null,
            'level_2_approved_by'   => null,
            'level_2_approved_sign' => null,
            'level_3_approved_by'   => null,
            'level_3_approved_sign' => null,
        ];
        if (!is_null($purchaseOrder->level_1_is_approved)) {
            $is_approved['level_1_approved_by']     = $purchaseOrder->level_1_is_approved;
            $is_approved['level_1_approved_sign']   = call_user_func(function() use ($purchaseOrder){
                $user = User::where('id',$purchaseOrder->level_1_is_approved)->first();
                return $user->sign;
            });
        }
        if (!is_null($purchaseOrder->level_2_is_approved)) {
            $is_approved['level_2_approved_by']     = $purchaseOrder->level_2_is_approved;
            $is_approved['level_2_approved_sign']   = call_user_func(function() use ($purchaseOrder){
                $user = User::where('id',$purchaseOrder->level_2_is_approved)->first();
                return $user->sign;
            });
        }
        if (!is_null($purchaseOrder->level_3_is_approved)) {
            $is_approved['level_3_approved_by']     = $purchaseOrder->level_3_is_approved;
            $is_approved['level_3_approved_sign']   = call_user_func(function() use ($purchaseOrder){
                $user = User::where('id',$purchaseOrder->level_3_is_approved)->first();
                return $user->sign;
            });
        }
        
        return view('closePurchaseOrder.create',[
            'title'             => 'Close Purchase Order',
            'dealer'            => $dealer,
            'purchaseOrder'     => $purchaseOrder,
            'purchaseOrderItem' => PurchaseOrderItem::where('purchase_order_id',$purchaseOrder->id)->get(),
            'created_by'        => call_user_func(function() use($purchaseOrder){
                return User::where('id',$purchaseOrder->created_by)->first()->name;
            }),
            'approval'      => $approvals,
            'is_approved'   => $is_approved,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClosePurchaseOrder  $closePurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ClosePurchaseOrder $closePurchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClosePurchaseOrder  $closePurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ClosePurchaseOrder $closePurchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClosePurchaseOrder  $closePurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClosePurchaseOrder $closePurchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClosePurchaseOrder  $closePurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClosePurchaseOrder $closePurchaseOrder)
    {
        //
    }
}
