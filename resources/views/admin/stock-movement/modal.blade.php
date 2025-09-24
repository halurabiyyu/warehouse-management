<!-- Add Modal -->
<div class="modal fade" id="add-item-modal" tabindex="-1" aria-labelledby="add-item-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-item-modal-label">Tambah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('items.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="item-code" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan Kode Barang" id="item-code" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="item-name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="item-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="item-unit" class="form-label">Satuan</label>
                        <input type="text" class="form-control" placeholder="Masukkan Satuan" id="item-unit" name="unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="item-stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" placeholder="Masukkan Stok" id="item-stock" name="stock" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>