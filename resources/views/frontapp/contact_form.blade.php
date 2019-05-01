@extends('layouts.app')
@section('content')
<section class="contact-block">
    <div class="row">
        <div class="col-md-8 banner-sec"> 
            <div class="banner">
                <div class="banner-container">
                    <div class="navbar-header">
                        <a class="navbar-brand page-scroll" href="{{ url('/') }}"><img src="{{asset('public/looksyassets/images/logo.png')}}" alt="Lattes theme logo"></a>
                    </div>
                    <div class="banner-content">
                    	<h2>GET IN TOUCH</h2>
                        <p style="text-transform:uppercase;">Whether you have any question about hosting, booking, or anything else, we're here to help.<br> We'd love to hear from you.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 login-sec signup-sec" style="padding-top:30px;">
        	@if(Session::get('status') == "success")
			<div class="alert alert-success alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			  <i class="icon fa fa-check"></i>  {{ Session::get('message') }}
			</div>
			@elseif(Session::get('status') == "danger")
			<div class="alert alert-danger alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			  <i class="icon fa fa-ban"></i>  {{ Session::get('message') }}
			</div>
			@endif
            <h2 class="text-center">Contact Us</h2>
            <form class="login100-form validate-form" method="POST" action="{{ url('/contact/send-message') }}">
            	@csrf
                <div class="wrap-input100 validate-input">                          
                    <input class="input100" type="text" name="name" placeholder="Name">
                    @if ($errors->has('name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                    @endif                           
                </div>
                <div class="wrap-input100 validate-input">                          
                    <input class="input100" type="email" name="email" placeholder="E-Mail">
                    @if ($errors->has('email'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif               
                </div>
                <div class="wrap-input100 validate-input">                          
                    <input class="input100" type="text" name="subject" placeholder="Subject">
                    @if ($errors->has('subject'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('subject') }}</strong>
                      </span>
                    @endif             
                </div>          
                <div class="wrap-input100 validate-input">                          
                    <textarea class="input100" name="message" rows="5" placeholder="Message"></textarea>
                    @if ($errors->has('message'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('message') }}</strong>
                      </span>
                    @endif 
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
