<?php

namespace App\DataTables;

use App\Models\SewaMobil;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SewaMobilDataTable extends DataTable
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
            ->addColumn('pengguna', function ($row){
                return $row->dataUser->name;
            })
            ->addColumn('mobil', function ($row){
                return $row->dataMobil->dataMerek->nama.'-'. $row->dataMobil->dataModel->nama.'-'.$row->dataMobil->nama;
            })
            ->addColumn('action', function ($row){
                $btn = '<button id="btn-pengembalian" data-id="'.$row->id.'" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i></button>';
                return $btn;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SewaMobil $model): QueryBuilder
    {
        return $model->where('id_user', Auth::user()->id)->with('dataUser', 'dataMobil')->orderBy('created_at', 'desc')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sewa-mobils-table')
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
            Column::make('pengguna'),
            Column::make('mobil'),
            Column::make('no_plat'),
            Column::make('tanggal_mulai'),
            Column::make('tanggal_selesai'),
            Column::make('jumlah_hari'),
            Column::make('status'),
            Column::make('tarif'),
            Column::make('total'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SewaMobil_' . date('YmdHis');
    }
}
