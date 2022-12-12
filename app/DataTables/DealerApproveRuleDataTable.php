<?php

namespace App\DataTables;

use App\Models\Dealer;
use App\Models\Position;
use App\Models\DealerApproveRule;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class DealerApproveRuleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
                    ->addIndexColumn()
                    ->addColumn('dealer',function(DealerApproveRule $approveRule){
                        $dealer = Dealer::where('id',$approveRule->dealer_id)->first();
                        if(!$dealer)
                        {
                            return '';
                        }
                        return $dealer->name;
                    })
                    ->addColumn('level_1_position_id',function(DealerApproveRule $approveRule){
                        $position = Position::where('id',$approveRule->level_1_position_id)->first();
                        if(!$position){return '';}
                        return $position->name;
                    })
                    ->addColumn('level_2_position_id',function(DealerApproveRule $approveRule){
                        $position = Position::where('id',$approveRule->level_2_position_id)->first();
                        if(!$position){return '';}
                        return $position->name;
                    })
                    ->addColumn('level_3_position_id',function(DealerApproveRule $approveRule){
                        $position = Position::where('id',$approveRule->level_3_position_id)->first();
                        if(!$position){return '';}
                        return $position->name;
                    })
                    ->addcolumn('action','dealerApproveRule.action')
                    ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Position $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DealerApproveRule $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('dealer_approve_rules')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'dom'     => 'Bfrtip',
                        'buttons' => ['create','reload'],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false),
            Column::make('dealer'),
            Column::make('level_1_min_nominal'),
            Column::make('level_1_position_id')->title('Responsible Position'),
            Column::make('level_2_min_nominal'),
            Column::make('level_2_position_id')->title('Responsible Position'),
            Column::make('level_3_min_nominal'),
            Column::make('level_3_position_id')->title('Responsible Position'),
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
        return 'Dealer_approve_rule_' . date('YmdHis');
    }
}
