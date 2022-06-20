<form id="form-member" method="post" data-oc-toggle="ajax" data-oc-load="{{ route('lang.admin.member.members.list') }}" data-oc-target="#member">
	@csrf
	@method('POST')
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', $(this).prop('checked'));" class="form-check-input"/></td>
					<td class="text-start"><a href="{{ $sort_name }}" @if($sort=='name')  class="{{ $order }}" @endif>{{ $langs->column_name }}</a></td>
					<td class="text-start"><a href="{{ $sort_email }}" @if($sort=='email')  class="{{ $order }}" @endif>{{ $langs->column_email }}</a></td>
					<?php /*<td class="text-start"><a href="http://opencart4x.test/backend/index.php?route=customer/customer|list&amp;user_token=5bb02794973e438e69f86e04c7730815&amp;sort=customer_group&amp;order=DESC">{{ $langs->column_customer_group }}</a></td> */ ?>
					<td class="text-start d-none d-lg-table-cell"><a href="{{ $sort_status }}" @if($sort=='status')  class="{{ $order }}" @endif>{{ $langs->column_status }}</a></td>
					<td class="text-start d-none d-lg-table-cell"><a href="{{ $sort_created_at}}" @if($sort=='created_at')  class="{{ $order }}" @endif>{{ $langs->column_date_added }}</a></td>
					<td class="text-end">{{ $langs->column_action }}</td>
				</tr>
			</thead>
			<tbody>
				@foreach($members as $row)
				<tr>
					<td class="text-center"><input type="checkbox" name="selected[]" value="1" class="form-check-input"/></td>
					<td class="text-start">{{ $row->name }}</td>
					<td class="text-start">{{ $row->email }}</td>
					<?php /*<td class="text-start">Default</td>*/?>
					<td class="text-start d-none d-lg-table-cell">{{ $row->status }}</td>
					<td class="text-start d-none d-lg-table-cell">{{ $row->created_at }}</td>
					<td class="text-end"><a href="{{ $row->url_edit }}" data-bs-toggle="tooltip" title="{{ $langs->button_edit }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
				</tr>
				@endforeach
												</tbody>
		</table>
	</div>
	{{-- $members->withQueryString()->links() --}}
	{{-- $members->links('ocadmin.pagination.default', ['members'=>$members]) --}}
	{{ $members->links('ocadmin.pagination.default', ['members'=>$members]) }}
</form>