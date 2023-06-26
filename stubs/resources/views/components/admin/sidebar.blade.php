<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                {{-- adash-dashboard --}}
                <li class="menu-title">Admin Main</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- end adash-dashboard --}}

                @can('queries_access')
                <li>
                    <a href="{{ route('admin.queries.index') }}" class="waves-effect">
                        <i class="fas fa-question-circle"></i>
                        <span>Queries</span>
                    </a>
                </li>
                @endcan

                @canany(['roles_access', 'permissions_access', 'users_access'])
                    <li class="menu-title">Manage Users</li>
                    @can('roles_access')
                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="waves-effect">
                                <i class="fas fa-users-cog"></i>
                                <span>All Roles</span>
                            </a>
                        </li>
                    @endcan

                    @can('permissions_access')
                        <li>
                            <a href="{{ route('admin.permissions.index') }}" class="waves-effect">
                                <i class="fas fa-user-shield"></i>
                                <span>All Permissions</span>
                            </a>
                        </li>
                    @endcan

                    @can('users_access')
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="waves-effect">
                                <i class="fas fa-users"></i>
                                <span>All Users</span>
                            </a>
                        </li>
                    @endcan
                @endcanany


                <li class="menu-title">Manage Account</li>
                <li>
                    <a href="{{ route('admin.profile.edit') }}" class=" waves-effect">
                        <i class="fas fa-user"></i>
                        <span>Update Profile</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class=" waves-effect"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
