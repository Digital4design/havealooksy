@extends('layouts.app')

@section('pageCss')
@stop

@section('content')
<section class="login-block">
    <div class="row">
        <div class="col-md-8 banner-sec">   
            <div class="banner host">
                <div class="banner-container">
                    <div class="navbar-header">
                        <a class="navbar-brand page-scroll" href="{{ url('/') }}"><img src="{{asset('public/looksyassets/images/logo.png') }}" alt="Lattes theme logo"></a>
                    </div>
                    <div class="banner-content">
                       <h2>Become  A  Host</h2>
                       <p> There’s Somebody who wants to know  <br> “ How you Do It.”</p>
                    </div>                           
                </div>
            </div>
        </div>
        <div class="col-md-4 login-sec signup-sec main_form">
            <h2 class="text-center">Signup Now</h2>
            <form method="POST" class="login100-form validate-form" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="user_type" value="host">
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
                    <input class="input100 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" placeholder="E-Mail Address" value="{{ old('email') }}" required>
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
                    <input class="input100 form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif                          
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100 form-control" type="password" name="password_confirmation" placeholder="Re-enter Password" required>
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <button class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <p>Already have an account?&nbsp;<a href="{{ route('login') }}" style="text-decoration:none;">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('pageJs')
@stop
