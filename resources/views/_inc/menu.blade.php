<ul class="menu-inner">

    <li class="menu-item {{ request()->routeIs('admin.people.*') ? 'active open' : '' }}">
        <a href="#" class="menu-link">
            <i class="icon-base ti tabler-users-group icon-md me-2"></i>
            <div data-i18n="Inquilinos">Inquilinos</div>
        </a>

        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('admin.people.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.people.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-users-group"></i>
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

    <li class="menu-item">
        <a href="{{ route('admin.properties.index') }}" class="menu-link">
            <i class="icon-base ti tabler-building icon-md me-2"></i>
            <div data-i18n="Propriedades">Propriedades</div>
        </a>
    </li>

</ul>