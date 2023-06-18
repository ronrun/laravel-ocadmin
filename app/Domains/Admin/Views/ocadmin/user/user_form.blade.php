@extends('ocadmin.app')

@section('pageJsCss')
@endsection

@section('columnLeft')
	@include('ocadmin.common.column_left')
@endsection

@section('content')
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-end">
        <button type="submit" form="form-customer" data-bs-toggle="tooltip" class="btn btn-primary" aria-label="Save" data-bs-original-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
        <a href="{{ $back_url }}" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fa-solid fa-reply"></i></a>
      </div>
      <h1>{{ $lang->heading_title }}</h1>
      @include('ocadmin.common.breadcumb')
    </div>
  </div>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><i class="fa-solid fa-pencil"></i> Add Customer</div>
      <div class="card-body">
        <form id="form-customer" action="{{ $save_url }}" method="post" data-oc-toggle="ajax">
          @csrf
          @method('PUT')
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a href="#tab-general" data-bs-toggle="tab" class="nav-link active" aria-selected="true" role="tab">General</a></li>
          </ul>
          <div class="tab-content">
            <div id="tab-general" class="tab-pane active show" role="tabpanel">
              <fieldset>
                <legend>User Details</legend>
                <div class="row mb-3 required">
                  <label for="input-email" class="col-sm-2 col-form-label">E-Mail</label>
                  <div class="col-sm-10">
                    <input type="text" name="email" value="{{ $user->email }}" placeholder="E-Mail" id="input-email" class="form-control">
                    <div id="error-email" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3 required">
                  <label for="input-display_name" class="col-sm-2 col-form-label">{{ $lang->column_display_name }}</label>
                  <div class="col-sm-10">
                    <input type="text" id="input-display_name" name="display_name" value="{{ $user->display_name }}" placeholder="Name" class="form-control">
                    <div id="error-display_name" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-mobile" class="col-sm-2 col-form-label">{{ $lang->column_mobile }}</label>
                  <div class="col-sm-10">
                    <input type="text" name="mobile" value="" placeholder="mobile" id="input-mobile" class="form-control">
                    <div id="error-mobile" class="invalid-feedback"></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Password</legend>
                <div class="row mb-3">
                  <label for="input-password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" autocomplete="new-password">
                    <div id="error-password" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-confirm" class="col-sm-2 col-form-label">Confirm</label>
                  <div class="col-sm-10">
                    <input type="password" name="confirm" value="" placeholder="Confirm" id="input-confirm" class="form-control">
                    <div id="error-confirm" class="invalid-feedback"></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Other</legend>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-10">
                    <div class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="status" value="0"> <input type="checkbox" name="status" value="1" id="input-status" class="form-check-input" checked="">
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
          <input type="hidden" id="input-user_id" name="user_id" value="{{ $user_id ?? '' }}">
        </form>
      </div>
    </div>
  </div>
</div>

@endsection