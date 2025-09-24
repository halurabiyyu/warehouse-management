<!-- Add Modal -->
<div class="modal fade" id="add-outbound-modal" tabindex="-1" aria-labelledby="add-outbound-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-outbound-modal-label">Tambah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('outbound.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="outbound-name" class="form-label">Nama Barang</label>
                        <select name="item_id" id="outbound-name" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Barang --</option>
                            {{-- @foreach($outbounds as $outbound)
                                <option value="{{ $outbound->id }}">{{ $outbound->name }} ({{ $outbound->code }})</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="outbound-unit" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" placeholder="Masukkan Jumlah" id="outbound-unit" name="quantity" required>
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