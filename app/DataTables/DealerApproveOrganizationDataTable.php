<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Dealer;
use App\Models\Position;
use App\Models\DealerApproveRule;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\DealerApproveOrganization;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class DealerApproveOrganizationDataTable extends DataTable
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
                    ->addColumn('dealer',function(DealerApproveOrganization $approveOrganization){
                        $dealer = Dealer::where('id',$approveOrganization->dealer_id)->first();
                        if(!$dealer){return '';}
                        return $dealer->name;
                    })
                    ->addColumn('level_1_position_id',function(DealerApproveOrganization $approveOrganization){
                        $position = Position::where('id',$approveOrganization->level_1_position_id)->first();
                        if(!$position){return '';}
                        return $position->name;
                    })
                    ->addColumn('level_1_user_id',function(DealerApproveOrganization $approveOrganization){
                        $user = User::where('id',$approveOrganization->level_1_user_id)->first();
                        if(!$user){return '';}
                        return $user->name;
                    })
                    ->addColumn('level_2_position_id',function(DealerApproveOrganization $approveOrganization){
                        $position = Position::where('id',$approveOrganization->level_2_position_id)->first();
                        if(!$position){return '';}
                        return $position->name;
                    })
                    ->addColumn('level_2_user_id',function(DealerApproveOrganization $approveOrganization){
                        $user = User::where('id',$approveOrganization->level_2_user_id)->first();
                        if(!$user){return '';}
                        return $user->name;
                    })
                    ->addColumn('level_3_position_id',function(DealerApproveOrganization $approveOrganization){
                        $position = Position::where('id',$approveOrganization->level_3_position_id)->first();
                        if(!$position){return '';}
                        return $position->name;
                    })
                    ->addColumn('level_3_user_id',function(DealerApproveOrganization $approveOrganization){
                        $user = User::where('id',$approveOrganization->level_3_user_id)->first();
                        if(!$user){return '';}
                        return $user->name;
                    })
                    ->addColumn('action', 'dealerApproveOrganization.action')
                    ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DealerApproveOrganizationDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DealerApproveOrganization $model): QueryBuilder
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
                    ->setTableId('dealer_approve_organizations')
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
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false),
            Column::make('dealer'),
            Column::make('level_1_position_id')->title('Level 1 Responsible Position'),
            Column::make('level_1_user_id')->title('Level 1 Person in Charge'),
            Column::make('level_2_position_id')->title('Level 2 Responsible Position'),
            Column::make('level_2_user_id')->title('Level 2 Person in Charge'),
            Column::make('level_3_position_id')->title('Level 3 Responsible Position'),
            Column::make('level_3_user_id')->title('Level 3 Person in Charge'),
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
        return 'DealerApproveOrganization_' . date('YmdHis');
    }
}
