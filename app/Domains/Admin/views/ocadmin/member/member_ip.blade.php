<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-start">{{ $lang->column_ip }}</td>
        <?php /*<td class="text-end">{{ $lang->column_account }}</td>*/?>
        <td class="text-end">{{ $lang->column_register_account }}</td>
        <?php /*<td class="text-start">{{ $lang->column_country }}</td>*/?>
        <td class="text-start">{{ $lang->column_date_added }}</td>
      </tr>
    </thead>
    <tbody>
      @if($ips)
        @foreach($ips as $ip)
          <tr>
            <td class="text-start"><a href="https://whatismyipaddress.com/ip/{{ $ip->ip }}" target="_blank">{{ $ip->ip }}</a></td>
            <?php /*<td class="text-end"><a href="{{ $ip->filter_ip }}" target="_blank">{{ $ip->account }}</a></td>*/?>
            <td class="text-end">
                @if($ip->registered_accounts > 0)
                <a href="{{ $ip->filter_ip }}" target="_blank">{{ $ip->registered_accounts }}</a></td>
                @else
                    0
                @endif
                <?php /*<td class="text-start">{{ $ip->country }}</td>*/?>
            <td class="text-start">{{ $ip->created_at }}</td>
          </tr>
        @endforeach
      @else
        <tr>
          <td class="text-center" colspan="3">{{ $lang->text_no_results }}</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-sm-6 text-start">{!! $pagination !!}</div>
  <div class="col-sm-6 text-end">{{ $results }}</div>
</div>