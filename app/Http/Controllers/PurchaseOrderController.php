<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Dealer;
use App\Models\SubItem;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\UserHasDealer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Dealer $dealer)
    {
        return view('purchaseOrder.create',[
            'title'     => 'Create Purchase Order',
            'dealer'    => $dealer,
            'poNumber'  => PurchaseOrder::generatePONumber($dealer->code),
            'items'     => Item::all(),
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
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }

    public function getSubItem(Request $request)
    {
        $subItems = SubItem::where('item_id',$request->item)->get();
        return response()->json($subItems);
    }
}
