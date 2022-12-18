<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Dealer;
use App\Models\Approval;
use App\Models\PurchaseOrderItem;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ApprovalDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
                    ->addIndexColumn()
                    ->addColumn('dealer', function (Approval $approval) {
                        $dealer = Dealer::where('id', $approval->dealer_id)->first();
                        return $dealer->name;
                    })
                    ->addColumn('nominal', function (Approval $approval) {
                        $items = PurchaseOrderItem::where('purchase_order_id', $approval->id)->get();
                        $totalPrice = 0;
                        foreach ($items as $item) {
                            $totalPrice += $item->qty * $item->price;
                        }

                        return $totalPrice;
                    })
                    ->addColumn('created_by', function (Approval $approval) {
                        $user = User::where('id', $approval->created_by)->first();
                        return $user->name;
                    })
                    ->addColumn('action', 'approval.action')
                    ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ApprovalDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Approval $model)
    {
        return $model->where('level_1_approved_by',Auth::user()->id)
        ->orWhere('level_2_approved_by',Auth::user()->id)
        ->orWhere('level_3_approved_by',Auth::user()->id)
        ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                ->setTableId('purchase_orders')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->orderBy(1)
                ->selectStyleSingle()
                ->parameters([
                    'dom'     => 'Bfrtip',
                    'buttons' => ['create', 'reload'],
                ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false),
            Column::make('po_num'),
            Column::make('dealer'),
            Column::make('created_by'),
            Column::make('release_date'),
            Column::make('nominal'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Approval_' . date('YmdHis');
    }
}
