<?php

namespace App\DataTables;

use App\Models\Item as BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ItemDataTable extends DataTable
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
                return view('admin.items.action', ['item' => $row]);
            })
            // ->editColumn('created_at', function (BaseModel $bidang) {
            //     return view('components.table-timestamp', [
            //         'date' => formatDateFromDatabase($bidang->created_at),
            //     ]);
            // })
            ->editColumn('updated_at', function (BaseModel $bidang) {
                return $bidang->updated_at ? Carbon::parse($bidang->updated_at)->format('d M Y') : '-';
            })
            ->rawColumns(['aksi'])
            ->setRowId('id');
    }

    public function query(BaseModel $model): QueryBuilder
    {
        return $model
            ->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('item-table')
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
            ->orderBy('3', 'asc')
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
            Column::make('code')
                ->title('Kode'),
            Column::make('name')
                ->title('Nama'),
            Column::make('size')
                ->title('Ukuran'),
            Column::make('stock')
                ->title('Stok')
        ];

        // if ($this->user->isSuperAdmin()) {
        //     $columns[] =  Column::make('lsp.nama')
        //         ->title('LSP')
        //         ->width('25%');
        // }

        $columns[] =  Column::make('updated_at')
            ->title('Terakhir Diubah')
            ->width('25%');

        return $columns;
    }
}
