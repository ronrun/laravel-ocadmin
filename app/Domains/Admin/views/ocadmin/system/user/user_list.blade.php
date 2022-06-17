<form id="form-user" method="post" data-oc-toggle="ajax" data-oc-load="{{ $form_action }}" data-oc-target="#user">
	@csrf
	@method('put')
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', $(this).prop('checked'));" class="form-check-input"/></td>
					<td class="text-start"><a href="" class="asc">管理員帳號</a></td>
					<td class="text-start"><a href="">狀態</a></td>
					<td class="text-start"><a href="">新增日期</a></td>
					<td class="text-end">管理</td>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $row)	
			<tr>
				<td class="text-center"><input type="checkbox" name="selected[]" value="1" class="form-check-input"/></td>
				<td class="text-start">{{ $row->username }}</td>
				<td class="text-start">{{ $row->status }}</td>
				<td class="text-start">{{ $row->created_at }}</td>
				<td class="text-end"><a href="{{ $row->url_edit }}" data-bs-toggle="tooltip" title="編輯" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
			</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{{-- $users->withQueryString()->links() --}}
	{{-- $users->links('ocadmin.pagination.default', ['users'=>$users]) --}}
	{{ $users->links('ocadmin.pagination.default', ['users'=>$users]) }}
	
</form>