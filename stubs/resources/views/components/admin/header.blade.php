<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box d-flex">
                <a href="{{ url('/') }}" target="_blank" class="logo logo-light text-white m-auto">
                    <span class="logo-sm">
                        <h2 class="mb-0">AD</h2>
                    </span>
                    <span class="logo-lg mb-0">
                        <h2 class="mb-0 d-flex">
                            <span>Adash</span>
                        </h2>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="fas fa-bars"></i>
            </button>


            <div class="d-none d-sm-block">
                <div class="dropdown pt-3 d-inline-block">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Shortcuts <i class="fas fa-caret-down"></i>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home mr-1"></i>
                            Dashboard
                        </a>

                        @can('users_access')
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users mr-1"></i>
                                Users List
                            </a>
                        @endcan

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="fas fa-power-off mr-1"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block dropstart">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ auth()->user()->profileImg() }}"
                        alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                        <i class="mdi mdi-account-circle font-size-17 align-middle mr-1"></i>
                        <i class="fas fa-home mr-1"></i>
                        Dashboard
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                        <i class="mdi mdi-lock-open-outline font-size-17 align-middle mr-1"></i>
                        <i class="fas fa-user mr-1"></i>
                        My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off font-size-17 align-middle mr-1 text-danger"></i>
                        <i class="fas fa-power-off mr-1"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="fas fa-arrows-alt"></i>
                </button>
            </div>
            <div class="dropdown d-none d-lg-inline-block">
                <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch">
                <label class="form-check-label btn header-item noti-icon waves-effect d-flex mb-0"
                    for="dark-mode-switch">
                    <i class="fas fa-moon m-auto"></i>
                </label>
            </div>
        </div>
    </div>
</header>
