@extends('layouts.app')

@section('content')
    <div class="py-4" style="max-width: 448px; margin: auto;">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h3 class="card-title">Daftar Barang</h3>
        </div>
        {{-- <div>
            <div class="btn-group mt-4 d-flex justify-content-end">
                <button onclick="reloadDatatable(tableId)" class="btn btn-secondary">
                    <i class="fa-solid fa-rotate"></i>
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-item-modal">
                    <i class="far fa-plus fa-fw"></i>
                </button>
            </div>
        </div> --}}
        <div class="card mt-4" style="height: 80%">
            <div class="card-body py-4 mt-4">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <button class="btn btn-primary btn-fab shadow-lg" data-bs-toggle="modal" data-bs-target="#add-item-modal"
            aria-label="Tambah Data">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    @include('admin.items.modal')
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
            const tableId = 'item-table';

            // let inputNama = document.getElementById('nama');
            // let inputNama2 = document.getElementById('nama_2');

            // inputNama.addEventListener('input', function (event) {
            //     validateInputChar(event.target);
            // });

            // inputNama2.addEventListener('input', function (event) {
            //     validateInputChar(event.target);
            // });
        </script>
    @endpush
@endsection