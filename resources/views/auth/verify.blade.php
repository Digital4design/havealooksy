@extends('layouts.app')

@section('pageCss')
<link href="{{asset('public/css/app.css')}}" rel="stylesheet">
<style type="text/css">
    /*.container{display:block;height:100vh;max-width:100%;padding:0px;margin:0px;}*/
    .container{padding: 250px 0px;}
    .card{font-size:1.8em;box-shadow:0px 0px 3px #ccc;}
    .card-header{background-color:rgba(137,43,225,0.8);color:#fff;}
    /*.row{padding: 250px 120px;}*/
</style>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
