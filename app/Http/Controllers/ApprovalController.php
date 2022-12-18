<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dealer;
use App\Models\Approval;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;
use App\DataTables\ApprovalDataTable;
use App\Models\PurchaseOrder;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ApprovalDataTable $dataTable)
    {
        return $dataTable->render('approval.index', [
            'title' => 'Approval'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function show(Approval $approval)
    {
        $approvals = [
            'level_1_position'  => null,
            'level_1_name'      => null,
            'level_2_position'  => null,
            'level_2_name'      => null,
            'level_3_position'  => null,
            'level_3_name'      => null,
        ];
        if (!is_null($approval->level_1_approved_by)) {
            $approvals['level_1_position']  = call_user_func(function () use ($approval) {
                $positionId = DB::table('model_has_position')->where('user_id', $approval->level_1_approved_by)->first();
                return Position::where('id', $positionId->position_id)->first()->name;
            });
            $approvals['level_1_name']      = call_user_func(function () use ($approval) {
                $user = User::where('id', $approval->level_1_approved_by)->first();
                return $user->name;
            });;
        }
        if (!is_null($approval->level_2_approved_by)) {
            $approvals['level_2_position']  = call_user_func(function () use ($approval) {
                $positionId = DB::table('model_has_position')->where('user_id', $approval->level_2_approved_by)->first();
                return Position::where('id', $positionId->position_id)->first()->name;
            });
            $approvals['level_2_name']      = call_user_func(function () use ($approval) {
                $user = User::where('id', $approval->level_2_approved_by)->first();
                return $user->name;
            });;
        }
        if (!is_null($approval->level_3_approved_by)) {
            $approvals['level_3_position']  = call_user_func(function () use ($approval) {
                $positionId = DB::table('model_has_position')->where('user_id', $approval->level_3_approved_by)->first();
                return Position::where('id', $positionId->position_id)->first()->name;
            });
            $approvals['level_3_name']      = call_user_func(function () use ($approval) {
                $user = User::where('id', $approval->level_3_approved_by)->first();
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
        if (!is_null($approval->level_1_is_approved)) {
            $is_approved['level_1_approved_by']     = $approval->level_1_is_approved;
            $is_approved['level_1_approved_sign']   = call_user_func(function () use ($approval) {
                $user = User::where('id', $approval->level_1_is_approved)->first();
                return $user->sign;
            });
        }
        if (!is_null($approval->level_2_is_approved)) {
            $is_approved['level_2_approved_by']     = $approval->level_2_is_approved;
            $is_approved['level_2_approved_sign']   = call_user_func(function () use ($approval) {
                $user = User::where('id', $approval->level_2_is_approved)->first();
                return $user->sign;
            });
        }
        if (!is_null($approval->level_3_is_approved)) {
            $is_approved['level_3_approved_by']     = $approval->level_3_is_approved;
            $is_approved['level_3_approved_sign']   = call_user_func(function () use ($approval) {
                $user = User::where('id', $approval->level_3_is_approved)->first();
                return $user->sign;
            });
        }

        return view('approval.show', [
            'title'         => $approval->po_num,
            'purchaseOrder' => $approval,
            'dealer'        => Dealer::where('id', $approval->dealer_id)->first(),
            'created_by'    => User::where('id', $approval->created_by)->first()->name,
            'items'         => PurchaseOrderItem::where('purchase_order_id', $approval->id)->get(),
            'attachments'   => DB::table('po_create_has_files')->where('po_num_id', $approval->po_num)->get(),
            'approval'      => $approvals,
            'is_approved'   => $is_approved,
        ]);
    }

    public function applySign(Request $request)
    {
        $purchaseOrder = Approval::where('id', $request->po_id)->first();
        if (!$purchaseOrder) {
            return redirect()->route('approval.show', $purchaseOrder)->with('error', 'PO tidak ditemukan');
        }

        if ($request->sign_level == 'level_1') {
            if ($request->user_id != $purchaseOrder->level_1_approved_by) {
                return redirect()->route('approval.show', $purchaseOrder)->with('error', 'Anda tidak memiliki hak untuk approve');
            }
            $purchaseOrder->update([
                'level_1_is_approved' => $request->user_id,
                'level_1_approved_time' => date('Y-m-d H:i:s'),
            ]);

            $this->checkStatusApproval($purchaseOrder->id);

            return redirect()->route('approval.show', $purchaseOrder)->with('success', 'Berhasil Melakukan Approve');
        }
        if ($request->sign_level == 'level_2') {
            if ($request->user_id != $purchaseOrder->level_2_approved_by) {
                return redirect()->route('approval.show', $purchaseOrder)->with('error', 'Anda tidak memiliki hak untuk approve');
            }
            $purchaseOrder->update([
                'level_2_is_approved' => $request->user_id,
                'level_2_approved_time' =>  date('Y-m-d H:i:s'),
            ]);

            $this->checkStatusApproval($purchaseOrder->id);

            return redirect()->route('approval.show', $purchaseOrder)->with('success', 'Berhasil Melakukan Approve');
        }
        if ($request->sign_level == 'level_3') {
            if ($request->user_id != $purchaseOrder->level_3_approved_by) {
                return redirect()->route('approval.show', $purchaseOrder)->with('error', 'Anda tidak memiliki hak untuk approve');
            }
            $purchaseOrder->update([
                'level_3_is_approved' => $request->user_id,
                'level_3_approved_time' =>  date('Y-m-d H:i:s'),
            ]);

            $this->checkStatusApproval($purchaseOrder->id);

            return redirect()->route('approval.show', $purchaseOrder)->with('success', 'Berhasil Melakukan Approve');
        }
        return redirect()->route('approval.show', $purchaseOrder)->with('error', 'Level tidak terdefinisi');
    }

    private function checkStatusApproval($po_id)
    {
        $purchaseOrder = Approval::where('id', $po_id);
        $purchaseOrderData = $purchaseOrder->first();
        if (!is_null($purchaseOrderData->level_1_approved_by) && !is_null($purchaseOrderData->level_2_approved_by) && !is_null($purchaseOrderData->level_3_approved_by)) {
            if (!is_null($purchaseOrderData->level_1_is_approved) && !is_null($purchaseOrderData->level_2_is_approved) && !is_null($purchaseOrderData->level_3_is_approved)) {
                $purchaseOrder->update([
                    'status' => 'approved'
                ]);
            }
        }
        if (!is_null($purchaseOrderData->level_1_approved_by) && !is_null($purchaseOrderData->level_2_approved_by) && is_null($purchaseOrderData->level_3_approved_by)) {
            if (!is_null($purchaseOrderData->level_1_is_approved) && !is_null($purchaseOrderData->level_2_is_approved)) {
                $purchaseOrder->update([
                    'status' => 'approved'
                ]);
            }
        }
        if (!is_null($purchaseOrderData->level_1_approved_by) && is_null($purchaseOrderData->level_2_approved_by) && is_null($purchaseOrderData->level_3_approved_by)) {
            if (!is_null($purchaseOrderData->level_1_is_approved)) {
                $purchaseOrder->update([
                    'status' => 'approved'
                ]);
            }
        }
    }
}
