<div class="dropdown">
    <button class="btn btn-sm btn-flat-primary btn-icon dropdown-toggle" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="fa fa-ellipsis-vertical fa-fw"></i>
    </button>
    <div class="dropdown-menu" style="">
        <a class="dropdown-item" href="{{ route('items.show', $item->id) }}">
            <i class="fa-solid fa-circle-info fa-fw me-1"></i>
            <span>Detail</span>
        </a>
        <button class="text-info dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-item-modal"
            data-id="{{$item->id}}" data-code="{{$item->code}}" data-name="{{$item->name}}" data-size="{{$item->size}}">
            <i class="far fa-edit fa-fw me-1"></i>
            <span>Ubah</span>
        </button>
        <button class="text-danger dropdown-item" data-action="destroy" data-table="item-table"
            data-url="{{ route('items.destroy', $item->id) }}">
            <i class="fa-solid fa-trash fa-fw me-1"></i>
            <span>Hapus</span>
        </button>
    </div>
</div>