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
        <button type="button" data-bs-toggle="tooltip" title="Filter" onclick="$('#filter-taxonomy').toggleClass('d-none');" class="btn btn-light d-md-none d-lg-none"><i class="fas fa-filter" style="font-size:18px"></i></button>
        <a href="{{ $add_url}}" data-bs-toggle="tooltip" title="{{ $lang->button_add }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
        <button type="submit" form="form-taxonomy" formaction="{{ $delete_url }}" data-bs-toggle="tooltip" title="{{ $lang->button_delete }}" onclick="return confirm('{{ $lang->text_confirm }}');" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></button>
      </div>
      <h1>{{ $lang->heading_title }}</h1>
      @include('ocadmin.common.breadcumb')
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div id="filter-taxonomy" class="col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3">
        <form id="filter-form">
          <div class="card">
            <div class="card-header"><i class="fas fa-filter"></i> {{ $lang->button_filter }}</div>
            <div class="card-body">

              <div class="mb-3">
                <label class="form-label">{{ $lang->column_code }}</label>
                <input type="text" id="input-filter_code" name="filter_code" value="" placeholder="{{ $lang->column_code }}" class="form-control"/>
              </div>

              <div class="mb-3">
                <label class="form-label">{{ $lang->column_name }}</label>
                <input type="text" id="input-filter_name" name="filter_name" value="" placeholder="{{ $lang->column_name }}" class="form-control"/>
                <datalist id="list-name"></datalist>
              </div>

              <div class="mb-3">
                <label class="form-label">{{ $lang->column_is_active }}</label>
                <select id="input-equal_is_active" name="equal_is_active" class="form-select">
                <option value="*">{{ $lang->text_select }}</option>
                  <option value="1" selected>{{ $lang->text_yes }}</option>
                  <option value="0">{{ $lang->text_no }}</option>
                </select>
              </div>

              <div class="text-end">
                <button type="reset" id="button-clear" class="btn btn-light"><i class="fa fa-refresh" aria-hidden="true"></i> {{ $lang->button_reset }}</button>
                <button type="button" id="button-filter" class="btn btn-light"><i class="fas fa-filter"></i> {{ $lang->button_filter }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="card">
          <div class="card-header"><i class="fas fa-list"></i> {{ $lang->text_list }}</div>
          <div id="taxonomy" class="card-body">{!! $list !!}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('bottom')
<script type="text/javascript">
$('#taxonomy').on('click', 'thead a, .pagination a', function(e) {
    e.preventDefault();

    $('#taxonomy').load(this.href);
});

$('#button-filter').on('click', function() {
  url = '';

  var filter_code = $('#input-filter_code').val();

  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }

  var filter_name = $('#input-filter_name').val();

  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var equal_is_active = $('#input-equal_is_active').val();

  if (equal_is_active) {
    url += '&equal_is_active=' + encodeURIComponent(equal_is_active);
  }

    url = "{{ $list_url }}?" + url;

    $('#taxonomy').load(url);
});
</script>
@endsection