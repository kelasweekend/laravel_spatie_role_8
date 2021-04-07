<div class="form-inline mt-2">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the  -->
        @can('menu-user')
            {{-- <li class="nav-item">
                <a href="$" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>
                        User Management
                    </p>
                </a>
            </li> --}}
            <li class="nav-item {{ Request::segment(1) === 'dashboard' ? 'menu-is-opening menu-open': null }}">
                <a href="#" class="nav-link {{ Request::segment(2) === 'course' ? 'active' : null }}">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>
                        Permissions Access
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('users.index')}}" class="nav-link {{ Request::is('dashboard/users') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('roles.index')}}" class="nav-link {{ Request::is('dashboard/roles') ? 'active' : null }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Role Controll</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('permissions.index')}}" class="nav-link {{ Request::is('dashboard/permissions') ? 'active' : null }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Permissions Controll</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
    </ul>
</nav>
<!-- /.sidebar-menu -->
