<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark2">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('backends/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                    class="navbar-brand" height="200" />
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
                        <p>@lang('Home')</p>
                    </a>
                </li>
                {{-- <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                </li> --}}
                @if (auth()->user()->can('view user'))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#forms"
                            @if (Route::is('roles.*') || Route::is('permission.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                            <i class="fas fa-users"></i>
                            <p>@lang('User Management')</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if (Route::is('roles.*') || Route::is('permission.*') || Route::is('users.*')) show @endif" id="forms">
                            <ul class="nav nav-collapse">
                                <li class="@if (Route::is('users.*')) active @endif">
                                    <a href="{{ route('users.index') }}">
                                        <span class="sub-item">@lang('Users')</span>
                                    </a>
                                </li>
                                @if (auth()->user()->can('view role'))
                                    <li class="@if (Route::is('roles.*')) active @endif">
                                        <a href="{{ route('roles.index') }}">
                                            <span class="sub-item">@lang('Roles')</span>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()->roles->first()->name == 'Admin')
                                    <li class="@if (Route::is('permission.*')) active @endif">
                                        <a href="{{ route('permission.index') }}">
                                            <span class="sub-item">@lang('Permissions')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif



                @if (auth()->user()->can('view user'))
<<<<<<< HEAD
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#rooms"
                            @if (Route::is('roles.*') || Route::is('rooms.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                            <i class="fa fa-bed"></i>
                            <p>@lang('Rooms Management')</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if (Route::is('roles.*') || Route::is('rooms.*') || Route::is('users.*')) show @endif" id="rooms">
                            <ul class="nav nav-collapse">
                                @if (auth()->user()->roles->first()->name == 'Admin')
                                    <li class="@if (Route::is('rooms.*')) active @endif">
                                        <a href="{{ route('rooms.index') }}">
                                            <span class="sub-item">@lang('Room Details')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                {{-- <li class="nav-item @if (Route::is('chat-indext')) active @endif">
                    <a href="{{ route('chat-indext') }}">
                        <i class="fas fa-comments"></i>
                        <p>@lang('Chat')</p>
                    </a>
                </li> --}}
                <li class="nav-item @if (Route::is('user-request.index')) active @endif">
                    <a href="{{ route('user-request.index') }}">
                        <i class="fas fa-comments"></i>
                        <p>@lang('Request')</p>
                    </a>
                </li>
=======
                <li class="nav-item">
                    <a data-toggle="collapse" href="#rooms"
                        @if (Route::is('roles.*') || Route::is('rooms.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-door-closed"></i>
                        <p>@lang('Rooms Management')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('roles.*') || Route::is('rooms.*') || Route::is('users.*')) show @endif" id="rooms">
                        <ul class="nav nav-collapse">
                            @if (auth()->user()->roles->first()->name == 'Admin')
                            <li class="@if (Route::is('rooms.*')) active @endif">
                                <a href="{{ route('rooms.index') }}">
                                    <span class="sub-item">@lang('Room Details')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif


                @if (auth()->user()->can('view user'))
                <li class="nav-item">
                    <a data-toggle="collapse" href="#amenities"
                        @if (Route::is('roles.*') || Route::is('amenities.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-couch"></i>
                        <p>@lang('Amenities Management')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('roles.*') || Route::is('amenities.*') || Route::is('users.*')) show @endif" id="amenities">
                        <ul class="nav nav-collapse">
                            @if (auth()->user()->roles->first()->name == 'Admin')
                            <li class="@if (Route::is('amenities.*')) active @endif">
                                <a href="{{ route('amenities.index') }}">
                                    <span class="sub-item">@lang('Details')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @if (auth()->user()->can('view user'))
                <li class="nav-item">
                    <a data-toggle="collapse" href="#price_adjustments"
                        @if (Route::is('roles.*') || Route::is('price_adjustments.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-tag"></i>
                        <p>@lang('Price Management')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('roles.*') || Route::is('price_adjustments.*') || Route::is('users.*')) show @endif" id="price_adjustments">
                        <ul class="nav nav-collapse">
                            @if (auth()->user()->roles->first()->name == 'Admin')
                            <li class="@if (Route::is('price_adjustments.*')) active @endif">
                                <a href="{{ route('price_adjustments.index') }}">
                                    <span class="sub-item">@lang('Details')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @if (auth()->user()->can('view user'))
                <li class="nav-item">
                    <a data-toggle="collapse" href="#utilities"
                        @if (Route::is('roles.*') || Route::is('utilities.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-plug"></i>
                        <p>@lang('Utilities Management')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('roles.*') || Route::is('utilities.*') || Route::is('users.*')) show @endif" id="utilities">
                        <ul class="nav nav-collapse">
                            @if (auth()->user()->roles->first()->name == 'Admin')
                            <li class="@if (Route::is('utilities.*')) active @endif">
                                <a href="{{ route('utilities.index') }}">
                                    <span class="sub-item">@lang('Details')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @if (auth()->user()->can('view user'))
                <li class="nav-item">
                    <a data-toggle="collapse" href="#monthly_usages"
                        @if (Route::is('roles.*') || Route::is('monthly_usages.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-chart-line"></i>
                        <p>@lang('Usages Management')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('roles.*') || Route::is('monthly_usages.*') || Route::is('users.*')) show @endif" id="monthly_usages">
                        <ul class="nav nav-collapse">
                            @if (auth()->user()->roles->first()->name == 'Admin')
                            <li class="@if (Route::is('monthly_usages.*')) active @endif">
                                <a href="{{ route('monthly_usages.index') }}">
                                    <span class="sub-item">@lang('Details')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

>>>>>>> pheakdey_branch
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tables">
                        <i class="fa fas fa-cog"></i>
                        <p>@lang('Setting')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="#">
                                    <span class="sub-item">@lang('General Setting')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
