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
			<div class="float-end"><a href="{{ route('lang.admin.system.user.users.form') }}" data-bs-toggle="tooltip" title="{{ $lang->button_add }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
				<button type="submit" form="form-user" formaction="http://opencart4x.test/backend/index.php?route=user/user|delete&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" data-bs-toggle="tooltip" title="刪除" onclick="return confirm('確定嗎？');" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
			</div>
			<h1>{{ $lang->heading_title }}</h1>
			<ol class="breadcrumb">
				@foreach($breadcumbs as $breadcumb)
					<li class="breadcrumb-item"><a href="{{ $breadcumb->href }}">{{ $breadcumb->text }}</a></li>
				@endforeach
			</ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><i class="fas fa-list"></i> {{ $lang->text_list }}</div>
			<div id="user" class="card-body">{!! $list !!}</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$('#user').on('click', 'thead a, .pagination a', function(e) {
    e.preventDefault();

    $('#user').load(this.href);
});
//--></script>
@endsection