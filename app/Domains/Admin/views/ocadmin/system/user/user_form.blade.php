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
				<button type="submit" form="form-user" data-bs-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fas fa-save"></i></button>
				<a href="{{ url()->previous() }}" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fas fa-reply"></i></a></div>
			<h1>Users</h1>
			<ol class="breadcrumb">
							</ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><i class="fas fa-pencil-alt"></i> Edit User</div>
			<div class="card-body">
				<form id="form-user" action="{{ $save }}" method="post" data-oc-toggle="ajax">
					@csrf
					@method('PUT')
					<div class="row mb-3 required">
						<label for="input-username" class="col-sm-2 col-form-label">{{ $lang->entry_username }}</label>
						<div class="col-sm-10">
							<input type="text" name="username" value="{{ $user->username }}" placeholder="{{ $lang->entry_username }}" id="input-username" class="form-control"/>
							<div id="error-username" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3">
						<label for="input-user-group" class="col-sm-2 col-form-label">{{ $lang->entry_user_group }}</label>
						<div class="col-sm-10">
							<select name="user_group_id" id="input-user-group" class="form-select">
																	<option value="1" selected>Administrator</option>
																	<option value="2">Demonstration</option>
															</select>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-name" class="col-sm-2 col-form-label">{{ $lang->entry_name }}</label>
						<div class="col-sm-10">
							<input type="text" name="name" value="{{ $user->name }}" placeholder="{{ $lang->entry_name }}" id="input-name" class="form-control"/>
							<div id="error-name" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-email" class="col-sm-2 col-form-label">{{ $lang->entry_email }}</label>
						<div class="col-sm-10">
							<input type="text" name="email" value="{{ $user->email }}" placeholder="{{ $lang->entry_email }}" id="input-email" class="form-control"/>
							<div id="error-email" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-password" class="col-sm-2 col-form-label">{{ $lang->entry_password }}</label>
						<div class="col-sm-10">
							<input type="password" name="password" value="" placeholder="{{ $lang->entry_password }}" id="input-password" class="form-control" autocomplete="new-password"/>
							<div id="error-password" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-confirm" class="col-sm-2 col-form-label">{{ $lang->entry_confirm }}</label>
						<div class="col-sm-10">
							<input type="password" name="confirm" value="" placeholder="{{ $lang->entry_confirm }}" id="input-confirm" class="form-control"/>
							<div id="error-confirm" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-10">
							<div class="form-check form-switch form-switch-lg">
								<input type="checkbox" name="status" value="{{ $user->ststus }}" id="input-status" class="form-check-input" checked/>
							</div>
						</div>
					</div>
					<input type="hidden" name="user_id" value="{{ $user_id }}" id="input-user-id"/>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection