@extends('ocadmin._layouts.app')

@section('pageJsCss')
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link	href="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
	@include('ocadmin._partials.column_left')
@endsection

@section('content')
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-end">
        <button type="submit" form="form-user" data-bs-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fas fa-save"></i></button>
        <a href="153c12deb2c87f8b7adf" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fas fa-reply"></i></a></div>
      <h1>Users</h1>
      <ol class="breadcrumb">
              </ol>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><i class="fas fa-pencil-alt"></i> Edit User</div>
      <div class="card-body">
        <form id="form-user" action="xxx" method="post" data-oc-toggle="ajax">
          <div class="row mb-3 required">
            <label for="input-username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input type="text" name="username" value="admin" placeholder="Username" id="input-username" class="form-control"/>
              <div id="error-username" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="input-user-group" class="col-sm-2 col-form-label">User Group</label>
            <div class="col-sm-10">
              <select name="user_group_id" id="input-user-group" class="form-select">
                                  <option value="1" selected>Administrator</option>
                                  <option value="2">Demonstration</option>
                              </select>
            </div>
          </div>
          <div class="row mb-3 required">
            <label for="input-firstname" class="col-sm-2 col-form-label">First Name</label>
            <div class="col-sm-10">
              <input type="text" name="firstname" value="John" placeholder="First Name" id="input-firstname" class="form-control"/>
              <div id="error-firstname" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="row mb-3 required">
            <label for="input-lastname" class="col-sm-2 col-form-label">Last Name</label>
            <div class="col-sm-10">
              <input type="text" name="lastname" value="Doe" placeholder="Last Name" id="input-lastname" class="form-control"/>
              <div id="error-lastname" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="row mb-3 required">
            <label for="input-email" class="col-sm-2 col-form-label">E-Mail</label>
            <div class="col-sm-10">
              <input type="text" name="email" value="arhatron@gmail.com" placeholder="E-Mail" id="input-email" class="form-control"/>
              <div id="error-email" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="input-image" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
              <div class="card image">
                <img src="http://opencart4x.test/image/cache/no_image-100x100.png" alt="" title="" id="thumb-image" data-oc-placeholder="http://opencart4x.test/image/cache/no_image-100x100.png" class="card-img-top"/> <input type="hidden" name="image" value="" id="input-image"/>
                <div class="card-body">
                  <button type="button" data-oc-toggle="image" data-oc-target="#input-image" data-oc-thumb="#thumb-image" class="btn btn-primary btn-sm btn-block"><i class="fas fa-pencil-alt"></i> Edit</button>
                  <button type="button" data-oc-toggle="clear" data-oc-target="#input-image" data-oc-thumb="#thumb-image" class="btn btn-warning btn-sm btn-block"><i class="fas fa-trash-alt"></i> Clear</button>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-3 required">
            <label for="input-password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" autocomplete="new-password"/>
              <div id="error-password" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="row mb-3 required">
            <label for="input-confirm" class="col-sm-2 col-form-label">Confirm</label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="" placeholder="Confirm" id="input-confirm" class="form-control"/>
              <div id="error-confirm" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="input-status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-select">
                <option value="1" selected>Enabled</option>
                <option value="0">Disabled</option>
              </select>
            </div>
          </div>
          <input type="hidden" name="user_id" value="1" id="input-user-id"/>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection