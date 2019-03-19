@extends('layouts.app')

@section('content')
<section class="login-block">
    <div class="row">
        <div class="col-md-8 banner-sec"> 
            <div class="banner">
                <div class="banner-container">
                    <div class="navbar-header">
                        <a class="navbar-brand page-scroll" href="#page-top"><img src="{{asset('public/looksyassets/images/logo.png')}}" alt="Lattes theme logo"></a>
                    </div>
                    <div class="banner-content">
                        <h2>Become  A  Host</h2>
                            <p> There’s Somebody who wants to know  <br> “ How you Do It.”</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 login-sec">
            <h2 class="text-center">{{ __('Reset Password') }}</h2>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form  method="POST" class="login100-form validate-form" action="{{ route('password.email') }}">
                @csrf
                <div class="wrap-input100 validate-input">
                    <input class="input100 validate-form{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" placeholder="Email Address">

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <button type="submit" class="btn btn-primary" style="font-size:1.5em;">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
                <div class="form-group">
                   <a href="{{ route('login') }}" style="text-decoration:none;"><i class="fa fa-long-arrow-left"></i>&nbsp;Back to Sign In</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
