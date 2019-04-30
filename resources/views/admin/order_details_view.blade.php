@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
    .box-row p{margin:0px;}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Order Details</h3>
                </div>
                <div class="box-body">
                  @foreach($order_items as $item)
                    <div class="box-row" style="flex-direction:column;border-bottom:1px solid #eee;">
                        <label>{{ $item['getBookedListingUser']['title'] }}</label>
                        <p>Date: {{ Carbon::create($item['date'])->format('d F, Y') }}</p>
                        <p>No of seats: {{ $item['no_of_seats'] }}</p>
                        <p>Time Slot: {{ Carbon::create($item['getBookedListingTime']['start_time'])->format('g:i a') }}-{{ Carbon::create($item['getBookedListingTime']['end_time'])->format('g:i a') }}</p>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('pageJs')
<script>
</script>
@stop