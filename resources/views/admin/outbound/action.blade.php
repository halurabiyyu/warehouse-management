<div class="dropdown">
    <button class="btn btn-sm btn-flat-primary btn-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-ellipsis-vertical fa-fw"></i>
    </button>
    <div class="dropdown-menu" style="">
        <button class="text-info dropdown-item edit-outbound-btn" data-bs-toggle="modal" data-bs-target="#edit-outbound-modal"
            data-item-id="{{$outbound->item_id}}" data-id="{{$outbound->id}}" data-quantity="{{$outbound->quantity}}">
            <i class="far fa-edit fa-fw me-1"></i>
            <span>Ubah</span>
        </button>
        <button class="text-danger dropdown-item" data-action="destroy" data-table="outbound-table"
            data-url="{{ route('outbound.destroy', $outbound->id) }}">
            <i class="fa-solid fa-trash fa-fw me-1"></i>
            <span>Hapus</span>
        </button>
    </div>
</div>
