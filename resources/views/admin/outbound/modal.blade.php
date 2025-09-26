<!-- Add Modal -->
<div class="modal fade" id="add-outbound-modal" tabindex="-1" aria-labelledby="add-outbound-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-outbound-modal-label">Tambah Barang Keluar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-outbound-form">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="outbound-name" class="form-label">Nama Barang</label>
                        <select name="item_id" id="outbound-name" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Barang --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="outbound-name-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="outbound-unit" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" placeholder="Masukkan Jumlah" id="outbound-unit" name="quantity" required>
                        <div class="invalid-feedback" id="outbound-unit-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="outbound-date" class="form-label">Tanggal keluar</label>
                        <input type="date" class="form-control" id="outbound-date" name="shipping_date" required>
                        <div class="invalid-feedback" id="outbound-date-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-button">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="button-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="edit-outbound-modal" tabindex="-1" aria-labelledby="edit-outbound-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit-outbound-modal-label">Edit Barang Keluar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-outbound-form">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="edit-outbound-name" class="form-label">Nama Barang</label>
                        <select name="item_id" id="edit-outbound-name" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Barang --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="edit-outbound-name-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-outbound-quantity" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" placeholder="Masukkan Jumlah" id="edit-outbound-quantity" name="quantity" required>
                        <div class="invalid-feedback" id="edit-outbound-quantity-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-outbound-date" class="form-label">Tanggal keluar</label>
                        <input type="date" class="form-control" id="edit-outbound-date" name="shipping_date" required>
                        <div class="invalid-feedback" id="edit-outbound-date-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-outbound-save-button">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="button-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('add-outbound-modal');
        const form = document.getElementById('add-outbound-form');
        const saveButton = document.getElementById('save-button');
        const spinner = saveButton.querySelector('.spinner-border');
        const buttonText = saveButton.querySelector('.button-text');

        // Reset form when modal is hidden
        modal.addEventListener('hidden.bs.modal', function () {
            resetForm();
        });

        // Handle form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            submitForm();
        });

        console.log(form);

        function submitForm() {
            const formData = new FormData(form);
            console.log(...formData);

            // Show loading state
            setLoadingState(true);
            clearValidationErrors();

            fetch('{{ route("outbound.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    setLoadingState(false);

                    if (data.success) {
                        // Close modal
                        const bootstrapModal = bootstrap.Modal.getInstance(modal);
                        bootstrapModal.hide();

                        // Show success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Barang berhasil ditambahkan',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });

                        // Refresh DataTable
                        if (window.LaravelDataTables && window.LaravelDataTables['outbound-table']) {
                            window.LaravelDataTables['outbound-table'].ajax.reload();
                        }

                        // Reset form
                        resetForm();
                    } else {
                        console.error('Error:', data);
                        handleErrors(data.errors || {});
                    }
                })
                .catch(error => {
                    setLoadingState(false);
                    console.error('Error:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Gagal menambahkan barang keluar. Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function setLoadingState(loading) {
            if (loading) {
                saveButton.disabled = true;
                spinner.classList.remove('d-none');
                buttonText.textContent = 'Menyimpan...';
            } else {
                saveButton.disabled = false;
                spinner.classList.add('d-none');
                buttonText.textContent = 'Simpan';
            }
        }

        function handleErrors(errors) {
            // Show validation errors
            console.error('Error:', errors);
            for (const field in errors) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const feedback = input.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.textContent = errors[field][0];
                    }
                }
            }

            // Show general error alert
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                text: 'Periksa kembali data yang Anda masukkan.',
                confirmButtonText: 'OK'
            });
        }

        function clearValidationErrors() {
            const inputs = form.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
            });

            const feedbacks = form.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.textContent = '';
            });
        }

        function resetForm() {
            form.reset();
            clearValidationErrors();
            setLoadingState(false);
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('edit-outbound-modal');
        const editForm = document.getElementById('edit-outbound-form');
        const editSaveButton = document.getElementById('edit-outbound-save-button');
        const spinner = editSaveButton.querySelector('.spinner-border');
        const buttonText = editSaveButton.querySelector('.button-text');

        // Delegated listener untuk tombol edit outbound
        document.addEventListener('click', function (e) {
            const button = e.target.closest('.edit-outbound-btn');
            if (!button) return;

            console.log(button.dataset);

            const id = button.dataset.id;
            const itemId = button.dataset.itemId;
            const quantity = button.dataset.quantity;
            const receivedDate = button.dataset.receivedDate;

            document.getElementById('edit-inbound-id').value = id;
            document.getElementById('edit-inbound-name').value = itemId;
            document.getElementById('edit-inbound-quantity').value = quantity;
            document.getElementById('edit-inbound-date').value = receivedDate;

            bootstrap.Modal.getOrCreateInstance(editModal).show();
        });

        // Reset form ketika modal ditutup
        editModal.addEventListener('hidden.bs.modal', function () {
            editForm.reset();
            clearValidationErrors(editForm);
            setLoadingState(false);
        });

        // Submit AJAX
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            submitEditForm();
        });

        function submitEditForm() {
            const formData = new FormData(editForm);
            const id = formData.get('id');

            setLoadingState(true);

            fetch(`/outbound/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-HTTP-Method-Override': 'PUT',
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    setLoadingState(false);

                    if (data.success) {
                        bootstrap.Modal.getOrCreateInstance(editModal).hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Barang keluar berhasil diperbarui',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });

                        // Refresh DataTable outbound
                        if (window.LaravelDataTables && window.LaravelDataTables['outbound-table']) {
                            window.LaravelDataTables['outbound-table'].ajax.reload();
                        }
                    } else {
                        handleErrors(editForm, data.errors || {});
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    setLoadingState(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Gagal memperbarui barang keluar. Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function setLoadingState(loading) {
            editSaveButton.disabled = loading;
            spinner.classList.toggle('d-none', !loading);
            buttonText.textContent = loading ? 'Menyimpan...' : 'Simpan';
        }

        function handleErrors(form, errors) {
            clearValidationErrors(form);
            for (const field in errors) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const feedback = input.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.textContent = errors[field][0];
                    }
                }
            }

            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                text: 'Periksa kembali data yang Anda masukkan.',
                confirmButtonText: 'OK'
            });
        }

        function clearValidationErrors(form) {
            form.querySelectorAll('.form-control, .form-select').forEach(input => input.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(fb => fb.textContent = '');
        }
    });
</script>