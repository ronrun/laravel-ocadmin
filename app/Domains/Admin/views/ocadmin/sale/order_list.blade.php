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
        <button type="button" data-bs-toggle="tooltip" title="Filter" onclick="$('#filter-order').toggleClass('d-none');" class="btn btn-light d-lg-none"><i class="fas fa-filter"></i></button>
        <button type="submit" id="button-invoice" form="form-order" formaction="http://opencart4x.test/backend/index.php?route=sale/order|invoice&amp;user_token=57f9e54a7f649466bfba134669196041" formtarget="_blank" data-bs-toggle="tooltip" title="Print Invoice" class="btn btn-info"><i class="fas fa-print"></i></button>
        <button type="submit" id="button-shipping" form="form-order" formaction="http://opencart4x.test/backend/index.php?route=sale/order|shipping&amp;user_token=57f9e54a7f649466bfba134669196041" formtarget="_blank" data-bs-toggle="tooltip" title="Print Shipping List" class="btn btn-info"><i class="fas fa-truck"></i></button>
        <a href="http://opencart4x.test/backend/index.php?route=sale/order|info&amp;user_token=57f9e54a7f649466bfba134669196041" data-bs-toggle="tooltip" title="Add New" class="btn btn-primary"><i class="fas fa-plus"></i></a>
        <button type="button" id="button-delete" data-bs-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
      </div>
      <h1>Orders</h1>
      <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="http://opencart4x.test/backend/index.php?route=common/dashboard&amp;user_token=57f9e54a7f649466bfba134669196041">Home</a></li>
                  <li class="breadcrumb-item"><a href="http://opencart4x.test/backend/index.php?route=sale/order&amp;user_token=57f9e54a7f649466bfba134669196041">Orders</a></li>
              </ol>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div id="filter-order" class="col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3">
        <div class="card">
          <div class="card-header"><i class="fas fa-filter"></i> Filter</div>
          <div class="card-body">
            <div class="mb-3">
              <label for="input-order-id" class="form-label">Order ID</label>
              <input type="text" name="filter_order_id" value="" placeholder="Order ID" id="input-order-id" class="form-control"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Customer</label>
              <input type="text" name="filter_customer" value="" placeholder="Customer" id="input-customer" list="list-customer" class="form-control"/>
              <datalist id="list-customer"></datalist>
            </div>
            <div class="mb-3">
              <label for="input-order-status" class="form-label">Order Status</label>
              <select name="filter_order_status_id" id="input-order-status" class="form-select">
                <option value=""></option>
                <option value="0">Missing Orders</option>
                                  <option value="7">Canceled</option>
                                  <option value="9">Canceled Reversal</option>
                                  <option value="13">Chargeback</option>
                                  <option value="5">Complete</option>
                                  <option value="8">Denied</option>
                                  <option value="14">Expired</option>
                                  <option value="10">Failed</option>
                                  <option value="1">Pending</option>
                                  <option value="15">Processed</option>
                                  <option value="2">Processing</option>
                                  <option value="11">Refunded</option>
                                  <option value="12">Reversed</option>
                                  <option value="3">Shipped</option>
                                  <option value="16">Voided</option>
                              </select>
            </div>
            <div class="mb-3">
              <label for="input-total" class="form-label">Total</label>
              <input type="text" name="filter_total" value="" placeholder="Total" id="input-total" class="form-control"/>
            </div>
            <div class="mb-3">
              <label for="input-date-added" class="form-label">Date Added</label>
              <div class="input-group">
                <input type="text" name="filter_date_added" value="" placeholder="Date Added" id="input-date-added" class="form-control date"/>
                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
              </div>
            </div>
            <div class="mb-3">
              <label for="input-date-modified" class="form-label">Date Modified</label>
              <div class="input-group">
                <input type="text" name="filter_date_modified" value="" placeholder="Date Modified" id="input-date-modified" class="form-control date"/>
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
          <div class="card-header"><i class="fas fa-list"></i> Order List</div>
          <div id="order" class="card-body"><form id="form-order" method="post" enctype="application/x-www-form-urlencoded" data-load="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041">
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').trigger('click');" class="form-check-input"/></td>
          <td class="text-end"><a href="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=o.order_id&amp;order=ASC" class="desc">Order ID</a></td>
          <td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=o.store_name&amp;order=ASC">Store</a></td>
          <td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=customer&amp;order=ASC">Customer</a></td>
          <td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=order_status&amp;order=ASC">Status</a></td>
          <td class="text-end d-none d-lg-table-cell"><a href="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=o.total&amp;order=ASC">Total</a></td>
          <td class="text-start d-none d-lg-table-cell"><a href="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=o.date_added&amp;order=ASC">Date Added</a></td>
          <td class="text-start d-none d-xl-table-cell"><a href="http://opencart4x.test/backend/index.php?route=sale/order|list&amp;user_token=57f9e54a7f649466bfba134669196041&amp;sort=o.date_modified&amp;order=ASC">Date Modified</a></td>
          <td class="text-end">Action</td>
        </tr>
      </thead>
      <tbody>
                              <tr>
              <td class="text-center"><input type="checkbox" name="selected[]" value="1" class="form-check-input"/>
                <input type="hidden" name="shipping_code[]" value=""/></td>
              <td class="text-end">1</td>
              <td class="text-start">Your Store</td>
              <td class="text-start">John Doe</td>
              <td class="text-start"><label>Pending</label></td>
              <td class="text-end d-none d-lg-table-cell">$500.00</td>
              <td class="text-start d-none d-lg-table-cell">12/06/2022</td>
              <td class="text-start d-none d-xl-table-cell">12/06/2022</td>
              <td class="text-end"><a href="http://opencart4x.test/backend/index.php?route=sale/order|info&amp;user_token=57f9e54a7f649466bfba134669196041&amp;order_id=1" data-bs-toggle="tooltip" title="View" class="btn btn-primary"><i class="fas fa-eye"></i></a></td>
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
$('#order').on('click', 'thead a, .pagination a', function(e) {
    e.preventDefault();

    $('#order').load(this.href);
});

