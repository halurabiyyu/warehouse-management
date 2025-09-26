@extends('layouts.app')

@section('content')
    <div class="py-4" style="max-width: 448px; margin: auto;">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h3 class="card-title">Daftar Barang</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="success-alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" id="error-alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert" id="validation-alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

            /* Loading spinner animation */
            .spinner-border-sm {
                width: 1rem;
                height: 1rem;
            }
        </style>
    @endpush
    
    @push('scripts')
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        {{ $dataTable->scripts() }}
        
        <script>
            const tableId = '{{ isset($tableId) ? $tableId : "item-table" }}';

            document.addEventListener('DOMContentLoaded', function() {
                // Auto dismiss success alerts
                const successAlert = document.getElementById('success-alert');
                if (successAlert) {
                    setTimeout(function() {
                        const alert = new bootstrap.Alert(successAlert);
                        alert.close();
                    }, 5000);
                }

                // Auto dismiss error alerts
                const errorAlert = document.getElementById('error-alert');
                if (errorAlert) {
                    setTimeout(function() {
                        const alert = new bootstrap.Alert(errorAlert);
                        alert.close();
                    }, 8000);
                }

                // Show validation errors with SweetAlert if any
                @if($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        html: '<ul style="text-align: left;">' +
                            @foreach($errors->all() as $error)
                                '<li>{{ $error }}</li>' +
                            @endforeach
                            '</ul>',
                        confirmButtonText: 'OK'
                    });
                @endif

                // Show success message with SweetAlert
                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                @endif

                // Show error message with SweetAlert
                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK'
                    });
                @endif
            });

            // Global function to refresh DataTable (can be called from modal)
            function refreshDataTable() {
                if (window.LaravelDataTables && window.LaravelDataTables[tableId]) {
                    window.LaravelDataTables[tableId].ajax.reload();
                }
            }
        </script>
    @endpush
@endsection