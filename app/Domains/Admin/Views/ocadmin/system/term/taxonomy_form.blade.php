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
        <button type="submit" form="form-taxonomy" data-bs-toggle="tooltip" title="儲存" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
            <li class="nav-item"><a href="#tab-trans" data-bs-toggle="tab" class="nav-link active">{{ $lang->tab_trans }}</a></li>
            <li class="nav-item"><a href="#tab-data" data-bs-toggle="tab" class="nav-link">{{ $lang->tab_data }}</a></li>
          </ul>
          <form id="form-taxonomy" action="{{ $save_url }}" method="post" data-oc-toggle="ajax">
            @csrf
            @method('POST')

            <div class="tab-content">
              <div id="tab-trans" class="tab-pane active" >
                <ul class="nav nav-tabs">
                  @foreach($supportedLocales as $locale => $localeContent)
                  <li class="nav-item"><a href="#language-{{ $locale }}" data-bs-toggle="tab" class="nav-link @if($loop->first) active @endif"> {{ $localeContent['native'] }}</a></li>
                  @endforeach
                </ul>
                <div class="tab-content">
                  @foreach($supportedLocales as $locale => $localeContent)
                  <div id="language-{{ $locale }}" class="tab-pane @if($loop->first) active @endif">

                    <div class="row mb-3 required">
                      <label for="input-name" class="col-sm-2 col-form-label">{{ $lang->column_name }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-name-{{ $locale }}" name="translations[{{ $locale }}][name]" value="{{ $translations[$locale]['name'] ?? '' }}" class="form-control">
                        <div id="error-name" class="invalid-feedback"></div>
                      </div>
                    </div>

                  </div>
                  @endforeach
                </div>
              </div>

              <div id="tab-data" class="tab-pane">

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">{{ $lang->column_code }}</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" id="input-code" name="code" value="{{ $taxonomy->code }}" placeholder="{{ $lang->column_code }}"  class="form-control" />
                    </div>
                    <div id="error-code" class="invalid-feedback"></div>
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">{{ $lang->column_enable }}</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div id="input-is_active" class="form-check form-switch form-switch-lg">
                        <input type="hidden" name="is_active" value="0"/>
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" @if($taxonomy->is_active) checked @endif/>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
              <input type="hidden" name="taxonomy_id" value="{{ $taxonomy_id }}" id="input-taxonomy_id"/>
            </div>
          </form>
          </div>
          </div>
        </div>
    </div>
</div>
@endsection

@section('bottom')
@endsection
