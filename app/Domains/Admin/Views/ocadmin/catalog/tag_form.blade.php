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
        <button type="submit" form="form-tag" data-bs-toggle="tooltip" class="btn btn-primary" aria-label="Save" data-bs-original-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
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
        <form id="form-tag" action="{{ $save }}" method="post" data-oc-toggle="ajax">
          @csrf
          @method('POST')
          <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a href="#tab-general" data-bs-toggle="tab" class="nav-link active">{{ $lang->tab_general }}</a></li>
          <li class="nav-item"><a href="#tab-data" data-bs-toggle="tab" class="nav-link">{{ $lang->tab_data }}</a></li>
          </ul>
          <div class="tab-content">
            <div id="tab-general" class="tab-pane active show" role="tabpanel">

              <ul class="nav nav-tabs">
                @foreach($supportedLocales as $locale => $localeContent)
                  <li class="nav-item"><a href="#language-{{ $locale }}" data-bs-toggle="tab" class="nav-link @if($loop->first) active @endif"> {{ $localeContent['native'] }}</a></li>
                @endforeach
              </ul>
              <div class="tab-content">
                @foreach($supportedLocales as $locale => $localeContent)
                  <input type="hidden" name="tag_translations[{{ $locale }}][id]" value="{{ !empty($tag_translations->$locale) ? $tag_translations->$locale->id : '' }}" >

                  <div id="language-{{ $locale }}" class="tab-pane @if($loop->first) active @endif">
                    <div class="row mb-3 required">
                      <label for="input-name" class="col-sm-2 col-form-label">{{ $lang->column_name }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-name-{{ $locale }}" name="tag_translations[{{ $locale }}][name]" value="{{ !empty($tag_translations->$locale) ? $tag_translations->$locale->name : '' }}" class="form-control">
                        <div id="error-name" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3 required">
                      <label for="input-slug" class="col-sm-2 col-form-label">{{ $lang->column_slug }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-slug-{{ $locale }}" name="tag_translations[{{ $locale }}][slug]" value="{{ !empty($tag_translations->$locale) ? $tag_translations->$locale->slug : '' }}" class="form-control">
                        <div id="error-slug" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>

            </div>

            <div id="tab-data" class="tab-pane">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">{{ $lang->column_is_active }}</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <div id="input-is_active" class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="is_active" value="0"/>
                      <input type="checkbox" name="is_active" value="1" class="form-check-input" @if($tag->is_active) checked @endif/>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <input type="hidden" name="tag_id" value="{{ $tag_id }}" id="input-tag_id"/>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection