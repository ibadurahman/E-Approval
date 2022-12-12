<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\DealerApproveRule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DealerApproveOrganization;
use App\DataTables\DealerApproveOrganizationDataTable;
use App\Http\Requests\DealerApproveOrganizationRequest;

class DealerApproveOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DealerApproveOrganizationDataTable $dataTable)
    {
        //
        return $dataTable->render('dealerApproveOrganization.index',[
            'title' => 'Dealer Approve Organization'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $dealerApproveRule = DealerApproveRule::where('dealer_id',$dealer->id)->first();
        // if (!$dealerApproveRule) {
        //    return redirect()->route('DealerApproveOrganization.index')->with('error','Dealer Approve Rule Not Found');
        // }

        return view('dealerApproveOrganization.create',[
            'title'     => 'Create Dealer Approve Organization',
            'dealers'   => Dealer::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerApproveOrganizationRequest $request)
    {
        DealerApproveOrganization::create([
            'dealer_id'             => $request->dealer_id,
            'level_1_position_id'   => $request->level_1_approval,
            'level_1_user_id'       => $request->level_1_user_id,
            'level_2_position_id'   => $request->level_2_approval,
            'level_2_user_id'       => $request->level_2_user_id,
            'level_3_position_id'   => $request->level_3_approval,
            'level_3_user_id'       => $request->level_3_user_id,
        ]);

        return redirect()->route('dealerApproveOrganization.index')->with('success','Data Dealer Approve Organization Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPosition(Request $request)
    {
        $dealerApproveOrg = DealerApproveRule::where('dealer_id',$request->dealer_id)->first();
        if(!$dealerApproveOrg)
        {
            return response()->json([
                'message' => 'Data Dealer Approve Org Not Found'
            ],404);
        }
        $dealerApproveOrg = [
            'level_1_position_id' => Position::where('id',$dealerApproveOrg->level_1_position_id)->first(),
            'level_2_position_id' => Position::where('id',$dealerApproveOrg->level_2_position_id)->first(),
            'level_3_position_id' => Position::where('id',$dealerApproveOrg->level_3_position_id)->first(),
        ];
        return response()->json($dealerApproveOrg);
    }

    public function getPersonCharge(Request $request)
    {
        $modelHasDealersLevel1 = DB::table('model_has_dealer')->where('dealer_id',$request->dealer_id)
                                ->join('model_has_position','model_has_dealer.user_id','=','model_has_position.user_id')
                                ->join('users','model_has_dealer.user_id','=','users.id')
                                ->where('position_id',$request->level_1_position_id)
                                ->get();
        $modelHasDealersLevel2 = DB::table('model_has_dealer')->where('dealer_id',$request->dealer_id)
                                ->join('model_has_position','model_has_dealer.user_id','=','model_has_position.user_id')
                                ->join('users','model_has_dealer.user_id','=','users.id')
                                ->where('position_id',$request->level_2_position_id)
                                ->get();
        $modelHasDealersLevel3 = DB::table('model_has_dealer')->where('dealer_id',$request->dealer_id)
                                ->join('model_has_position','model_has_dealer.user_id','=','model_has_position.user_id')
                                ->join('users','model_has_dealer.user_id','=','users.id')
                                ->where('position_id',$request->level_3_position_id)
                                ->get();
        $modelHasDealers = [
            'level1'    => $modelHasDealersLevel1,
            'level2'    => $modelHasDealersLevel2,
            'level3'    => $modelHasDealersLevel3
        ];

        return response()->json($modelHasDealers);
    }
}
