<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark2">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('backends/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                    class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item @if (Route::is('home')) active @endif">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#forms"
                        @if (Route::is('roles.*') || Route::is('permission.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-users"></i>
                        <p>User Management</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('roles.*') || Route::is('permission.*')) show @endif" id="forms">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="#">
                                    <span class="sub-item">Users</span>
                                </a>
                            </li>
                            <li class="@if (Route::is('roles.*')) active @endif">
                                <a href="{{ route('roles.index') }}">
                                    <span class="sub-item">Role</span>
                                </a>
                            </li>
                            <li class="@if (Route::is('permission.*')) active @endif">
                                <a href="{{ route('permission.index') }}">
                                    <span class="sub-item">Permissions</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tables">
                        <i class="fa fas fa-cog"></i>
                        <p>Setting</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="#">
                                    <span class="sub-item">General Setting</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
