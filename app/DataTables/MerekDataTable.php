<?php

namespace App\DataTables;

use App\Models\MasterMerek;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MerekDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row){
                $btn = '<a href="/master-merek/edit/'.$row->id.'" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                $btn .= '<button id="btn-delete" data-id="'.$row->id.'" class="btn btn-danger"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            // ->addColumn('created_at', function ($row){
            //     $created_at = Carbon::parse($row->created_at)->format('d-m-Y H:i:s');
            //     return $created_at;
            // })
            // ->addColumn('updated_at', function ($row){
            //     $updated_at = Carbon::parse($row->updated_at)->format('d-m-Y H:i:s');
            //     return $updated_at;
            // })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MasterMerek $model): QueryBuilder
    {
        return $model->orderBy('nama', 'asc')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('master-mereks-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
            ->title('No')
            ->width(50)
            ->orderable(false),
            Column::make('nama')->addClass('text-center'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Merek_' . date('YmdHis');
    }
}
