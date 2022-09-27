@extends('ocadmin.app')

@section('pageJsCss')
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/moment-with-locales.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/daterangepicker.js') }}" type="text/javascript" ></script>
<link  href="{{ asset('ocadmin-asset/javascript/jquery/datetimepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('sidebar')
  @include('ocadmin.common.column_left')
@endsection

@section('content')
哈哈哈
@endsection