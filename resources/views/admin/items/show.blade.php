@extends('layouts.app')

@section('content')
    <div class="py-4" style="max-width: 448px; margin: auto;">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h3 class="card-title">Detail Barang</h3>
        </div>
        <div class="card mt-4" style="height: 80%">
            <div class="card-body py-4 mt-4">
                <h3>Kode : {{ $item->code }}</h3>
                <h3>Nama : {{ $item->name }}</h3>
                <h3>Ukuran : {{ $item->size }}</h3>
                <h3>Stok : {{ $item->stock }}</h3>
            </div>
        </div>

        <div class="card mt-4" style="height: 80%">
            <div class="card-header">
                <h3 class="card-title">Riwayat Pergerakan Stok</h3>
            </div>
            <div class="card-body py-4 mt-4">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    
    @push('styles')
        <style>
            /* Loading spinner animation */
            .spinner-border-sm {
                width: 1rem;
                height: 1rem;
            }
        </style>
    @endpush
    
    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
@endsection