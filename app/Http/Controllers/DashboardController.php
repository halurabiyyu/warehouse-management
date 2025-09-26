<?php

namespace App\Http\Controllers;

use App\DataTables\ItemDataTable;
use App\Models\Inbound;
use Dflydev\DotAccessData\Data;
use App\Models\Item as BaseModel;
use App\Models\Item;
use App\Models\Outbound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class DashboardController extends Controller
{
    public function index()
    {
        $itemCount = Item::count();
        $stockCount = Item::sum('stock');
        $inboundCount = Inbound::sum('quantity');
        $outboundCount = Outbound::sum('quantity');

        return view('admin.dashboard.index', compact(
            'itemCount',
            'stockCount',
            'inboundCount',
            'outboundCount'
        ));
    }
}
