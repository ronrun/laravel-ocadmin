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
				<a href="javascript:void(0)" data-bs-toggle="tooltip" title="Orders" class="btn btn-warning"><i class="fas fa-receipt"></i></a>
				<button type="submit" form="form-member" data-bs-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fas fa-save"></i></button>

				<a href="{{ $back }}" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fas fa-reply"></i></a>
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
            <div class="card-header"><i class="fas fa-pencil-alt"></i> {{ $lang->text_form }}</div>
            <div class="card-body">

                <ul class="nav nav-tabs">
                    <li class="nav-item"><a href="#tab-general" data-bs-toggle="tab" class="nav-link active">{{ $lang->tab_general }}</a></li>
                    <li class="nav-item"><a href="#tab-ip" data-bs-toggle="tab" class="nav-link">{{ $lang->tab_ip }}</a></li>
                </ul>
                <div class="tab-content">
					<div id="tab-general" class="tab-pane active">
                    <form id="form-member" action="{{ $save }}" method="post">
							@csrf
							@method('PUT')
							<fieldset>
								<legend>Member Details</legend>
								<div class="row mb-3">
									<label for="input-member-group" class="col-sm-2 col-form-label">{{ $lang->entry_member_group }}</label>
									<div class="col-sm-10">
										<select name="member_group_id" id="input-member-group" class="form-select">
																							<option value="1" selected>Default</option>
																					</select>
									</div>
								</div>
								<div class="row mb-3 required">
									<label for="input-firstname" class="col-sm-2 col-form-label">{{ $lang->entry_firstname }}</label>
									<div class="col-sm-10">
										<input type="text" name="firstname" value="{{ $member->firstname }}" placeholder="First Name" id="input-firstname" class="form-control"/>
										<div id="error-firstname" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3 required">
									<label for="input-lastname" class="col-sm-2 col-form-label">{{ $lang->entry_lastname }}</label>
									<div class="col-sm-10">
										<input type="text" name="lastname" value="{{ $member->lastname }}" placeholder="Last Name" id="input-lastname" class="form-control"/>
										<div id="error-lastname" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3">
									<label for="input-name" class="col-sm-2 col-form-label">{{ $lang->entry_name }}</label>
									<div class="col-sm-10">
										<input type="text" name="name" value="{{ $member->name }}" placeholder="Name" id="input-name" class="form-control"/>
										<div id="error-name" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3 required">
									<label for="input-email" class="col-sm-2 col-form-label">{{ $lang->entry_email }}</label>
									<div class="col-sm-10">
										<input type="text" name="email" value="{{ $member->email }}" placeholder="E-Mail" id="input-email" class="form-control"/>
										<div id="error-email" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3">
								{{-- <div class="row mb-3{% if config_telephone_required %} required{% endif %}"> --}}
									<label for="input-telephone" class="col-sm-2 col-form-label">{{ $lang->entry_telephone }}</label>
									<div class="col-sm-10">
										<input type="text" name="telephone" value="{{ $member->telephone }}" placeholder="{{ $lang->entry_telephone }}" id="input-telephone" class="form-control"/>
										<div id="error-telephone" class="invalid-feedback"></div>
									</div>
								</div>
															</fieldset>
							<fieldset>
								<legend>{{ $lang->entry_password }}</legend>
								<div class="row mb-3">
									<label for="input-password" class="col-sm-2 col-form-label">{{ $lang->entry_password }}</label>
									<div class="col-sm-10">
										<input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" autocomplete="new-password"/>
										<div id="error-password" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3 required">
									<label for="input-confirm" class="col-sm-2 col-form-label">{{ $lang->entry_confirm }}</label>
									<div class="col-sm-10">
										<input type="password" name="confirm" value="" placeholder="Confirm" id="input-confirm" class="form-control"/>
										<div id="error-confirm" class="invalid-feedback"></div>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend>Other</legend>
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label">Newsletter</label>
									<div class="col-sm-10">
										<div class="form-check form-switch form-switch-lg">
											<input type="checkbox" name="newsletter" value="1" id="input-newsletter" class="form-check-input"/>
										</div>
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label">Status</label>
									<div class="col-sm-10">
										<div class="form-check form-switch form-switch-lg">
											<input type="checkbox" name="status" value="{{ $member->ststus }}" id="input-status" class="form-check-input" checked/>
										</div>
									</div>
								</div>
                                <?php /*
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label">Safe</label>
									<div class="col-sm-10">
										<div class="form-check form-switch form-switch-lg">
											<input type="checkbox" name="safe" value="1" id="input-safe" class="form-check-input"/>
										</div>
										<div class="form-text">Set to true to avoid this member from being caught by the anti-fraud system</div>
									</div>
								</div>
                                */?>
							</fieldset>

							<input type="hidden" name="member_id" value="{{ $member_id }}" id="input-member-id"/>
						</form>
					</div>


                    <div id="tab-ip" class="tab-pane">
                        <fieldset>
                            <legend>IP</legend>
                            <div id="ip">{!! $ip !!}</div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
//$('#form-member, #form-address').on('submit', function (e) {
$('#form-member').submit(function( e ) {
    e.preventDefault();

    $.ajax({
        url: '{{ $save }}',
        type: 'post',
        data: $('#form-member, #form-address').serialize(),
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        beforeSend: function () {
            $('#button-member').prop('disabled', true).addClass('loading');
        },
        complete: function () {
            $('#button-member').prop('disabled', false).removeClass('loading');
        },
        success: function (json) {
            $('.alert-dismissible').remove();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').removeClass('d-block');

            if (json['error']) {
                if (json['error']['warning']) {
                    $('#alert').prepend('<div class="alert alert-danger alert-dismissible"><i class="fas fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                }

                for (key in json['error']) {
                    $('#input-' + key.replaceAll('_', '-')).addClass('is-invalid').find('.form-control, .form-select, .form-check-input, .form-check-label').addClass('is-invalid');
                    $('#error-' + key.replaceAll('_', '-')).html(json['error'][key]).addClass('d-block');
                }
            }

            if (json['success']) {
                $('#alert').prepend('<div class="alert alert-success alert-dismissible"><i class="fas fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');

                // Replace any form values that correspond to form names.
                for (key in json) {
                    $('#form-member, #form-address').find('[name=\'' + key + '\']').val(json[key]);
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
$('#ip').on('click', '.pagination a', function (e) {
        e.preventDefault();

        $('#ip').load(this.href);
});
//--></script>
@endsection