@extends('ocadmin._layouts.app')

@section('pageJsCss')
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link  href="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
  @include('ocadmin._partials.column_left')
@endsection

@section('content')
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-end"><a href="http://opencart4x.test/backend/index.php?route=user/user_permission|form&amp;user_token=d1d126a904cd4287c86c407357a3bd31" data-bs-toggle="tooltip" title="新增" class="btn btn-primary"><i class="fas fa-plus"></i></a>
				<button type="submit" form="form-user-group" formaction="http://opencart4x.test/backend/index.php?route=user/user_permission|delete&amp;user_token=d1d126a904cd4287c86c407357a3bd31" data-bs-toggle="tooltip" title="刪除" onclick="return confirm('確定嗎？');" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
			</div>
			<h1>管理員群組</h1>
			<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="http://opencart4x.test/backend/index.php?route=common/dashboard&amp;user_token=d1d126a904cd4287c86c407357a3bd31">首頁</a></li>
									<li class="breadcrumb-item"><a href="http://opencart4x.test/backend/index.php?route=user/user_permission&amp;user_token=d1d126a904cd4287c86c407357a3bd31">管理員群組</a></li>
							</ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><i class="fas fa-list"></i> 管理員群組</div>
			<div id="user-group" class="card-body"><form id="form-user-group" method="post" data-oc-toggle="ajax" data-oc-load="http://opencart4x.test/backend/index.php?route=user/user_permission|list&amp;user_token=d1d126a904cd4287c86c407357a3bd31" data-oc-target="#user-group">
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', $(this).prop('checked'));" class="form-check-input"/></td>
          <td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=user/user_permission|list&amp;user_token=d1d126a904cd4287c86c407357a3bd31&amp;sort=name&amp;order=DESC" class="asc">管理員群組名稱</a></td>
          <td class="text-end">管理</td>
        </tr>
      </thead>
      <tbody>
                              <tr>
              <td class="text-center"><input type="checkbox" name="selected[]" value="1" class="form-check-input"/></td>
              <td class="text-start">Administrator</td>
              <td class="text-end"><a href="http://opencart4x.test/backend/index.php?route=user/user_permission|form&amp;user_token=d1d126a904cd4287c86c407357a3bd31&amp;user_group_id=1" data-bs-toggle="tooltip" title="編輯" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
            </tr>
                      <tr>
              <td class="text-center"><input type="checkbox" name="selected[]" value="2" class="form-check-input"/></td>
              <td class="text-start">Demonstration</td>
              <td class="text-end"><a href="http://opencart4x.test/backend/index.php?route=user/user_permission|form&amp;user_token=d1d126a904cd4287c86c407357a3bd31&amp;user_group_id=2" data-bs-toggle="tooltip" title="編輯" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
            </tr>
                        </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-sm-6 text-start"></div>
    <div class="col-sm-6 text-end">顯示 1 - 2 / 2 (共 1 頁)</div>
  </div>
</form>
</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$('#user-group').on('click', 'thead a, .pagination a', function(e) {
    e.preventDefault();

    $('#user-group').load(this.href);
});
//--></script>
@endsection