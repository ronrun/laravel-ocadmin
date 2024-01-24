@extends('admin._layouts.app')

@section('pageJsCss')
@endsection

@section('content')
<div id="content">
  <div class="container-fluid">
    <br/>
    <br/>
    <div class="row justify-content-sm-center">
      <div class="col-sm-10 col-md-8 col-lg-5">
        <div class="card">
          <div class="card-header"><i class="fa-solid fa-lock"></i> Please enter your login details.</div>
          <div class="card-body">
            <form id="form-login" action="{{ route('lang.admin.login') }}" method="post">
              @csrf
              @if($errors->has('password'))                   
              <div class="alert alert-danger alert-dismissible"><i class="fas fa-exclamation-circle"></i> {{ $errors->first('password') }}</div>
              @endif

              @if(session()->has('error_warning'))
              <div class="alert alert-danger alert-dismissible"><i class="fas fa-exclamation-circle"></i> {{ session('error_warning') }}</div>
              @endif
              <div class="mb-3">
                <label for="input-email" class="form-label">Email</label>
                <div class="input-group">
                  <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                  <input type="text" name="email" value="" placeholder="email" id="input-email" class="form-control"/>
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
@endsection

@section('buttom')
@endsection