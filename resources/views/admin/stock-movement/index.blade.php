@extends('layouts.app')

@section('content')
    <div class="py-4" style="max-width: 448px; margin: auto;">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h3 class="card-title">Riwayat Stok</h3>
        </div>
        <div class="card mt-4" style="height: 80%">
            <div class="card-body py-4 mt-4">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <button class="btn btn-primary btn-fab shadow-lg" onclick="window.location.reload();"
            aria-label="Reload Data">
            <i class="fas fa-sync"></i>
        </button>
    </div>

    @push('styles')
        <style>
            .fab-container {
                position: fixed;
                bottom: 50px;
                right: 20px;
                z-index: 1030;
            }

            .btn-fab {
                width: 46px;
                height: 46px;
                border-radius: 50%;
                border: none;
                font-size: 1.25rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: linear-gradient(135deg, var(--bs-primary), #4c63d2);
            }

            .btn-fab:hover {
                transform: scale(1.1) translateY(-2px);
                box-shadow: 0 12px 30px rgba(13, 110, 253, 0.4);
            }

            .btn-fab:active {
                transform: scale(0.95);
            }
        </style>
    @endpush
    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            const tableId = 'stock-movement-table';
        </script>
    @endpush
@endsection