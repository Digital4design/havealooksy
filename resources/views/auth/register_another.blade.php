@extends('layouts.app')

@section('pageCss')
<style type="text/css">
.select_user_form{width:100%;display:block;margin-top: 2em;}
.radio_input{display:flex;align-items: center;justify-content: space-evenly;margin:2em;}
.error{color: red;}
.select_user{display:flex;flex-direction:column;justify-content:center;}
h3#title{text-transform: uppercase;font-weight: 300;color: #848080;font-size: 42px;}
.radio_label{color: #848080;font-weight: normal;text-transform: uppercase;font-size:18px;}
.radio_input input{height:20px;margin:1em auto;outline:none;width:100%;}
#previous{cursor:pointer;text-decoration:none;}
</style>
@stop

@section('content')
<section class="login-block">
    <div class="row">
        <div class="col-md-8 banner-sec">   
            <div class="banner">
                <div class="banner-container">
                    <div class="navbar-header">
                        <a class="navbar-brand page-scroll" href="#page-top"><img src="{{asset('public/looksyassets/images/logo.png') }}" alt="Lattes theme logo"></a>
                    </div>
                    <div class="banner-content">
                       <h2>Become  A  Host</h2>
                       <p> There’s Somebody who wants to know  <br> “ How you Do It.”</p>
                    </div>                           
                </div>
            </div>
        </div>
        <div class="col-md-4 login-sec signup-sec select_user">
            <h3 id="title" class="text-center">Signup As</h3>
            <div class="select_user_form">
                <div class="radio_input">
                    <label>
                        <input type="radio" value="buyer" name="user_type_selector" checked><span class="radio_label">Buyer</span>
                    </label>
                    <label>
                        <input type="radio" value="seller" name="user_type_selector"><span class="radio_label">Seller</span>
                    </label>
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <button class="btn btn-primary" name="next" type="button">
                            {{ __('Next') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 login-sec signup-sec main_form hide">
            <h2 class="text-center">Signup Now</h2>
            <form method="POST" class="login100-form validate-form" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="usertype">
                <div class="wrap-input100 validate-input">
                    <input class="input100 form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                    @if ($errors->has('first_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif                           
                </div>
                <div class="wrap-input100 validate-input">                          
                    <input class="input100 form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" value="{{ old('last_name') }}"
                    placeholder="Last Name" required>
                    @if ($errors->has('last_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif                             
                </div>
                <div class="wrap-input100 validate-input">                          
                    <input class="input100 form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" type="text" name="user_name" value="{{ old('user_name') }}"
                    placeholder="Username" required>
                    @if ($errors->has('user_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('user_name') }}</strong>
                        </span>
                    @endif                         
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" placeholder="E-Mail Address" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif                           
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100 form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" type="text" name="postal_code" placeholder="Zip Code" required>
                    @if ($errors->has('postal_code'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('postal_code') }}</strong>
                        </span>
                    @endif                        
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100 form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="Password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif                          
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100 form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <button class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
                <a id="previous"><i class="fa fa-long-arrow-left"></i> Previous</a>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <!-- <a href="{{ url('/auth/github') }}" class="btn btn-github"><i class="fa fa-github"></i> Github</a>
                        <a href="{{ url('/auth/twitter') }}" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a> -->
                        <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('pageJs')
<script type="text/javascript">
    // $("button[name=next]").on("click", function(){
    //       var usertype = $("input:radio[name=user_type_selector]:checked").val();
    //       $(".select_user").animate({
    //         opacity: 0,
    //       }, 500, function() {
    //             $(".select_user").removeClass("show");
    //             $(".select_user").addClass("hide");
    //       });

    //       $(".main_form").animate({
    //         opacity: 1,
    //       }, 500, function() {
    //             $(".main_form").removeClass("hide");
    //             $(".main_form").addClass("show");
    //       });
        
    //     $("input[name=usertype]").val(usertype);
    // });
    // $("#previous").on("click", function(){

    //       $(".main_form").animate({
    //         opacity: 0,
    //       }, 500, function() {
    //             $(".main_form").removeClass("show");
    //             $(".main_form").addClass("hide");
    //       });

    //       $(".select_user").animate({
    //         opacity: 1,
    //       }, 500, function() {
    //             $(".select_user").removeClass("hide");
    //       });
        
    //     $("input[name=usertype]").val("");
    // });
</script>
@stop
