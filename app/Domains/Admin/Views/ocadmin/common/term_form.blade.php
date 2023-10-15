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
        <button type="submit" form="form-term" data-bs-toggle="tooltip" class="btn btn-primary" aria-label="Save" data-bs-original-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
        <a href="{{ $back_url }}" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fa-solid fa-reply"></i></a>
      </div>
      <h1>{{ $lang->heading_title }}</h1>
      @include('ocadmin.common.breadcumb')
    </div>
  </div>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><i class="fa-solid fa-pencil"></i> {{ $lang->button_add }}</div>
      <div class="card-body">
        <form id="form-term" action="{{ $save_url }}" method="post" data-oc-toggle="ajax">
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
                  <input type="hidden" name="translations[{{ $locale }}][id]" value="{{ !empty($translations->$locale) ? $translations->$locale->id : '' }}" >

                  <div id="language-{{ $locale }}" class="tab-pane @if($loop->first) active @endif">
                    <div class="row mb-3 required">
                      <label for="input-name" class="col-sm-2 col-form-label">{{ $lang->column_name }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-name-{{ $locale }}" name="translations[{{ $locale }}][name]" value="{{ !empty($translations->$locale) ? $translations->$locale->name : '' }}" class="form-control">
                        <div id="error-name-{{ $locale }}" class="invalid-feedback"></div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input-slug" class="col-sm-2 col-form-label">{{ $lang->column_slug }}</label>
                      <div class="col-sm-10">
                        <input type="text" id="input-slug-{{ $locale }}" name="translations[{{ $locale }}][slug]" value="{{ !empty($translations->$locale) ? $translations->$locale->slug : '' }}" class="form-control">
                        <div id="error-slug-{{ $locale }}" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>

            </div>

            <div id="tab-data" class="tab-pane">

              <div class="row mb-3">
                <label for="input-code" class="col-sm-2 col-form-label">{{ $lang->column_code }}</label>
                <div class="col-sm-10">
                  <input type="text" id="input-code" name="code" value="{{ $term->code }}" placeholder="code (not necesarry)" class="form-control">
                  <div id="error-code" class="invalid-feedback"></div>
                </div>
              </div>

              <div class="row mb-3">
                <label for="input-taxonomy_code" class="col-sm-2 col-form-label">{{ $lang->column_taxonomy_code }}</label>
                <div class="col-sm-10">
                  <input type="text" id="input-taxonomy_code" name="taxonomy_code" value="{{ $term->taxonomy_code }}" placeholder="code (not necesarry)" class="form-control">
                  <div id="error-taxonomy_code" class="invalid-feedback"></div>
                </div>
              </div>

              <div class="row mb-3">
                <label for="input-parent_name" class="col-sm-2 col-form-label">{{ $lang->column_parent_name }}</label>
                <div class="col-sm-10">
                  <input type="text" id="input-parent_name" name="parent_name" value="{{ $term->parent_name }}" placeholder="autocomplete" class="form-control">
                  <div id="error-parent_id" class="invalid-feedback"></div>
                  <input type="hidden" id="input-parent_id" name="parent_id" value="{{ $term->parent_id }}" class="form-control">

                </div>
              </div>

              <div class="row mb-3">
                <label for="input-sort_order" class="col-sm-2 col-form-label">{{ $lang->column_sort_order }}</label>
                <div class="col-sm-10">
                  <input type="text" id="input-sort_order" name="sort_order" value="{{ $term->sort_order }}" placeholder="code (not necesarry)" class="form-control">
                  <div id="error-sort_order" class="invalid-feedback"></div>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">{{ $lang->column_is_active }}</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <div id="input-is_active" class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="is_active" value="0"/>
                      <input type="checkbox" name="is_active" value="1" class="form-check-input" @if($term->is_active) checked @endif/>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <input type="hidden" name="term_id" value="{{ $term_id }}" id="input-term_id"/>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection