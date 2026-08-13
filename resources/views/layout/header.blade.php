<!-- Topbar Start -->
<div class="topbar-custom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                <li>
                    <button class="button-toggle-menu nav-link">
                        <i data-feather="menu" class="noti-icon"></i>
                    </button>
                </li>
                <li class="d-none d-lg-block">
                    <h5 class="mb-0">
                        {{ Auth::user()->name ?? 'Admin User' }}
                    </h5>
                </li>
            </ul>

            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">

                <li class="d-none d-lg-block">
                    <div class="position-relative topbar-search">
                        <input type="text" class="form-control bg-light bg-opacity-75 border-light ps-4"
                            placeholder="Search...">
                        <i
                            class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                    </div>
                </li>


                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('assets/images/users/user-5.jpg') }}" alt="user-image"
                            class="rounded-circle">
                        <span class="pro-user-name ms-1">
                            {{ Auth::user()->name ?? 'Admin User' }}
                            <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>


                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item border-0 bg-transparent">
                                <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                <span>Logout</span>
                            </button>
                        </form>

                    </div>
                </li>

            </ul>
        </div>

    </div>

</div>
<!-- end Topbar -->

<!-- Left Sidebar Start -->
<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <div id="sidebar-menu">

            <!-- LOGO -->
            <div class="logo-box text-center" style="margin-top: -5;">
                <a class="logo logo-dark" href="{{ route('dashboard') }}">
                    <span class="logo-lg d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/logo1.png') }}" alt="logo"
                            style="width:150px; height:80px; object-fit:contain;">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarUserManagement" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span>User Management</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUserManagement">
                        <ul class="nav-second-level">
                            <li>
                                <a class="tp-link" href="{{ route('user.index') }}">User</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('company.index') }}">Companies</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarPackageManagement" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span>Packages</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarPackageManagement">
                        <ul class="nav-second-level">
                            {{-- <li>
                <a class="tp-link" href="{{ route('package.index') }}">Packages</a>
            </li> --}}
                            <li>
                                <a class="tp-link" href="{{ route('hajj-package.index') }}">Hajj Packages</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('umrah-package.index') }}">Umrah Packages</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('domestic-package.index') }}">Domestic Packages</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('international-package.index') }}">International
                                    Packages</a>
                            </li>
                            <li>
                                <a class="tp-link" href="{{ route('package-booking.index') }}">Package Bookings</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('visa-application.index') }}">
                        <i data-feather="file-text"></i>
                        <span>Visas</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('visa-country.index') }}">
                        <i data-feather="globe"></i>
                        <span>Visa Countries</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('hotel.index') }}">
                        <i data-feather="briefcase"></i>
                        <span>Hotels</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('meal-type.index') }}">
                        <i data-feather="coffee"></i>
                        <span>Meal Types</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('city.index') }}">
                        <i data-feather="map-pin"></i>
                        <span>Cities</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('hotel-booking.index') }}">
                        <i data-feather="calendar"></i>
                        <span>Hotel Bookings</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('transportation-route.index') }}">
                        <i data-feather="map"></i>
                        <span>Transportation Routes</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('tutorial.index') }}">
                        <i data-feather="video"></i>
                        <span>Tutorials</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('terms.edit') }}">
                        <i data-feather="file-text"></i>
                        <span>Terms & Conditions</span>
                    </a>
                </li>

                <li>
                    <a class="tp-link" href="{{ route('privacy.edit') }}">
                        <i data-feather="shield"></i>
                        <span>Privacy Policy</span>
                    </a>
                </li>




            </ul>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
