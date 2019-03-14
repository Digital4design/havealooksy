@extends('layouts.frontapp')
@section('content')
<!------------------------------------->
        <section id="category">
            <div class="container">             
                <div class="row">
                    <div class="col-lg-12 text-center slider-cat">
                        <div class="owl-carousel">
                            <div class="item">
                                <div class="partner-logo"><img src="{{ asset('looksyassets/images/icon1.png') }}" alt="partners"></div>
                                <div class="partner-text"> Food & Beverage </div>
                            </div>
                            <div class="item">
                                <div class="partner-logo"><img src="{{ asset('looksyassets/images/icon2.png') }}" alt="partners"></div>
                                <div class="partner-text"> Media & Entertainment </div>
                            </div>
                            <div class="item">
                                <div class="partner-logo"><img src="{{ asset('looksyassets/images/icon3.png') }}" alt="partners"></div>
                                <div class="partner-text"> Real Estate </div>
                            </div>
                            <div class="item">
                                <div class="partner-logo"><img src="{{ asset('looksyassets/images/icon4.png') }}" alt="partners"></div>
                                <div class="partner-text"> Sports </div>
                            </div>
                            <div class="item">
                                <div class="partner-logo"><img src="{{ asset('looksyassets/images/icon5.png') }}" alt="partners"></div>
                                <div class="partner-text"> TV & Film </div>
                            </div>
                            
                        </div>
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
                        
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-lg-12 text-center slider-cat">
                <div class="owl-carousel">
                
                <!-- start portfolio item -->
                <div class="item ">
                    <div class="ot-portfolio-item">
                        <figure class="effect-bubba">
                            <img src="{{ asset('looksyassets/images/img1.jpg') }}" alt="img02" class="img-responsive" />
                            <figcaption>
                                <h2>Green Salad</h2>
                                <p>Branding, Design</p>
                                <a href="#" data-toggle="modal" data-target="#Modal-1">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <!-- end portfolio item -->
                <!-- start portfolio item -->
                <div class="item ">
                    <div class="ot-portfolio-item">
                        <figure class="effect-bubba">
                            <img src="{{ asset('looksyassets/images/img2.jpg') }}" alt="img02" class="img-responsive" />
                            <figcaption>
                                <h2>Canchánchara  Rum</h2>
                                <p>Branding, Web Design</p>
                                <a href="#" data-toggle="modal" data-target="#Modal-2">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <!-- end portfolio item -->
                <!-- start portfolio item -->
                <div class="item ">
                    <div class="ot-portfolio-item">
                        <figure class="effect-bubba">
                            <img src="{{ asset('looksyassets/images/img3.jpg') }}" alt="img02" class="img-responsive" />
                            <figcaption>
                                <h2>Troia Resort</h2>
                                <p>Branding, Web Design</p>
                                <a href="#" data-toggle="modal" data-target="#Modal-3">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <!-- end portfolio item -->
                <!-- start portfolio item -->
                <div class="item ">
                    <div class="ot-portfolio-item">
                        <figure class="effect-bubba">
                            <img src="{{ asset('looksyassets/images/img4.jpg') }}" alt="img02" class="img-responsive" />
                            <figcaption>
                                <h2>Eden</h2>
                                <p>Branding, Web Design</p>
                                <a href="#" data-toggle="modal" data-target="#Modal-3">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <!-- end portfolio item -->
                <!-- start portfolio item -->
                <div class="item ">
                    <div class="ot-portfolio-item">
                        <figure class="effect-bubba">
                            <img src="{{ asset('looksyassets/images/img5.jpg') }}" alt="img02" class="img-responsive" />
                            <figcaption>
                                <h2>Plato, Ljubljana</h2>
                                <p>Branding, Web Design</p>
                                <a href="#" data-toggle="modal" data-target="#Modal-3">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <!-- end portfolio item -->
                
                
                </div>
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
                    <!-- team member item -->
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat1.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">RESTAURANT</div> 
                                <h3>Katz's Delicatessen</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
                    <!-- team member item -->
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat2.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">RESTAURANT</div> 
                                <h3>Katz's Delicatessen</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
                    <!-- team member item -->
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat3.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">RESTAURANT</div> 
                                <h3>Katz's Delicatessen</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
                    <!-- team member item -->
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat4.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">RESTAURANT</div> 
                                <h3>Katz's Delicatessen</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
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
                
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat2.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">Food</div> 
                                <h3>Salsa Delicatessen</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
                    <!-- team member item -->
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat3.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">Real Estate</div> 
                                <h3>RESTAURANT</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
                    <!-- team member item -->
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat1.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">Food</div> 
                                <h3>Katz's Delicatessen</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
                    <!-- team member item -->
                    
                    <!-- team member item -->
                    <div class="col-md-3">
                        <div class="team-item">
                            <div class="team-image">
                                <img src="{{ asset('looksyassets/images/cat4.jpg') }}" class="img-responsive" alt="author">
                            </div>
                            <div class="team-text">
                                <div class="team-name">RESTAURANT</div> 
                                <h3>Katz's Delicatessen</h3>
                                <p>$125 per person</p>
                            </div>
                        </div>
                    </div>
                    <!-- end team member item -->
                </div>
            </div>
        </section>
        <section id="footer-main">
            <div class="container">
                
                <div class="row">
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href=""> Home</a></li>
                          <li><a href=""> About</a></li>
                          <li><a href=""> Message</a></li>
                          <li><a href=""> Saved</a></li>
                          <li><a href=""> Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href=""> Help</a></li>
                          <li><a href=""> Support</a></li>                      
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href=""> Term</a></li>
                          <li><a href=""> Privacy</a></li>                      
                          <li><a href=""> Site Map</a></li>                     
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <ul>
                          <li><a href=""> Carrer</a></li>
                          <li><a href=""> Policies</a></li>                     
                          <li><a href=""> Press</a></li>                        
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6 social-icons">
                        <ul>
                          <li><a href=""> <i class="fa fa-facebook"></i></a></li>
                          <li><a href=""> <i class="fa fa-twitter"></i></a></li>                        
                          <li><a href=""> <i class="fa fa-instagram"></i></a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </section>
        @endsection