$('#button-filter').on('click', function() {
    url = '';

    var filter_order_id = $('#input-order-id').val();

    if (filter_order_id) {
        url += '&filter_order_id=' + filter_order_id;
    }

    var filter_customer = $('#input-customer').val();

    if (filter_customer) {
        url += '&filter_customer=' + encodeURIComponent(filter_customer);
    }

    var filter_store_id = $('#input-store').val();

    if (filter_store_id !== '') {
        url += '&filter_store_id=' + filter_store_id;
    }

    var filter_order_status_id = $('#input-order-status').val();

    if (filter_order_status_id !== '') {
        url += '&filter_order_status_id=' + filter_order_status_id;
    }

    var filter_total = $('#input-total').val();

    if (filter_total) {
        url += '&filter_total=' + encodeURIComponent(filter_total);
    }

    var filter_date_added = $('#input-date-added').val();

    if (filter_date_added) {
        url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
    }

    var filter_date_modified = $('#input-date-modified').val();

    if (filter_date_modified) {
        url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
    }

    $('#order').load('index.php?route=sale/order|list&user_token=57f9e54a7f649466bfba134669196041' + url);
});

$('#input-customer').autocomplete({
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

$('input[name^=\'selected\']').on('change', function() {
    $('#button-shipping, #button-invoice').prop('disabled', true);

    var selected = $('input[name^=\'selected\']:checked');

    if (selected.length) {
        $('#button-invoice').prop('disabled', false);
    }

    for (i = 0; i < selected.length; i++) {
        if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
            $('#button-shipping').prop('disabled', false);

            break;
        }
    }
});

$('#button-shipping, #button-invoice').prop('disabled', true);

$('#button-delete').on('click', function(e) {
    e.preventDefault();

    var element = this;

    if (confirm('Are you sure?')) {
        $.ajax({
            url: 'index.php?route=sale/order|call&user_token=57f9e54a7f649466bfba134669196041&action=sale/order|delete',
            type: 'post',
            data: $('#form-order').serialize(),
            dataType: 'json',
            beforeSend: function() {
                $(element).prop('disabled', true).addClass('loading');
            },
            complete: function() {
                $(element).prop('disabled', false).removeClass('loading');
            },
            success: function(json) {
                $('.alert-dismissible').remove();

                if (json['error']) {
                    $('#alert').prepend('<div class="alert alert-danger alert-dismissible"><i class="fas fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                }

                if (json['success']) {
                    $('#alert').prepend('<div class="alert alert-success alert-dismissible"><i class="fas fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');

                    $('#order').load($('#form-order').attr('data-load'));
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
});
//--></script>
@endsection