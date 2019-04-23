@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title" style="padding:10px 50px;">{{ $user['first_name'] }}&nbsp;{{ $user['last_name'] }}</h3>
                </div>
                <div class="box-body">
                    <div class="box-row">
                        <label>First Name</label>
                        <p class="box-row-content">{{ $user['first_name'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Last Name</label>
                        <p class="box-row-content">{{ $user['last_name'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Role</label>
                        <p class="box-row-content">{{ $user['getRole']['display_name'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Username</label>
                        <p class="box-row-content">{{ $user['user_name'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Email Address</label>
                        <p class="box-row-content">{{ $user['email'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Postal Code</label>
                        <p class="box-row-content">{{ $user['postal_code'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Profile Picture</label>
                        <p class="box-row-content" id="image-box">
                            @if($user['profile_picture'])
                            <a href="{{ asset('public/images/profile_pictures/'.$user['profile_picture']) }}" data-lightbox="{{ $user['profile_picture'] }}">
                                <img src="{{ asset('public/images/profile_pictures/'.$user['profile_picture']) }}" style="height:80px;">
                            </a>
                            @else
                            {{ '-' }}
                            @endif
                        </p>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection