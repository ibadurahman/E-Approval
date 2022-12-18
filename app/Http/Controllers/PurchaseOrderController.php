<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Dealer;
use App\Models\SubItem;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\UserHasDealer;
use App\Models\PoCreateHasFile;
use App\Models\DealerApproveRule;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DataTables\PurchaseOrderDataTable;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchaseOrderDataTable $dataTable)
    {
        return $dataTable->render('purchaseOrder.index',[
            'title' => 'Purchase Order'
        ]);
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
        // dd(json_decode($request->approval[0])->user_id);
        $purchaseOrder = PurchaseOrder::create([
            'po_num'                => $request->po_num,
            'dealer_id'             => $request->dealer_id,
            'created_by'            => $request->created_by,
            'release_date'          => $request->release_date,
            'level_1_approved_by'   => ($request->approval[0] == null)?null:json_decode($request->approval[0])->user_id,
            'level_2_approved_by'   => ($request->approval[1] == null)?null:json_decode($request->approval[1])->user_id,
            'level_3_approved_by'   => ($request->approval[2] == null)?null:json_decode($request->approval[2])->user_id,
            'status'                => 'review'
        ]);

        foreach ($request->items as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'item_id'           => json_decode($item)->item_id,
                'sub_item_id'       => json_decode($item)->sub_item_id,
                'remarks'           => json_decode($item)->remarks,
                'qty'               => json_decode($item)->qty,
                'price'             => json_decode($item)->price
            ]);
        }

        return redirect()->route('home')->with('success','Data Purchase Order Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
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

        return view('purchaseOrder.show',[
            'title'         => $purchaseOrder->po_num,
            'purchaseOrder' => $purchaseOrder,
            'dealer'        => Dealer::where('id',$purchaseOrder->dealer_id)->first(),
            'created_by'    => User::where('id',$purchaseOrder->created_by)->first()->name,
            'items'         => PurchaseOrderItem::where('purchase_order_id',$purchaseOrder->id)->get(),
            'attachments'   => DB::table('po_create_has_files')->where('po_num_id',$purchaseOrder->po_num)->get(),
            'approval'      => $approvals,
            'is_approved'   => $is_approved,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        
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

    public function getItemName(Request $request)
    {
        $item = Item::where('id',$request->item_id)->first();
        return response()->json($item);
    }

    public function getSubItemName(Request $request)
    {
        $subItem = SubItem::where('id',$request->subItem_id)->first();
        return response()->json($subItem);
    }

    public function getApprovalData(Request $request)
    {

        $dealerApproveRule = [];
        $dealerApproveRuleLevel1 = DealerApproveRule::where('dealer_approve_rules.dealer_id',$request->dealer_id)
                                        ->join('dealer_approve_organizations','dealer_approve_rules.dealer_id','=','dealer_approve_organizations.dealer_id')
                                        ->join('positions','dealer_approve_rules.level_1_position_id','=','positions.id')
                                        ->join('users','dealer_approve_organizations.level_1_user_id','=','users.id')
                                        ->select('dealer_approve_rules.level_1_min_nominal','positions.name as position','users.name as name','users.id as user_id')
                                        ->first();
        if(!$dealerApproveRuleLevel1){
            $dealerApproveRule['ApproveRule1'] = false;
            $dealerApproveRule['ApproveRule1'] = '';
        }
        if($request->total_price < $dealerApproveRuleLevel1->level_1_min_nominal){
            $dealerApproveRule['ApproveRule1'] = false;
            $dealerApproveRule['dealerApproveRule1'] = $dealerApproveRuleLevel1;
        }else{
            $dealerApproveRule['ApproveRule1'] = true;
            $dealerApproveRule['dealerApproveRule1'] = $dealerApproveRuleLevel1;
        }

        $dealerApproveRuleLevel2 = DealerApproveRule::where('dealer_approve_rules.dealer_id',$request->dealer_id)
                                ->join('dealer_approve_organizations','dealer_approve_rules.dealer_id','=','dealer_approve_organizations.dealer_id')
                                ->join('positions','dealer_approve_rules.level_2_position_id','=','positions.id')
                                ->join('users','dealer_approve_organizations.level_2_user_id','=','users.id')
                                ->select('dealer_approve_rules.level_2_min_nominal','positions.name as position','users.name as name','users.id as user_id')
                                ->first();
        if(!$dealerApproveRuleLevel2){
            $dealerApproveRule['ApproveRule2'] = false;
            $dealerApproveRule['ApproveRule2'] = '';
        }
        if($request->total_price < $dealerApproveRuleLevel2->level_2_min_nominal){
            $dealerApproveRule['ApproveRule2'] = false;
            $dealerApproveRule['dealerApproveRule2'] = $dealerApproveRuleLevel2;
        }else{
            $dealerApproveRule['ApproveRule2'] = true;
            $dealerApproveRule['dealerApproveRule2'] = $dealerApproveRuleLevel2;
        }

        $dealerApproveRuleLevel3 = DealerApproveRule::where('dealer_approve_rules.dealer_id',$request->dealer_id)
                                ->join('dealer_approve_organizations','dealer_approve_rules.dealer_id','=','dealer_approve_organizations.dealer_id')
                                ->join('positions','dealer_approve_rules.level_3_position_id','=','positions.id')
                                ->join('users','dealer_approve_organizations.level_3_user_id','=','users.id')
                                ->select('dealer_approve_rules.level_3_min_nominal','positions.name as position','users.name as name','users.id as user_id')
                                ->first();
        if(!$dealerApproveRuleLevel3){
            $dealerApproveRule['ApproveRule3'] = false;
            $dealerApproveRule['ApproveRule3'] = '';
        }
        if($request->total_price < $dealerApproveRuleLevel3->level_3_min_nominal){
            $dealerApproveRule['ApproveRule3'] = false;
            $dealerApproveRule['dealerApproveRule3'] = $dealerApproveRuleLevel3;
        }else{
            $dealerApproveRule['ApproveRule3'] = true;
            $dealerApproveRule['dealerApproveRule3'] = $dealerApproveRuleLevel3;
        }

        return response()->json($dealerApproveRule);
    }

    public function uploadFiles(Request $request)
    {
        $files = $request->file('file');

        $fileInfo = $files->getClientOriginalName();
        $fileName = pathinfo($fileInfo,PATHINFO_FILENAME);
        $fileName = str_replace(' ','_',$fileName);
        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $file_name = $fileName.'-'.time().'.'.$extension;
        $files->move(public_path('uploads'),$file_name);

        DB::table('po_create_has_files')->insert([
            'po_num_id'     => $request->po_num,
            'file_name'     => $file_name
        ]);

        return response()->json([
            'message'   => 'Upload Complete',
            'request'   => $request->po_num
        ]);
    }

    public function downloadFile(PurchaseOrder $purchaseOrder, $fileName){
        $file = public_path().'\uploads\\'.$fileName;
        return response()->download($file);
    }
}
