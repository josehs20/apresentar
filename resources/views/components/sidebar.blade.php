<nav class="sidebar" id="sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-grid-fill"></i>
        </div>
        <span class="sidebar-logo-text">{{ config('app.name') }}</span>
    </div>

    {{-- Navigation --}}
    <div class="sidebar-nav">
        <div class="sidebar-label">Navegação</div>

        <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 sidebar-icon"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>

        <a href="{{ route('admin.products.index') }}" class="sidebar-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam sidebar-icon"></i>
            <span class="sidebar-text">Produtos</span>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags sidebar-icon"></i>
            <span class="sidebar-text">Categorias</span>
        </a>

        <a href="{{ route('admin.posts.index') }}" class="sidebar-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <i class="bi bi-file-text sidebar-icon"></i>
            <span class="sidebar-text">Blog</span>
        </a>

        <a href="{{ route('admin.interactions.index') }}" class="sidebar-item {{ request()->routeIs('admin.interactions.*') ? 'active' : '' }}">
            <i class="bi bi-activity sidebar-icon"></i>
            <span class="sidebar-text">Interações</span>
        </a>

        <a href="{{ route('admin.pontos-venda.index') }}" class="sidebar-item {{ request()->routeIs('admin.pontos-venda.*') ? 'active' : '' }}">
            <i class="bi bi-shop sidebar-icon"></i>
            <span class="sidebar-text">Pontos de Venda</span>
        </a>

        <a href="{{ route('admin.configuracoes.index') }}" class="sidebar-item {{ request()->routeIs('admin.configuracoes.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill sidebar-icon"></i>
            <span class="sidebar-text">Configurações</span>
        </a>

        <a href="{{ route('admin.configuracoes-cores.edit') }}" class="sidebar-item {{ request()->routeIs('admin.configuracoes-cores.*') ? 'active' : '' }}">
            <i class="bi bi-palette sidebar-icon"></i>
            <span class="sidebar-text">Cores do Site</span>
        </a>

        <a href="{{ route('admin.tipos-interacao.index') }}" class="sidebar-item {{ request()->routeIs('admin.tipos-interacao.*') ? 'active' : '' }}">
            <i class="bi bi-gear sidebar-icon"></i>
            <span class="sidebar-text">Tipos de Interação</span>
        </a>
    </div>

    {{-- Footer --}}
    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}" class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="bi bi-person sidebar-icon"></i>
            <span class="sidebar-text">Perfil</span>
        </a>
    </div>
</nav>