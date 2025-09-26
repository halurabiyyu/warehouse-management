<!-- Add Modal -->
<div class="modal fade" id="add-item-modal" tabindex="-1" aria-labelledby="add-item-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-item-modal-label">Tambah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-item-form">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="item-code" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan Kode Barang" id="item-code"
                            name="code" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="item-name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="item-name"
                            name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="item-size" class="form-label">Ukuran</label>
                        <input type="text" class="form-control" placeholder="Masukkan Ukuran" id="item-size" name="size"
                            required>
                        <div class="invalid-feedback"></div>
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

<div class="modal fade" id="edit-item-modal" tabindex="-1" aria-labelledby="edit-item-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit-item-modal-label">Ubah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-item-form">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="edit-item-id" name="id">
                    <div class="mb-3">
                        <label for="edit-item-code" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan Kode Barang" id="edit-item-code"
                            name="code" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-item-name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="edit-item-name"
                            name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-item-size" class="form-label">Ukuran</label>
                        <input type="text" class="form-control" placeholder="Masukkan Ukuran" id="edit-item-size"
                            name="size" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-save-button">
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
        const modal = document.getElementById('add-item-modal');
        const form = document.getElementById('add-item-form');
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

        function submitForm() {
            const formData = new FormData(form);

            // Show loading state
            setLoadingState(true);
            clearValidationErrors();

            fetch('{{ route("items.store") }}', {
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
                        if (window.LaravelDataTables && window.LaravelDataTables['item-table']) {
                            window.LaravelDataTables['item-table'].ajax.reload();
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
                        text: 'Gagal menambahkan barang. Silakan coba lagi.',
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
        const editForm = document.getElementById('edit-item-form');
        const editModal = document.getElementById('edit-item-modal');
        const editSaveButton = document.getElementById('edit-save-button');
        const spinner = editSaveButton.querySelector('.spinner-border');
        const buttonText = editSaveButton.querySelector('.button-text');

        // Open modal and populate data
        document.addEventListener('click', function (e) {
            const button = e.target.closest('.text-info');
            if (!button) return;

            const editModal = document.getElementById('edit-item-modal');

            // Ambil data dari data-* tombol
            const id = button.dataset.id;
            const code = button.dataset.code;
            const name = button.dataset.name;
            const size = button.dataset.size;

            document.getElementById('edit-item-id').value = id;
            document.getElementById('edit-item-code').value = code;
            document.getElementById('edit-item-name').value = name;
            document.getElementById('edit-item-size').value = size;

            // Tampilkan modal
            bootstrap.Modal.getOrCreateInstance(editModal).show();
        });


        // Reset form when modal is hidden
        editModal.addEventListener('hidden.bs.modal', function () {
            editForm.reset();
            clearValidationErrors(editForm);
            setLoadingState(false);
        });

        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            submitEditForm();
        });

        function submitEditForm() {
            const formData = new FormData(editForm);
            const id = formData.get('id');

            // Show loading
            setLoadingState(true);

            fetch(`/items/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-HTTP-Method-Override': 'PUT', // Laravel untuk update via POST
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    setLoadingState(false);

                    if (data.success) {
                        const bsModal = bootstrap.Modal.getInstance(editModal);
                        bsModal.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Barang berhasil diperbarui',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });

                        // Refresh datatable
                        if (window.LaravelDataTables && window.LaravelDataTables['item-table']) {
                            window.LaravelDataTables['item-table'].ajax.reload();
                        }
                    } else {
                        handleErrors(editForm, data.errors || {});
                    }
                })
                .catch(err => {
                    setLoadingState(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Gagal memperbarui barang. Silakan coba lagi.',
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
            form.querySelectorAll('.form-control').forEach(input => input.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(fb => fb.textContent = '');
        }
    });

</script>