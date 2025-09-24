<nav class="bottom-navbar bg-body-tertiary rounded-top">
    <ul class="navbar-nav d-flex flex-row justify-content-around w-100 text-center">
        <li class="nav-item flex-fill">
            <a class="nav-link active" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-house"></i>
            </a>
        </li>
        <li class="nav-item flex-fill dropup">
            <a class="nav-link dropdown-toggle" href="#" id="barangDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-boxes-stacked"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="barangDropdown">
                <li><a class="dropdown-item" href="{{route('items.index')}}">Barang</a></li>
                <li><a class="dropdown-item" href="{{route('inbound.index')}}">Barang Masuk</a></li>
                <li><a class="dropdown-item" href="{{route('outbound.index')}}">Barang Keluar</a></li>
            </ul>
        </li>
        <li class="nav-item flex-fill">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </a>
        </li>
        <li class="nav-item flex-fill">
            <a class="nav-link" href="{{ route('profile') }}">
                <i class="fa-solid fa-user"></i>
            </a>
        </li>
    </ul>
</nav>