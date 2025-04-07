@php
    $route = \App\Helpers\RouterLink::string(Auth::user()->role);
@endphp
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route($route) }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                {{-- <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo image" class="logo-lg" /> --}}
                <span class="fs-1 fw-medium"> {{ env('APP_NAME') }}</span>
                <span class="badge bg-brand-color-1 rounded-pill ms-2 theme-version">Version
                    {{ env('APP_VERSION') }}</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ route($route) }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-house"></i>
                        </span>
                        <span class="pc-mtext">Home</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Queue</label>
                    <i class="ph-duotone ph-users"></i>
                </li>
                <li class="pc-item">
                    @php
                        $route = \App\Helpers\RouterLink::queue(Auth::user()->role);
                    @endphp
                    <a href="{{ route($route) }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-users-three"></i>
                        </span>
                        <span class="pc-mtext">Queue</span>
                    </a>
                </li>
                @if (Auth::user()->role === \App\Enum\RolesEnum::ADMIN->value)
                    <li class="pc-item pc-caption">
                        <label>User & Officer</label>
                        <i class="ph-duotone ph-users"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('officers.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-user-square"></i>
                            </span>
                            <span class="pc-mtext">Officers</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('users.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-user"></i>
                            </span>
                            <span class="pc-mtext">Users</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Counter</label>
                        <i class="ph-duotone ph-desktop-tower"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('counters.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-database"></i>
                            </span>
                            <span class="pc-mtext">Counter</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Setting</label>
                        <i class="ph-duotone ph-gear"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('voice.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-soundcloud-logo"></i>
                            </span>
                            <span class="pc-mtext">Voice</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('setting.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-desktop"></i>
                            </span>
                            <span class="pc-mtext">Application</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('logs.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-activity"></i>
                            </span>
                            <span class="pc-mtext">Logs Activity</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="card nav-action-card bg-brand-color-4">
                <div class="card-body"
                    style="background-image: url('{{ asset('assets/images/layout/nav-card-bg.svg') }}')">
                    <h5 class="text-dark">Help Center</h5>
                    <p class="text-dark text-opacity-75">Please contact us for more questions.</p>
                    <a href="https://wa.me/6281376472224" class="btn btn-primary" target="_blank">
                        Go to help Center
                    </a>
                </div>
            </div>
        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image"
                            class="user-avtar wid-45 rounded-circle" />
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="dropdown">
                            <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,20">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                        <small>{{ Auth::user()->role }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="btn btn-icon btn-link-secondary avtar">
                                            <i class="ph-duotone ph-windows-logo"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li>
                                        <a class="pc-user-links">
                                            <i class="ph-duotone ph-user"></i>
                                            <span>My Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="pc-user-links" href="{{ route($route) }}">
                                            <i class="ph-duotone ph-users-three"></i>
                                            <span>Queue</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="pc-user-links" onclick="signOut()">
                                            <i class="ph-duotone ph-power"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
