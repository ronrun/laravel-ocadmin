@extends('ocadmin.app')

@section('pageJsCss')
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link	href="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
	@include('ocadmin.common.column_left')
@endsection

@section('content')
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-end">
				<button type="button" data-bs-toggle="tooltip" title="Filter" onclick="$('#filter-member').toggleClass('d-none');" class="btn btn-light d-md-none d-lg-none"><i class="fas fa-filter" style="font-size:18px"></i></button>
				<button type="button" data-bs-toggle="tooltip" title="Export" class="btn btn-light" data-bs-original-title="Edit" aria-label="Edit" id="button-export"><i class="fa fa-file-export" style="font-size:20px"></i></button>
				<a href="{{ route('lang.admin.member.members.form') }}" data-bs-toggle="tooltip" title="Add New" class="btn btn-primary"><i class="fas fa-plus"></i></a>
				<?php /*<button type="submit" form="form-member" formaction="{{ route('lang.admin.member.members.massdelete') }}" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?');" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button> */ ?>
			</div>
			<h1>{{ $lang->heading_title }}</h1>
			<ol class="breadcrumb">
				@foreach($breadcumbs as $breadcumb)
					@if(!empty($breadcumb->href))
					<li class="breadcrumb-item"><a href="{{ $breadcumb->href }}">{{ $breadcumb->text }}</a></li>
					@else
					<li class="breadcrumb-item"><a href="#" οnclick="return false">{{ $breadcumb->text }}</a></li>
					@endif
				@endforeach
			</ol>
		</div>
	</div>
  <div class="container-fluid">
	<div class="row">
	  <div id="filter-member" class="col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3">
		<form id="filter-form">
		<div class="card">
		  <div class="card-header"><i class="fas fa-filter"></i> Filter</div>
		  <div class="card-body">
					<div class="mb-3">
						<label class="form-label">{{ $lang->entry_name }}</label>
						<input type="text" name="filter_name" value="" placeholder="{{ $lang->entry_name }}" id="input-name" list="list-name" class="form-control"/>
						<datalist id="list-name"></datalist>
					</div>
					<div class="mb-3">
						<label class="form-label">{{ $lang->entry_mobile }}</label>
						<input type="text" name="filter_mobile" value="" placeholder="{{ $lang->entry_mobile }}" id="input-mobile" list="list-mobile" class="form-control"/>
						<datalist id="list-mobile"></datalist>
					</div>
					<div class="mb-3">
						<label class="form-label">{{ $lang->entry_email }}</label>
						<input type="text" name="filter_email" value="" placeholder="{{ $lang->entry_email }}" id="input-email" list="list-email" class="form-control"/>
						<datalist id="list-email"></datalist>
					</div>
			<div class="text-end">
			  <button type="button" id="button-filter" class="btn btn-light"><i class="fas fa-filter"></i> Filter</button>
			</div>
		  </div>
		</div>
		</form>
	  </div>
	  <div class="col-lg-9 col-md-12">
		<div class="card">
		  <div class="card-header"><i class="fas fa-list"></i> {{ $lang->text_list }}</div>
		  <div id="member" class="card-body">{!! $list !!}</div>
		</div>
	  </div>
	</div>
  </div>
</div>

<!-- 下載 excel 彈出視窗 -->
<div id="modal-option" class="modal fade">
	<form id="excel-form">
		@csrf
		@method('post')
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fas fa-file-excel"></i> Export</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label for="input-format" class="form-label">Format</label>
						<select name="format" id="input-excel-format" class="form-select">
							<option value="xlsx" selected="selected">xlsx</option>
							<option value="csv">csv</option>
							<?php /*
							<option value="csv">csv</option>
							<option value="pdf">pdf</option>
							*/ ?>
						</select>
					</div>
					<div class="mb-3">
						<label for="input-template" class="form-label">Template</label>
						<select name="template" id="input-template" class="form-select">
							<option value="">{{ $lang->text_none }}</option>
							<option value="BasicTableLaravelExcel">Basic Table with freeze panes, memory maybe not enough.</option>
						</select>
					</div>
					<div class="modal-footer">
						<div class="loadingdiv" id="loading" style="display: none;">
							<img src="{{ asset('media/ajax-loader.gif') }}" width="50"/>     
						</div>
						<button type="button" id="button-export-save" class="btn btn-primary">Save</button>
						<button type="button" id="button-export-cancel" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
					</div>


				</div>
			</div>
		</div>
	</form>
</div>
@endsection

@section('buttom')
<script type="text/javascript"><!--
//Export: Show window
$('#button-export').on('click', function () {
	$('#modal-option').modal('show');
	
});


//Export: Download
$('#button-export-save').on('click', function () {
	//var dataString = $('#excel-form').serialize();
	var dataString = $('form').serialize();
	var ext = $('#input-excel-format').val();

    $.ajax
    ({
        type: "POST",
        url: "{{ route('lang.admin.member.members.index') }}",
        data: dataString,
        cache: false,
        xhrFields:{
            responseType: 'blob'
        },
		beforeSend: function () {
			console.log('beforeSend');
            $('#loading').css("display", "");
            $('#button-export-save').attr("disabled", true);
		},
        success: function(data)
        {
			console.log('success');
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(data);
			link.download = 'members.' + ext;

            link.click();
			$('#modal-option').modal('hide');
        },
		complete: function () {
			console.log('complete');
			$('#loading').css("display", "none");
            $('#button-export-save').attr("disabled", false);
		},
        fail: function(data) {
			console.log('fail');
            alert('Not downloaded');
        }
    });
});


$('#button-export-cancel').on('click', function () {
	$('#loading').css("display", "none");
	$('#button-export-save').attr("disabled", false);
});

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

	var filter_mobile = $('#input-mobile').val();

	if (filter_mobile) {
		url += '&filter_mobile=' + encodeURIComponent(filter_mobile);
	}

	var filter_email = $('#input-email').val();

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	/*
	var filter_status = $('#input-status').val();

	if (filter_status) {
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
	*/

	url = "{{ route('lang.admin.member.members.list') }}?" + url;

	$('#member').load(url);
});

/* 考量效能，先不使用
$('#input-full_name').autocomplete({
	'source': function(request, response) {
		$.ajax({
			//url: 'index.php?route=customer/customer|autocomplete&user_token=5bb02794973e438e69f86e04c7730815&filter_name=' + encodeURIComponent(request),
			url: "{{ route('lang.admin.member.members.autocomplete') }}?filter_full_name=" + encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['full_name'],
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
*/
//--></script>
@endsection