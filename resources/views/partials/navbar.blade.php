<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2D4059">
    <div class="container-fluid">
        <a class="navbar-brand mx-3" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="white"
                class="bi bi-book"viewBox="0 0 16 16">
                <path
                    d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
            </svg></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @if (Auth::guard('mahasiswa')->check())
                    <li class="nav-item mx-3">
                        <a class="nav-link active text-white" aria-current="page"
                            href="{{ route('mahasiswa.dashboard') }}">Books</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link active text-white" aria-current="page"
                            href="{{ route('mahasiswa.history') }}">History</a>
                    </li>
                @endif
                @if (Auth::guard('admin')->check())
                    <li class="nav-item mx-3">
                        <a class="nav-link active text-white" aria-current="page"
                            href="{{ route('admin.dashboard') }}">Books</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link text-white" href="{{ url('/category') }}">Categories</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link text-white" href="{{ route('admin.borrowing') }}">Borrowing</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-3">
                    <a class="nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="30"
                            height="30" fill="white" class="bi bi-bell nav-icon" viewBox="0 0 16 16">
                            <path
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                        </svg>
                        <span class="nav-text text-white nav-link">Notification</span>
                    </a>
                </li>
                @if (Auth::guard('mahasiswa')->check())
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="{{ route('mahasiswa.cart') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white"
                                class="bi bi-cart nav-icon" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                            </svg>
                            <span class="nav-text text-white nav-link">Cart</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item mx-3 profile-name">
                    <a class="nav-link text-white" href="#">{{ session('namaLengkap') }}</a>
                </li>
                @if (Auth::guard('admin')->check())
                    <li class="nav-item mx-3 nav-item-profile">
                        <a class="nav-link text-white" href="{{ route('admin.setting', session('id')) }}">Settings</a>
                    </li>
                @endif
                @if (Auth::guard('mahasiswa')->check())
                    <li class="nav-item mx-3 nav-item-profile">
                        <a class="nav-link text-white"
                            href="{{ route('mahasiswa.setting', session('id')) }}">Settings</a>
                    </li>
                @endif
                <li class="nav-item mx-3 nav-item-profile">
                    <a class="nav-link text-white" href="/logout">Logout</a>
                </li>
                <li class="nav-item mx-3 nav-item-img">
                    <div class="btn-group">
                        <img src="{{ url('/img/person-circle.svg') }}" height="40" width="40"
                            class="dropdown-toggle nav-img" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            @if (Auth::guard('admin')->check())
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.setting', session('id')) }}">Settings</a></li>
                            @endif
                            @if (Auth::guard('mahasiswa')->check())
                                <li><a class="dropdown-item"
                                        href="{{ route('mahasiswa.setting', session('id')) }}">Settings</a></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="/logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
