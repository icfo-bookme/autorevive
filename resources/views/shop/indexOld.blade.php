@extends('layouts.master')
@section('title')
HOME
@endsection
@section('content')
 <div id="fullNav">
    @include('partials.navBar')
 <div>
    @section('styles')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}"> --}}
    <link href="{{asset('styles/shop_styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('styles/shop_responsive.css')}}" rel="stylesheet" type="text/css">
  @endsection
   
@if (isset($anchor))
<input type="hidden" name="anchor" id="anchor" value="{{ $anchor }}">
@endif

@if (isset($message))
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong>Thank You!</strong> {{$message}}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif



{{-- banner --}}
<div class="banner">
    <div class="banner_background" style="background-image:url({{ asset('img/images/banner_background.jpg') }})"></div>
    <div class="container fill_height">
        <div class="row fill_height">
            <div class="banner_product_image responsive-image">
                <img src="{{ asset($websiteDetails->banner_image_path) }}" alt="">
            </div> 
            <div class="col-lg-5 offset-lg-4 fill_height">
                <div class="banner_content mb-3">
                    <h1 class="banner_text">{{ $websiteDetails->banner_text }}</h1>
                    <div class="banner_price"></div>
                    <div class="banner_product_name"></div>
                    <div class="button banner_button"><a href="{{url('shopview')}}">Start Buying</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="banner">
    <div class="banner_background" style="background-image:url({{ asset('img/images/banner_background.jpg') }})"></div>
    <div class="container fill_height">
        <div class="row fill_height">
            <div class="banner_product_image"><img src="{{ asset('img/images/banner_01.png') }}"  width="1000" height="1000"alt=""></div>
            <div class="col-lg-5 offset-lg-4 fill_height">
                <img src="{{ asset('img/images/right-back-lg-01.png') }}" width="700" height="659" alt="">
            </div>
        </div>
    </div>
</div> --}}
{{-- characteristics --}}

<div class="characteristics">
    <div class="container">
        <div class="row">

            <!-- Char. Item -->
            <div class="col-lg-3 col-md-6 char_col">

                <div class="char_item d-flex flex-row align-items-center justify-content-start">
                    <div class="char_icon"><img src="{{ asset('img/images/char_1.png') }}" alt=""></div>
                    <div class="char_content">
                        <div class="char_title">Free Delivery</div>
                        {{-- <div class="char_subtitle">from ৳50</div> --}}
                    </div>
                </div>
            </div>

            <!-- Char. Item -->
            <div class="col-lg-3 col-md-6 char_col">

                <div class="char_item d-flex flex-row align-items-center justify-content-start">
                    <div class="char_icon"><img src="{{ asset('img/images/char_2.png') }}" alt=""></div>
                    <div class="char_content">
                        <div class="char_title">Replacement</div>
                        {{-- <div class="char_subtitle">from ৳50</div> --}}
                    </div>
                </div>
            </div>

            <!-- Char. Item -->
            <div class="col-lg-3 col-md-6 char_col">

                <div class="char_item d-flex flex-row align-items-center justify-content-start">
                    <div class="char_icon"><img src="{{ asset('img/images/char_3.png') }}" alt=""></div>
                    <div class="char_content">
                        <div class="char_title">Cash on Delivery</div>
                        {{-- <div class="char_subtitle">from ৳50</div> --}}
                    </div>
                </div>
            </div>

            <!-- Char. Item -->
            <div class="col-lg-3 col-md-6 char_col">

                <a href="{{url('contactFormView#contact_form_name')}}">
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">
                        <div class="char_icon"><img src="{{ asset('img/images/boxes.png') }}" alt=""></div>
                        <div class="char_content">
                            <div class="char_title">Whole Sale</div>
                            {{-- <div class="char_subtitle">from ৳50</div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> 
<!-- Popular Categories -->

{{-- <div class="popular_categories">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="popular_categories_content">
                    <div class="popular_categories_title">Popular Categories</div>
                    <div class="popular_categories_slider_nav">
                        <div class="popular_categories_prev popular_categories_nav"><i
                                class="fas fa-angle-left ml-auto"></i></div>
                        <div class="popular_categories_next popular_categories_nav"><i
                                class="fas fa-angle-right ml-auto"></i></div>
                    </div>
                   
                </div>
            </div>

           

            <div class="col-lg-9">
                <div class="popular_categories_slider_container">
                    <div class="owl-carousel owl-theme popular_categories_slider">

                        
                        <div class="owl-item">
                            <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                <div class="popular_category_image"><img src="{{ asset('img/images/popular_1.png') }}"
                                        alt=""></div>
                                <div class="popular_category_text">Smartphones & Tablets</div>
                            </div>
                        </div>

                        
                        <div class="owl-item">
                            <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                <div class="popular_category_image"><img src="{{ asset('img/images/popular_2.png') }}"
                                        alt=""></div>
                                <div class="popular_category_text">Computers & Laptops</div>
                            </div>
                        </div>

                        
                        <div class="owl-item">
                            <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                <div class="popular_category_image"><img src="{{ asset('img/images/popular_3.png') }}"
                                        alt=""></div>
                                <div class="popular_category_text">Gadgets</div>
                            </div>
                        </div>

                        
                        <div class="owl-item">
                            <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                <div class="popular_category_image"><img src="{{ asset('img/images/popular_4.png') }}"
                                        alt=""></div>
                                <div class="popular_category_text">Video Games & Consoles</div>
                            </div>
                        </div>

                        
                        <div class="owl-item">
                            <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                <div class="popular_category_image"><img src="{{ asset('img/images/popular_5.png') }}"
                                        alt=""></div>
                                <div class="popular_category_text">Accessories</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- test section from shop UI  start--}}
<div class="shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                
                <!-- Shop Content -->

                <div class="shop_content">
                    <div class="shop_bar clearfix">
                        <h4>Featured Products</h4>
                    </div>

                    <div class="product_grid">
                        <div class="product_grid_border"></div>

                        <!-- Product Item -->
                        {{-- <div class="product_item is_new">
                            <div class="product_border"></div>
                            <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="images/new_5.jpg" alt=""></div>
                            <div class="product_content">
                                <div class="product_price">$225</div>
                                <div class="product_name"><div><a href="#" tabindex="0">Philips BT6900A</a></div></div>
                            </div>
                            <div class="product_fav"><i class="fas fa-heart"></i></div>
                            <ul class="product_marks">
                                <li class="product_mark product_discount">-25%</li>
                                <li class="product_mark product_new">new</li>
                            </ul>
                        </div> --}}

                        @foreach ($fProduct as $item)
                        <div class="product_item is_new">
                            <div class="product_border"></div>
                            <a href="{{url('singleProductDetails',$item->id)}}" tabindex="0">
                                <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset($item->thumbnail) }}" alt="">
                                </div>
                            </a>
                            <div class="product_content">
                                <div class="product_price">৳{{$item->sales_price}}</div>
                                <div class="product_name">
                                    <div class="px-2 text-truncate">
                                        <a href="{{url('singleProductDetails',$item->id)}}" tabindex="0">
                                            {{$item->category->name}}<small style="font-size: 55%">(Min Order {{$item->minimum_order_quantity}})</small>
                                        </a>
                                    </div>
                                </div>
                                <button class="btn customized-btn" onclick="addToCart({{$item->id}})">Add to Cart</button>
                            </div>
                        </div>
                        @endforeach

                        <!-- Product Item -->


                    </div>
                    <div class="float-right">
                       {{$fProduct->links()}}

                    </div>

                    <!-- Shop Page Navigation -->

                    {{-- <div class="shop_page_nav d-flex flex-row">
                        <div class="page_prev d-flex flex-column align-items-center justify-content-center"><i class="fas fa-chevron-left"></i></div>
                        <ul class="page_nav d-flex flex-row">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">21</a></li>
                        </ul>
                        <div class="page_next d-flex flex-column align-items-center justify-content-center"><i class="fas fa-chevron-right"></i></div>
                    </div> --}}

                </div>

            </div>
        </div>
    </div>
