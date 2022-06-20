@extends('ocadmin._layouts.app')

@section('pageJsCss')
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link	href="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
	@include('ocadmin._partials.column_left')
@endsection

@section('content')
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-end">
				<button type="button" data-bs-toggle="tooltip" title="Filter" onclick="$('#filter-member').toggleClass('d-none');" class="btn btn-light d-md-none d-lg-none"><i class="fas fa-filter" style="font-size:18px"></i></button>
				<button type="button" data-bs-toggle="tooltip" title="Download" class="btn btn-light"><i class="fas fa-file-excel" style="font-size:18px"></i></button>
				<a href="{{ route('lang.admin.member.members.create') }}" data-bs-toggle="tooltip" title="Add New" class="btn btn-primary"><i class="fas fa-plus"></i></a>
				<?php /*<button type="submit" form="form-member" formaction="{{ route('lang.admin.member.members.massdelete') }}" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?');" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button> */ ?>
			</div>
			<h1>{{ $langs->heading_title }}</h1>
			<ol class="breadcrumb">
				@foreach($breadcumbs as $breadcumb)
					<li class="breadcrumb-item"><a href="{{ $breadcumb->href }}">{{ $breadcumb->text }}</a></li>
				@endforeach
			</ol>
		</div>
	</div>
  <div class="container-fluid">
    <div class="row">
      <div id="filter-member" class="col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3">
        <div class="card">
          <div class="card-header"><i class="fas fa-filter"></i> Filter</div>
		  <div class="card-body">
					<div class="mb-3">
						<label class="form-label">{{ $langs->entry_name }}</label>
						<input type="text" name="filter_name" value="" placeholder="{{ $langs->entry_name }}" id="input-name" list="list-name" class="form-control"/>
						<datalist id="list-name"></datalist>
					</div>
					<div class="mb-3">
						<label class="form-label">{{ $langs->entry_email }}</label>
						<input type="text" name="filter_email" value="" placeholder="{{ $langs->entry_email }}" id="input-email" list="list-email" class="form-control"/>
						<datalist id="list-email"></datalist>
					</div>
					<div class="mb-3">
						<label for="input-status" class="form-label">{{ $langs->entry_status }}</label> <select name="filter_status" id="input-status" class="form-select">
							<option value=""></option>
							<option value="1">Enabled</option>
							<option value="0" >Disabled</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="input-ip" class="form-label">{{ $langs->entry_ip }}</label>
						<input type="text" name="filter_ip" value="" placeholder="{{ $langs->entry_ip }}" id="input-ip" class="form-control"/>
					</div>
            <div class="text-end">
              <button type="button" id="button-filter" class="btn btn-light"><i class="fas fa-filter"></i> Filter</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="card">
          <div class="card-header"><i class="fas fa-list"></i> {{ $langs->text_list }}</div>
          <div id="member" class="card-body">{!! $list !!}</div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#member').on('click', 'thead a, .pagination a', function(e) {
    e.preventDefault();

    $('#member').load(this.href);
});

$('#button-filter').on('click', function() {
    url = '';

    var filter_name = $('#input-name').val();

    if (filter_name) {
        url += '&filter_name=' + encodeURIComponent(filter_name);
    }

    var filter_email = $('#input-email').val();

    if (filter_email) {
        url += '&filter_email=' + encodeURIComponent(filter_email);
    }
    <?php /*
    var filter_customer_group_id = $('#input-customer-group').val();

    if (filter_customer_group_id !== '') {
        url += '&filter_customer_group_id=' + filter_customer_group_id;
    }
    */ ?>

    var filter_status = $('#input-status').val();

    if (filter_status !== '') {
        url += '&filter_status=' + filter_status;
    }

    var filter_ip = $('#input-ip').val();

    if (filter_ip) {
        url += '&filter_ip=' + encodeURIComponent(filter_ip);
    }

    var filter_date_added = $('#input-date-added').val();

    if (filter_date_added) {
        url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
    }

	url = "{{ route('lang.admin.member.members.list') }}?" + url;

    $('#member').load(url);
});

$('#input-name').autocomplete({
    'source': function(request, response) {
        $.ajax({
            //url: 'index.php?route=customer/customer|autocomplete&user_token=5bb02794973e438e69f86e04c7730815&filter_name=' + encodeURIComponent(request),
			url: "{{ route('lang.admin.member.members.autocomplete') }}?filter_name=" + encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['name'],
                        value: item['member_id']
                    }
                }));
            }
        });
    },
    'select': function(item) {}
});

$('#input-email').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: "{{ route('lang.admin.member.members.autocomplete') }}?filter_email=" + encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['email'],
                        value: item['customer_id']
                    }
                }));
            }
        });
    },
    'select': function(item) {}
});
//--></script>
@endsection