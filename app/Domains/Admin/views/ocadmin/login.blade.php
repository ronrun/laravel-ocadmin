@extends('ocadmin._layouts.app')

@section('content')
<div id="content">
    <div class="container-fluid">
        <br/>
        <br/>
        <div class="row justify-content-sm-center">
            <div class="col-sm-4 col-md-6">
                <div class="card">
                    <div class="card-header"><i class="fas fa-lock"></i> {{ $lang->text_login }}</div>
                    <div class="card-body">
                        <form id="form-login" action="{{ route('lang.admin.login') }}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <label for="input-username" class="form-label">{{ $lang->entry_username }}</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    <input type="text" name="username" value="" placeholder="{{ $lang->entry_username }}" id="input-username" class="form-control"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="input-password" class="form-label">{{ $lang->entry_password }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    <input type="password" name="password" value="" placeholder="{{ $lang->entry_password }}" id="input-password" class="form-control"/>
                                </div>
                                <?php /*<div class="mb-3"><a href="{{ route('lang.admin.password.request') }}">{{ $lang->text_forgotten }}</a></div>*/ ?>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> {{ $lang->button_login }}</button>
                            </div>
                                                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('buttom')
<script type="text/javascript"> 
$(document).ready(function(){
    $('form').submit(function(e) {  
        e.preventDefault(); 
        e.returnValue = false; 
        var $form = $(this); 
        $.ajax({ 
            method: "get",
            url: '{{ $refresh_token_url }}', 
            context: $form, 
            success: function (response) { 
                $('meta[name="csrf-token"]').attr('content', response); 
                $('input[name="_token"]').val(response); 
                this.off('submit'); 
                this.submit(); 
            }, 
            error: function (thrownError) { 
                console.log(thrownError); 
            } 
        }); 
    }); 
}); 
</script> 
@endsection