<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Dealer;
use App\Models\Position;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UsersDataTable extends DataTable
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
                    ->addColumn('action','user.action')
                    ->addColumn('position',function(User $user)
                    {
                        $position = DB::table('model_has_position')->where('user_id',$user->id)->first();
                        if(!$position)
                        {
                            return '';
                        }
                        $ps = Position::where('id',$position->position_id)->first();
                        return $ps->name;
                    })
                    ->addColumn('dealer',function(User $user){
                        $dealers = DB::table('model_has_dealer')->where('user_id',$user->id)->get();
                        $results = [];
                        foreach ($dealers as $dealer) {
                            $dl = Dealer::where('id',$dealer->dealer_id)->first();
                            $results[] = $dl->name;
                        }
                        return $results;
                    })
                    ->addColumn('status',function(User $user){
                        if($user->is_active)
                        {
                            return '<span class="badge rounded-pill bg-success">Active</span>';
                        }
                        return '<span class="badge rounded-pill bg-danger">Not Active</span>';
                    })
                    ->addColumn('sign',function(User $user){
                        if(!$user->sign)
                        {
                            return '<span class="badge rounded-pill bg-danger">Not Found</span>';
                        }
                        return '<img src="'.asset('images\sign\\'.$user->sign).'" class="" width="100" height="30">';
                    })
                    ->rawColumns(['status','action','sign'])
                    ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
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
                    ->setTableId('users')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'dom'     => 'Bfrtip',
                        'buttons' => ['create','excel','reload'],
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
            Column::make('name'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('position'),
            Column::make('dealer'),
            Column::make('status'),
            Column::make('sign'),
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
        return 'Users_' . date('YmdHis');
    }
}
