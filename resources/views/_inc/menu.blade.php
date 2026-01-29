<ul class="menu-inner">




    <!-- Layouts -->


    @canany(['super-admin-access', 'admin-access'])

        <!-- CONFIGURAÇÕES -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="icon-base ti tabler-settings icon-md me-4"></i>
                <div data-i18n="Configurações">Configurações</div>
            </a>
            <ul class="menu-sub">

                @canany(['super-admin-access', 'admin-access'])
                    @if (auth()->user()->nivel == 'SuperAdmin')
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon icon-base ti tabler-building"></i>
                                <div data-i18n="Setores">Setores</div>
                            </a>
                        @else
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon icon-base ti tabler-building"></i>
                                <div data-i18n="Setor">Setor</div>
                            </a>
                    @endif

                    @if (auth()->user()->nivel == 'SuperAdmin')
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.departments.index') }}" class="menu-link">
                                    <div data-i18n="Listar">Listar</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.departments.create') }}" class="menu-link">
                                    <div data-i18n="Criar">Criar</div>
                                </a>
                            </li>
                        </ul>
                    @else
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.departments.edit', auth()->user()->departamento_id) }}"
                                    class="menu-link">
                                    <div data-i18n="Editar">Editar</div>
                                </a>
                            </li>
                        </ul>
                    @endif


            </li>

            @can(['super-admin-access'])
                <li class="menu-item">
                    <a href="{{ route('admin.configurations.index') }}" class="menu-link">
                        <i class="menu-icon icon-base ti tabler-user-circle"></i>
                        <div data-i18n="Configurações da Empresa">Configurações da Empresa</div>
                    </a>
                </li>
            @endcan
        @endcanany

    </ul>
    </li>
@endcanany

@canany(['super-admin-access', 'admin-access'])
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
@endcanany

</ul>
