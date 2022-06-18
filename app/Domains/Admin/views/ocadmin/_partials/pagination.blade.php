<ul class="pagination">
	@if($first)
		<li class="page-item"><a href="{{ $first }}" class="page-link">|&lt;</a></li>
	@endif
	@if($prev)
		<li class="page-item"><a href="{{ $prev }}" class="page-link">&lt;</a></li>
	@endif
    @foreach($links as $link)
		@if($link['page'] == $page)
			<li class="page-item active"><span class="page-link">{{ $link['page'] }}</span></li>
		@else
			<li class="page-item"><a href="{{ $link['href'] }}" class="page-link">{{ $link['page'] }}</a></li>
		@endif
	@endforeach
	@if($next)
		<li class="page-item"><a href="{{ $next }}" class="page-link">&gt;</a></li>
	@endif
	@if($last)
		<li class="page-item"><a href="{{ $last }}" class="page-link">&gt;|</a></li>
	@endif
</ul>