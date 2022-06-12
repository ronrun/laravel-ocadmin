@extends('ocadmin._layouts.app')

@section('pageJsCss')
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link  href="{{ asset('oc-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
  @include('ocadmin._partials.sidebar')
@endsection

@section('content')
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-end">
				<button class="btn btn-light d-lg-none" data-bs-toggle="tooltip" onclick="$('#filter-product').toggleClass('d-none');" title="Filter" type="button"><i class="fas fa-filter"></i></button> <a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" title="Add New"><i class="fas fa-plus"></i></a> <button class="btn btn-light" data-bs-toggle="tooltip" form="form-product" formaction="http://opencart4x.test/backend/index.php?route=catalog/product|copy&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" title="Copy" type="submit"><i class="fas fa-copy"></i></button> <button class="btn btn-danger" data-bs-toggle="tooltip" form="form-product" formaction="http://opencart4x.test/backend/index.php?route=catalog/product|delete&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" onclick="return confirm('Are you sure?');" title="Delete" type="submit"><i class="far fa-trash-alt"></i></button>
			</div>
			<h1>Products</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="http://opencart4x.test/backend/index.php?route=common/dashboard&amp;user_token=9d6eeccf87f512a5b1c5431281d43541">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="http://opencart4x.test/backend/index.php?route=catalog/product&amp;user_token=9d6eeccf87f512a5b1c5431281d43541">Products</a>
				</li>
			</ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3" id="filter-product">
				<div class="card">
					<div class="card-header">
						<i class="fas fa-filter"></i> Filter
					</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label" for="input-name">Product Name</label> <input class="form-control" id="input-name" list="list-name" name="filter_name" placeholder="Product Name" type="text" value=""> <datalist id="list-name">
							</datalist>
						</div>
						<div class="mb-3">
							<label class="form-label" for="input-model">Model</label> <input class="form-control" id="input-model" list="list-model" name="filter_model" placeholder="Model" type="text" value=""> <datalist id="list-model">
							</datalist>
						</div>
						<div class="mb-3">
							<label class="form-label" for="input-price">Price</label> <input class="form-control" id="input-price" name="filter_price" placeholder="Price" type="text" value="">
						</div>
						<div class="mb-3">
							<label class="form-label" for="input-quantity">Quantity</label> <input class="form-control" id="input-quantity" name="filter_quantity" placeholder="Quantity" type="text" value="">
						</div>
						<div class="mb-3">
							<label class="form-label" for="input-status">Status</label> <select class="form-select" id="input-status" name="filter_status">
								<option value="">
								</option>
								<option value="1">
									Enabled
								</option>
								<option value="0">
									Disabled
								</option>
							</select>
						</div>
						<div class="text-end">
							<button class="btn btn-light" id="button-filter" type="button"><i class="fas fa-filter"></i> Filter</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col col-lg-9 col-md-12">
				<div class="card">
					<div class="card-header">
						<i class="fas fa-list"></i> Product List
					</div>
					<div class="card-body" id="product">
						<form data-oc-load="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541" data-oc-target="#product" data-oc-toggle="ajax" id="form-product" method="post" name="form-product">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-center" style="width: 1px;"><input class="form-check-input" onclick="$('input[name*=\'selected\']').prop('checked', $(this).prop('checked'));" type="checkbox"></td>
											<td class="text-center">Image</td>
											<td class="text-start">
												<a class="asc" href="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;sort=pd.name&amp;order=DESC">Product Name</a>
											</td>
											<td class="text-start d-none d-lg-table-cell">
												<a href="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;sort=p.model&amp;order=DESC">Model</a>
											</td>
											<td class="text-end">
												<a href="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;sort=p.price&amp;order=DESC">Price</a>
											</td>
											<td class="text-end">
												<a href="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;sort=p.quantity&amp;order=DESC">Quantity</a>
											</td>
											<td class="text-end">Action</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="42"></td>
											<td class="text-center"><img alt="Apple Cinema 30&quot;" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/apple_cinema_30-40x40.jpg"></td>
											<td class="text-start">Apple Cinema 30&quot;<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 15</td>
											<td class="text-end">
												<span style="text-decoration: line-through;">$100.00</span><br>
												<div class="text-danger">
													$90.00
												</div>
											</td>
											<td class="text-end"><span class="badge bg-success">990</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=42" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=42"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="30"></td>
											<td class="text-center"><img alt="Canon EOS 5D" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/canon_eos_5d_1-40x40.jpg"></td>
											<td class="text-start">Canon EOS 5D<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 3</td>
											<td class="text-end">
												<span style="text-decoration: line-through;">$100.00</span><br>
												<div class="text-danger">
													$80.00
												</div>
											</td>
											<td class="text-end"><span class="badge bg-success">7</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=30" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=30"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="47"></td>
											<td class="text-center"><img alt="HP LP3065" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/hp_1-40x40.jpg"></td>
											<td class="text-start">HP LP3065<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 21</td>
											<td class="text-end">$100.00</td>
											<td class="text-end"><span class="badge bg-success">1000</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=47" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=47"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="28"></td>
											<td class="text-center"><img alt="HTC Touch HD" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/htc_touch_hd_1-40x40.jpg"></td>
											<td class="text-start">HTC Touch HD<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 1</td>
											<td class="text-end">$100.00</td>
											<td class="text-end"><span class="badge bg-success">939</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=28" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=28"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="41"></td>
											<td class="text-center"><img alt="iMac" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/imac_1-40x40.jpg"></td>
											<td class="text-start">iMac<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 14</td>
											<td class="text-end">$100.00</td>
											<td class="text-end"><span class="badge bg-success">977</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=41" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=41"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="40"></td>
											<td class="text-center"><img alt="iPhone" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/iphone_1-40x40.jpg"></td>
											<td class="text-start">iPhone<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">product 11</td>
											<td class="text-end">$101.00</td>
											<td class="text-end"><span class="badge bg-success">970</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=40" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=40"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="48"></td>
											<td class="text-center"><img alt="iPod Classic" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/ipod_classic_1-40x40.jpg"></td>
											<td class="text-start">iPod Classic<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">product 20</td>
											<td class="text-end">$100.00</td>
											<td class="text-end"><span class="badge bg-success">995</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=48" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=48"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="36"></td>
											<td class="text-center"><img alt="iPod Nano" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/ipod_nano_1-40x40.jpg"></td>
											<td class="text-start">iPod Nano<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 9</td>
											<td class="text-end">$100.00</td>
											<td class="text-end"><span class="badge bg-success">994</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=36" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=36"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="34"></td>
											<td class="text-center"><img alt="iPod Shuffle" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/ipod_shuffle_1-40x40.jpg"></td>
											<td class="text-start">iPod Shuffle<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 7</td>
											<td class="text-end">$100.00</td>
											<td class="text-end"><span class="badge bg-success">1000</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=34" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=34"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="text-center"><input class="form-check-input" name="selected[]" type="checkbox" value="32"></td>
											<td class="text-center"><img alt="iPod Touch" class="img-thumbnail" src="http://opencart4x.test/image/cache/catalog/demo/ipod_touch_1-40x40.jpg"></td>
											<td class="text-start">iPod Touch<br>
											<small class="text-success">Enabled</small></td>
											<td class="text-start d-none d-lg-table-cell">Product 5</td>
											<td class="text-end">$100.00</td>
											<td class="text-end"><span class="badge bg-success">999</span></td>
											<td class="text-end">
												<div class="btn-group">
													<a class="btn btn-primary" data-bs-toggle="tooltip" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;product_id=32" title="Edit"><i class="fas fa-pencil-alt"></i></a> <button class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button"><i class="fas fa-caret-down"></i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="http://opencart4x.test/backend/index.php?route=catalog/product|form&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;master_id=32"><i class="fas fa-plus"></i> Add Variant</a>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="row">
								<div class="col-sm-6 text-start">
									<ul class="pagination">
										<li class="page-item active"><span class="page-link">1</span></li>
										<li class="page-item">
											<a class="page-link" href="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;page=2">2</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;page=2">&gt;</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="http://opencart4x.test/backend/index.php?route=catalog/product|list&amp;user_token=9d6eeccf87f512a5b1c5431281d43541&amp;page=2">&gt;|</a>
										</li>
									</ul>
								</div>
								<div class="col-sm-6 text-end">
									Showing 1 to 10 of 19 (2 Pages)
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
$('#product').on('click', 'thead a, .pagination a', function (e) {
	e.preventDefault();

	$('#product').load(this.href);
});

$('#button-filter').on('click', function () {
	var url = '';

	var filter_name = $('#input-name').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_model = $('#input-model').val();

	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}

	var filter_price = $('#input-price').val();

	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}

	var filter_quantity = $('#input-quantity').val();

	if (filter_quantity) {
		url += '&filter_quantity=' + filter_quantity;
	}

	var filter_status = $('#input-status').val();

	if (filter_status !== '') {
		url += '&filter_status=' + filter_status;
	}

	$('#product').load('index.php?route=catalog/product|list&user_token=9d6eeccf87f512a5b1c5431281d43541' + url);
});

$('#input-name').autocomplete({
	'source': function (request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product|autocomplete&user_token=9d6eeccf87f512a5b1c5431281d43541&filter_name=' + encodeURIComponent(request),
			dataType: 'json',
			success: function (json) {
				response($.map(json, function (item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function (item) {

	}
});

$('#input-model').autocomplete({
	'source': function (request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product|autocomplete&user_token=9d6eeccf87f512a5b1c5431281d43541&filter_model=' + encodeURIComponent(request),
			dataType: 'json',
			success: function (json) {
				response($.map(json, function (item) {
					return {
						label: item['model'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function (item) {

	}
});
//--></script>
@endsection