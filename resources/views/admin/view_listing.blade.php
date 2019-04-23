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
                    <h3 class="box-title" style="padding:10px 50px;">{{ $listing['title'] }}</h3>
                </div>
                <div class="box-body">
                    <div class="box-row">
                        <label>Title</label>
                        <p class="box-row-content">{{ $listing['title'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Description</label>
                        <p class="box-row-content">{{ $listing['description'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Location</label>
                        <p class="box-row-content">{{ $listing['location'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Price</label>
                        <p class="box-row-content">{{ $listing['price'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Category</label>
                        <p class="box-row-content">{{ $listing['getCategory']['name'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Images</label>
                        <p class="box-row-content" id="image-box">
                            @foreach($listing['getImages'] as $val)
                                <a href="{{ asset('public/images/listings/'.$val['name']) }}" data-lightbox="{{ $val['listing_id'] }}">
                                  <img src="{{ asset('public/images/listings/'.$val['name']) }}" style="height:80px;">
                                </a>
                            @endforeach
                        </p>
                    </div>
                    <div class="box-row">
                        <label>People Allowed</label>
                        <p class="box-row-content">
                            @if(isset($listing['getGuests']['adults']))
                                {{ 'Adults' }}
                            @endif
                            @if(isset($listing['getGuests']['children']))
                                {{ ', Children' }}
                            @endif
                            @if(isset($listing['getGuests']['infants']))
                                {{ ', Infants' }}
                            @endif
                        </p>
                    </div>
                    <div class="box-row">
                        <label>People Count</label>
                        <p class="box-row-content">{{ $listing['getGuests']['total_count'] }}</p>
                    </div>
                    <div class="box-row">
                        <label>Time Slots</label>
                        <div class="box-row-content">
                            @foreach($listing['getTimes'] as $t)
                                <p>{{ Carbon::create($t['start_time'])->format("g:i a") }}-{{ Carbon::create($t['end_time'])->format("g:i a") }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection