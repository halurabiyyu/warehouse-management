<!-- Add Modal -->
<div class="modal fade" id="add-inbound-modal" tabindex="-1" aria-labelledby="add-inbound-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-inbound-modal-label">Tambah Barang Masuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inbound.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="inbound-name" class="form-label">Nama Barang</label>
                        <select name="item_id" id="inbound-name" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Barang --</option>
                            {{-- @foreach($inbounds as $inbound)
                                <option value="{{ $inbound->id }}">{{ $inbound->name }} ({{ $inbound->code }})</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="inbound-unit" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" placeholder="Masukkan Jumlah" id="inbound-unit" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="inbound-date" class="form-label">Tanggal masuk</label>
                        <input type="date" class="form-control" id="inbound-date" name="received_date" required>
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