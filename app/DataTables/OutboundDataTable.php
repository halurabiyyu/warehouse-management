<?php

namespace App\DataTables;

use App\Models\Outbound as BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OutboundDataTable extends DataTable
{
    public $user = null;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('aksi', function (BaseModel $row) {
                return view('admin.outbound.action', ['outbound' => $row]);
            })
            // ->editColumn('created_at', function (BaseModel $bidang) {
            //     return view('components.table-timestamp', [
            //         'date' => formatDateFromDatabase($bidang->created_at),
            //     ]);
            // })
            ->editColumn('shipping_date', function (BaseModel $bidang) {
                return $bidang->shipping_date ? Carbon::parse($bidang->shipping_date)->format('d M Y') : '-';
            })
            ->rawColumns(['aksi'])
            ->setRowId('id');
    }

    public function query(BaseModel $model): QueryBuilder
    {
        return $model
            ->with('item')
            ->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('outbound-table')
            ->columns($this->getColumns())
            ->minifiedAjax(script: "
                        data._token = '" . csrf_token() . "';
                        data._p = 'POST';
                    ")
            ->addTableClass('table table-striped table-hover table-bordered table-sm')
            ->setTableHeadClass('text-start text-muted fw-bold  text-uppercase gs-0')
            ->drawCallbackWithLivewire(
                file_get_contents(
                    public_path('/assets/js/dataTables/drawCallback.js')
                )
            )
            ->language([
                'paginate' => [
                    'previous' => '<i class="fas fa-chevron-left"></i>',
                    'next'     => '<i class="fas fa-chevron-right"></i>',
                ],
            ])
            ->orderBy('6', 'desc')
            ->select(false)
            ->buttons([]);
    }

    public function getColumns(): array
    {
        $columns = [
            Column::computed('DT_RowIndex')
                ->title('No.')
                ->addClass('text-center')
                ->width('5%'),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->width('5%')
                ->addClass('text-center')
                ->title('Aksi'),
            Column::make('item.code')
                ->title('Kode Barang'),
            Column::make('item.name')
                ->title('Nama Barang'),
            Column::make('item.size')
                ->title('Ukuran'),
            Column::make('quantity')
                ->title('Jumlah'),
            Column::make('shipping_date')
                ->title('Tanggal Dikirim')
        ];

        return $columns;
    }
}