</div>
{{-- test section from shop UI end --}}




{{-- Best Sales  start--}}
<div class="shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <!-- Shop Content -->

                <div class="shop_content">
                    <div class="shop_bar clearfix">
                        <h4>Best Sales</h4>
                    </div>

                    <div class="product_grid">
                        <div class="product_grid_border"></div>

                        @foreach ($topOrders as $topOrder)
                        <div class="product_item is_new">
                            <div class="product_border"></div>
                            <a href="{{url('singleProductDetails',$topOrder->item->id)}}" tabindex="0">
                                <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset($topOrder->item->thumbnail) }}" alt="">
                                </div>
                            </a>
                            <div class="product_content">
                                <div class="product_price">৳{{$topOrder->item->sales_price}}</div>
                                <div class="product_name">
                                    <div class="px-2 text-truncate">
                                        <a href="{{url('singleProductDetails',$topOrder->item->id)}}" tabindex="0">
                                            {{$topOrder->item->category->name}}<small style="font-size: 55%">(Min Order
                                                {{$topOrder->item->minimum_order_quantity}})</small>
                                        </a>
                                    </div>
                                </div>
                                <button class="btn customized-btn" onclick="addToCart({{$topOrder->item->id}})">Add to
                                    Cart</button>
                            </div>
                        </div>
                        @endforeach

                      
                        
                    </div>

                    

                </div>
                <div class="float-right">
                   {{$topOrders->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
{{-- Best Sales - end --}}


<!-- Hot New Arrivals -->

{{-- <div class="new_arrivals pb-0">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="tabbed_container">
                    <div class="tabs clearfix tabs-right">
                        <div class="new_arrivals_title">ALL ITEMS</div>
                        <ul class="clearfix">
                            <li class="active"></li> --}}
                            {{-- <li>@if(!empty($categoryOne)){{$categoryOne->name}}@endif</li>
                            <li>@if(!empty($categoryTwo)){{$categoryTwo->name}}@endif</li> --}}
                        {{-- </ul>
                        <div class="tabs_line"><span></span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="z-index:1;">

                            <!-- Product Panel -->
                            <div class="product_panel panel active">
                                <div class="arrivals_slider slider">
                                    @if($allProducts)
                                    @foreach($allProducts as $item)
                                    <!-- Slider Item -->
                                    
                                    <div class="arrivals_slider_item">
                                        <div class="border_active"></div>
                                        <div
                                            class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                         
                                           
                                            <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                                 <a href="{{url('singleProductDetails',$item->id)}}">
                                                    <img src="{{ asset($item->thumbnail) }}" alt="">
                                                </a>
                                                        </div> --}}

                                                        {{-- <div class="thumb-group">
                                                            <div class="yith-wcwl-add-to-wishlist">
                                                                <div class="yith-wcwl-add-button">
                                                                    <a href="#">Add to Wishlist</a>
                                                                </div>
                                                            </div>
                                                            <a href="#" class="button quick-wiew-button">Quick View</a>
                                                            <div class="loop-form-add-to-cart">
                                                                <button class="single_add_to_cart_button button">Add to cart</button>
                                                            </div>
                                                        </div> --}}

                                        
                                            {{-- <div class="product_content">
                                                <div class="product_price">৳{{$item->sales_price}}</div>
                                                <div class="product_name">
                                                    <div class="px-2"><a href="{{url('singleProductDetails',$item->id)}}" style="white-space: normal;">{{$item->name}}<small style="font-size: 55%">(Min Order {{$item->minimum_order_quantity}})</small></a></div>
                                                </div>
                                                <div class="product_extras"> --}}
                                                    {{-- <div class="product_color">
                                                        <input type="radio" checked name="product_color"
                                                            style="background:#b19c83">
                                                        <input type="radio" name="product_color"
                                                            style="background:#000000">
                                                        <input type="radio" name="product_color"
                                                            style="background:#999999">
                                                    </div> --}}
                                                    {{-- <button class="product_cart_button" onclick="addToCart({{$item->id}})">Add to Cart</button>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="product_fav"><i class="fas fa-heart"></i></div> --}}
                                            {{-- <ul class="product_marks"> --}}
                                                {{-- <li class="product_mark product_discount">-25%</li> --}}
                                                {{-- <li class="product_mark product_new">new</li> --}}
                                            {{-- </ul> --}}
                                        {{-- </div>
                                    </div>

                                    @endforeach
                                    @endif
                                </div>
                                <div class="arrivals_slider_dots_cover"></div>
                            </div>

                        </div>
                        @if(isset($fProduct))
                        
                        
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- 
<div class="deals_featured">
    <div class="container">
        <div class="row">
            <div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">

                <!-- Deals -->

                <div class="deals">
                    <div class="deals_title">Deals of the Week</div>
                    <div class="deals_slider_container">

                        <!-- Deals Slider -->
                        <div class="owl-carousel owl-theme deals_slider">

                            <!-- Deals Item -->
                            
                            @foreach($dealOfTheWeek as $deal)
                            <div class="owl-item deals_item">
                                <div class="deals_image">
                                    <a href="{{url('singleProductDetails',$deal->id)}}">
                                        <img src="{{asset($deal->thumbnail)}}" alt="">
                                    </a>
                                    
                                </div>
                                <div class="deals_content">
                                    <div class="deals_info_line d-flex flex-row justify-content-start">
                                    <div class="deals_item_category"><a href="#">{{$deal->category->name}}</a></div>
                                    <div class="deals_item_price_a ml-auto">৳{{$deal->regular_price}}</div>
                                    </div>
                                    <div class="deals_info_line d-flex flex-row justify-content-start">
                                    <div class="deals_item_name"><a href="{{url('singleProductDetails',$deal->id)}}">{{$deal->name}}</a></div>
                                        <div class="deals_item_price ml-auto">৳{{$deal->sales_price}}</div>
                                    </div>
                                   
                                    <div class="deals_timer d-flex flex-row align-items-center justify-content-start">
                                        <div class="deals_timer_title_container">
                                            <div class="deals_timer_title">Hurry Up</div>
                                            <div class="deals_timer_subtitle">Offer ends in:</div>
                                        </div>
                                        <div class="deals_timer_content ml-auto">
                                            <div class="deals_timer_box clearfix" data-target-time="">
                                                <div class="deals_timer_unit">
                                                    <div id="deals_timer1_hr" class="deals_timer_hr"></div>
                                                    <span>hours</span>
                                                </div>
                                                <div class="deals_timer_unit">
                                                    <div id="deals_timer1_min" class="deals_timer_min"></div>
                                                    <span>mins</span>
                                                </div>
                                                <div class="deals_timer_unit">
                                                    <div id="deals_timer1_sec" class="deals_timer_sec"></div>
                                                    <span>secs</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="text-center py-3">
                                        <button class="btn btn-primary text-white btn-block deals_addto_cart_btn" onclick="addToCart({{$deal->id}})" role="button">Add to Cart</button>
                                    </div>
                                   
                                </div>
                            </div>
                            @endforeach

                           

                          

                        </div>

                    </div>

                    <div class="deals_slider_nav_container">
                        <div class="deals_slider_prev deals_slider_nav"><i class="fas fa-chevron-left ml-auto"></i>
                        </div>
                        <div class="deals_slider_next deals_slider_nav"><i class="fas fa-chevron-right ml-auto"></i>
                        </div>
                    </div>
                </div>

               <!-- Featured -->
                 <div class="featured">
                     <div class="tabbed_container">
                         <div class="tabs">
                             <ul class="clearfix">
                                 <li class="active">Featured</li>
                                 <li>On Sale</li>
                                 <li>Best Rated</li>
                             </ul>
                             <div class="tabs_line"><span></span></div>
                         </div>

                         <!-- Product Panel -->
                         <div class="product_panel panel active" id="allProductsAjaxLoad">
                             <div class="featured_slider slider">

                                 <!-- Slider Item -->
								 @foreach($featuredProducts as $item)
                                 <div class="featured_slider_item">
                                     <div class="border_active"></div>
                                     <div
                                         class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                         <a href="{{url('singleProductDetails',$item->id)}}">
                                             <div
                                             class="product_image d-flex flex-column align-items-center justify-content-center">
                                             <img src="{{asset($item->thumbnail)}}" alt=""></div></a>
                                         <div class="product_content">
                                               <div class="product_price discount">৳{{$item->sales_price}}<span>৳{{$item->regular_price}}</span></div>
                                             <div class="product_name">
                                                 <div><a href="{{url('singleProductDetails',$item->id)}}">{{$item->name}}</a></div>
                                             </div>
                                             <div class="product_extras">
                                                 <div class="product_color">
                                                     <input type="radio" checked name="product_color"
                                                         style="background:#b19c83">
                                                     <input type="radio" name="product_color"
                                                         style="background:#000000">
                                                     <input type="radio" name="product_color"
                                                         style="background:#999999">
                                                 </div>
                                                 <button class="product_cart_button active" onclick="addToCart({{$item->id}})">Add to Cart</button>
                                             </div>
                                         </div>
                                         <div class="product_fav"><i class="fas fa-heart"></i></div>
                                         <ul class="product_marks">
                                             <li class="product_mark product_discount"></li>
                                             <li class="product_mark product_new">new</li>
                                         </ul>
                                     </div>
								 </div>
								 @endforeach
							
                             </div>
                             <div class="featured_slider_dots_cover"></div>
                         </div>

                         <!-- Product Panel -->

                         <div class="product_panel panel">
                             <div class="featured_slider slider">

                                  <!-- Slider Item -->
								 @foreach($onsaleProducts as $item)
                                 <div class="featured_slider_item">
                                     <div class="border_active"></div>
                                     <div
                                         class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                        <a href="{{url('singleProductDetails',$item->id)}}">
                                            <div
                                             class="product_image d-flex flex-column align-items-center justify-content-center">
                                             <img src="{{asset($item->thumbnail)}}" alt=""></div></a>
                                         <div class="product_content">
                                               <div class="product_price discount">৳{{$item->sales_price}}<span>৳{{$item->regular_price}}</span></div>
                                             <div class="product_name">
                                                 <div><a href="{{url('singleProductDetails',$item->id)}}">{{$item->name}}</a></div>
                                             </div>
                                             <div class="product_extras">
                                                 <div class="product_color">
                                                     <input type="radio" checked name="product_color"
                                                         style="background:#b19c83">
                                                     <input type="radio" name="product_color"
                                                         style="background:#000000">
                                                     <input type="radio" name="product_color"
                                                         style="background:#999999">
                                                 </div>
                                                 <button class="product_cart_button active" onclick="addToCart({{$item->id}})">Add to Cart</button>
                                             </div>
                                         </div>
                                         <div class="product_fav"><i class="fas fa-heart"></i></div>
                                         <ul class="product_marks">
                                             <li class="product_mark product_discount"></li>
                                             <li class="product_mark product_new">new</li>
                                         </ul>
                                     </div>
								 </div>
								 @endforeach

                             </div>
                             <div class="featured_slider_dots_cover"></div>
                         </div>

                         <!-- Product Panel -->

                         <div class="product_panel panel">
                             <div class="featured_slider slider">

                                 <!-- Slider Item -->
								 @foreach($bestRatedProduct as $item)
                                 <div class="featured_slider_item">
                                     <div class="border_active"></div>
                                     <div
                                         class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                        <a href="{{url('singleProductDetails',$item->id)}}">
                                            <div
                                             class="product_image d-flex flex-column align-items-center justify-content-center">
                                             <img src="{{asset($item->thumbnail)}}" alt=""></div></a>
                                         <div class="product_content">
                                               <div class="product_price discount">৳{{$item->sales_price}}<span>৳{{$item->regular_price}}</span></div>
                                             <div class="product_name">
                                                 <div><a href="{{url('singleProductDetails',$item->id)}}">{{$item->name}}</a></div>
                                             </div>
                                             <div class="product_extras">
                                                 <div class="product_color">
                                                     <input type="radio" checked name="product_color"
                                                         style="background:#b19c83">
                                                     <input type="radio" name="product_color"
                                                         style="background:#000000">
                                                     <input type="radio" name="product_color"
                                                         style="background:#999999">
                                                 </div>
                                                 <button class="product_cart_button active" onclick="addToCart({{$item->id}})">Add to Cart</button>
                                             </div>
                                         </div>
                                         <div class="product_fav"><i class="fas fa-heart"></i></div>
                                         <ul class="product_marks">
                                             <li class="product_mark product_discount"></li>
                                             <li class="product_mark product_new">new</li>
                                         </ul>
                                     </div>
								 </div>
								 @endforeach

                             </div>
                             <div class="featured_slider_dots_cover"></div>
                         </div>

                     </div>
                 </div>

            </div>
        </div>
    </div>
</div> --}}

{{-- @endif --}}

<!-- Adverts -->

{{-- <div class="adverts">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 advert_col">

         

                <div class="advert d-flex flex-row align-items-center justify-content-start">
                    <div class="advert_content">
                        <div class="advert_title"><a href="#">Trends 2018</a></div>
                        <div class="advert_text">Lorem ipsum dolor sit amet, consectetur adipiscing Donec et.</div>
                    </div>
                    <div class="ml-auto">
                        <div class="advert_image"><img src="{{ asset('img/images/adv_1.png') }}" alt=""></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 advert_col">

              

                <div class="advert d-flex flex-row align-items-center justify-content-start">
                    <div class="advert_content">
                        <div class="advert_subtitle">Trends 2018</div>
                        <div class="advert_title_2"><a href="#">Sale -45%</a></div>
                        <div class="advert_text">Lorem ipsum dolor sit amet, consectetur.</div>
                    </div>
                    <div class="ml-auto">
                        <div class="advert_image"><img src="{{ asset('img/images/adv_2.png') }}" alt=""></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 advert_col">


                <div class="advert d-flex flex-row align-items-center justify-content-start">
                    <div class="advert_content">
                        <div class="advert_title"><a href="#">Trends 2018</a></div>
                        <div class="advert_text">Lorem ipsum dolor sit amet, consectetur.</div>
                    </div>
                    <div class="ml-auto">
                        <div class="advert_image"><img src="{{ asset('img/images/adv_3.png') }}" alt=""></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> --}}

<!-- Trends -->

{{-- <div class="trends">
    <div class="trends_background" style="background-image:url({{ asset('img/images/trends_background.jpg') }})"></div>
    <div class="trends_overlay"></div>
    <div class="container">
        <div class="row">

            <!-- Trends Content -->
            <div class="col-lg-3">
                <div class="trends_container">
                    <h2 class="trends_title">Trends 2018</h2>
                    <div class="trends_text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing Donec et.</p>
                    </div>
                    <div class="trends_slider_nav">
                        <div class="trends_prev trends_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                        <div class="trends_next trends_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                    </div>
                </div>
            </div>

            <!-- Trends Slider -->
            <div class="col-lg-9">
                <div class="trends_slider_container">
                    <!-- Trends Slider -->

                    <div class="owl-carousel owl-theme trends_slider">

                        <!-- Trends Slider Item -->
                        <div class="owl-item">
                            <div class="trends_item is_new">
                                <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset('img/images/trends_1.jpg') }}" alt=""></div>
                                <div class="trends_content">
                                    <div class="trends_category"><a href="#">Smartphones</a></div>
                                    <div class="trends_info clearfix">
                                        <div class="trends_name"><a href="product.html">Jump White</a></div>
                                        <div class="trends_price">$379</div>
                                    </div>
                                </div>
                                <ul class="trends_marks">
                                    <li class="trends_mark trends_discount">-25%</li>
                                    <li class="trends_mark trends_new">new</li>
                                </ul>
                                <div class="trends_fav"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>

                        <!-- Trends Slider Item -->
                        <div class="owl-item">
                            <div class="trends_item">
                                <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset('img/images/trends_2.jpg') }}" alt=""></div>
                                <div class="trends_content">
                                    <div class="trends_category"><a href="#">Smartphones</a></div>
                                    <div class="trends_info clearfix">
                                        <div class="trends_name"><a href="product.html">Samsung Charm...</a></div>
                                        <div class="trends_price">$379</div>
                                    </div>
                                </div>
                                <ul class="trends_marks">
                                    <li class="trends_mark trends_discount">-25%</li>
                                    <li class="trends_mark trends_new">new</li>
                                </ul>
                                <div class="trends_fav"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>

                        <!-- Trends Slider Item -->
                        <div class="owl-item">
                            <div class="trends_item is_new">
                                <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset('img/images/trends_3.jpg') }}" alt=""></div>
                                <div class="trends_content">
                                    <div class="trends_category"><a href="#">Smartphones</a></div>
                                    <div class="trends_info clearfix">
                                        <div class="trends_name"><a href="product.html">DJI Phantom 3...</a></div>
                                        <div class="trends_price">$379</div>
                                    </div>
                                </div>
                                <ul class="trends_marks">
                                    <li class="trends_mark trends_discount">-25%</li>
                                    <li class="trends_mark trends_new">new</li>
                                </ul>
                                <div class="trends_fav"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>

                        <!-- Trends Slider Item -->
                        <div class="owl-item">
                            <div class="trends_item is_new">
                                <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset('img/images/trends_1.jpg') }}" alt=""></div>
                                <div class="trends_content">
                                    <div class="trends_category"><a href="#">Smartphones</a></div>
                                    <div class="trends_info clearfix">
                                        <div class="trends_name"><a href="product.html">Jump White</a></div>
                                        <div class="trends_price">$379</div>
                                    </div>
                                </div>
                                <ul class="trends_marks">
                                    <li class="trends_mark trends_discount">-25%</li>
                                    <li class="trends_mark trends_new">new</li>
                                </ul>
                                <div class="trends_fav"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>

                        <!-- Trends Slider Item -->
                        <div class="owl-item">
                            <div class="trends_item">
                                <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset('img/images/trends_2.jpg') }}" alt=""></div>
                                <div class="trends_content">
                                    <div class="trends_category"><a href="#">Smartphones</a></div>
                                    <div class="trends_info clearfix">
                                        <div class="trends_name"><a href="product.html">Jump White</a></div>
                                        <div class="trends_price">$379</div>
                                    </div>
                                </div>
                                <ul class="trends_marks">
                                    <li class="trends_mark trends_discount">-25%</li>
                                    <li class="trends_mark trends_new">new</li>
                                </ul>
                                <div class="trends_fav"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>

                        <!-- Trends Slider Item -->
                        <div class="owl-item">
                            <div class="trends_item is_new">
                                <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset('img/images/trends_3.jpg') }}" alt=""></div>
                                <div class="trends_content">
                                    <div class="trends_category"><a href="#">Smartphones</a></div>
                                    <div class="trends_info clearfix">
                                        <div class="trends_name"><a href="product.html">Jump White</a></div>
                                        <div class="trends_price">$379</div>
                                    </div>
                                </div>
                                <ul class="trends_marks">
                                    <li class="trends_mark trends_discount">-25%</li>
                                    <li class="trends_mark trends_new">new</li>
                                </ul>
                                <div class="trends_fav"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div> --}}

<!-- Reviews -->

{{-- <div class="reviews">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="reviews_title_container">
                    <h3 class="reviews_title">Latest Reviews</h3>
                    <div class="reviews_all ml-auto"><a href="#">view all <span>reviews</span></a></div>
                </div>

                <div class="reviews_slider_container">

                    <!-- Reviews Slider -->
                    <div class="owl-carousel owl-theme reviews_slider">

                        <!-- Reviews Slider Item -->
                        <div class="owl-item">
                            <div class="review d-flex flex-row align-items-start justify-content-start">
                                <div>
                                    <div class="review_image"><img src="{{ asset('img/images/review_1.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="review_content">
                                    <div class="review_name">Roberto Sanchez</div>
                                    <div class="review_rating_container">
                                        <div class="rating_r rating_r_4 review_rating">
                                            <i></i><i></i><i></i><i></i><i></i></div>
                                        <div class="review_time">2 day ago</div>
                                    </div>
                                    <div class="review_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum
                                            laoreet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Slider Item -->
                        <div class="owl-item">
                            <div class="review d-flex flex-row align-items-start justify-content-start">
                                <div>
                                    <div class="review_image"><img src="{{ asset('img/images/review_2.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="review_content">
                                    <div class="review_name">Brandon Flowers</div>
                                    <div class="review_rating_container">
                                        <div class="rating_r rating_r_4 review_rating">
                                            <i></i><i></i><i></i><i></i><i></i></div>
                                        <div class="review_time">2 day ago</div>
                                    </div>
                                    <div class="review_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum
                                            laoreet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Slider Item -->
                        <div class="owl-item">
                            <div class="review d-flex flex-row align-items-start justify-content-start">
                                <div>
                                    <div class="review_image"><img src="{{ asset('img/images/review_3.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="review_content">
                                    <div class="review_name">Emilia Clarke</div>
                                    <div class="review_rating_container">
                                        <div class="rating_r rating_r_4 review_rating">
                                            <i></i><i></i><i></i><i></i><i></i></div>
                                        <div class="review_time">2 day ago</div>
                                    </div>
                                    <div class="review_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum
                                            laoreet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Slider Item -->
                        <div class="owl-item">
                            <div class="review d-flex flex-row align-items-start justify-content-start">
                                <div>
                                    <div class="review_image"><img src="{{ asset('img/images/review_1.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="review_content">
                                    <div class="review_name">Roberto Sanchez</div>
                                    <div class="review_rating_container">
                                        <div class="rating_r rating_r_4 review_rating">
                                            <i></i><i></i><i></i><i></i><i></i></div>
                                        <div class="review_time">2 day ago</div>
                                    </div>
                                    <div class="review_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum
                                            laoreet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Slider Item -->
                        <div class="owl-item">
                            <div class="review d-flex flex-row align-items-start justify-content-start">
                                <div>
                                    <div class="review_image"><img src="{{ asset('img/images/review_2.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="review_content">
                                    <div class="review_name">Brandon Flowers</div>
                                    <div class="review_rating_container">
                                        <div class="rating_r rating_r_4 review_rating">
                                            <i></i><i></i><i></i><i></i><i></i></div>
                                        <div class="review_time">2 day ago</div>
                                    </div>
                                    <div class="review_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum
                                            laoreet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Slider Item -->
                        <div class="owl-item">
                            <div class="review d-flex flex-row align-items-start justify-content-start">
                                <div>
                                    <div class="review_image"><img src="{{ asset('img/images/review_3.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="review_content">
                                    <div class="review_name">Emilia Clarke</div>
                                    <div class="review_rating_container">
                                        <div class="rating_r rating_r_4 review_rating">
                                            <i></i><i></i><i></i><i></i><i></i></div>
                                        <div class="review_time">2 day ago</div>
                                    </div>
                                    <div class="review_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum
                                            laoreet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="reviews_dots"></div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Recently Viewed -->

{{-- <div class="viewed">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="viewed_title_container">
                    <h3 class="viewed_title">Recently Viewed</h3>
                    <div class="viewed_nav_container">
                        <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
                        <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
                    </div>
                </div>

                <div class="viewed_slider_container">

                    <!-- Recently Viewed Slider -->

                    <div class="owl-carousel owl-theme viewed_slider">

                        <!-- Recently Viewed Item -->
                        <div class="owl-item">
                            <div
                                class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="viewed_image"><img src="{{ asset('img/images/view_1.jpg') }}" alt=""></div>
                                <div class="viewed_content text-center">
                                    <div class="viewed_price">$225<span>$300</span></div>
                                    <div class="viewed_name"><a href="#">Beoplay H7</a></div>
                                </div>
                                <ul class="item_marks">
                                    <li class="item_mark item_discount">-25%</li>
                                    <li class="item_mark item_new">new</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Recently Viewed Item -->
                        <div class="owl-item">
                            <div
                                class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="viewed_image"><img src="{{ asset('img/images/view_2.jpg') }}" alt=""></div>
                                <div class="viewed_content text-center">
                                    <div class="viewed_price">$379</div>
                                    <div class="viewed_name"><a href="#">LUNA Smartphone</a></div>
                                </div>
                                <ul class="item_marks">
                                    <li class="item_mark item_discount">-25%</li>
                                    <li class="item_mark item_new">new</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Recently Viewed Item -->
                        <div class="owl-item">
                            <div
                                class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="viewed_image"><img src="{{ asset('img/images/view_3.jpg') }}" alt=""></div>
                                <div class="viewed_content text-center">
                                    <div class="viewed_price">$225</div>
                                    <div class="viewed_name"><a href="#">Samsung J730F...</a></div>
                                </div>
                                <ul class="item_marks">
                                    <li class="item_mark item_discount">-25%</li>
                                    <li class="item_mark item_new">new</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Recently Viewed Item -->
                        <div class="owl-item">
                            <div
                                class="viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="viewed_image"><img src="{{ asset('img/images/view_4.jpg') }}" alt=""></div>
                                <div class="viewed_content text-center">
                                    <div class="viewed_price">$379</div>
                                    <div class="viewed_name"><a href="#">Huawei MediaPad...</a></div>
                                </div>
                                <ul class="item_marks">
                                    <li class="item_mark item_discount">-25%</li>
                                    <li class="item_mark item_new">new</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Recently Viewed Item -->
                        <div class="owl-item">
                            <div
                                class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="viewed_image"><img src="{{ asset('img/images/view_5.jpg') }}" alt=""></div>
                                <div class="viewed_content text-center">
                                    <div class="viewed_price">$225<span>$300</span></div>
                                    <div class="viewed_name"><a href="#">Sony PS4 Slim</a></div>
                                </div>
                                <ul class="item_marks">
                                    <li class="item_mark item_discount">-25%</li>
                                    <li class="item_mark item_new">new</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Recently Viewed Item -->
                        <div class="owl-item">
                            <div
                                class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="viewed_image"><img src="{{ asset('img/images/view_6.jpg') }}" alt=""></div>
                                <div class="viewed_content text-center">
                                    <div class="viewed_price">$375</div>
                                    <div class="viewed_name"><a href="#">Speedlink...</a></div>
                                </div>
                                <ul class="item_marks">
                                    <li class="item_mark item_discount">-25%</li>
                                    <li class="item_mark item_new">new</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


<!-- Hot New Arrivals -->



<!-- Brands -->

{{-- <div class="brands">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="brands_slider_container">

                    <!-- Brands Slider -->

                    <div class="owl-carousel owl-theme brands_slider">

                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_1.jpg') }}" alt=""></div>
                        </div>
                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_2.jpg') }}" alt=""></div>
                        </div>
                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_3.jpg') }}" alt=""></div>
                        </div>
                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_4.jpg') }}" alt=""></div>
                        </div>
                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_5.jpg') }}" alt=""></div>
                        </div>
                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_6.jpg') }}" alt=""></div>
                        </div>
                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_7.jpg') }}" alt=""></div>
                        </div>
                        <div class="owl-item">
                            <div class="brands_item d-flex flex-column justify-content-center"><img
                                    src="{{ asset('img/images/brands_8.jpg') }}" alt=""></div>
                        </div>

                    </div>

                    <!-- Brands Slider Navigation -->
                    <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
                    <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>

                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Newsletter -->

{{-- <div class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col">
                <div
                    class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                    <div class="newsletter_title_container">
                        <div class="newsletter_icon"><img src="{{ asset('img/images/send.png') }}" alt=""></div>
                        <div class="newsletter_title">Sign up for Newsletter</div>
                        <div class="newsletter_text">
                            <p>...and receive %20 coupon for first shopping.</p>
                        </div>
                    </div>
                    <div class="newsletter_content clearfix">
                        <form action="#" class="newsletter_form">
                            <input type="email" class="newsletter_input" required="required"
                                placeholder="Enter your email address">
                            <button class="newsletter_button">Subscribe</button>
                        </form>
                        <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


<script>


// $(document).ready(function(){


//      $.ajax({
//             url: '{{url("getSidecartData")}}',
//             type: 'get',
//             success: function (response) {
//               $('#sideNavCartData').html(response);
//             },
//             error: function () {
//             alert("error");
//             }
//         });

// })

$(document).ready(function(){
let slider = $("#slider__new");

slider.not('.slick-initialized').slick({
  autoplay: true,
  vertical: false,
  dots: true,
  arrows: false,
  slidesToShow: 4,
  slidesToScroll: 4,
  customPaging: function(slider, i) {},
  responsive: [ {
    breakpoint: 320,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  }, {
    breakpoint: 360,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  },
  {
    breakpoint: 375,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  },
  {
    breakpoint: 384,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  },
  {
    breakpoint: 400,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  },
  {
    breakpoint: 412,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  },
  {
    breakpoint: 414,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  },
  {
    breakpoint: 480,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  },
  {
    breakpoint: 575,
    settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows: false,
      vertical: true,
    },
  }
  ]
});
})




    function quantityWiseChangeValue(quantityId,priceId,tdId,price,shippingCharge,productId){
     addToCart(productId);
     var value = 0;
     var quantityVal = parseInt($('#'+quantityId).val())+1;
     $('#'+quantityId).val(quantityVal);
     var total        =  price*quantityVal;
     $('#'+priceId).val(total);
     $('#'+tdId).html('৳'+total);
     var totalAmount = $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();
      
        for ( var i = 0; i < totalAmount.length; i++) {
          value += parseInt(totalAmount[i]);
        }

        
        $('#totalAmount').html('৳'+value);
        $('#totalAmountWithCharge').html('৳'+(value+shippingCharge));   
    
    }







  var globalDataArray      = new Array();
  var globalTotalPages ;

  function addToCart(id){
  var base_url =  {!! json_encode(url('/')) !!}

  $.ajax({
    url: base_url+'/addToCart',
    type: 'POST',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
    success: function (response) {
    // console.log(response);
        alertify.success('Added To the Cart');
      $("#cartSymbol").text(response.cart.totalQty);
      $("#totalCartAmount").text(response.cart.totalPrice);

            $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {
              $('#sideNavCartData').html(response);
              
            },
            error: function () {
            alert("error");
            }
        });


    },
    error: function () {
      alert("error");
    }
  });
  }



  function decreaseToCart(id){
  var base_url =  {!! json_encode(url('/')) !!}

  $.ajax({
    url: base_url+'/decreaseToCart',
    type: 'POST',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
    success: function (response) {
    // console.log(response);
      $("#cartSymbol").text(response.cart.totalQty);
      $("#totalCartAmount").text(response.cart.totalPrice);

            $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {
              $('#sideNavCartData').html(response);
            },
            error: function () {
            alert("error");
            }
        });


    },
    error: function () {
      alert("error");
    }
  });
  }



  function removeItem(id){
      $.ajax({
          url: '{{ url("removeItemFromCart") }}',
          type: 'POST',
          data:{
            "_token"  : "{{ csrf_token() }}",
            "item_id" : id
          },
          success: function (response) {
          
            $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {
              $('#sideNavCartData').html(response);
              var totalPrice = $('#getTotalAmount').val();
              var totalQuantity = $('#getTotalQuantity').val();
              
              if(totalQuantity>0){
              $("#cartSymbol").text(totalQuantity);
              $("#totalCartAmount").text(totalPrice);
              }else{
                   $("#cartSymbol").text(0);
                   $("#totalCartAmount").text(0);
              }

            },
            error: function () {
            alert("error");
            }
        });


          },
          error: function () {
            // alert("error");
          }
        });
    }

    

//open cart
    function openNav() {

    if ($(window).width() <= 700) {
		var size = '100vw';
    }else{
        var size = '35vw';
    }

     document.getElementById("mySidenav").style.width = size;


    $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {

              $('#sideNavCartData').html(response);

            },
            error: function () {
            alert("error");
            }
        });    



    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }







    function minusQuantity(quantityId,priceId,tdId,price,shippingCharge,productId){
    var quantityVal = parseInt($('#'+quantityId).val());

    if (quantityVal > 1) {
     decreaseToCart(productId);
     var value = 0;
    
     $('#'+quantityId).val(quantityVal-1);
     var total        =  price*quantityVal;
     $('#'+priceId).val(total);
     $('#'+tdId).html('৳'+total);
     var totalAmount = $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();
      
        for ( var i = 0; i < totalAmount.length; i++) {
          value += parseInt(totalAmount[i]);
        }

        
        $('#totalAmount').html('৳'+value);
        $('#totalAmountWithCharge').html('৳'+(value+shippingCharge));   

    }else{

    }
     
  }


</script>

@endsection
{{-- @include('partials.footer') --}}

@push('footerasset')

<script src="{{asset('styles/bootstrap4/popper.js')}}"></script>
<script src="{{asset('styles/bootstrap4/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('plugins/slick-1.8.0/slick.js')}}"></script>
<script src="{{asset('plugins/easing/easing.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>

<script src="{{ asset('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script>
<script src="{{ asset('js/shop_custom.js') }}"></script>

@endpush

{{-- @push('footerasset')

<script src="{{ asset('styles/bootstrap4/popper.js') }}"></script>
<script src="{{ asset('styles/bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TweenMax.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TimelineMax.min.js') }}"></script>
<script src="{{ asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/animation.gsap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
<script src="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
<script src="{{ asset('plugins/easing/easing.js') }}"></script>
<script src="{{ asset('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script>
<script src="{{ asset('js/shop_custom.js') }}"></script>

@endpush --}}
