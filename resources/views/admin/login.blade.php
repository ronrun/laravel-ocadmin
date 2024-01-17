<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Administration</title>
  <base href="http://opencart.test/ocadmin/"/>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <link href="view/stylesheet/bootstrap.css" rel="stylesheet" media="screen"/>
  <link href="view/stylesheet/fonts/fontawesome/css/all.min.css" rel="stylesheet" type="text/css"/>
  <link href="view/stylesheet/stylesheet.css" rel="stylesheet" type="text/css"/>
  <script src="view/javascript/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="view/javascript/jquery/datetimepicker/moment.min.js"></script>
  <script type="text/javascript" src="view/javascript/jquery/datetimepicker/moment-with-locales.min.js"></script>
  <script type="text/javascript" src="view/javascript/jquery/datetimepicker/daterangepicker.js"></script>
  <link href="view/javascript/jquery/datetimepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
  <script type="text/javascript" src="view/javascript/common.js"></script>
      </head>
<body>
<div id="container">
  <div id="alert" class="toast-container position-fixed top-0 end-0 p-3"></div>
  <header id="header" class="navbar navbar-expand navbar-light bg-light">
    <div class="container-fluid">
      <a href="http://opencart.test/ocadmin/index.php?route=common/login" class="navbar-brand d-none d-lg-block"><img src="view/image/logo.png" alt="OpenCart" title="OpenCart"/></a>
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
            <form id="form-login" action="http://opencart.test/ocadmin/index.php?route=common/login.login&login_token=15ba5cb17682a1084cec82da75456696" method="post" data-oc-toggle="ajax">
                                          <div class="mb-3">
                <label for="input-username" class="form-label">Username</label>
                <div class="input-group">
                  <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                  <input type="text" name="username" value="" placeholder="Username" id="input-username" class="form-control"/>
                </div>
              </div>
              <div class="mb-3">
                <label for="input-password" class="form-label">Password</label>
                <div class="input-group mb-2">
                  <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                  <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control"/>
                </div>
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
<footer id="footer"><a href="https://www.opencart.com">OpenCart</a> &copy; 2009-2024 All Rights Reserved.<br/></footer></div>
<script src="view/javascript/bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
</body></html>

