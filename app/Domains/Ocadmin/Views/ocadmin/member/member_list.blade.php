<form id="form-member" method="post" data-oc-toggle="ajax" data-oc-load="{{ route('lang.admin.member.members.list') }}" data-oc-target="#member">
	@csrf
	@method('POST')
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-end">{{ $lang->column_id }}</td>
					<td class="text-start"><a href="{{ $sort_name }}" @if($sort=='full_name') class="{{ $order }}" @endif>{{ $lang->column_name }}</a></td>
					<td class="text-start"><a href="{{ $sort_mobile }}" @if($sort=='mobile') class="{{ $order }}" @endif>{{ $lang->column_mobile }}</a></td>
					<td class="text-start"><a href="{{ $sort_email }}" @if($sort=='email') class="{{ $order }}" @endif>{{ $lang->column_email }}</a></td>
					<td class="text-start"><a href="{{ $sort_date_added }}" @if($sort=='date_created') class="{{ $order }}" @endif>{{ $lang->column_date_added }}</a></td>
					<td class="text-end">{{ $lang->column_action }}</td>
				</tr>
			</thead>
			<tbody>
				@foreach($members as $row)
				<tr>
					<td class="text-end">{{ $row->id }}</td>
					<td class="text-start">{{ $row->name }}</td>
					<td class="text-start">{{ $row->mobile }}</td>
					<td class="text-start">{{ $row->email }}</td>
					<td class="text-start d-none d-lg-table-cell">{{ $row->create_date }}</td>
					<td class="text-end"><a href="{{ $row->edit_url }}" data-bs-toggle="tooltip" title="{{ $lang->button_edit }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{-- $members->withQueryString()->links() --}}
	{!! $members->links('ocadmin.pagination.default', ['members'=>$members]) !!}

    <?php /*
    <div class="row">
        <div class="col-sm-6 text-start">{!! $pagination !!}</div>
        <div class="col-sm-6 text-end">{{ $results }}</div>
    </div>
    */ ?>
</form>