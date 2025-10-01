<?php

namespace App\DataTables;

use App\Models\StockMovement as BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DetailItemDataTable extends DataTable
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
            ->editColumn('type', function (BaseModel $baseModel) {
                $html = '<span class="badge bg-' . ($baseModel->type == 'masuk' ? 'success' : 'danger') . '">' . strtoupper($baseModel->type) . '</span>';

                return $html;
            })
            ->editColumn('movement_date', function (BaseModel $baseModel) {
                return $baseModel->movement_date ? Carbon::parse($baseModel->movement_date)->format('d M Y') : '-';
            })
            ->rawColumns(['aksi', 'type'])
            ->setRowId('id');
    }

    public function query(BaseModel $model): QueryBuilder
    {
        $model = $model
            ->with('item')
            ->whereHas('item', function ($query) {
                if ($this->item_id) {
                    $query->where('id', $this->item_id);
                }
            })
            ->orderBy('movement_date', 'desc')
            ->newQuery();

        return $model;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('detail-item-table')
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
            // Column::computed('aksi')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width('5%')
            //     ->addClass('text-center')
            //     ->title('Aksi'),
            Column::make('item.code')
                ->title('Kode'),
            Column::make('item.name')
                ->title('Nama'),
            Column::make('type')
                ->title('Tipe'),
            Column::make('quantity')
                ->title('Jumlah'),
            Column::make('movement_date')
                ->title('Tanggal Pergerakan')
        ];

        return $columns;
    }
}
