<ul class="menu-inner py-1">
    @foreach ($menus as $menu)
        @if (count($menu['sub_menus']) > 0)
            <li class="menu-item dropdown">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-{!! $menu['icon'] !!}"></i>
                    <div data-i18n="{{ $menu['menu_name'] }}">{{ $menu['menu_name'] }}</div>
                </a>
                <ul class="menu-sub">
                    @foreach ($menu['sub_menus'] as $submenu)
                        <li class="menu-item">
                            <a href="{{ url($submenu['route_name']) }}" class="menu-link">
                                <div data-i18n="{{ $submenu['menu_name'] }}">{{ $submenu['menu_name'] }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="menu-item">
                <a href="{{ url($menu['route_name']) }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-{!! $menu['icon'] !!}"></i>
                    <div data-i18n="{{ $menu['menu_name'] }}">{{ $menu['menu_name'] }}</div>
                </a>
            </li>
        @endif
    @endforeach
</ul>

</aside>

<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->

    <nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
        <div class="container-xxl">

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

                <!-- Search -->
                <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <i class="icon-base ri ri-search-line icon-lg lh-0"></i>
                        <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                            aria-label="Search..." />
                    </div>
                </div>
                <!-- /Search -->

                <ul class="navbar-nav flex-row align-items-center ms-md-auto">

                    <!-- <li class="nav-item dropdown-language dropdown me-sm-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                            href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class="icon-base ri ri-translate-2 icon-22px"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-language="en"
                                    data-text-direction="ltr">
                                    <span>English</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-language="fr"
                                    data-text-direction="ltr">
                                    <span>French</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-language="ar"
                                    data-text-direction="rtl">
                                    <span>Arabic</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-language="de"
                                    data-text-direction="ltr">
                                    <span>German</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <!--/ Language -->

                    <!-- Style Switcher -->
                    <li class="nav-item dropdown me-sm-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                            id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class="icon-base ri ri-sun-line icon-22px theme-icon-active"></i>
                            <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                            <li>
                                <button type="button" class="dropdown-item align-items-center active"
                                    data-bs-theme-value="light" aria-pressed="false">
                                    <span> <i class="icon-base ri ri-sun-line icon-md me-3"
                                            data-icon="sun-line"></i>Light</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item align-items-center"
                                    data-bs-theme-value="dark" aria-pressed="true">
                                    <span> <i class="icon-base ri ri-moon-clear-line icon-md me-3"
                                            data-icon="moon-clear-line"></i>Dark</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item align-items-center"
                                    data-bs-theme-value="system" aria-pressed="false">
                                    <span> <i class="icon-base ri ri-computer-line icon-md me-3"
                                            data-icon="computer-line"></i>System</span>
                                </button>
                            </li>
                        </ul>
                    </li>
                    <!-- / Style Switcher-->

                    <!-- Notification -->
                    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                        <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                            href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <span class="position-relative">
                                <i class="icon-base ri ri-notification-2-line icon-22px"></i>
                                <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0">
                            <li class="dropdown-menu-header border-bottom">
                                <div class="dropdown-header d-flex align-items-center py-3">
                                    <h6 class="mb-0 me-auto">Notification</h6>
                                    <div class="d-flex align-items-center h6 mb-0">
                                        <span class="badge bg-label-primary rounded-pill me-2">8 New</span>
                                        <a href="javascript:void(0)" class="dropdown-notifications-all p-2"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Mark all as read">
                                            <i class="icon-base ri ri-mail-open-line text-heading"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-notifications-list scrollable-container">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="{{ url('/') }}/assets/img/avatars/1.png"
                                                        alt="alt" class="rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">Congratulation Lettie ?</h6>
                                                <small class="mb-1 d-block text-body">Won the monthly best
                                                    seller gold badge</small>
                                                <small class="text-body-secondary">1h ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span
                                                        class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">Charles Franklin</h6>
                                                <small class="mb-1 d-block text-body">Accepted your
                                                    connection</small>
                                                <small class="text-body-secondary">12hr ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="{{ url('/') }}/assets/img/avatars/2.png"
                                                        alt="alt" class="rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">New Message ??</h6>
                                                <small class="mb-1 d-block text-body">You have new message from
                                                    Natalie</small>
                                                <small class="text-body-secondary">1h ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-label-success">
                                                        <i class="icon-base ri ri-car-line"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">Whoo! You have new order ?</h6>
                                                <small class="mb-1 d-block text-body">ACME Inc. made new order
                                                    $1,154</small>
                                                <small class="text-body-secondary">1 day ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="{{ url('/') }}/assets/img/avatars/9.png"
                                                        alt="alt" class="rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">Application has been approved ?</h6>
                                                <small class="mb-1 d-block text-body">Your ABC project
                                                    application has been approved.</small>
                                                <small class="text-body-secondary">2 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-label-success">
                                                        <i class="icon-base ri ri-pie-chart-2-line"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">Monthly report is generated</h6>
                                                <small class="mb-1 d-block text-body">July monthly financial
                                                    report is generated </small>
                                                <small class="text-body-secondary">3 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="{{ url('/') }}/assets/img/avatars/5.png"
                                                        alt="alt" class="rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">Send connection request</h6>
                                                <small class="mb-1 d-block text-body">Peter sent you connection
                                                    request</small>
                                                <small class="text-body-secondary">4 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="{{ url('/') }}/assets/img/avatars/6.png"
                                                        alt="alt" class="rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">New message from Jane</h6>
                                                <small class="mb-1 d-block text-body">Your have new message
                                                    from Jane</small>
                                                <small class="text-body-secondary">5 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-label-warning">
                                                        <i class="icon-base ri ri-error-warning-line"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-50">CPU is running high</h6>
                                                <small class="mb-1 d-block text-body">CPU Utilization Percent
                                                    is currently at 88.63%,</small>
                                                <small class="text-body-secondary">5 days ago</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                <a href="javascript:void(0)" class="dropdown-notifications-read">
                                                    <span class="badge badge-dot"></span></a>
                                                <a href="javascript:void(0)" class="dropdown-notifications-archive">
                                                    <span class="icon-base ri ri-close-line"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="border-top">
                                <div class="d-grid p-4">
                                    <a class="btn btn-primary btn-sm d-flex h-px-34" href="javascript:void(0);">
                                        <small class="align-middle">View all notifications</small>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!--/ Notification -->

                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img src="{{ url('/') }}/assets/img/avatars/1.png" alt="alt"
                                    class="rounded-circle" />
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                            <li>
                                <a class="dropdown-item" href="pages-account-settings-account.html">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar avatar-online">
                                                <img src="{{ url('/') }}/assets/img/avatars/1.png"
                                                    alt="alt" class="w-px-40 h-auto rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">
                                                @if (session()->has('name'))
                                                    {{ session()->get('name') }}
                                                @else
                                                    Guest
                                                @endif
                                            </h6>
                                            <small class="text-body-secondary">
                                                @if (session()->has('designation'))
                                                    {{ session()->get('designation') }}
                                                @else
                                                    Guest
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pages-profile-user.html">
                                    <i class="icon-base ri ri-user-3-line icon-22px me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <!--
                            <li>
                                <a class="dropdown-item" href="pages-account-settings-account.html">
                                    <i class="icon-base ri ri-settings-4-line icon-22px me-2"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="pages-account-settings-billing.html">
                                    <span class="d-flex align-items-center align-middle">
                                        <i class="flex-shrink-0 icon-base ri ri-file-text-line icon-22px me-2"></i>
                                        <span class="flex-grow-1 align-middle">Billing</span>
                                        <span
                                            class="flex-shrink-0 badge badge-center rounded-pill bg-danger h-px-20 d-flex align-items-center justify-content-center">4</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pages-pricing.html">
                                    <i class="icon-base ri ri-money-dollar-circle-line icon-22px me-2"></i>
                                    <span class="align-middle">Pricing</span>
                                </a>
                            </li>-->
                            <li>
                                <a href="#" id="change_pass" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-change-pass">
                                    <i class="icon-base ri ri-settings-4-line icon-md me-3"></i>
                                    <span>Change Password</span>
                                </a>
                            </li>
                            <li>
                                <div class="d-grid px-4 pt-2 pb-1">
                                    <a class="btn btn-danger d-flex" href="{{ url('/logout') }}">
                                        <small class="align-middle">Logout</small>
                                        <i class="ri ri-logout-box-r-line ms-2 ri-xs"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!--/ User -->

                </ul>
            </div>
        </div>
    </nav>

    <!-- / Navbar -->
