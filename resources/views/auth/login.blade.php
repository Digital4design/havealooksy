@extends('layouts.app')
@section('content')
<section class="login-block">
    <div class="row">
        <div class="col-md-8 banner-sec"> 
            <div class="banner login">
                <div class="banner-container">
                    <div class="navbar-header">
                        <a class="navbar-brand page-scroll" href="{{ url('/') }}"><img src="{{asset('public/looksyassets/images/logo.png')}}" alt="Lattes theme logo"></a>
                    </div>
                    <div class="banner-content">
                        <h2>Experience the Unexplorable</h2>
                        <p> Change the way you learn. <br> Share what you already know. </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 login-sec">
            <h2 class="text-center">Login Now</h2>
            <form  method="POST" class="login100-form validate-form" action="{{ route('login') }}">
                    @csrf
                <div class="wrap-input100 validate-input">
                    <input class="input100 validate-form{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" placeholder="Username or Email Address"> 
                    <!-- @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif -->
                </div>
                <div class="wrap-input100 validate-input{{ $errors->has('password') ? ' is-invalid' : '' }}">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('user_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('user_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="text-left p-t-8 p-b-31">
                    <a href="{{ route('password.request') }}" style="text-decoration:none;">
                        Forgot password?
                    </a>
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <button class="btn btn-primary">{{ __('Login') }}
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <p>Don't have an account?&nbsp;<a href="{{ route('register') }}" style="text-decoration:none;">Sign Up</a></p>
                </div>
                <!-- <div class="txt1 text-center p-t-54 p-b-20">
                    <span>
                        Or Sign In Using
                    </span>
                </div>
                <div class="flex-c-m">
                    <a href="#" class="login100-social-item bg1">
                        <i class="fa fa-facebook"></i>
                    </a> 
                </div> -->
            </form>
        </div>
    </div>
</section>
@endsection
