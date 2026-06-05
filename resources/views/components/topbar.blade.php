<header class="topbar">
    <div class="topbar-left">
        <button class="topbar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div>
            <h6 class="mb-0 fw-semibold" style="font-size:15px;">@yield('title', 'Dashboard')</h6>
        </div>
    </div>

    <div class="topbar-right">
        <div class="dropdown">
            <a href="#" class="topbar-user" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="topbar-avatar">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <span class="topbar-username d-none d-md-inline">{{ Auth::user()->name ?? 'Usuário' }}</span>
                <i class="bi bi-chevron-down d-none d-md-inline" style="font-size:12px;opacity:0.5;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border:none;border-radius:10px;min-width:180px;">
                <li>
                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person me-2"></i>Perfil
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Sair
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>