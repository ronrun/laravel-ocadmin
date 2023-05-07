@extends('ocadmin.app')

@section('pageJsCss')
@endsection

@section('columnLeft')
	@include('ocadmin.common.column_left')
@endsection

@section('content')<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-end">
        <button type="submit" form="form-permission" data-bs-toggle="tooltip" class="btn btn-primary" aria-label="Save" data-bs-original-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
        <a href="{{ $back }}" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fa-solid fa-reply"></i></a>
      </div>
      <h1>{{ $lang->heading_title }}</h1>
      @include('ocadmin.common.breadcumb')
    </div>
  </div>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><i class="fa-solid fa-pencil"></i> {{ $lang->button_add }}</div>
      <div class="card-body">
        <form id="form-permission" action="{{ $save }}" method="post" data-oc-toggle="ajax">
          @csrf
          @method('PUT')
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a href="#tab-general" data-bs-toggle="tab" class="nav-link active" aria-selected="true" role="tab">General</a></li>
          </ul>
          <div class="tab-content">
            <div id="tab-general" class="tab-pane active show" role="tabpanel">
              <fieldset>
                <legend>Details</legend>
                <div class="row mb-3 required">
                  <label for="input-name" class="col-sm-2 col-form-label">{{ $lang->column_name }}</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" value="{{ $permission->name }}" id="input-name" class="form-control">
                    <div id="error-name" class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="input-description" class="col-sm-2 col-form-label">{{ $lang->column_description }}</label>
                  <div class="col-sm-10">
                    <input type="text" id="input-description" name="description" value="{{ $permission->description }}" class="form-control">
                    <div id="error-description" class="invalid-feedback"></div>
                  </div>
                </div>
              </fieldset>
            </div>

          </div>
          <input type="hidden" name="permission_id" value="{{ $permission_id }}" id="input-permission_id"/>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection