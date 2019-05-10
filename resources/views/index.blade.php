@guest
  @php $layout = 'layouts.frontapp' @endphp
@endguest

@auth
    @if(Auth::user()->roles->first()->name == 'shopper')
        @php $layout = 'layouts.shopperLayout.shopperFrontApp' @endphp
    @elseif(Auth::user()->roles->first()->name == 'host')
        @php $layout = 'layouts.hostLayout.hostFrontApp' @endphp
    @endif
@endauth

@extends($layout)

@section('pageCss')
<style type="text/css">
    a.item{text-decoration:none;color:inherit;}  
</style>
@stop

@section('content')
<!------------------------------------->
        <section id="category">
            <div class="container">             
                <div class="row">
                    <div class="col-lg-12 text-center slider-cat">
                        @if(!$categories->isEmpty())
                            <div class="owl-carousel">
                                @foreach($categories as $value)
                                    <a href="{{ url('get-products/'.$value['id']) }}" class="item">
                                        @if($value['image'] != "")
                                        <div class="partner-logo"><img src="{{ asset('public/images/categories/'.$value['image']) }}" alt="partners"></div>
                                        @else
                                        <div class="partner-logo"><img src="{{ asset('public/images/no-image-available.png') }}" alt="partners"></div>
                                        @endif
                                        <div class="partner-text">{{ $value['name'] }}</div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center">No Category Available!</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        
        <!------------------------------------->
        
        <section id="Favorites" >
            <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <h2>Favorites</h2>
                        <!-- <a href="{{ url('product-detail') }}"></a> -->
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-lg-12 text-center slider-cat">
                @if(!$fav_listings->isEmpty())
                    <div class="owl-carousel">
                    @foreach($fav_listings as $value)
                        <div class="item ">
                            <div class="ot-portfolio-item">
                                <figure class="effect-bubba">
                                    <img src="{{ asset('public/images/listings/'.$value['listing_image']) }}" alt="{{ $value['title'] }}" class="img-responsive" />
                                    <figcaption>
                                        <h2>{{ $value['title'] }}</h2>
                                        <p>{{ $value['description'] }}</p>
                                        <a href="{{ url('get-products/product-details/'.$value['id']) }}" style="padding:180px 50px;">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @else
                    <p class="text-center">No Favorite Listing Available!</p>
                @endif
              </div>
            </div>
            
            </div><!-- end container -->
        </section>
        
        <section id="category-same">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="section-title">
                            <h2>Founders Picks</h2>                         
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if(!$founder_picks->isEmpty())
                        @foreach($founder_picks as $val)
                        <div class="col-md-3">
                            <a href="{{ url('get-products/product-details/'.$val['id']) }}">
                                <div class="team-item">
                                    <div class="team-image">
                                        <img src="{{ asset('public/images/listings/'.$val['getImages'][0]['name']) }}" class="img-responsive"  alt="{{ $val['title'] }}">
                                    </div>
                                    <div class="team-text">
                                        <div class="team-name">{{ $val['getCategory']['name'] }}</div> 
                                        <h3>{{ $val['title'] }}</h3>
                                        <p>${{ $val['price'] }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <p class="text-center">No Founders Picks Available!</p>
                    @endif
                </div>
            </div>
        </section>
        <section id="category-same" class="category-same2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="section-title">
                            <h2>What’s New</h2>                         
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if(!$new_listings->isEmpty())
                        @foreach($new_listings as $val)
                        <!-- team member item -->
                        <div class="col-md-3">
                            <a href="{{ url('get-products/product-details/'.$val['id']) }}">
                                <div class="team-item">
                                    <div class="team-image">
                                        <img src="{{ asset('public/images/listings/'.$val['getImages'][0]['name']) }}" alt="{{ $val['title'] }}" class="img-responsive">
                                    </div>
                                    <div class="team-text">
                                        <div class="team-name">{{ $val['getCategory']['name'] }}</div> 
                                        <h3>{{ $val['title'] }}</h3>
                                        <p>${{ $val['price'] }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- end team member item -->
                        @endforeach
                    @else
                        <p class="text-center">No New Listing Available!</p>
                    @endif
                </div>
            </div>
        </section>
        <section id="footer-main">
            <div class="container">
                
                <div class="row">
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href="#"> Home</a></li>
                          <li><a href="#"> About</a></li>
                          <li><a href="{{ url('/messages') }}"> Message</a></li>
                          <li><a href="#"> Saved</a></li>
                          <li><a href="#"> Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href="#"> Help</a></li>
                          <li><a href="#"> Support</a></li>                      
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href="#"> Term</a></li>
                          <li><a href="#"> Privacy</a></li>                      
                          <li><a href="#"> Site Map</a></li>                     
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href="#"> Carrier</a></li>
                          <li><a href="#"> Policies</a></li>                     
                          <li><a href="#"> Press</a></li>                        
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6 social-icons">
                        <ul>
                          <li><a href="#"> <i class="fa fa-facebook"></i></a></li>
                          <li><a href="#"> <i class="fa fa-twitter"></i></a></li>                        
                          <li><a href="#"> <i class="fa fa-instagram"></i></a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </section>
        @endsection