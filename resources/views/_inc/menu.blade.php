<ul class="menu-inner">
    <li class="menu-item">
        <a href="{{ route('admin.people.index') }}" class="menu-link">
            <i class="icon-base ti tabler-users-group icon-md me-4"></i>
            <div data-i18n="Inquilinos">Inquilinos</div>
        </a>
    </li>

    <!-- Usuários -->
    <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="icon-base ti tabler-user icon-md me-4"></i>
            <div data-i18n="Usuários">Usuários</div>
        </a>

        <ul class="menu-sub">
            <!-- Usuários -->
            <li class="menu-item">
                <a href="{{ route('admin.user.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-list"></i>
                    <div data-i18n="Listar">Listar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.user.create') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-pencil-plus"></i>
                    <div data-i18n="Cadastrar">Cadastrar</div>
                </a>
            <li class="menu-item">
                <a href="{{ route('admin.user.inativos') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-user-off"></i>
                    <div data-i18n="Inativos">Inativos</div>
                </a>
            </li>
        </ul>
    </li>

</ul>