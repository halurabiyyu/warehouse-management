<?php

namespace App\Http\Controllers;

use App\DataTables\StockMovementDataTable;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(StockMovementDataTable $dataTable)
    {
        return $dataTable->render('admin.stock-movement.index');

    }
}
