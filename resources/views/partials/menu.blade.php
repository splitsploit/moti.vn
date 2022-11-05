<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.configurations.index') }}"
                        class="nav-link {{ request()->is('admin/configurations') || request()->is('admin/configurations/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-cog nav-icon">

                        </i>
                        {{ trans('cruds.configurations.title') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.availableBookingTime.index') }}"
                        class="nav-link {{ request()->is('admin/availableBookingTime') || request()->is('admin/availableBookingTime/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-calendar-times-o nav-icon">

                        </i>
                        {{ trans('cruds.availableBookingTime.title') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.specialTime.index') }}"
                        class="nav-link {{ request()->is('admin/specialTime') || request()->is('admin/specialTime/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clock nav-icon">

                        </i>
                        {{ trans('cruds.specialTime.title') }}
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('admin.timekeeping.index') }}"
                    class="nav-link {{ request()->is('admin/timekeeping') || request()->is('admin/timekeeping/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-calendar-check-o nav-icon">

                    </i>
                    {{ trans('cruds.timekeeping.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.timesheets.index') }}"
                    class="nav-link {{ request()->is('admin/timesheets') || request()->is('admin/timesheets/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-calendar-o nav-icon">

                    </i>
                    {{ trans('cruds.timesheets.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.bookingTime.index') }}"
                    class="nav-link {{ request()->is('admin/bookingTime') || request()->is('admin/bookingTime/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-clock nav-icon">

                    </i>
                    {{ trans('cruds.bookingTime.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.calendar.index') }}"
                    class="nav-link {{ request()->is('admin/calendar') || request()->is('admin/calendar/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-calendar nav-icon">

                    </i>
                    Calendar
                </a>
            </li>
            @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}"
                        href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
