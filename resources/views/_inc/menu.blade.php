<ul class="menu-inner">

    <li class="menu-item {{ request()->routeIs('admin.people.*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle">
            <i class="icon-base ti tabler-users-group icon-md me-2"></i>
            <div data-i18n="Inquilinos">Inquilinos</div>
        </a>

        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('admin.people.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.people.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-users"></i>
                    <div data-i18n="Meus Inquilinos">Meus Inquilinos</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.people.create') ? 'active open' : '' }}">
                <a href="{{ route('admin.people.create') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-plus"></i>
                    <div data-i18n="Novo Inquilino">Novo Inquilino</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item {{ request()->routeIs('admin.properties.*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle">
            <i class="icon-base ti tabler-building-community icon-md me-2"></i>
            <div data-i18n="Propriedades">Propriedades</div>
        </a>

        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('admin.properties.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.properties.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-building"></i>
                    <div data-i18n="Minhas Propriedades">Minhas Propriedades</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.properties.create') ? 'active open' : '' }}">
                <a href="{{ route('admin.properties.create') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-plus"></i>
                    <div data-i18n="Nova Propriedade">Nova Propriedade</div>
                </a>
            </li>
    </li>

</ul>