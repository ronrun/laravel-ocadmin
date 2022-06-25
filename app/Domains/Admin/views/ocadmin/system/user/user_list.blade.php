<form id="form-user" method="post" data-oc-toggle="ajax" data-oc-load="{{ route('lang.admin.system.user.users.list') }}" data-oc-target="#user">
	@csrf
	@method('put')
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', $(this).prop('checked'));" class="form-check-input"/></td>
					<td class="text-start"><a href="{{ $sort_username }}" @if($sort=='username') class="{{ $order }}" @endif>{{ $lang->column_username }}</a></td>
					<td class="text-start"><a href="{{ $sort_email }}" @if($sort=='email') class="{{ $order }}" @endif>{{ $lang->column_email }}</a></td>
					<td class="text-start"><a href="{{ $sort_name }}" @if($sort=='name') class="{{ $order }}" @endif>{{ $lang->column_name }}</a></td>
                    <td class="text-start"><a href="{{ $sort_status}}" @if($sort=='status') class="{{ $order }}" @endif>{{ $lang->column_status }}</a></td>
					<td class="text-start"><a href="{{ $sort_created_at}}" @if($sort=='created_at') class="{{ $order }}" @endif>{{ $lang->column_date_added }}</a></td>
					<td class="text-end">{{ $lang->column_action }}</td>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $row)	
			<tr>
				<td class="text-center"><input type="checkbox" name="selected[]" value="1" class="form-check-input"/></td>
				<td class="text-start">{{ $row->username }}</td>
				<td class="text-start">{{ $row->email }}</td>
				<td class="text-start">{{ $row->name }}</td>
				<td class="text-start">{{ $row->status }}</td>
				<td class="text-start">{{ $row->created_at }}</td>
				<td class="text-end"><a href="{{ $row->url_edit }}" data-bs-toggle="tooltip" title="{{ $lang->button_edit }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
			</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{{-- $users->withQueryString()->links() --}}
	{{-- $users->links('ocadmin.pagination.default', ['users'=>$users]) --}}
	{{ $users->links('ocadmin.pagination.default', ['users'=>$users]) }}
	
</form>