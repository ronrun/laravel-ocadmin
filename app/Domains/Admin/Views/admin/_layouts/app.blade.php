<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>{{ config('app.name') }}</title>
  <base href="{{ $base }}"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link  href="{{ asset('/assets-admin/ocadmin/view4024/stylesheet/bootstrap.css') }}" rel="stylesheet" media="screen"/>
  <link  href="{{ asset('/assets-admin/ocadmin/view4024/stylesheet/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css"/>
  <link  href="{{ asset('/assets-admin/ocadmin/view4024/stylesheet/stylesheet.css') }}" rel="stylesheet" type="text/css"/>
  <script src="{{ asset('/assets-admin/ocadmin/view4024/javascript/jquery/jquery-3.7.1.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/assets-admin/ocadmin/view4024/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/assets-admin/ocadmin/view4024/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/assets-admin/ocadmin/view4024/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript"></script>
  <link  href="{{ asset('/assets-admin/ocadmin/view4024/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
  <script src="{{ asset('/assets-admin/ocadmin/view4024/javascript/common.js') }}" type="text/javascript"></script>
</head>

<body>
<div id="container">
  <div id="alert" class="toast-container position-fixed top-0 end-0 p-3"></div>
  <header id="header" class="navbar navbar-expand navbar-light bg-light">
    <div class="container-fluid">
      <a href="javascript:void(0)" class="navbar-brand d-none d-lg-block"><img src="{{ asset('assets-admin/image/logo.png') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}"/></a>
      @if (Auth::check())
        <button type="button" id="button-menu" class="btn btn-link d-inline-block d-lg-none"><i class="fa-solid fa-bars"></i></button>
        <ul class="nav navbar-nav">
          <li id="nav-notification" class="nav-item dropdown">
            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle"><i class="fa-regular fa-bell"></i></a>
            <div class="dropdown-menu dropdown-menu-end">
              <span class="dropdown-item text-center">No results!</span>
            </div>
          </li>
          <li id="nav-language" class="nav-item dropdown">
            <a href="en-gb" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><img src="{{ asset('assets-admin/image/icon.ico') }}" alt="English" title="English"/></a>
            <ul class="dropdown-menu">
              <li><a href="en-gb" class="dropdown-item"><img src="{{ asset('assets-admin/image/icon.ico') }}" alt="English" title="English"/> English</a></li>
            </ul>
            <input type="hidden" name="redirect" value="http://dboemlaravel.test/admin/index.php?route=common/dashboard&amp;user_token=4c90b9e922ee3c23f21f07d551dc9d15" id="input-redirect"/>
            <script type="text/javascript"><!--
              $('#nav-language .dropdown-item').on('click', function (e) {
                  e.preventDefault();
              
                  var element = this;
              
                  $.ajax({
                      url: 'index.php?route=common/language.save&user_token=4c90b9e922ee3c23f21f07d551dc9d15',
                      type: 'post',
                      data: 'code=' + $(element).attr('href') + '&redirect=' + encodeURIComponent($('#input-redirect').val()),
                      dataType: 'json',
                      success: function (json) {
                          console.log($(element).attr('href'));
                          console.log($('input-redirect').val());
              
                          if (json['redirect']) {
                              location = json['redirect'];
                          }
              
                          if (json['error']) {
                              $('#alert').prepend('<div class="alert alert-danger alert-dismissible"><i class="fa-solid fa-circle-exclamation"></i> ' + json['error'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                          }
                      },
                      error: function (xhr, ajaxOptions, thrownError) {
                          console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                      }
                  });
              });
              //-->
            </script>
          </li>
          <li id="nav-profile" class="nav-item dropdown">
            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle"><img src="{{ asset('/assets-admin/ocadmin/view4024/image/profile.png') }}" alt="{{ $auth_user->name ?? '' }}" title="{{ $auth_user->name ?? '' }}" class="rounded-circle"/><span class="d-none d-md-inline d-lg-inline">&nbsp;&nbsp;&nbsp;{{ $auth_user->name ?? '' }} <i class="fa-solid fa-caret-down fa-fw"></i></span></a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a href="http://dboemlaravel.test/admin/index.php?route=user/profile&amp;user_token=4c90b9e922ee3c23f21f07d551dc9d15" class="dropdown-item"><i class="fa-solid fa-user-circle fa-fw"></i> Your Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <h6 class="dropdown-header">Stores</h6>
              </li>
              <a href="http://dboemlaravel.test/" target="_blank" class="dropdown-item">Your Store</a>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <h6 class="dropdown-header">Help</h6>
              </li>
              <li><a href="https://www.opencart.com" target="_blank" class="dropdown-item"><i class="fa-brands fa-opencart fa-fw"></i> OpenCart Homepage</a></li>
              <li><a href="http://docs.opencart.com" target="_blank" class="dropdown-item"><i class="fa-solid fa-file fa-fw"></i> Documentation</a></li>
              <li><a href="https://forum.opencart.com" target="_blank" class="dropdown-item"><i class="fa-solid fa-comments fa-fw"></i> Support Forum</a></li>
            </ul>
          </li>
          <li id="nav-logout" class="nav-item">
            <a class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="cursor:pointer;">
            <i class="fa-solid fa-sign-out"></i> <span class="d-none d-md-inline">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('lang.admin.logout') }}" method="POST" class="d-none">@csrf</form>
          </li>
        </ul>
      @endif

    </div>
  </header>
  @yield('columnLeft')

  @yield('content')


<footer id="footer"><a href="https://www.dboem.com">{{ config('app.name') }}</a> &copy; 2009-2024 All Rights Reserved.<br/>Version 1.0.0.0</footer></div>
<script src="{{ asset('/assets-admin/ocadmin/view4024/javascript/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
@yield('buttom')

</body></html>
