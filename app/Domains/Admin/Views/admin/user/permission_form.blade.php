@extends('admin._layouts.app')

@section('pageJsCss')
@endsection

@section('columnLeft')
  @include('admin._layouts.column_left')
@endsection

@section('content')
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-end">
          {{-- <a href="javascript:void(0)" data-bs-toggle="tooltip" title="Orders" class="btn btn-warning"><i class="fas fa-receipt"></i></a> --}}
        {{-- <button type="submit" form="form-permission" data-bs-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fas fa-save"></i></button> --}}
        <button type="submit" form="form-permission" data-bs-toggle="tooltip" title="{{ $lang->save }}" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="{{ $back_url }}" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fas fa-reply"></i></a>
      </div>
      <h1>{{ $lang->heading_title }}</h1>
      @include('admin._layouts.breadcumb')
    </div>
  </div>
    <div class="container-fluid">
      <div class="card">
        <div class="card-header"><i class="fas fa-pencil-alt"></i> {{ $lang->text_form }}</div>
        <div class="card-body">
          <ul class="nav nav-tabs">
              <li class="nav-item"><a href="#tab-general" data-bs-toggle="tab" class="nav-link active">{{ $lang->tab_general }}</a></li>
              <!--<li class="nav-item"><a href="#tab-address" data-bs-toggle="tab" class="nav-link">{{ $lang->tab_address }}</a></li>-->
          </ul>
          <form id="form-permission" action="{{ $save_url }}" method="post" data-oc-toggle="ajax">
            @csrf
            @method('POST')
            <div class="tab-content">
              <div id="tab-general" class="tab-pane active">

                  <fieldset>
                    <legend>{{ $lang->trans('text_permission_details') }}</legend>

                    <div class="row mb-3 required">
                      <label for="input-permissionname" class="col-sm-2 col-form-label">{{ $lang->column_permissionname }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-permissionname" name="permissionname" value="{{ $permission->permissionname }}" class="form-control"/>
                        <div id="error-permissionname" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-email" class="col-sm-2 col-form-label">{{ $lang->column_email }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-email" name="email" value="{{ $permission->email }}" class="form-control"/>
                        <div id="error-email" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3 required">
                      <label for="input-name" class="col-sm-2 col-form-label">{{ $lang->column_name }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-name" name="name" value="{{ $permission->name }}" class="form-control"/>
                        <div id="error-name" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-mobile" class="col-sm-2 col-form-label">{{ $lang->column_mobile }}</label>
                      <div class="col-sm-10">
                        <input type="text" name="mobile" value="{{ $permission->mobile }}" id="input-mobile" class="form-control"/>
                        <div id="error-mobile" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-telephone" class="col-sm-2 col-form-label">{{ $lang->column_telephone }}</label>
                      <div class="col-sm-10">
                        <input type="text" name="telephone" value="{{ $permission->telephone }}" id="input-telephone" class="form-control"/>
                        <div id="error-telephone" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-is_admin" class="col-sm-2 col-form-label">{{ $lang->column_is_admin }}</label>
                      <div class="col-sm-10">
                        <div class="form-check form-switch form-switch-lg">
                          <input type="hidden" name="is_admin" value="0"/>
                          <input type="checkbox" id="input-is_admin" name="is_admin" value="1" class="form-check-input" @if($permission->is_admin) checked @endif/>
                        </div>
                      </div>
                    </div>
                    
                    <legend>密碼</legend>
                    <div class="row mb-3">
                      <label for="input-payment_company" class="col-sm-2 col-form-label">{{ $lang->column_password }}</label>
                      <div class="col-sm-10">
                        <input type="text" name="password" value="" id="input-password" class="form-control"/>
                        <div id="error-password" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-password_confirmation" class="col-sm-2 col-form-label">{{ $lang->column_password_confirm }}</label>
                      <div class="col-sm-10">
                        <input type="text" name="password_confirmation" value="{{ $permission->password_confirmation }}" id="input-password_confirmation" class="form-control"/>
                        <div id="error-password_confirmation" class="invalid-feedback"></div>
                      </div>
                    </div>
                    
                    <legend>異動時間</legend>
                    <div class="row mb-3">
                      <label for="input-updated_date" class="col-sm-2 col-form-label">{{ $lang->column_updated_time}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $permission->updated_at }}" class="form-control" disabled/>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-created_date" class="col-sm-2 col-form-label">{{ $lang->column_created_time}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $permission->created_at }}" class="form-control" disabled/>
                      </div>
                    </div>
                                  </fieldset>

                  <input type="hidden" name="permission_id" value="{{ $permission_id }}" id="input-permission_id"/>
              </div>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('buttom')
<script type="text/javascript">

</script>
@endsection
