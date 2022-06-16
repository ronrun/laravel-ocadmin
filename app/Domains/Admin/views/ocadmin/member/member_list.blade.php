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
      <div class="float-end">
        <button type="button" data-bs-toggle="tooltip" title="Filter" onclick="$('#filter-customer').toggleClass('d-none');" class="btn btn-light d-md-none d-lg-none"><i class="fas fa-filter"></i></button>
        <a href="{{ route('lang.admin.member.members.create') }}" data-bs-toggle="tooltip" title="Add New" class="btn btn-primary"><i class="fas fa-plus"></i></a>
        <button type="submit" form="form-customer" formaction="http://opencart4x.test/backend/index.php?route=customer/customer|delete&amp;user_token=57f9e54a7f649466bfba134669196041" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?');" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
      </div>
      <h1>Customers</h1>
      <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('lang.admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('lang.admin.member.members.index') }}">Members</a></li>
              </ol>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div id="filter-customer" class="col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3">
        <div class="card">
          <div class="card-header"><i class="fas fa-filter"></i> Filter</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Customer Name</label>
              <input type="text" name="filter_name" value="" placeholder="Customer Name" id="input-name" list="list-name" class="form-control"/>
              <datalist id="list-name"></datalist>
            </div>
            <div class="mb-3">
              <label class="form-label">E-Mail</label>
              <input type="text" name="filter_email" value="" placeholder="E-Mail" id="input-email" list="list-email" class="form-control"/>
              <datalist id="list-email"></datalist>
            </div>
            <div class="mb-3">
              <label for="input-customer-group" class="form-label">Customer Group</label> <select name="filter_customer_group_id" id="input-customer-group" class="form-select">
                <option value=""></option>
                                  <option value="1">Default</option>
                              </select>
            </div>
            <div class="mb-3">
              <label for="input-status" class="form-label">Status</label> <select name="filter_status" id="input-status" class="form-select">
                <option value=""></option>
                <option value="1">Enabled</option>
                <option value="0" >Disabled</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="input-ip" class="form-label">IP</label>
              <input type="text" name="filter_ip" value="" placeholder="IP" id="input-ip" class="form-control"/>
            </div>
            <div class="mb-3">
              <label for="input-date-added" class="form-label">Date Added</label>
              <div class="input-group">
                <input type="text" name="filter_date_added" value="" placeholder="Date Added" id="input-date-added" class="form-control date"/>
                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
              </div>
            </div>
            <div class="text-end">
              <button type="button" id="button-filter" class="btn btn-light"><i class="fas fa-filter"></i> Filter</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="card">
          <div class="card-header"><i class="fas fa-list"></i> Customer List</div>
          <div id="customer" class="card-body"><form id="form-customer" method="post" data-oc-toggle="ajax" data-oc-load="http://opencart4x.test/backend/index.php?route=customer/customer|list&amp;user_token=57f9e54a7f649466bfba134669196041" data-oc-target="#customer">
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', $(this).prop('checked'));" class="form-check-input"/></td>
					<td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=customer/customer|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=name&amp;order=DESC" class="asc">Customer Name</a></td>
					<td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=customer/customer|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=c.email&amp;order=DESC">E-Mail</a></td>
					<td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=customer/customer|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=customer_group&amp;order=DESC">Customer Group</a></td>
					<td class="text-start d-none d-lg-table-cell"><a href="http://opencart4x.test/backend/index.php?route=customer/customer|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=c.status&amp;order=DESC">Status</a></td>
					<td class="text-start d-none d-lg-table-cell"><a href="http://opencart4x.test/backend/index.php?route=customer/customer|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=c.date_added&amp;order=DESC">Date Added</a></td>
					<td class="text-end">Action</td>
				</tr>
			</thead>
			<tbody>
															<tr>
							<td class="text-center"><input type="checkbox" name="selected[]" value="1" class="form-check-input"/></td>
							<td class="text-start">John Doe</td>
							<td class="text-start">john.doe@example.com</td>
							<td class="text-start">Default</td>
							<td class="text-start d-none d-lg-table-cell">Enabled</td>
							<td class="text-start d-none d-lg-table-cell">02/06/2022</td>
							<td class="text-end">
								<div class="btn-group dropdown">

									<a href="http://opencart4x.test/backend/index.php?route=customer/customer|form&amp;user_token=57f9e54a7f649466bfba134669196041&amp;customer_id=1" data-bs-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>

									<button type="button" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split"><span class="fas fa-caret-down"></span></button>

									<ul class="dropdown-menu dropdown-menu-right">
										<li><h6 class="dropdown-header">Options</h6></li>
																				<li><a href="#" class="dropdown-item disabled"><i class="fas fa-unlock"></i> Unlock Account</a></li>
																				<li><hr class="dropdown-divider"></li>
										<li><h6 class="dropdown-header">Login into Store</h6></li>
																				<li><a href="http://opencart4x.test/backend/index.php?route=customer/customer|login&amp;user_token=57f9e54a7f649466bfba134669196041&amp;customer_id=1&amp;store_id=0" target="_blank" class="dropdown-item"><i class="fas fa-lock"></i> <span class="text-primary">Your Store</span></a></li>
																			</ul>
								</div>
							</td>
						</tr>
												</tbody>
		</table>
	</div>
	<div class="row">
		<div class="col-sm-6 text-start"></div>
		<div class="col-sm-6 text-end">Showing 1 to 1 of 1 (1 Pages)</div>
	</div>
</form></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#customer').on('click', 'thead a, .pagination a', function(e) {
    e.preventDefault();

    $('#customer').load(this.href);
});

$('#button-filter').on('click', function() {
    url = '';

    var filter_name = $('#input-name').val();

    if (filter_name) {
        url += '&filter_name=' + encodeURIComponent(filter_name);
    }

    var filter_email = $('#input-email').val();

    if (filter_email) {
        url += '&filter_email=' + encodeURIComponent(filter_email);
    }

    var filter_customer_group_id = $('#input-customer-group').val();

    if (filter_customer_group_id !== '') {
        url += '&filter_customer_group_id=' + filter_customer_group_id;
    }

    var filter_status = $('#input-status').val();

    if (filter_status !== '') {
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

    $('#customer').load('index.php?route=customer/customer|list&user_token=57f9e54a7f649466bfba134669196041' + url);
});

$('#input-name').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'index.php?route=customer/customer|autocomplete&user_token=57f9e54a7f649466bfba134669196041&filter_name=' + encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['name'],
                        value: item['customer_id']
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
            url: 'index.php?route=customer/customer|autocomplete&user_token=57f9e54a7f649466bfba134669196041&filter_email=' + encodeURIComponent(request),
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
//--></script>
@endsection