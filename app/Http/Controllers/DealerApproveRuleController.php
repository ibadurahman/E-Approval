<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\DealerApproveRule;
use App\Http\Controllers\Controller;
use App\DataTables\DealerApproveRuleDataTable;
use App\Http\Requests\DealerApproveRuleRequest;

class DealerApproveRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DealerApproveRuleDataTable $dataTable)
    {
        return $dataTable->render('dealerApproveRule.index',[
            'title' => 'Dealer Approval'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dealerApproveRule.create',[
            'title'     => 'Create Dealer Approval Rule',
            'dealers'   => Dealer::all(),
            'positions' => Position::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerApproveRuleRequest $request)
    {
        DealerApproveRule::create([
            'dealer_id'             => $request->dealer_id,
            'level_1_min_nominal'   => $request->level_1_min_nominal,
            'level_1_position_id'   => $request->level_1_position_id,
            'level_2_min_nominal'   => $request->level_2_min_nominal,
            'level_2_position_id'   => $request->level_2_position_id,
            'level_3_min_nominal'   => $request->level_3_min_nominal,
            'level_3_position_id'   => $request->level_3_position_id
        ]);

        return redirect()->route('dealerApproveRule.index')->with('success','Data Dealer Approve Rule Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DealerApproveRule  $dealerApproveRule
     * @return \Illuminate\Http\Response
     */
    public function show(DealerApproveRuleRequest $dealerApproveRule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DealerApproveRule  $dealerApproveRule
     * @return \Illuminate\Http\Response
     */
    public function edit(DealerApproveRule $dealerApproveRule)
    {
        return view('dealerApproveRule.edit',[
            'title'             => 'Edit Dealer Approve Rule',
            'dealerApproveRule' => $dealerApproveRule,
            'dealers'           => Dealer::all(),
            'positions'         => Position::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DealerApproveRule  $dealerApproveRule
     * @return \Illuminate\Http\Response
     */
    public function update(DealerApproveRuleRequest $request, DealerApproveRule $dealerApproveRule)
    {
        $dealerApproveRule->update([
            'dealer_id'             => $request->dealer_id,
            'level_1_min_nominal'   => $request->level_1_min_nominal,
            'level_1_position_id'   => $request->level_1_position_id,
            'level_2_min_nominal'   => $request->level_2_min_nominal,
            'level_2_position_id'   => $request->level_2_position_id,
            'level_3_min_nominal'   => $request->level_3_min_nominal,
            'level_3_position_id'   => $request->level_3_position_id
        ]);
        return redirect()->route('dealerApproveRule.index')->with('success','Data Dealer Approve Rule Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DealerApproveRule  $dealerApproveRule
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealerApproveRule $dealerApproveRule)
    {
        //
    }
}
