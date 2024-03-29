<form id="form-list" method="post" data-oc-toggle="ajax" data-oc-load="{{ $list_url }}" data-oc-target="#category">
	@csrf
	@method('POST')
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-end">{{ $lang->column_id }}</td>
					<td class="text-start"><a href="{{ $sort_name }}" @if($sort=='name') class="{{ $order }}" @endif>{{ $lang->column_name }}</a></td>
					<td class="text-start"><a href="{{ $sort_date_added }}" @if($sort=='created_at') class="{{ $order }}" @endif>{{ $lang->column_date_created }}</a></td>
					<td class="text-end">{{ $lang->column_action }}</td>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $record)
				<tr>
					<td class="text-end">{{ $record->id }}</td>
					<td class="text-start">{{ $record->name }}</td>
					<td class="text-start d-none d-lg-table-cell">{{ $record->dateCreated }}</td>
					<td class="text-end"><a href="{{ $record->edit_url }}" data-bs-toggle="tooltip" title="{{ $lang->button_edit }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{!! $categories->links('ocadmin.common.pagination', ['categories' => $categories]) !!}
</form>