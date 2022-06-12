@extends('ocadmin._layouts.app')

@section('content')
<div id="content">
    <div class="container-fluid">
        <br/>
        <br/>
        <div class="row justify-content-sm-center">
            <div class="col-sm-4 col-md-6">
                <div class="card">
                    <div class="card-header"><i class="fas fa-lock"></i> Please enter your login details.</div>
                    <div class="card-body">
                        <form id="form-login" action="{{ route('admin.login') }}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <label for="input-username" class="form-label">Username</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    <input type="text" name="username" value="" placeholder="Username" id="input-username" class="form-control"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="input-password" class="form-label">Password</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control"/>
                                </div>
                                <div class="mb-3"><a href="{{ route('admin.password.request') }}">Forgotten Password</a></div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Login</button>
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
            url: 'refresh-token', 
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