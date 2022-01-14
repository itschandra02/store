@section('loader')
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
@endsection
@section('head')
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/">
                    <!-- Logo icon -->
                    <b>
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="{{ setting('logo') }}" alt="homepage" class="dark-logo" width="32px"
                            height="32px" />
                        <!-- Light Logo icon -->
                        <img src="{{ setting('logo') }}" alt="homepage" class="light-logo" width="32px"
                            height="32px" />
                    </b>
                    <!--End Logo icon -->
                    {{-- <!-- Logo text --><span>
                        <!-- dark Logo text -->
                        <img src="{{ URL::to('storage/' . setting('logo')) }}" alt="homepage" class="dark-logo" width="32px" height="32px" />
                        <!-- Light Logo text -->
                        <img src="{{ URL::to('storage/' . setting('logo')) }}" class="light-logo" alt="homepage" width="32px" height="32px" />
                    </span> --}}
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto mt-md-0">
                    <!-- This is  -->
                    <li class="nav-item"> <a
                            class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                            href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    <li class="nav-item m-l-10"> <a
                            class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"
                            href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    <!-- ============================================================== -->
                    <!-- Comment -->
                    <!-- ============================================================== -->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href=""
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                class="mdi mdi-message"></i>
                            <div class="notify"> <span class="heartbit"></span> <span
                                    class="point"></span> </div>
                        </a>
                        <div class="dropdown-menu mailbox animated slideInUp">
                            <ul>
                                <li>
                                    <div class="drop-title">Notifications</div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new
                                                    admin!</span> <span class="time">9:30 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Event today</h5> <span class="mail-desc">Just a reminder that you
                                                    have
                                                    event</span> <span class="time">9:10 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Settings</h5> <span class="mail-desc">You can customize this
                                                    template as
                                                    you want</span> <span class="time">9:08 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my
                                                    admin!</span>
                                                <span class="time">9:02 AM</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all
                                            notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Comment -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Messages -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                class="mdi mdi-email"></i>
                            <div class="notify"> <span class="heartbit"></span> <span
                                    class="point"></span> </div>
                        </a>
                        <div class="dropdown-menu mailbox animated slideInUp" aria-labelledby="2">
                            <ul>
                                <li>
                                    <div class="drop-title">You have 4 new messages</div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="user-img"> <img src="" alt="user" class="img-circle">
                                                <span class="profile-status online"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my
                                                    admin!</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="user-img"> <img src="" alt="user" class="img-circle">
                                                <span class="profile-status busy"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you
                                                    at</span> <span class="time">9:10 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="user-img"> <img src="" alt="user" class="img-circle">
                                                <span class="profile-status away"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span>
                                                <span class="time">9:08 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="user-img"> <img src="" alt="user" class="img-circle">
                                                <span class="profile-status offline"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my
                                                    admin!</span>
                                                <span class="time">9:02 AM</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all
                                            e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    <!-- ============================================================== -->
                    <!-- End Messages -->
                    <!-- ============================================================== -->
                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <ul class="navbar-nav my-lg-0">
                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->
                    {{-- <li class="nav-item hidden-sm-down search-box"> <a
                            class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i
                                class="ti-search"></i></a>
                        <form class="app-search">
                            <input type="text" class="form-control" placeholder="Search & enter"> <a
                                class="srh-btn"><i class="ti-close"></i></a>
                        </form>
                    </li> --}}
                    <!-- ============================================================== -->
                    <!-- Language -->
                    <!-- ============================================================== -->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                class="flag-icon flag-icon-us"></i></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i
                                    class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i
                                    class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i
                                    class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i
                                    class="flag-icon flag-icon-de"></i> Dutch</a> </div>
                    </li> --}}
                    <!-- ============================================================== -->
                    <!-- Profile -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                src="{{ Session::get('admin')['profile_pic'] }}" alt="user" class="profile-pic" /></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img"><img src="{{ Session::get('admin')['profile_pic'] }}"
                                                alt="user"></div>
                                        <div class="u-text">
                                            <h4>{{ Session::get('admin')['username'] }}</h4>
                                            <p class="text-muted">{{ Session::get('admin')['email'] }}</p><a
                                                href="{{ route('admin.profile') }}"
                                                class="btn btn-rounded btn-danger btn-sm">View
                                                Profile</a>
                                        </div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('admin.profile.list-user') }}"><i class="ti-user"></i> List
                                        User</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('admin.profile') }}"><i class="ti-settings"></i> Account
                                        Setting</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('admin.logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
@endsection
@section('sidebar')

    @php
    $navs = json_decode(
        json_encode([
            [
                'title' => 'Dashboard',
                'url' => URL::route('admin'),
                'icon' => 'fas fa-home',
                'submenu' => [],
            ],
            [
                'title' => 'Invoices',
                'url' => URL::route('admin.invoice.page'),
                'icon' => 'fas fa-file-invoice',
                'submenu' => [],
            ],
            [
                'title' => 'Banners',
                'url' => URL::route('admin.banner.page'),
                'icon' => 'fa fa-sliders',
                'submenu' => [],
            ],
            [
                'title' => 'Products',
                'url' => '#products',
                'icon' => 'fas fa-box',
                'submenu' => [
                    [
                        'title' => 'Add Product',
                        'url' => route('prod.add'),
                        'icon' => 'fas fa-plus',
                    ],
                    [
                        'title' => 'List Product',
                        'url' => route('a_product.list'),
                        'icon' => 'fas fa-list',
                    ],
                    [
                        'title' => 'Category',
                        'url' => route('prod.category'),
                        'icon' => 'fas fa-list',
                    ],
                ],
            ],
            [
                'title' => 'Data Products',
                'url' => '#dataproducts',
                'icon' => 'fas fa-database',
                'submenu' => [
                    [
                        'title' => 'Add Data',
                        'url' => route('page.add.data'),
                        'icon' => 'fas fa-plus',
                    ],
                    [
                        'title' => 'List Data',
                        'url' => route('page.data'),
                        'icon' => 'fas fa-list',
                    ],
                    [
                        'title' => 'List Voucher',
                        'url' => route('data.page.voucher'),
                        'icon' => 'fas fa-tag',
                    ],
                ],
            ],
            [
                'title' => 'Whatsapp Gateway',
                'url' => route('wa'),
                'icon' => 'fab fa-whatsapp',
                'submenu' => [],
            ],
            [
                'title' => 'Auto Order',
                'url' => '#autoorder',
                'icon' => 'fas fa-robot',
                'submenu' => [
                    [
                        'title' => 'Add Auto Order',
                        'url' => route('auto-order.add'),
                        'icon' => 'fas fa-plus',
                    ],
                    [
                        'title' => 'List Auto Order',
                        'url' => route('auto-order'),
                        'icon' => 'fas fa-list',
                    ],
                    // [
                    //     'title' => 'Mobile Legends',
                    //     'url' => route('auto.smile'),
                    //     'icon' => 'far fa-smile',
                    // ],
                    // [
                    //     'title' => 'Free Fire',
                    //     'url' => route('auto.kiosgamer'),
                    //     'icon' => 'fas fa-store',
                    // ],
                    // [
                    //     'title' => 'Call Of Duty Mobile',
                    //     'url' => route('auto.kiosgamercodm'),
                    //     'icon' => 'fas fa-store',
                    // ],
                    // [
                    //     'title' => 'Garena AOV - Arena Of Valor',
                    //     'url' => route('auto.kiosgameraov'),
                    //     'icon' => 'fas fa-store',
                    // ],
                ],
            ],
            [
                'title' => 'Payment Gateway',
                'url' => route('payment'),
                'icon' => 'fas fa-wallet',
                'submenu' => [],
            ],
            [
                'title' => 'Settings',
                'url' => URL::to('admin/settings'),
                'icon' => 'fas fa-cog',
                'submenu' => [],
            ],
        ]),
    );
    @endphp
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- User profile -->
            <div class="user-profile">
                <!-- User profile image -->
                <div class="profile-img"> <img src="{{ Session::get('admin')['profile_pic'] }}" alt="user" />
                    <!-- this is blinking heartbit-->
                    <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span>
                    </div>
                </div>
                <!-- User profile text-->
                <div class="profile-text">
                    <h5>{{ Session::get('admin')['username'] }}</h5>
                    <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                    <a href="{{ route('admin.profile.list-user') }}" class="" data-toggle=" tooltip"
                        title="Email"><i class="mdi mdi-face"></i></a>
                    <a href="{{ route('admin.logout') }}" class="" data-toggle=" tooltip" title="Logout"><i
                            class="mdi mdi-power"></i></a>
                    <div class="dropdown-menu animated flipInY">
                        <!-- text-->
                        <a href="{{ route('admin.profile.list-user') }}" class="dropdown-item"><i
                                class="ti-user"></i> List User</a>

                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="{{ route('admin.profile') }}" class="dropdown-item"><i class="ti-settings"></i>
                            Account Setting</a>
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="{{ route('admin.logout') }}" class="dropdown-item"><i class="fa fa-power-off"></i>
                            Logout</a>
                        <!-- text-->
                    </div>
                </div>
            </div>
            <!-- End User profile text-->
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-devider"></li>
                    <li class="nav-small-cap">Navigation</li>
                    @foreach ($navs as $nav)
                        <li>
                            <a @if (count($nav->submenu) > 0)
                                class="has-arrow waves-effect waves-dark"
                                aria-expanded="false"
                    @endif
                    href="{{ $nav->url }}">
                    <i class="{{ $nav->icon }}"></i> <span class="hide-menu">{{ $nav->title }}</span>
                    </a>
                    @if (count($nav->submenu) > 0)
                        <ul aria-expanded="false" class="collapse">
                            @foreach ($nav->submenu as $menu)
                                <li><a href="{{ $menu->url }}"><i class="{{ $menu->icon }}"></i>
                                        {{ $menu->title }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                    </li>
                    @endforeach
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
@endsection
@section('body')
    @yield('loader')
    <div id="main-wrapper">

        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @yield('head')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        @yield('sidebar')
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">@yield('title')</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                        {{-- <li class="breadcrumb-item">pages</li> --}}
                        <li class="breadcrumb-item active text-strong"><b>@yield('title')</b></li>
                    </ol>
                </div>
                <div>
                    <button
                        class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i
                            class="ti-settings text-white"></i></button>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                @yield('content')
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span>
                        </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a>
                                </li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a>
                                </li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a>
                                </li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2021 {{ setting('company_name') }} - {{ settings('app_name') }}
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

    </div>
@endsection
