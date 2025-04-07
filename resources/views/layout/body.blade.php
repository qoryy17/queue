@include('layout.header')
@if (session()->has('success'))
    <script>
        'use strict';
        window.onload = function() {
            Swal.fire({
                icon: "success",
                title: "Notification",
                text: "{{ session('success') }}"
            });
        }
    </script>
@elseif (session()->has('error'))
    <script>
        'use strict';
        window.onload = function() {
            Swal.fire({
                icon: "error",
                title: "Notification",
                text: "{{ session('error') }}"
            });
        }
    </script>
@endif
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
@include('layout.sidebar')

<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item">
                    <p class="d-none d-md-block mt-4 f-16">
                        {{ env('APP_DESC') }}
                    </p>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar" />
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <ul class="list-group list-group-flush w-100">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('assets/images/user/avatar-2.jpg') }}"
                                                    alt="user-image" class="wid-50 rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1 mx-3">
                                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                                <a class="link-primary"
                                                    href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-key"></i>
                                                <span>Change password</span>
                                            </span>
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-user-circle"></i>
                                                <span>Edit profile</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" class="dropdown-item" onclick="signOut()">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-power"></i>
                                                <span>Logout</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header ] end -->

@yield('content')


<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <p class="m-0">Support By <a href="https://www.instagram.com/qori_chairawan17/" target="_blank">
                        {{ env('APP_AUTHOR') }}
                    </a>
                </p>
            </div>
            <div class="col-lg-6">
                <p class="m-0 text-end">
                    Version {{ env('APP_VERSION') }}
                </p>
            </div>
        </div>
    </div>
</footer>
<form action="{{ route('logout') }}" method="POST" id="formLogout">
    @method('POST')
    @csrf
</form>
<script>
    function signOut() {
        let formLogout = document.getElementById('formLogout');
        formLogout.submit();
    }
</script>

@include('layout.footer')
