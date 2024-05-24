<div class="sidebar pe-4 pb-5">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Jhon Doe</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            
            <a href="{{route ('pelaporan')}}" class="nav-item nav-link {{ \Route::is('pelaporan') ? 'active' : ''}}"><i class="fa fa-keyboard me-2"></i>Pelaporan</a>
            <a href="{{route ('laporansaya')}}" class="nav-item nav-link {{ \Route::is('laporansaya') ? 'active' : ''}}"><i class="fa fa-keyboard me-2"></i>Laporan Saya</a>
            {{-- <a href="{{route ('laporan_saya')}}" class="nav-item nav-link {{ \Route::is('laporan_saya') ? 'active' : ''}}"><i class="fa fa-keyboard me-2"></i>Laporan Saya</a> --}}
    </div>
        </div>
    </nav>
</div>