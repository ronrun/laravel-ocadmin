<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>Dashboard</title>
        <base href="{{ $base }}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- 全站通用套件 --}} <?php /** {{ asset('xxx') }} */ ?>
        <link  href="{{ asset('oc-asset/stylesheet/bootstrap.css') }}" rel="stylesheet" media="screen"/>
        <link  href="{{ asset('oc-asset/stylesheet/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css"/>
        <link  href="{{ asset('oc-asset/stylesheet/stylesheet.css') }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('oc-asset/javascript/jquery/jquery-3.6.0.min.js') }}" type="text/javascript"></script>

        {{-- 頁面套件 --}}
        @yield('pageJsCss')

        {{-- 全站opencart預設 --}}
        <script type="text/javascript" src="{{ asset('oc-asset/javascript/common.js') }}"></script>

        {{-- 自訂 --}}
        @yield('customJsCss')
    </head> 
    <body>
        <div id="container">
            <div id="alert" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
            <header id="header" class="navbar navbar-expand navbar-light bg-light">
                <div class="container-fluid">
                    <a href="{{ route('lang.admin.dashboard') }}" class="navbar-brand d-none d-lg-block"><img src="{{ asset('oc-asset/image/logo.png') }}" alt="OpenCart" title="OpenCart"/></a>
                    @if (Auth::guard('admin')->check())
                    <button type="button" id="button-menu" class="btn btn-link d-inline-block d-lg-none"><i class="fas fa-bars"></i></button>
                    <ul class="nav navbar-nav">
                        <li id="header-notification" class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle"><i class="far fa-bell"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <span class="dropdown-item text-center">No results!</span>
                            </div>
                        </li>
                        <li id="header-profile" class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle"><img src="{{ asset('oc-asset/image/profile.png') }}" alt="LaravelOcadmin" title="admin" class="rounded-circle"/><span class="d-none d-md-inline d-lg-inline">&nbsp;&nbsp;&nbsp;Ron Lee <i class="fas fa-caret-down fa-fw"></i></span></a>
                            <ul class="dropdown-menu drofpdown-menu-right">
                                <li><a href="http://opencart4x.test/backend/index.php?route=user/profile&amp;user_token=a04539592e4472b5201c41a7e23a6e75" class="dropdown-item"><i class="fa fa-user-circle fa-fw"></i> Your Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <h6 class="dropdown-header">Stores</h6>
                                </li>
                                <a href="http://opencart4x.test/" target="_blank" class="dropdown-item">Your Store</a>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <h6 class="dropdown-header">Help</h6>
                                </li>
                                <li><a href="https://www.opencart.com" target="_blank" class="dropdown-item"><i class="fab fa-opencart fa-fw"></i> OpenCart Homepage</a></li>
                                <li><a href="http://docs.opencart.com" target="_blank" class="dropdown-item"><i class="fas fa-file-alt fa-fw"></i> Documentation</a></li>
                                <li><a href="http://forum.opencart.com" target="_blank" class="dropdown-item"><i class="fas fa-comments fa-fw"></i> Support Forum</a></li>
                            </ul>
                        </li>
                        <li id="header-logout" class="nav-item">
                        <?php /* <a href="{{ route('lang.admin.logout') }}" class="nav-link"><i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">Logout</span></a> */ ?>
                        <a href="{{ route('lang.admin.logout') }}" class="nav-link" 
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">{{ __('Logout') }}</span></a> 
                            <form id="logout-form" action="{{ route('lang.admin.logout') }}" method="POST" class="d-none">
                                                     @csrf
                                                </form>
                        
                        </li>
                    </ul>
@endif

                </div>
            </header>
            @yield('sidebar')

            @yield('content')
            
            <footer id="footer"><a href="https://www.opencart.com">Ron Lee</a> &copy; 2009-2022 All Rights Reserved.<br />Version 1.9.4.1</footer>
        </div>
        <script src="{{ asset('oc-asset/javascript/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        @yield('buttom')
    </body>
</html>