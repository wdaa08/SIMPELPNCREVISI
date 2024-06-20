<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <div class="navbar-nav align-items-center ms-auto">

        <div class="nav-item dropdown">
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
            
            </div>
        </div>
        <div class="nav-item dropdown"  >
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-fill" style="margin-right: 6px;"></i>{{auth()->user()->nama}}
                {{-- <span class="d-none d-lg-inline-flex">Welcome, </span> --}}
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('profile', ['id' => auth()->user()->id]) }}" class="dropdown-item">Profil Saya</a>
                <form action="{{ route('actionlogout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
