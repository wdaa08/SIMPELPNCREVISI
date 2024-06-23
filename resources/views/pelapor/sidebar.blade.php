<div class="sidebar pe-4 pb-5">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ Route('pelaporan') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>SIMPEL PNC</h3>
        </a>

        <div class="navbar-nav w-100">
            <a href="{{route ('dashboardpelapor')}}" class="nav-item nav-link {{ \Route::is('dashboardpelapor') ? 'active' : ''}}"><i class="bi bi-file-earmark-ppt-fill me-2"></i>Dashboard</a>
            <a href="{{route ('pelaporan')}}" class="nav-item nav-link {{ \Route::is('pelaporan') ? 'active' : ''}}"><i class="bi bi-file-earmark-ppt-fill me-2"></i>Pelaporan</a>
            <a href="{{route ('laporansaya')}}" class="nav-item nav-link {{ \Route::is('laporansaya') ? 'active' : ''}}"><i class="fa fa-keyboard me-2"></i>Laporan Saya</a>
            <a href="{{route ('chatbot')}}" class="nav-item nav-link {{ \Route::is('chatbot') ? 'active' : ''}}"><i class="bi bi-chat-right-text me-2"></i>ChatBot</a>

            {{-- <a href="{{route ('laporan_saya')}}" class="nav-item nav-link {{ \Route::is('laporan_saya') ? 'active' : ''}}"><i class="fa fa-keyboard me-2"></i>Laporan Saya</a> --}}
    </div>
        </div>
    </nav>
</div>