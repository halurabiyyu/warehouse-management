<div class="dropdown">
    <button class="btn btn-sm btn-flat-primary btn-icon dropdown-toggle" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="fa fa-ellipsis-vertical fa-fw"></i>
    </button>
    <div class="dropdown-menu" style="">
        <button class="text-info dropdown-item edit-inbound-btn" data-bs-toggle="modal" data-bs-target="#edit-inbound-modal"
            data-item-id="{{$inbound->item_id}}" data-id="{{$inbound->id}}" data-quantity="{{$inbound->quantity}}">
            <i class="far fa-edit fa-fw me-1"></i>
            <span>Ubah</span>
        </button>
        <button class="text-danger dropdown-item" data-action="destroy" data-table="inbound-table"
            data-url="{{ route('inbound.destroy', $inbound->id) }}">
            <i class="fa-solid fa-trash fa-fw me-1"></i>
            <span>Hapus</span>
        </button>
    </div>
</div>