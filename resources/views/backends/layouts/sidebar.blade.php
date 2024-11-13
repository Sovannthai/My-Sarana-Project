<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark2">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('uploads/all_photo/' . session('business_logo')) }}"
                {{-- {{ asset('backends/assets/img/kaiadmin/logo_light.svg') }} --}}
                    class="navbar-brand" alt="AdminLTE Logo" class="brand-image"
                    style="width: 80%;object-fit: cover;margin-left: 12px;height: 190px;max-height: 105px;" />
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
                <li class="nav-item">
                    <a data-toggle="collapse" href="#room-management"
                        @if (Route::is('rooms.*') || Route::is('room-prices.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-door-closed"></i>
                        <p>@lang('Rooms Management')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('rooms.*') || Route::is('room-prices.*')) show @endif" id="room-management">
                        <ul class="nav nav-collapse">
                            <li class="@if (Route::is('rooms.*')) active @endif">
                                <a href="{{ route('rooms.index') }}">
                                    <span class="sub-item">@lang('Room List')</span>
                                </a>
                            </li>
                            <li class="@if (Route::is('room-prices.index')) active @endif">
                                <a href="{{ route('room-prices.index') }}">
                                    <span class="sub-item">@lang('Room Price')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item @if (Route::is('amenities.index')) active @endif">
                    <a href="{{ route('amenities.index') }}">
                        <i class="fas fa-couch"></i>
                        <p>@lang('Amenities Management')</p>
                    </a>
                </li>
                {{-- <li class="nav-item @if (Route::is('utilities.index')) active @endif">
                    <a href="{{ route('utilities.index') }}">
                        <i class="fas fa-plug"></i>
                        <p>@lang('Utilities Management')</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a data-toggle="collapse" href="#Utilities"
                        @if (Route::is('utilities.*') || Route::is('utilities_type.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fas fa-cubes"></i>
                        <p>@lang('Utilities Management')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('utilities.*') || Route::is('utilities_type.*')) show @endif" id="Utilities">
                        <ul class="nav nav-collapse">
                            <li class="@if (Route::is('utilities.*')) active @endif">
                                <a href="{{ route('utilities.index') }}">
                                    <span class="sub-item">@lang('Utilities List')</span>
                                </a>
                            </li>
                            <li class="@if (Route::is('utilities_type.*')) active @endif">
                                <a href="{{ route('utilities_type.index') }}">
                                    <span class="sub-item">@lang('Utilities Type')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item @if (Route::is('monthly_usages.index')) active @endif">
                    <a href="{{ route('monthly_usages.index') }}">
                        <i class="fas fa-chart-line"></i>
                        <p>@lang('Usages Management')</p>
                    </a>
                </li>
                {{-- <li class="nav-item @if (Route::is('chat-indext')) active @endif">
                    <a href="{{ route('chat-indext') }}">
                        <i class="fas fa-comments"></i>
                        <p>@lang('Chat')</p>
                    </a>
                </li> --}}
                <li class="nav-item @if (Route::is('price_adjustments.index')) active @endif">
                    <a href="{{ route('price_adjustments.index') }}">
                        <i class="fas fa-tag"></i>
                        <p>@lang('Discounts')</p>
                    </a>
                </li>
                <li class="nav-item @if (Route::is('user-request.index')) active @endif">
                    <a href="{{ route('user-request.index') }}">
                        <i class="fas fa-comments"></i>
                        <p>@lang('Chat')</p><span class="badge badge-danger">{{ $unreadMessagesCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tables"
                        @if (Route::is('business_setting.*')) aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa fas fa-cog"></i>
                        <p>@lang('Setting')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if (Route::is('business_setting.*')) show @endif" id="tables">
                        <ul class="nav nav-collapse">
                            <li class="@if (Route::is('business_setting.*')) active @endif">
                                <a href="{{ route('business_setting.index') }}">
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
