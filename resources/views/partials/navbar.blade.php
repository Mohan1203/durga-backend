<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="/"><img src="/assets/Durga_logo.png" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="/">
            <img src="/assets/Durga_logo.png" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">


        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="/assets/Durga_logo.png" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">Admin</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown border-0 shadow-sm" aria-labelledby="profileDropdown">
                    <div class="dropdown-header bg-light py-2">
                        <strong>Administrator</strong>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out me-2 text-danger"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                id="sidebarToggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </ul>
    </div>
</nav>
