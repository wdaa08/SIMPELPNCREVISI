<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ auth()->user()->role_id == 1 ? route('dashboardsatgas') : route('chatbot') }}"" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"></i>SIMPEL-PNC</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ auth()->user()->nama }}</h6>
                <span>{{ auth()->user()->npm_nidn_npak }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            @if (auth()->user()->role_id == 1)
                <a href="{{ route('dashboardsatgas') }}"
                   class="nav-item nav-link {{ \Route::is('dashboardsatgas') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                </a>    
                <a href="{{ route('s.datapelaporan') }}"
                   class="nav-item nav-link {{ \Route::is('s.datapelaporan') ? 'active' : '' }}">
                    <i class="fa fa-file-alt me-2"></i>Data Pelaporan
                </a>
                <a href="{{ route('s.datapengguna') }}"
                   class="nav-item nav-link {{ \Route::is('s.datapengguna') ? 'active' : '' }}">
                    <i class="fa fa-users me-2"></i>Data Pengguna
                </a>
                <a href="{{ route('addquestion') }}"
                   class="nav-item nav-link {{ \Route::is('addquestion') ? 'active' : '' }}">
                    <i class="fa fa-comments me-2"></i>Olah Data Chatbot
                </a>
            @endif

            @if (auth()->user()->role_id == 2)
            <a href="{{ route('chatbot') }}"
                class="nav-item nav-link {{ \Route::is('chatbot') ? 'active' : '' }}"><i
                    class="fas fa-comments me-2"></i>ChatBot</a>
            <a href="{{ route('pelaporan') }}"
                class="nav-item nav-link {{ \Route::is('pelaporan') ? 'active' : '' }}"><i
                    class="fas fa-exclamation-triangle me-2"></i>Pelaporan</a>
            <a href="{{ route('laporansaya') }}"
                class="nav-item nav-link {{ \Route::is('laporansaya') ? 'active' : '' }}"><i
                    class="fas fa-file-alt me-2"></i>Laporan Saya</a>
        @endif
        
        </div>
</div>
</nav>
</div>
