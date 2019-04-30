@extends('layouts.frontapp')

@section('pageCss')
@stop

@section('content')
<section>
	<div class="container">
		<div class="box">
            <div class="box-body">
            	<div class="col-md-6 login-sec signup-sec">
					<h2 class="text-center">Contact Us</h2>
					<form class="login100-form validate-form">
						<div class="wrap-input100 validate-input">							
							<input class="input100" type="text" name="username"
							placeholder="First Name">							
						</div>
						<div class="wrap-input100 validate-input">							
							<input class="input100" type="text" name="username"
							placeholder="E-Mail">							
						</div>
                          <div class="wrap-input100 validate-input">							
							<input class="input100" type="text" name="username"
							placeholder="Subject">							
						</div>
						
						  <div class="wrap-input100 validate-input">							
							<textarea class="input100" type="text" name="username"
							placeholder="Message"></textarea>							
						</div>
						<div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn">
								<button class="btn btn-primary">
								Send
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-4 pull-right company-details-box">
					<div class="form-group company-details">
	                 	Company:  <a href="#">HostRiver</a>
	                </div>
	                <div class="form-group company-details">
	                 	Address: <a href="#">4435 Berkshire Circle Knoxville</a>
	                </div>
	                <div class="form-group company-details">
	                  	Phone:  <a href="#">+ 879-890-9767</a>
	                </div>
	                
	                <div class="form-group company-details">
	                  	Website:  <a href="https://uny.ro">www.uny.ro</a>
	                </div>
	                <div class="form-group company-details">
	                   	Program: <a href="#">Mon to Sat: 09:30 AM - 10.30 PM</a>
	                </div>
				</div>
            </div>
        </div>
	</div>
</section>
@endsection

@section('pageJs')
@stop