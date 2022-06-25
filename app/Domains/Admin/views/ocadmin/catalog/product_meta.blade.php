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
                @foreach($breadcumbs as $breadcumb)
					<li class="breadcrumb-item"><a href="{{ $breadcumb->href }}">{{ $breadcumb->text }}</a></li>
				@endforeach
            </ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><i class="fas fa-pencil-alt"></i> Edit User</div>
			<div class="card-body">
                <form id="form-user" action="http://laraocadmin9.test/en/backgarden/system/user/users/51" method="post" data-oc-toggle="ajax">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3 required">
                        <label for="input-filename" class="col-sm-2 col-form-label">Filename</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <button type="button" id="button-upload" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</button>
                                <input type="text" name="filename" value="" placeholder="Filename" id="input-filename" class="form-control"/>
                                <button type="button" id="button-download" class="btn btn-outline-secondary" disabled><i class="fas fa-download"></i> Download</button>
                            </div>
                            <div class="form-text">You can upload via the upload button or use FTP to upload to the download directory and enter the details below.</div>
                            <div id="error-filename" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3 required">
                        <label for="input-mask" class="col-sm-2 col-form-label">Mask</label>
                        <div class="col-sm-10">
                            <input type="text" name="mask" value="" placeholder="Mask" id="input-mask" class="form-control"/>
                            <div class="form-text">It is recommended that the filename and the mask are different to stop people trying to directly link to your downloads.</div>
                            <div id="error-mask" class="invalid-feedback"></div>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript"><!--

$('#button-upload').on('click', function () {
    var element = this;

    $('#form-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file"/></form>');

    $('#form-upload input[name=\'file\']').trigger('click');

    $('#form-upload input[name=\'file\']').on('change', function () {
        if ((this.files[0].size / 1024) > 52428800) {
            alert('Warning: The uploaded file exceeds the 50Mmb max file size!');

            $(this).val('');
        }
    });

    if (typeof timer !== 'undefined') {
        clearInterval(timer);
    }

    var timer = setInterval(function () {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);

            $.ajax({
                url: 'index.php?route=catalog/download|upload&user_token=4f282756b38a3e13e8e8886b445b8c78',
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(element).prop('disabled', true).addClass('loading');
                },
                complete: function () {
                    $(element).prop('disabled', false).removeClass('loading');
                },
                success: function (json) {
                    if (json['error']) {
                        alert(json['error']);
                    }

                    if (json['success']) {
                        alert(json['success']);

                        $('#input-filename').val(json['filename']);
                        $('#input-mask').val(json['mask']);

                        $('#button-download').prop('disabled', false);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});

$('#input-filename').on('change', function (e) {
    var value = $(this).val();

    if (value != '') {
        $('#button-download').prop('disabled', false);
    } else {
        $('#button-download').prop('disabled', true);
    }
});

$('#button-download').on('click', function (e) {
    location = 'index.php?route=catalog/download|download&user_token=' + getURLVar('user_token') + '&filename=' + $('#input-filename').val();
});
//--></script>

@endsection