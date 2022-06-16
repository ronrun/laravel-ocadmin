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
			<div class="float-end"><a href="http://opencart4x.test/backend/index.php?route=user/user|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" data-bs-toggle="tooltip" title="新增" class="btn btn-primary"><i class="fas fa-plus"></i></a>
				<button type="submit" form="form-user" formaction="http://opencart4x.test/backend/index.php?route=user/user|delete&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" data-bs-toggle="tooltip" title="刪除" onclick="return confirm('確定嗎？');" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
			</div>
			<h1>管理員管理</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="http://opencart4x.test/backend/index.php?route=common/dashboard&amp;user_token=9d6eeccf87f512a5b1c5431281d43541">首頁</a></li>
				<li class="breadcrumb-item"><a href="http://opencart4x.test/backend/index.php?route=user/user&amp;user_token=9d6eeccf87f512a5b1c5431281d43541">管理員管理</a></li>
			</ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><i class="fas fa-list"></i> 管理員帳號清單</div>
			<?php /*<div id="user" class="card-body"><form id="form-user" method="post" data-oc-toggle="ajax" data-oc-load="http://opencart4x.test/backend/index.php?route=user/user|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" data-oc-target="#user">*/?>
				<div id="user" class="card-body"><form id="form-user" method="post">
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', $(this).prop('checked'));" class="form-check-input"/></td>
					<td class="text-start"><a href="" class="asc">管理員帳號</a></td>
					<td class="text-start"><a href="">狀態</a></td>
					<td class="text-start"><a href="">新增日期</a></td>
					<td class="text-end">管理</td>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $row)	
			<tr>
				<td class="text-center"><input type="checkbox" name="selected[]" value="1" class="form-check-input"/></td>
				<td class="text-start">{{ $row->username }}</td>
				<td class="text-start">{{ $row->is_active }}</td>
				<td class="text-start">{{ $row->created_at }}</td>
				<td class="text-end"><a href="{{ $row->url_edit }}" data-bs-toggle="tooltip" title="編輯" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
			</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{{-- $users->withQueryString()->links() --}}
	{{-- $users->links('ocadmin.pagination.default', ['users'=>$users]) --}}
	{{ $users->links('ocadmin.pagination.default', ['users'=>$users]) }}
	
</form></div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--

//--></script>
@endsection