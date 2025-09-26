document.addEventListener('click', function(e) {
    const button = e.target.closest('[data-action]');
    if (!button) return;

    const action = button.dataset.action; // create, update, destroy
    const url = button.dataset.url;       // endpoint API
    const method = button.dataset.method || 'POST'; // bisa override
    const modalId = button.dataset.modal; // opsional untuk create/update
    const tableId = button.dataset.table; // opsional untuk refresh datatable

    // Ambil data form jika ada modal
    let formData = null;
    if (modalId) {
        const form = document.querySelector(`#${modalId} form`);
        if (form) formData = new FormData(form);
    }

    // Konfirmasi jika action = destroy
    if (action === 'destroy') {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;
            sendRequest(url, 'DELETE');
        });
    } else {
        sendRequest(url, method, formData, modalId);
    }
});

function sendRequest(url, method = 'POST', formData = null, modalId = null) {
    console.log(method, url);
    const headers = {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
    };

    // Jika bukan FormData, pakai JSON
    let body = formData || null;

    fetch(url, { method, headers, body })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // tutup modal jika ada
                if (modalId) {
                    const modal = document.getElementById(modalId);
                    bootstrap.Modal.getInstance(modal)?.hide();
                    if (formData) formData.get('form')?.reset();
                }

                // tampilkan sweetalert global
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Operasi berhasil',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });

                // refresh datatable jika ada
                if (window.LaravelDataTables && window.LaravelDataTables[`${tableId}`]) {
                    window.LaravelDataTables[`${tableId}`].ajax.reload();
                }

            } else {
                // validasi error
                if (data.errors) handleValidationErrors(data.errors);
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan',
                        confirmButtonText: 'OK'
                    });
                }
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: 'Silakan coba lagi.',
                confirmButtonText: 'OK'
            });
        });
}

function handleValidationErrors(errors) {
    for (const field in errors) {
        const input = document.querySelector(`[name="${field}"]`);
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
