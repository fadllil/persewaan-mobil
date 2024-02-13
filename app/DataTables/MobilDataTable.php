<?php

namespace App\DataTables;

use App\Models\MasterMobil;
use App\Models\Mobil;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MobilDataTable extends DataTable
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
            ->addColumn('merek', function ($row){
                $merek = $row->dataMerek->nama;
                return $merek;
            })
            ->addColumn('model', function ($row){
                $model = $row->dataModel->nama;
                return $model;
            })
            ->addColumn('tarif', function ($row){
                $tarif = 'Rp. '.number_format($row->tarif, 0, ',', '.');
                return $tarif;
            })
            ->addColumn('action', function ($row){
                $btn = '<a href="/master-mobil/edit/'.$row->id.'" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                $btn .= '<button id="btn-delete" data-id="'.$row->id.'" class="btn btn-danger"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MasterMobil $model): QueryBuilder
    {
        return $model->orderBy('created_at', 'desc')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('master-mobils-table')
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
            Column::make('merek'),
            Column::make('model'),
            Column::make('nama'),
            Column::make('tahun'),
            Column::make('tarif')->title('Tarif/Hari'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::make('status'),
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
        return 'Mobil_' . date('YmdHis');
    }
}
