@extends('ocadmin.app')

@section('pageJsCss')
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link  href="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
  @include('ocadmin.common.column_left')
@endsection

@section('content')
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-end">
        <button type="submit" form="form-setting" data-bs-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i></button>
        <a href="http://opencart4011.test/backend/index.php?route=setting/store&amp;user_token=7109c73d683c15a0ac011fe5822a62be" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fa-solid fa-reply"></i></a>
      </div>
      <h1>Settings</h1>
      <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="http://opencart4011.test/backend/index.php?route=common/dashboard&amp;user_token=7109c73d683c15a0ac011fe5822a62be">Home</a></li>
                  <li class="breadcrumb-item"><a href="http://opencart4011.test/backend/index.php?route=setting/store&amp;user_token=7109c73d683c15a0ac011fe5822a62be">Stores</a></li>
                  <li class="breadcrumb-item"><a href="http://opencart4011.test/backend/index.php?route=setting/setting&amp;user_token=7109c73d683c15a0ac011fe5822a62be">Settings</a></li>
              </ol>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><i class="fa-solid fa-pencil"></i> Edit Setting</div>
      <div class="card-body">
        <form id="form-setting" action="{{ route('lang.admin.system.setting.settings.save') }}" method="post" data-oc-toggle="ajax">
          @csrf
					@method('PUT')

          <ul class="nav nav-tabs">
            <li class="nav-item"><a href="#tab-mail" data-bs-toggle="tab" class="nav-link active">Mail</a></li>
            <li class="nav-item"><a href="#tab-server" data-bs-toggle="tab" class="nav-link">Server</a></li>
          </ul>
          <div class="tab-content">
            <div id="tab-mail" class="tab-pane active">
              <fieldset>
                <legend>General</legend>
                <div class="row mb-3">
                  <label for="input-mail-engine" class="col-sm-2 col-form-label">Mail Engine</label>
                  <div class="col-sm-10">
                    <select name="config_mail_engine" id="input-mail-engine" class="form-select">
                      <option value="">None</option>
                      <option value="mail" @if($settings->config_mail_engine == 'mail') selected="selected" @endif>Mail</option>
                      <option value="smtp" @if($settings->config_mail_engine == 'smtp') selected="selected" @endif>SMTP</option>
                    </select>
                    <div class="form-text">Only choose 'Mail' unless your host has disabled the php mail function.</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-mail-parameter" class="col-sm-2 col-form-label">Mail Parameters</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_mail_parameter" value="{{ $settings->config_mail_parameter }}" placeholder="Mail Parameters" id="input-mail-parameter" class="form-control">
                    <div class="form-text">When using 'Mail', additional mail parameters can be added here (e.g. -f email@storeaddress.com).</div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>SMTP</legend>
                <div class="row mb-3">
                  <label for="input-mail-smtp-hostname" class="col-sm-2 col-form-label">Hostname</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_mail_smtp_hostname" value="{{ $settings->config_mail_smtp_hostname }}" placeholder="Hostname" id="input-mail-smtp-hostname" class="form-control">
                    <div class="form-text">Add 'tls://' or 'ssl://' prefix if security connection is required. (e.g. tls://smtp.gmail.com, ssl://smtp.gmail.com).</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-mail-smtp-username" class="col-sm-2 col-form-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_mail_smtp_username" value="{{ $settings->config_mail_smtp_username }}" placeholder="Username" id="input-mail-smtp-username" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-mail-smtp-password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_mail_smtp_password" value="" placeholder="Password" id="input-mail-smtp-password" class="form-control">
                    <div class="form-text">For Gmail you might need to setup an application specific password here: <a href="https://security.google.com/settings/security/apppasswords" target="_blank">https://security.google.com/settings/security/apppasswords</a>.</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-mail-smtp-port" class="col-sm-2 col-form-label">Port</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_mail_smtp_port" value="{{ $settings->config_mail_smtp_port }}" placeholder="Port" id="input-mail-smtp-port" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-mail-smtp-timeout" class="col-sm-2 col-form-label">Timeout</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_mail_smtp_timeout" value="{{ $settings->config_mail_smtp_timeout }}" placeholder="Timeout" id="input-mail-smtp-timeout" class="form-control">
                  </div>
                </div>
              </fieldset>
            </div>
            <div id="tab-server" class="tab-pane">
              <fieldset>
                <legend>General</legend>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Maintenance Mode</label>
                  <div class="col-sm-10">
                    <div class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="config_maintenance" value="0">
                      <input type="checkbox" name="config_maintenance" value="1" id="input-maintenance" class="form-check-input">
                    </div>
                    <div class="form-text">Prevents customers from browsing your store. They will instead see a maintenance message. If logged in as admin, you will see the store as normal.</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-session-expire" class="col-sm-2 col-form-label">Session Lifetime</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_session_expire" value="{{ $settings->config_session_expire }}" placeholder="Session Lifetime" id="input-session-expire" class="form-control">
                    <div class="form-text">Set the PHP Session lifetime</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-robots" class="col-sm-2 col-form-label">Robots</label>
                  <div class="col-sm-10">
                    <textarea name="config_robots" rows="5" placeholder="Robots" id="input-robots" class="form-control">{{ $settings->config_robots }}</textarea>
                    <div class="form-text">A list of web crawler user agents that shared sessions will not be used with. Use separate lines for each user agent.</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-compression" class="col-sm-2 col-form-label">Output Compression Level</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_compression" value="0" placeholder="Output Compression Level" id="input-compression" class="form-control">
                    <div class="form-text">GZIP for more efficient transfer to requesting clients. Compression level must be between 0 - 9.</div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Security</legend>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Two-factor Security</label>
                  <div class="col-sm-10">
                    <div class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="config_security" value="0">
                      <input type="checkbox" name="config_security" value="1" id="input-security" class="form-check-input" @if($settings->config_security == 1) checked @endif>
                    </div>
                    <div class="form-text">Two-factor security for admin users.</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Use Shared Sessions</label>
                  <div class="col-sm-10">
                    <div class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="config_shared" value="0">
                      <input type="checkbox" name="config_shared" value="1" id="input-shared" class="form-check-input" @if($settings->config_shared == 1) checked @endif>
                    </div>
                    <div class="form-text">Try to share the session cookie between stores so the cart can be passed between different domains.</div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-encryption" class="col-sm-2 col-form-label">Encryption Key</label>
                  <div class="col-sm-10">
                    <textarea name="config_encryption" rows="5" placeholder="Encryption Key" id="input-encryption" class="form-control">{{ $settings->config_encryption }}</textarea>
                    <div class="form-text">Please provide a secret key that will be used to encrypt private information when processing orders.</div>
                    <div id="error-encryption" class="invalid-feedback"></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Uploads</legend>
                <div class="row mb-3 required">
                  <label for="input-file-max-size" class="col-sm-2 col-form-label">Max File Size</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_file_max_size" value="20" placeholder="Max File Size" id="input-file-max-size" class="form-control">
                    <div class="form-text">The maximum file size you can allow customers to upload. Enter as megabyte.</div>
                    <div id="error-file-max-size" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-file-ext-allowed" class="col-sm-2 col-form-label">Allowed File Extensions</label>
                  <div class="col-sm-10">
                    <textarea name="config_file_ext_allowed" rows="5" placeholder="Allowed File Extensions" id="input-file-ext-allowed" class="form-control">{{ $settings->config_file_ext_allowed }}</textarea>
                    <div class="form-text">Add which file extensions are allowed to be uploaded. Use a new line for each value.</div>
                    <div id="error-file-ext-allowed" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-file-mime-allowed" class="col-sm-2 col-form-label">Allowed File Mime Types</label>
                  <div class="col-sm-10">
                    <textarea name="config_file_mime_allowed" rows="5" placeholder="Allowed File Mime Types" id="input-file-mime-allowed" class="form-control">{{ $settings->config_file_mime_allowed }}</textarea>
                    <div class="form-text">Add which file mime types are allowed to be uploaded. Use a new line for each value.</div>
                    <div id="error-file-mime-allowed" class="invalid-feedback"></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Error Handling</legend>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Display Errors</label>
                  <div class="col-sm-10">
                    <div class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="config_error_display" value="0">
                      <input type="checkbox" name="config_error_display" value="1" id="input-error-display" class="form-check-input" checked="">
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Log Errors</label>
                  <div class="col-sm-10">
                    <div class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="config_error_log" value="0">
                      <input type="checkbox" name="config_error_log" value="1" id="input-error-log" class="form-check-input" checked="">
                    </div>
                  </div>
                </div>
                <div class="row mb-3 required">
                  <label for="input-error-filename" class="col-sm-2 col-form-label">Error Log Filename</label>
                  <div class="col-sm-10">
                    <input type="text" name="config_error_filename" value="error.log" placeholder="Error Log Filename" id="input-error-filename" class="form-control">
                    <div id="error-error-filename" class="invalid-feedback"></div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection