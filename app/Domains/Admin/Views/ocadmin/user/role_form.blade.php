@extends('ocadmin.app')

@section('pageJsCss')
@endsection

@section('columnLeft')
	@include('ocadmin.common.column_left')
@endsection

@section('content')
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-end">
        <button type="submit" form="form-role" data-bs-toggle="tooltip" class="btn btn-primary" aria-label="Save" data-bs-original-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
        <a href="{{ $back_url }}" data-bs-toggle="tooltip" title="Back" class="btn btn-light"><i class="fa-solid fa-reply"></i></a>
      </div>
      <h1>Role</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="http://opencart.test/backend/index.php?route=common/dashboard&amp;role_token=a1d0d772d41ec8d7930ea1b78321d9f6">Home</a></li>
        <li class="breadcrumb-item"><a href="http://opencart.test/backend/index.php?route=role/role&amp;role_token=a1d0d772d41ec8d7930ea1b78321d9f6">Roles</a></li>
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header"><i class="fa-solid fa-pencil"></i> Add Role</div>
      <div class="card-body">
        <form id="form-role" action="{{ $save_url }}" method="post" data-oc-toggle="ajax">
          @csrf
          @method('PUT')
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a href="#tab-general" data-bs-toggle="tab" class="nav-link active" aria-selected="true" role="tab">General</a></li>

        </ul>
          <div class="tab-content">
            <div id="tab-general" class="tab-pane active show" role="tabpanel">
              <fieldset>
                <legend>Role Details</legend>
                <div class="row mb-3 required">
                  <label for="input-name" class="col-sm-2 col-form-label">First Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" value="{{ $role->name }}" placeholder="Name" id="input-name" class="form-control">
                    <div id="error-name" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3 required">
                  <label for="input-email" class="col-sm-2 col-form-label">E-Mail</label>
                  <div class="col-sm-10">
                    <input type="text" name="email" value="{{ $role->email }}" placeholder="E-Mail" id="input-email" class="form-control">
                    <div id="error-email" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-mobile" class="col-sm-2 col-form-label">{{ $lang->column_mobile }}</label>
                  <div class="col-sm-10">
                    <input type="text" name="mobile" value="" placeholder="mobile" id="input-mobile" class="form-control">
                    <div id="error-mobile" class="invalid-feedback"></div>
                  </div>
                </div>
                              </fieldset>
              <fieldset>
                <legend>Password</legend>
                <div class="row mb-3 required">
                  <label for="input-password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" autocomplete="new-password">
                    <div id="error-password" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="row mb-3 required">
                  <label for="input-confirm" class="col-sm-2 col-form-label">Confirm</label>
                  <div class="col-sm-10">
                    <input type="password" name="confirm" value="" placeholder="Confirm" id="input-confirm" class="form-control">
                    <div id="error-confirm" class="invalid-feedback"></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Other</legend>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-10">
                    <div class="form-check form-switch form-switch-lg">
                      <input type="hidden" name="status" value="0"> <input type="checkbox" name="status" value="1" id="input-status" class="form-check-input" checked="">
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div id="tab-address" class="tab-pane" role="tabpanel">
                                          <div class="text-end">
                <button type="button" id="button-address" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i> Add Address</button>
              </div>
              <input type="hidden" name="role_id" value="{{ $role->id }}" id="input-role-id">
            </div>

            <div id="tab-payment" class="tab-pane" role="tabpanel">
              <fieldset>
                <legend>Payment Methods</legend>
                <div id="payment-method"></div>
              </fieldset>
            </div>
            <div id="tab-history" class="tab-pane" role="tabpanel">
              <fieldset>
                <legend>History</legend>
                <div id="history"><div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <td class="text-start">Date Added</td>
        <td class="text-start">Comment</td>
      </tr>
    </thead>
    <tbody>
              <tr>
          <td class="text-center" colspan="2">No results!</td>
        </tr>
          </tbody>
  </table>
</div>
<div class="row">
  <div class="col-sm-6 text-start"></div>
  <div class="col-sm-6 text-end">Showing 0 to 0 of 0 (0 Pages)</div>
</div>
</div>
              </fieldset>
              <fieldset>
                <legend>Add History</legend>
                <div class="row mb-3">
                  <label for="input-history" class="col-sm-2 col-form-label">Comment</label>
                  <div class="col-sm-10">
                    <textarea name="comment" rows="8" placeholder="Comment" id="input-history" class="form-control"></textarea>
                  </div>
                </div>
                <div class="text-end">
                  <button type="button" id="button-history" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i> Add History</button>
                </div>
              </fieldset>
            </div>

            <div id="tab-transaction" class="tab-pane" role="tabpanel">
              <fieldset>
                <legend>Transactions</legend>
                <div id="transaction"><div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-start">Date Added</td>
        <td class="text-start">Description</td>
        <td class="text-end">Amount</td>
      </tr>
    </thead>
    <tbody>
              <tr>
          <td class="text-center" colspan="3">No results!</td>
        </tr>
          </tbody>
  </table>
</div>
<div class="row">
  <div class="col-sm-6 text-start"></div>
  <div class="col-sm-6 text-end">Showing 0 to 0 of 0 (0 Pages)</div>
</div>
</div>
              </fieldset>
              <fieldset>
                <legend>Add Transaction</legend>
                <div class="row mb-3">
                  <label for="input-transaction" class="col-sm-2 col-form-label">Description</label>
                  <div class="col-sm-10">
                    <input type="text" name="description" value="" placeholder="Description" id="input-transaction" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-amount" class="col-sm-2 col-form-label">Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="amount" value="" placeholder="Amount" id="input-amount" class="form-control">
                  </div>
                </div>
                <div class="text-end">
                  <button type="button" id="button-transaction" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i> Add Transaction</button>
                </div>
              </fieldset>
            </div>
            <div id="tab-reward" class="tab-pane" role="tabpanel">
              <fieldset>
                <legend>Reward Points</legend>
                <div id="reward"><div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-start">Date Added</td>
        <td class="text-start">Description</td>
        <td class="text-end">Points</td>
      </tr>
    </thead>
    <tbody>
              <tr>
          <td class="text-center" colspan="3">No results!</td>
        </tr>
          </tbody>
  </table>
</div>
<div class="row">
  <div class="col-sm-6 text-start"></div>
  <div class="col-sm-6 text-end">Showing 0 to 0 of 0 (0 Pages)</div>
</div>
</div>
              </fieldset>
              <fieldset>
                <legend>Add Reward Points</legend>
                <div class="row mb-3">
                  <label for="input-reward" class="col-sm-2 col-form-label">Description</label>
                  <div class="col-sm-10">
                    <input type="text" name="description" value="" placeholder="Description" id="input-reward" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="input-points" class="col-sm-2 col-form-label">Points</label>
                  <div class="col-sm-10">
                    <input type="text" name="points" value="" placeholder="Points" id="input-points" class="form-control">
                    <div class="form-text">Use minus to remove points</div>
                  </div>
                </div>
                <div class="text-end">
                  <button type="button" id="button-reward" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i> Add Reward Points</button>
                </div>
              </fieldset>
            </div>
            <div id="tab-ip" class="tab-pane" role="tabpanel">
              <fieldset>
                <legend>IP</legend>
                <div id="ip"><div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-start">IP</td>
        <td class="text-end">Accounts</td>
        <td class="text-start">Store</td>
        <td class="text-start">Country</td>
        <td class="text-start">Date Added</td>
      </tr>
    </thead>
    <tbody>
              <tr>
          <td class="text-center" colspan="5">No results!</td>
        </tr>
          </tbody>
  </table>
</div>
<div class="row">
  <div class="col-sm-6 text-start"></div>
  <div class="col-sm-6 text-end">Showing 0 to 0 of 0 (0 Pages)</div>
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