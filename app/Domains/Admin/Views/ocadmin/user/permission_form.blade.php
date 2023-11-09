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
          {{-- <a href="javascript:void(0)" data-bs-toggle="tooltip" title="Orders" class="btn btn-warning"><i class="fas fa-receipt"></i></a> --}}
        {{-- <button type="submit" form="form-permission" data-bs-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fas fa-save"></i></button> --}}
        <button type="submit" form="form-permission" data-bs-toggle="tooltip" title="儲存" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="{{ $back_url }}" data-bs-toggle="tooltip" title="{{ $lang->button_back }}" class="btn btn-light"><i class="fas fa-reply"></i></a>
      </div>
      <h1>{{ $lang->heading_title }}</h1>
      @include('ocadmin.common.breadcumb')
    </div>
  </div>
    <div class="container-fluid">
      <div class="card">
        <div class="card-header"><i class="fas fa-pencil-alt"></i> {{ $lang->text_form }}</div>
        <div class="card-body">
          <ul class="nav nav-tabs">
            <li class="nav-item"><a href="#tab-data" data-bs-toggle="tab" class="nav-link active">{{ $lang->tab_data }}</a></li>
          </ul>
          <form id="form-permission" action="{{ $save_url }}" method="post" data-oc-toggle="ajax">
            @csrf
            @method('POST')

            <div class="tab-content">

              <div id="tab-data" class="tab-pane active" >

                <input type="hidden" id="input-guard_name" name="guard_name" value="{{ $permission->guard_name ?? 'web'}}" class="form-control">


                <div class="row mb-3 required">
                  <label class="col-sm-2 col-form-label">{{ $lang->column_name }}</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" id="input-name" name="name" value="{{ $permission->name ?? ''}}" class="form-control" />
                    </div>
                    <div class="form-text"></div>
                    <div id="error-name" class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">{{ $lang->column_description }}</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" id="input-description" name="description" value="{{ $permission->description ?? ''}}" class="form-control" />
                    </div>
                    <div class="form-text"></div>
                    <div id="error-description" class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">{{ $lang->column_enable }}</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div id="input-is_active" class="form-check form-switch form-switch-lg">
                        <input type="hidden" name="is_active" value="0"/>
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" @if($permission->is_active) checked @endif/>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <input type="hidden" id="input-permission_id" name="permission_id" value="{{ $permission_id }}"/>
            </div>
          </form>
          </div>
          </div>
        </div>
    </div>
</div>
@endsection

@section('bottom')
<script type="text/javascript">
</script>
@endsection
