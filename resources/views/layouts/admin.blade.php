<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>Админ-панель</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/plugins/c3-master/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Changing the theme colors from here -->
    <link href="{{ asset('css/colors/blue.css') }}" id="theme" rel="stylesheet">
    @yield('style')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('js\vue.js') }}"></script>
    <script src="{{ asset('js\vue-resource.js') }}"></script>
</head>

<body class="fix-header fix-sidebar card-no-border">
<!-- Preloader - styles in spinners.css -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- Main wrapper - styles in pages.scss -->
<div id="main-wrapper">
    <!-- Topbar header - styles in pages.scss -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
            <!-- Logo -->
            <div class="navbar-header">
            </div>
            <!-- End Logo -->
            <div class="navbar-collapse">
                <!-- toggle and nav items -->
                <ul class="navbar-nav mr-auto mt-md-0">
                    <!-- This is  -->
                    <li class="nav-item">
                        <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                           href="javascript:void(0)">
                            <i class="mdi mdi-menu"></i>
                        </a>
                    </li>
                    <!-- Search -->
                    <li class="nav-item hidden-sm-down search-box">
                        <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)">
                            <i class="ti-search"></i>
                        </a>
                        <form class="app-search">
                            <input type="text" class="form-control" placeholder="Search & enter">
                            <a class="srh-btn">
                                <i class="ti-close"></i>
                            </a>
                        </form>
                    </li>
                </ul>
                <!-- User profile and search -->
                <ul class="navbar-nav my-lg-0">
                    <!-- Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('assets/images/users/1.jpg') }}" alt="user" class="profile-pic m-r-10"/>Markarn
                            Doe
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- End Topbar header -->

    <!-- Left Sidebar - styles in sidebar.scss  -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li><a class="waves-effect waves-dark" href="{{url('/admin')}}" aria-expanded="false"><i
                                    class="mdi mdi-gauge"></i><span class="hide-menu">Главная</span></a>
                    </li>
                    <li><a class="waves-effect waves-dark" href="{{url('/item')}}" aria-expanded="false"><i
                                    class="mdi mdi-account-check"></i><span class="hide-menu">Товары</span></a>
                    </li>
                    <li><a class="waves-effect waves-dark" href="{{url('/item/new-item')}}" aria-expanded="false"><i
                                    class="mdi mdi-plus"></i><span class="hide-menu">Новый товар</span></a>
                    </li>
                    <li><a class="waves-effect waves-dark" href="{{url('/category')}}" aria-expanded="false"><i
                                    class="mdi mdi-window-restore"></i><span class="hide-menu">Категории</span></a>
                    </li>
                    <li><a class="waves-effect waves-dark" href="{{url('/brand')}}" aria-expanded="false"><i
                                    class="mdi mdi-heart-outline"></i><span class="hide-menu">Бренды</span></a></li>
                    <li><a class="waves-effect waves-dark" href="{{url('/colour')}}" aria-expanded="false"><i
                                    class="mdi mdi-yin-yang"></i><span class="hide-menu">Цвета</span></a></li>
                    <li><a class="waves-effect waves-dark" href="{{url('/fluffiness')}}" aria-expanded="false"><i
                                    class="mdi mdi-leaf"></i><span class="hide-menu">Классы пышности</span></a></li>
                    <li><a class="waves-effect waves-dark" href="{{url('/size')}}" aria-expanded="false"><i
                                    class="mdi mdi-tag-text-outline"></i><span class="hide-menu">Размеры</span></a></li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
        <!-- Bottom points-->
        <div class="sidebar-footer">
            <a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
            <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
            <a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a></div>
        <!-- End Bottom points-->
    </aside>
    <!-- End Left Sidebar - styles in sidebar.scss  -->

    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Bread crumb and right sidebar toggle -->
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            <!-- Start Page Content -->
        @yield('content')
        <!-- End PAge Content -->
        </div>

        <!-- footer -->
        <footer class="footer"> © 2017 Моя Доня</footer>
        <!-- End footer -->
    </div>
    <!-- End Page wrapper  -->
</div>
<!-- End Wrapper -->


<!-- All Jquery -->

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/plugins/bootstrap/js/tether.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<!--stickey kit -->
<script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('js/custom.min.js') }}"></script>

<!-- This page plugins -->
<!--c3 JavaScript -->
<script src="{{ asset('assets/plugins/d3/d3.min.js') }}"></script>
<script src="{{ asset('assets/plugins/c3-master/c3.min.js') }}"></script>
@yield('script')
</body>

</html>
