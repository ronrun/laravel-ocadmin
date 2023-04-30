<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Administration</title>
  <base href="{{ $base }}"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <link href="{{ asset('assets/backend/ocadmin/stylesheet/bootstrap.css') }}" rel="stylesheet" media="screen"/>
  <link href="{{ asset('assets/backend/ocadmin/stylesheet/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('assets/backend/ocadmin/stylesheet/stylesheet.css') }}" rel="stylesheet" type="text/css"/>
  <script src="{{ asset('assets/backend/ocadmin/javascript/jquery/jquery-3.6.1.min.js') }}" type="text/javascript"></script>
  <script type="text/javascript" src="{{ asset('assets/backend/ocadmin/javascript/jquery/datetimepicker/moment.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/backend/ocadmin/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/backend/ocadmin/javascript/jquery/datetimepicker/daterangepicker.js') }}"></script>
  <link type="text/css" href="{{ asset('assets/backend/ocadmin/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" />
  <script type="text/javascript" src="{{ asset('assets/backend/ocadmin/javascript/common.js') }}"></script>
</head>
<body>
<div id="container">
  <div id="alert" class="toast-container position-fixed top-0 end-0 p-3"></div>
  <header id="header" class="navbar navbar-expand navbar-light bg-light">
    <div class="container-fluid">
      <a href="{{ route('admin.login') }}" class="navbar-brand d-none d-lg-block"><img src="{{ asset('assets/backend/ocadmin/image/logo.png') }}" alt="OpenCart" title="OpenCart"/></a>
          </div>
  </header>

<div id="content">
  <div class="container-fluid">
    <br/>
    <br/>
    <div class="row justify-content-sm-center">
      <div class="col-sm-10 col-md-8 col-lg-5">
        <div class="card">
          <div class="card-header"><i class="fa-solid fa-lock"></i> Please enter your login details.</div>
          <div class="card-body">
            <form id="form-login" action="{{ route('admin.login') }}" method="post" data-oc-toggle="ajax">
              @csrf
                                          <div class="mb-3">
                <label for="input-email" class="form-label">Username</label>
                <div class="input-group">
                  <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                  <input type="text" name="email" value="" placeholder="Username or email" id="input-email" class="form-control"/>
                </div>
              </div>
              <div class="mb-3">
                <label for="input-password" class="form-label">Password</label>
                <div class="input-group mb-2">
                  <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                  <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control"/>
                </div>
                <div class="mb-3"><a href="http://laravel.test/backend/index.php?route=common/forgotten">Forgotten Password</a></div>
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-key"></i> Login</button>
              </div>
                          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<footer id="footer"><a href="https://www.opencart.com">OpenCart</a> &copy; 2009-2023 All Rights Reserved.<br/></footer></div>
<script src="{{ asset('assets/backend/ocadmin/javascript/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
</body></html>

