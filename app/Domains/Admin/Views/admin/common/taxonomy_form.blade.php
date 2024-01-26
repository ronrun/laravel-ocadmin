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
        <button type="submit" form="form-taxonomy" data-bs-toggle="tooltip" title="{{ $lang->save }}" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
              <li class="nav-item"><a href="#tab-data" data-bs-toggle="tab" class="nav-link active">{{ $lang->tab_data }}</a></li>
              <!--<li class="nav-item"><a href="#tab-address" data-bs-toggle="tab" class="nav-link">{{ $lang->tab_address }}</a></li>-->
          </ul>
          <form id="form-taxonomy" action="{{ $save_url }}" method="post" data-oc-toggle="ajax">
            @csrf
            @method('POST')
            <div class="tab-content">
              <div id="tab-data" class="tab-pane active">

                  <fieldset>
                    <legend>{{ $lang->tab_data }}</legend>

                    <div class="row mb-3 required">
                      <label for="input-code" class="col-sm-2 col-form-label">{{ $lang->column_code }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-code" name="code" value="{{ $taxonomy->code }}" class="form-control"/>
                        <div id="error-code" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3 required">
                      <label class="col-sm-2 col-form-label">{{ $lang->column_name }}</label>
                      <div class="col-sm-10">
                        @foreach($languages as $language)
                          <div class="input-group">
                            <div class="input-group-text">{{ $language->name }} {{ $language->native_name }}</div>
                            <input type="text" id="input-name-{{ $language->locale }}" name="translations[{{ $language->locale }}][name]" value="{{ $translations[$language->locale]->name ?? '' }}" class="form-control"/>
                          </div>
                          <div id="error-name-{{ $language->locale }}" class="invalid-feedback"></div>
                        @endforeach
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-comment" class="col-sm-2 col-form-label">{{ $lang->column_comment }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-comment" name="comment" value="{{ $taxonomy->comment }}" class="form-control"/>
                        <div id="error-comment" class="invalid-feedback"></div>
                      </div>
                    </div>
                    
                    <legend>異動時間</legend>
                    <div class="row mb-3">
                      <label for="input-updated_date" class="col-sm-2 col-form-label">{{ $lang->column_updated_time}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $taxonomy->updated_at }}" class="form-control" disabled/>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-created_date" class="col-sm-2 col-form-label">{{ $lang->column_created_time}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $taxonomy->created_at }}" class="form-control" disabled/>
                      </div>
                    </div>
                                  </fieldset>

                  <input type="hidden" name="taxonomy_id" value="{{ $taxonomy_id }}" id="input-taxonomy_id"/>
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
