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
				<form id="form-user" action="{{ $form_action }}" method="post" data-oc-toggle="ajax">
					{{ csrf_field() }}
					{{ method_field($form_method) }}
					<div class="row mb-3 required">
						<label for="input-username" class="col-sm-2 col-form-label">{{ $langs->entry_username }}</label>
						<div class="col-sm-10">
							<input type="text" name="username" value="{{ $user->username }}" placeholder="{{ $langs->entry_username }}" id="input-username" class="form-control"/>
							<div id="error-username" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3">
						<label for="input-user-group" class="col-sm-2 col-form-label">{{ $langs->entry_user_group }}</label>
						<div class="col-sm-10">
							<select name="user_group_id" id="input-user-group" class="form-select">
																	<option value="1" selected>Administrator</option>
																	<option value="2">Demonstration</option>
															</select>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-name" class="col-sm-2 col-form-label">{{ $langs->entry_name }}</label>
						<div class="col-sm-10">
							<input type="text" name="name" value="John" placeholder="{{ $langs->entry_name }}" id="input-name" class="form-control"/>
							<div id="error-name" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-email" class="col-sm-2 col-form-label">{{ $langs->entry_email }}</label>
						<div class="col-sm-10">
							<input type="text" name="email" value="arhatron@gmail.com" placeholder="{{ $langs->entry_email }}" id="input-email" class="form-control"/>
							<div id="error-email" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-password" class="col-sm-2 col-form-label">{{ $langs->entry_password }}</label>
						<div class="col-sm-10">
							<input type="password" name="password" value="" placeholder="{{ $langs->entry_password }}" id="input-password" class="form-control" autocomplete="new-password"/>
							<div id="error-password" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3 required">
						<label for="input-confirm" class="col-sm-2 col-form-label">{{ $langs->entry_confirm }}</label>
						<div class="col-sm-10">
							<input type="password" name="confirm" value="" placeholder="{{ $langs->entry_confirm }}" id="input-confirm" class="form-control"/>
							<div id="error-confirm" class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row mb-3">
						<label for="input-status" class="col-sm-2 col-form-label">{{ $langs->entry_status }}</label>
						<div class="col-sm-10">
							<select name="status" id="input-status" class="form-select">
								<option value="1"@if($user->status) selected @endif>{{ $langs->text_enabled }}</option>
								<option value="0"@if(!$user->status) selected @endif>{{ $langs->text_disabled }}</option>
							</select>
						</div>
					</div>
					<input type="hidden" name="user_id" value="1" id="input-user-id"/>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection