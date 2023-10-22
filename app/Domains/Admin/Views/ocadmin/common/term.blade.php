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
        <button type="button" data-bs-toggle="tooltip" title="{{ $lang->button_filter }}" onclick="$('#filter-term').toggleClass('d-none');" class="btn btn-light d-md-none d-lg-none"><i class="fa-solid fa-filter"></i></button>
        <a id="button-add" href="{{ $add_url }}" data-bs-toggle="tooltip" title="{{ $lang->button_add }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
        <button type="submit" form="form-term" formaction="{{ $delete_url }}" data-bs-toggle="tooltip" title="{{ $lang->button_delete }}" onclick="return confirm('{{ $lang->text_confirm }}');" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></button>
      </div>
      <h1>{{ $lang->heading_title }}</h1>
      @include('ocadmin.common.breadcumb')
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div id="filter-term" class="col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3">
        <form>
          <div class="card">
            <div class="card-header"><i class="fa-solid fa-filter"></i> {{ $lang->text_filter }}</div>
            <div class="card-body">

              <div class="mb-3">
                <label class="form-label">{{ $lang->column_taxonomy }}</label>
                <input type="text" id="input-taxonomy_name" name="filter_taxonomy_name" value="{{ $filter_taxonomy_name ?? '' }}"  data-oc-target="autocomplete-taxonomy_name" class="form-control" autocomplete="on"/>
                <ul id="autocomplete-taxonomy_name" class="dropdown-menu"></ul>
              </div>

              <div class="mb-3">
                <label class="form-label">{{ $lang->column_code }}</label>
                <input type="text" id="input-code" name="filter_code" value="{{ $filter_code?? '' }}"  data-oc-target="autocomplete-name" class="form-control" autocomplete="off"/>
                <ul id="autocomplete-code" class="dropdown-menu"></ul>
              </div>

              <div class="mb-3">
                <label class="form-label">{{ $lang->column_name }}</label>
                <input type="text" id="input-name" name="filter_name" value="{{ $filter_name ?? '' }}"  data-oc-target="autocomplete-name" class="form-control" autocomplete="off"/>
                <ul id="autocomplete-name" class="dropdown-menu"></ul>
              </div>

              <div class="text-end">
                <button type="reset" id="button-clear" class="btn btn-light"><i class="fa fa-refresh" aria-hidden="true"></i> {{ $lang->button_reset }}</button>
                <button type="button" id="button-filter" class="btn btn-light"><i class="fa-solid fa-filter"></i> {{ $lang->button_filter }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="card">
          <div class="card-header"><i class="fa-solid fa-list"></i> {{ $lang->text_list }}</div>
          <div id="term" class="card-body">{!! $list !!}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('bottom')
<script type="text/javascript"><!--
$('#term').on('click', 'thead a, .pagination a', function(e) {
	e.preventDefault();

	$('#term').load(this.href);
});

$('#button-filter').on('click', function() {
	url = '?';

  var filter_taxonomy_name = $('#input-taxonomy_name').val();

  if (filter_taxonomy_name) {
    url += '&filter_taxonomy_name=' + encodeURIComponent(filter_taxonomy_name);
  }

  var filter_code = $('#input-code').val();

  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }

	var filter_name = $('#input-name').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

  var equal_is_active = $('#input-equal_is_active').val();

  if (equal_is_active) {
    url += '&equal_is_active=' + encodeURIComponent(equal_is_active);
  }

	list_url = "{{ $list_url }}" + url;

	$('#term').load(list_url);

  add_url = $("#button-add").attr("href") + url
  $("#button-add").attr("href", add_url);

});
//--></script>
@endsection