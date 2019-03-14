@extends('layouts.app')
@section('content')
<section class="login-block">
    <div class="row">
        <div class="col-md-8 banner-sec"> 
            <div class="banner">
                <div class="banner-container">
                    <div class="navbar-header">
                        <a class="navbar-brand page-scroll" href="#page-top"><img src="{{asset('looksyassets/images/logo.png')}}" alt="Lattes theme logo"></a>
                    </div>
                    <div class="banner-content">
                        <h2>Become  A  Host</h3>
                            <p> There’s Somebody who wants to know  </br> “ How you Do It.”</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 login-sec">
                <h2 class="text-center">Login Now</h2>
                <form  method="POST" class="login100-form validate-form" action="{{ route('login') }}">
                        @csrf
                    <div class="wrap-input100 validate-input">
                        <input class="input100 validate-form{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" placeholder="email"> 
                         @if ($errors->has('email'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('email') }}</strong>
                             </span>
                        @endif
                    </div>
                    <div class="wrap-input100 validate-input{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="text-left p-t-8 p-b-31">
                        <a href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    </div>
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <button class="btn btn-primary">{{ __('Login') }}
                            </button>
                        </div>
                    </div>
                    <div class="txt1 text-center p-t-54 p-b-20">
                        <span>
                            Or Sign In Using
                        </span>
                    </div>
                    <div class="flex-c-m">
                        <a href="#" class="login100-social-item bg1">
                            <i class="fa fa-facebook"></i>
                        </a> 
                    </div>
                </form>
            </div>
        </div>
    </section>



<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <!-- <a href="{{ url('/auth/github') }}" class="btn btn-github"><i class="fa fa-github"></i> Github</a>
                                <a href="{{ url('/auth/twitter') }}" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a> ->
                                <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
