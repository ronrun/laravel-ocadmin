@extends('ocadmin.app')

@section('pageJsCss')
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link	href="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
	@include('ocadmin.common.column_left')
@endsection

@section('content')
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-end">
			    {{-- <a href="javascript:void(0)" data-bs-toggle="tooltip" title="Orders" class="btn btn-warning"><i class="fas fa-receipt"></i></a> --}}
				{{-- <button type="submit" form="form-member" data-bs-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fas fa-save"></i></button> --}}
				<button type="submit" form="form-member" data-bs-toggle="tooltip" title="儲存" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                    <li class="nav-item"><a href="#tab-address" data-bs-toggle="tab" class="nav-link">{{ $lang->tab_address }}</a></li>
                </ul>
                <div class="tab-content">
					<div id="tab-general" class="tab-pane active">
                    	<form id="form-member" action="{{ $save }}" method="post">
							@csrf
							@method('PUT')
							<fieldset>
								<legend>Member Details</legend>
								<div class="row mb-3">
									<label for="input-name" class="col-sm-2 col-form-label">{{ $lang->entry_name }}</label>
									<div class="col-sm-10">
										<input type="text" name="name" value="{{ $member->name }}" placeholder="Name" id="input-name" class="form-control" disabled/>
										<div id="error-name" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3 required">
									<label for="input-last_name" class="col-sm-2 col-form-label">{{ $lang->entry_last_name }}</label>
									<div class="col-sm-10">
										<input type="text" name="last_name" value="{{ $member->last_name }}" placeholder="Last Name" id="input-last_name" class="form-control"/>
										<div id="error-last_name" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3 required">
									<label for="input-first_name" class="col-sm-2 col-form-label">{{ $lang->entry_first_name }}</label>
									<div class="col-sm-10">
										<input type="text" name="first_name" value="{{ $member->first_name }}" placeholder="First Name" id="input-first_name" class="form-control"/>
										<div id="error-first_name" class="invalid-feedback"></div>
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
								{{-- <div class="row mb-3{% if config_mobile_required %} required{% endif %}"> --}}
									<label for="input-mobile" class="col-sm-2 col-form-label">{{ $lang->entry_mobile }}</label>
									<div class="col-sm-10">
										<input type="text" name="mobile" value="{{ $member->mobile }}" placeholder="{{ $lang->entry_mobile }}" id="input-telephone" class="form-control"/>
										<div id="error-mobile" class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row mb-3 required">
									<label for="input-create_date" class="col-sm-2 col-form-label">{{ $lang->entry_create_date}}</label>
									<div class="col-sm-10">
										<input type="text" name="create_date" value="{{ $member->create_date }}" placeholder="E-Mail" id="input-create_date" class="form-control"/>
										<div id="error-create_date" class="invalid-feedback"></div>
									</div>
								</div>
															</fieldset>

							<input type="hidden" name="member_id" value="{{ $member_id }}" id="input-member-id"/>
						</form>
					</div>
					<div id="tab-address" class="tab-pane">

			  <?php $address_row = 0; ?>
			  @foreach($addresses as $address)
                <fieldset id="address-row-{{ $address_row }}">
                  <legend>{{ $lang->text_address }} {{ address_row + 1 }} <button type="button" onclick="$('#address-row-{{ $address_row }}').remove();" data-bs-toggle="tooltip" title="{{ $lang->button_remove }}" class="btn btn-danger btn-sm float-end"><i class="fa-solid fa-minus-circle"></i></button></legend>



                  <div class="row mb-3">
                    <label for="input-address-{{ $address_row }}-default" class="col-sm-2 col-form-label">{{ $lang->entry_default }}</label>
                    <div class="col-sm-10">
                      <div class="form-check">
                        <input type="radio" name="address[{{ $address_row }}][default]" value="1" id="input-address-{{ $address_row }}-default" class="form-check-input"{% if address.default %} checked{% endif %}/>
                      </div>
                    </div>
                  </div>
				  
                  <div class="row mb-3 required">
                    <label for="input-address-{{ $address_row }}-first_name" class="col-sm-2 col-form-label">{{ $lang->entry_first_name }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="address[{{ $address_row }}][first_name]" value="{{ address.first_name }}" placeholder="{{ $lang->entry_first_name }}" id="input-address-{{ $address_row }}-first_name" class="form-control"/>
                      <div id="error-address-{{ $address_row }}-first_name" class="invalid-feedback"></div>
                    </div>
                  </div>

                  <div class="row mb-3 required">
                    <label for="input-address-{{ $address_row }}-lastname" class="col-sm-2 col-form-label">{{ $lang->entry_last_name }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="address[{{ $address_row }}][lastname]" value="{{ address.lastname }}" placeholder="{{ $lang->entry_last_name }}" id="input-address-{{ $address_row }}-lastname" class="form-control"/>
                      <div id="error-address-{{ $address_row }}-lastname" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="input-address-{{ $address_row }}-company" class="col-sm-2 col-form-label">{{ $lang->entry_company }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="address[{{ $address_row }}][company]" value="{{ address.company }}" placeholder="{{ $lang->entry_company }}" id="input-address-{{ $address_row }}-company" class="form-control"/>
                    </div>
                  </div>
                  <div class="row mb-3 required">
                    <label for="input-address-{{ $address_row }}-address-1" class="col-sm-2 col-form-label">{{ $lang->entry_address_1 }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="address[{{ $address_row }}][address_1]" value="{{ address.address_1 }}" placeholder="{{ $lang->entry_address_1 }}" id="input-address-{{ $address_row }}-address-1" class="form-control"/>
                      <div id="error-address-{{ $address_row }}-address-1" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="input-address-{{ $address_row }}-address-2" class="col-sm-2 col-form-label">{{ $lang->entry_address_2 }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="address[{{ $address_row }}][address_2]" value="{{ address.address_2 }}" placeholder="{{ $lang->entry_address_2 }}" id="input-address-{{ $address_row }}-address-2" class="form-control"/>
                    </div>
                  </div>
                  <div class="row mb-3 required">
                    <label for="input-address-{{ $address_row }}-city" class="col-sm-2 col-form-label">{{ $lang->entry_city }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="address[{{ $address_row }}][city]" value="{{ address.city }}" placeholder="{{ $lang->entry_city }}" id="input-address-{{ $address_row }}-city" class="form-control"/>
                      <div id="error-address-{{ $address_row }}-city" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="row mb-3 required">
                    <label for="input-address-{{ $address_row }}-postcode" class="col-sm-2 col-form-label">{{ $lang->entry_postcode }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="address[{{ $address_row }}][postcode]" value="{{ address.postcode }}" placeholder="{{ $lang->entry_postcode }}" id="input-address-{{ $address_row }}-postcode" class="form-control"/>
                      <div id="error-address-{{ $address_row }}-postcode" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="row mb-3 required">
                    <label for="input-address-{{ $address_row }}-country" class="col-sm-2 col-form-label">{{ $lang->entry_country }}</label>
                    <div class="col-sm-10">
                      <select name="address[{{ $address_row }}][country_code]" id="input-address-{{ $address_row }}-country" class="form-select" data-address-row="{{ $address_row }}" data-zone-id="{{ address.zone_id }}" disabled>
                        <option value="">{{ $lang->text_select }}</option>
						@foreach($countries as $country)
                          <option value="{{ $country->country_code }}"{% if country.country_code == address.country_code %} selected{% endif %}>{{ $country->name }}</option>
						@endforeach
                      </select>
                      <div id="error-address-{{ $address_row }}-country" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="row mb-3 required">
                    <label for="input-address-{{ $address_row }}-zone" class="col-sm-2 col-form-label">{{ $lang->entry_zone }}</label>
                    <div class="col-sm-10">
                      <select name="address[{{ $address_row }}][zone_id]" id="input-address-{{ $address_row }}-zone" class="form-select" disabled></select>
                      <div id="error-address-{{ $address_row }}-zone" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <input type="hidden" name="address[{{ $address_row }}][address_id]" value="{{ address.address_id }}"/>
                </fieldset>
				<?php $address_row++; ?>

			  @endforeach
              <div class="text-end">
                <button type="button" id="button-address" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i> {{ $lang->button_address_add }}</button>
              </div>
              <input type="hidden" name="member_id" value="{{ $member_id }}" id="input-member-id"/>
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


var address_row = {{ $address_row }};

$('#button-address').on('click', function (e) {
    e.preventDefault();

    html = '<fieldset id="address-row-' + address_row + '">';
    html += '  <legend>{{ $lang->text_address }} ' + (address_row + 1) + ' <button type="button" onclick="$(\'#address-row-' + address_row + '\').remove();" data-bs-toggle="tooltip" title="{{ $lang->button_remove }}" class="btn btn-danger btn-sm float-end"><i class="fa-solid fa-minus-circle"></i></button></legend>';
    html += '  <input type="hidden" name="address[' + address_row + '][address_id]" value="" />';

    html += '  <div class="row mb-3 required">';
    html += '    <label for="input-address-' + address_row + '-first_name" class="col-sm-2 col-form-label">{{ $lang->entry_first_name }}</label>';
    html += '    <div class="col-sm-10">';
    html += '      <input type="text" name="address[' + address_row + '][first_name]" value="" placeholder="{{ $lang->entry_first_name }}" id="input-address-' + address_row + '-first_name" class="form-control"/>';
    html += '      <div id="error-address-' + address_row + '-first_name" class="invalid-feedback"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class="row mb-3 required">';
    html += '    <label for="input-address-' + address_row + '-lastname" class="col-sm-2 col-form-label">{{ $lang->entry_last_name }}</label>';
    html += '    <div class="col-sm-10">';
    html += '      <input type="text" name="address[' + address_row + '][lastname]" value="" placeholder="{{ $lang->entry_last_name }}" id="input-address-' + address_row + '-lastname" class="form-control"/>';
    html += '      <div id="error-address-' + address_row + '-lastname" class="invalid-feedback"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class="row mb-3">';
    html += '    <label for="input-address-' + address_row + '-company" class="col-sm-2 col-form-label">{{ $lang->entry_company }}</label>';
    html += '    <div class="col-sm-10"><input type="text" name="address[' + address_row + '][company]" value="" placeholder="{{ $lang->entry_company }}" id="input-address-' + address_row + '-company" class="form-control"/></div>';
    html += '  </div>';

    html += '  <div class="row mb-3 required">';
    html += '    <label for="input-address-' + address_row + '-address-1" class="col-sm-2 col-form-label">{{ $lang->entry_address_1 }}</label>';
    html += '    <div class="col-sm-10">';
    html += '      <input type="text" name="address[' + address_row + '][address_1]" value="" placeholder="{{ $lang->entry_address_1 }}" id="input-address-' + address_row + '-address-1" class="form-control"/>';
    html += '      <div id="error-address-' + address_row + '-address-1" class="invalid-feedback"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class="row mb-3">';
    html += '    <label for="input-address-' + address_row + '-address-2" class="col-sm-2 col-form-label">{{ $lang->entry_address_2 }}</label>';
    html += '    <div class="col-sm-10"><input type="text" name="address[' + address_row + '][address_2]" value="" placeholder="{{ $lang->entry_address_2 }}" id="input-address-' + address_row + '-address-2" class="form-control"/></div>';
    html += '  </div>';

    html += '  <div class="row mb-3 required">';
    html += '    <label for="input-address-' + address_row + '-city" class="col-sm-2 col-form-label">{{ $lang->entry_city }}</label>';
    html += '    <div class="col-sm-10">';
    html += '      <input type="text" name="address[' + address_row + '][city]" value="" placeholder="{{ $lang->entry_city }}" id="input-address-' + address_row + '-city" class="form-control"/>';
    html += '      <div id="error-address-' + address_row + '-city" class="invalid-feedback"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class="row mb-3 required">';
    html += '    <label for="input-address-' + address_row + '-postcode" class="col-sm-2 col-form-label">{{ $lang->entry_postcode }}</label>';
    html += '    <div class="col-sm-10">';
    html += '      <input type="text" name="address[' + address_row + '][postcode]" value="" placeholder="{{ $lang->entry_postcode }}" id="input-address-' + address_row + '-postcode" class="form-control"/>';
    html += '      <div id="error-address-' + address_row + '-postcode" class="invalid-feedback"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class="row mb-3 required" style="display:none">';
    html += '    <label for="input-address-' + address_row + '-country" class="col-sm-2 col-form-label">{{ $lang->entry_country }}</label>';
    html += '    <div class="col-sm-10">';
    html += '       <select name="address[' + address_row + '][country_code]" id="input-address-' + address_row + '-country" data-address-row="' + address_row + '" data-zone-id="0" class="form-select" disabled>';
    html += '         <option value="TW" selected >台灣(中華民國)</option>';
    html += '      </select>';
    html += '      <div id="error-address-' + address_row + '-country" class="invalid-feedback"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class="row mb-3 required">';
    html += '    <label for="input-address-' + address_row + '-zone" class="col-sm-2 col-form-label">{{ $lang->entry_zone }}</label>';
    html += '    <div class="col-sm-10">';
    html += '      <select name="address[' + address_row + '][zone_id]" id="input-address-' + address_row + '-zone" class="form-select" disabled><option value="">{{ $lang->text_none }}</option></select>';
    html += '      <div id="error-address-' + address_row + '-zone" class="invalid-feedback"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '<div class="row mb-3">';
    html += '  <label for="input-address-' + address_row + '-default" class="col-sm-2 col-form-label">{{ $lang->entry_default }}</label>';
    html += '  <div class="col-sm-10">';
    html += '    <div class="form-check"><input type="radio" name="default" value="' + address_row + '" id="input-address-' + address_row + '-default" class="form-check-label"/></div>';
    html += '  </div>';
    html += '</div>';

    html += '</fieldset>';

    $(this).parent().before(html);

    $('#input-customer-group').trigger('change');

    $('select[name=\'address[' + address_row + '][country_code]\']').trigger('change');

    address_row++;
});

var zone = [];

$('#tab-address').on('change', 'select[name$=\'[country_code]\']', function () {
    var element = this;

    $(element).prop('disabled', true);

    $('select[name=\'address[' + $(element).attr('data-address-row') + '][zone_id]\']').prop('disabled', false);

    if (!zone[$(element).val()]) {
        $.ajax({
            url: 'index.php?route=localisation/country|country&user_token=user_token123&country_code=' + $(element).val(),
            dataType: 'json',
            beforeSend: function () {
                $(element).prop('disabled', true);
            },
            complete: function () {
                $(element).prop('disabled', false);
            },
            success: function (json) {
                zone[$(element).val()] = json;

                if (json['postcode_required'] == '1') {
                    $('#input-address-' + $(element).attr('data-address-row') + '-postcode').parent().parent().addClass('required');
                } else {
                    $('#input-address-' + $(element).attr('data-address-row') + '-postcode').parent().parent().removeClass('required');
                }

                html = '<option value="">{{ $lang->text_select }}</option>';

                if (json['zone'] && json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                        if (json['zone'][i]['zone_id'] == $(element).attr('data-zone-id')) {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0">{{ $lang->text_none }}</option>';
                }

                $('#tab-address select[name=\'address[' + $(element).attr('data-address-row') + '][zone_id]\']').html(html);

                $('#tab-address select[name=\'address[' + $(element).attr('data-address-row') + '][zone_id]\']').prop('disabled', false);

                $(element).prop('disabled', false);

                $('#tab-address select[name$=\'[country_code]\']:disabled:first').trigger('change');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    } else {
        html = '<option value="">{{ $lang->text_select }}</option>';

        if (zone[$(element).val()]['zone'] && zone[$(element).val()]['zone'] != '') {
            for (i = 0; i < zone[$(element).val()]['zone'].length; i++) {
                html += '<option value="' + zone[$(element).val()]['zone'][i]['zone_id'] + '"';

                if (zone[$(element).val()]['zone'][i]['zone_id'] == $(element).attr('data-zone-id')) {
                    html += ' selected="selected"';
                }

                html += '>' + zone[$(element).val()]['zone'][i]['name'] + '</option>';
            }
        } else {
            html += '<option value="0">{{ $lang->text_none }}</option>';
        }

        $('#tab-address select[name=\'address[' + $(element).attr('data-address-row') + '][zone_id]\']').html(html);

        $('#tab-address select[name=\'address[' + $(element).attr('data-address-row') + '][zone_id]\']').prop('disabled', false);

        $(element).prop('disabled', false);

        $('#tab-address select[name$=\'[country_code]\']:disabled:first').trigger('change');
    }
});

$('#tab-address select[name$=\'[country_code]\']:first').trigger('change');


$('#ip').on('click', '.pagination a', function (e) {
        e.preventDefault();

        $('#ip').load(this.href);
});
//--></script>
@endsection