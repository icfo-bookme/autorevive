@extends('layouts.master')

@section('title')
HOME
@endsection

@section('slider')
@include('partials.slider')
@endsection

@section('content')

@section('styles')
{{-- <link href="{{asset('styles/shop_styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('styles/shop_responsive.css')}}" rel="stylesheet" type="text/css"> --}}
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

<section>
    <div class="shipping_area shipping_three mb-75">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-12 col-md-12 col-lg-10">
                    <div class="car-model-select p-5">
                        <div class="text-center">
                            <h2 class="text-white"> <img src="{{asset('mazley_assets/img/car-select.png')}}"> Select
                                Your Car</h2>
                        </div>
                        <form id="carSearchForm">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2">
                                    <label class="text-white">Company</label>
                                    <select class="custom-select w-100 my-select" id="car_company">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->car_company }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="text-white">Brand</label>
                                    <select class="custom-select w-100 my-select" id="car_brand">
                                        <option value="">Select Brand</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="text-white">Model</label>
                                    <select class="custom-select w-100 my-select" id="car_model">
                                        <option value="">Select Model</option>
                                    </select>
                                </div>
                                {{-- <div class="col-sm-2">
                                    <label class="text-white">Engine</label>
                                    <select class="custom-select w-100 my-select">
                                        <option>1998 cc</option>
                                        <option>1995 cc</option>
                                    </select>
                                </div> --}}
                                <div class="col-sm-2 d-flex">
                                    <button id="searchCar" class="car-finder__button align-self-center"
                                        style="margin-top: 20px">Search</button>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="home_section_bg">
    {{-- search result - start --}}
    <div id="searchResultContainer" style="display: none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                        <div class="title_content">
                            <h2><span>Search</span>Result</h2>
                        </div>
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#Sellers" role="tab"
                                        aria-controls="Sellers" aria-selected="true">
                                        Searched Products
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Sellers" role="tabpanel">
                    <div class="product_carousel product_column6 owl-carousel" id="searchResult">

                        @foreach ($LatestProducts as $item)

                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <a class="secondary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-0%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$item->id)}}" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a href="{{url('singleProductDetails',$item->id)}}">
                                                {{$item->name}}</a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="old_price">৳{{$item->regular_price}}</span>
                                            <span class="current_price">৳{{$item->sales_price}}</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a onclick="addToCart({{$item->id}})"
                                                    title="Add to cart">Add to cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>
    </div>
    {{-- search result - end --}}

    <!--product area start-->
    <div class="product_area product_style3 color_three">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                        <div class="title_content">
                            <h2><span>Latest</span>Collection</h2>
                        </div>
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#Sellers" role="tab"
                                        aria-controls="Sellers" aria-selected="true">
                                        Latest Collection
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Sellers" role="tabpanel">
                    <div class="product_carousel product_column6 owl-carousel">

                        @foreach ($LatestProducts as $item)

                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <a class="secondary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-0%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$item->id)}}" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a href="{{url('singleProductDetails',$item->id)}}">
                                                {{$item->name}}</a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="old_price">৳{{$item->regular_price}}</span>
                                            <span class="current_price">৳{{$item->sales_price}}</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a onclick="addToCart({{$item->id}})"
                                                    title="Add to cart">Add to cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>
    </div>
    <!--product area start-->
    <div class="product_area product_style3 color_three">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                        <div class="title_content">
                            <h2><span>Our</span> Products</h2>
                        </div>
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#Sellers" role="tab"
                                        aria-controls="Sellers" aria-selected="true">
                                        Featured Products
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#topOrders" role="tab" aria-controls="Top"
                                        aria-selected="false">
                                        Top Orders
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#specialOffers" role="tab" aria-controls="special"
                                        aria-selected="false">
                                        Special Offers
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Sellers" role="tabpanel">
                    <div class="product_carousel product_column6 owl-carousel">
                        @isset($fProduct)
                        @foreach ($fProduct as $item)
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <a class="secondary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-0%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$item->id)}}" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a href="{{url('singleProductDetails',$item->id)}}">
                                                {{$item->name}}</a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="old_price">৳{{$item->regular_price}}</span>
                                            <span class="current_price">৳{{$item->sales_price}}</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a onclick="addToCart({{$item->id}})"
                                                    title="Add to cart">Add to cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                        @endforeach
                        @endif
                    </div>

                </div>
                <div class="tab-pane fade" id="topOrders" role="tabpanel">
                    <div class="product_carousel product_column6 owl-carousel">

                        @foreach ($topOrders as $topOrder)
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img"
                                        href="{{url('singleProductDetails',$topOrder->item->id)}}"><img
                                            src="{{ asset($topOrder->item->thumbnail) }}" alt=""></a>
                                    <a class="secondary_img"
                                        href="{{url('singleProductDetails',$topOrder->item->id)}}"><img
                                            src="{{ asset($topOrder->item->thumbnail) }}" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-0%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$topOrder->item->id)}}"
                                            title="quick view"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a
                                                href="{{url('singleProductDetails',$topOrder->item->id)}}">
                                                {{$topOrder->item->name}}</a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="old_price">৳{{$topOrder->item->regular_price}}</span>
                                            <span class="current_price">৳{{$topOrder->item->sales_price}}</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a onclick="addToCart({{$topOrder->item->id}})"
                                                    title="Add to cart">Add to cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                        @endforeach

                    </div>
                </div>
                <div class="tab-pane fade" id="specialOffers" role="tabpanel">
                    <div class="product_carousel product_column6 owl-carousel">
                        @foreach ($specialOffers as $specialOffer)


                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{url('singleProductDetails',$specialOffer->id)}}"><img
                                            src="{{ asset($specialOffer->thumbnail) }}" alt=""></a>
                                    <a class="secondary_img"
                                        href="{{url('singleProductDetails',$specialOffer->id)}}"><img
                                            src="{{ asset($specialOffer->thumbnail) }}" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-48%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$specialOffer->id)}}"
                                            title="quick view"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a
                                                href="#">{{ $specialOffer->category->name }}</a></p>
                                        <h4 class="product_name"><a
                                                href="{{url('singleProductDetails',$specialOffer->id)}}">{{$specialOffer->name}}</a>
                                        </h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="old_price">৳{{$specialOffer->regular_price}}</span>
                                            <span class="current_price">৳{{$specialOffer->sales_price}}</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a onclick="addToCart({{$specialOffer->id}})"
                                                    title="Add to cart">Add to cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                        @endforeach




                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--product area end-->

    {{-- dynamic section appear from here --}}
    @foreach($sections as $section )
    <!--product area start-->
    <div class="product_area product_style3 color_three">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                        <div class="title_content">
                            <h2><span>{{$section->name}}</span></h2>
                        </div>
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#Sellers" role="tab"
                                        aria-controls="Sellers" aria-selected="true">
                                        {{$section->name}}
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Sellers" role="tabpanel">
                    <div class="product_carousel product_column6 owl-carousel">

                        @foreach ($section->items->where('soft_delete',0)->where('is_published',1) as $item)

                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <a class="secondary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ asset($item->thumbnail) }}" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-0%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$item->id)}}" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a href="{{url('singleProductDetails',$item->id)}}">
                                                {{$item->name}}</a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="old_price">৳{{$item->regular_price}}</span>
                                            <span class="current_price">৳{{$item->sales_price}}</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a onclick="addToCart({{$item->id}})"
                                                    title="Add to cart">Add to cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>
    </div>
    @endforeach

    {{-- dynamic section end here --}}
    <!--banner area start-->
    <div class="banner_area mb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="shop.html"><img src="" alt=""></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="shop.html"><img src="" alt=""></a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->

    <!--product area start-->
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                        <div class="title_content">
                            <h2><span>Deal</span> Of The Week</h2>
                            <p>The highest discount products of Automax </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product_container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="product_style_left">
                            @isset($item, $dealOfTheWeek)

                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a class="primary_img"
                                            href="{{url('singleProductDetails',$dealOfTheWeek->id)}}"><img
                                                src="{{ asset($dealOfTheWeek->thumbnail) }}" alt=""></a>
                                        <a class="secondary_img"
                                            href="{{url('singleProductDetails',$dealOfTheWeek->id)}}"><img
                                                src="{{ asset($dealOfTheWeek->thumbnail) }}" alt=""></a>
                                        <div class="label_product">
                                            <span class="label_sale">-52%</span>
                                        </div>
                                    </div>
                                    <div class="product_content">
                                        <p class="manufacture_product"><a
                                                href="#">{{ $dealOfTheWeek->category->name }}</a></p>
                                        <h4 class="product_name"><a
                                                href="{{url('singleProductDetails',$dealOfTheWeek->id)}}">{{ $dealOfTheWeek->name }}</a>
                                        </h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="old_price">{{ $dealOfTheWeek->regular_price }}</span>
                                            <span class="current_price">{{ $dealOfTheWeek->sales_price }}</span>
                                        </div>
                                        <div class="product_desc">
                                            <p>{{ str_limit($dealOfTheWeek->details,140) }}</p>
                                        </div>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart"><a onclick="addToCart({{$dealOfTheWeek->id}})"
                                                        title="Add to cart">Add to cart</a></li>
                                                {{-- <a href="{{url('singleProductDetails',$dealOfTheWeek->id)}}"
                                                title="quick view"><i class="icon-eye"></i></a> --}}
                                                <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                            class="icon-heart"></i></a></li>
                                                <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                            class="icon-rotate-cw"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </figure>
                            </article>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="product_style_right">
                            <div class="row">
                                <div class="product_carousel product_column3 owl-carousel">
                                    @foreach ($onsaleProducts as $onsaleProduct)
                                    <div class="col-lg-3">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img"
                                                        href="{{url('singleProductDetails',$onsaleProduct->id)}}"><img
                                                            src="{{ asset($onsaleProduct->thumbnail) }}" alt=""></a>
                                                    <a class="secondary_img"
                                                        href="{{url('singleProductDetails',$onsaleProduct->id)}}"><img
                                                            src="{{ asset($onsaleProduct->thumbnail) }}" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-44%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="{{url('singleProductDetails',$onsaleProduct->id)}}"
                                                            title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a
                                                                href="#">{{ $onsaleProduct->category->name }}</a></p>
                                                        <h4 class="product_name"><a
                                                                href="{{url('singleProductDetails',$onsaleProduct->id)}}">{{$onsaleProduct->name}}</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li><a href="#"><i
                                                                            class="ion-android-star-outline"></i></a>
                                                                </li>
                                                                <li><a href="#"><i
                                                                            class="ion-android-star-outline"></i></a>
                                                                </li>
                                                                <li><a href="#"><i
                                                                            class="ion-android-star-outline"></i></a>
                                                                </li>
                                                                <li><a href="#"><i
                                                                            class="ion-android-star-outline"></i></a>
                                                                </li>
                                                                <li><a href="#"><i
                                                                            class="ion-android-star-outline"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span
                                                                class="old_price">৳{{$onsaleProduct->regular_price}}</span>
                                                            <span
                                                                class="current_price">৳{{$onsaleProduct->sales_price}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="action_links">
                                                        <ul>
                                                            <li class="add_to_cart"><a
                                                                    onclick="addToCart({{$onsaleProduct->id}})"
                                                                    title="Add to cart">Add to cart</a></li>
                                                            <li class="wishlist"><a href="wishlist.html"
                                                                    title="Add to Wishlist"><i
                                                                        class="icon-heart"></i></a></li>
                                                            <li class="compare"><a href="compare.html"
                                                                    title="Add to Compare"><i
                                                                        class="icon-rotate-cw"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </figure>
                                        </article>
                                    </div>


                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--banner area start-->
    <div class="banner_area banner_style3 mb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <figure class="single_banner">
                        <div class="banner_thumb b_fullwidth_thumb">
                            <a href="{{url('shopview')}}"><img src="{{asset('mazley_assets/img/bg/banner11.jpg')}}"
                                    alt=""></a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>


</div>



<!--home section bg area start-->

<div class="clearfix"></div>







<script>
    $(document).ready(function () {
        // load cart data
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


        /*
            ----------------------------
                Item search dropdowns
            ----------------------------
        */
        $('#car_company').change(function () {
            let company_id = $('#car_company').val();
 
            if (company_id.length <= 0) {
                $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
            } else {
                $.ajax({
                    url: '{{ URL("getBrandByCompanyIdAjax") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: company_id
                    },
                    success: data => {
                        $('#car_brand').html('');
                        if (Object.keys(data).length > 0) {
                            $.each(data, (key, val) => {
                                $('#car_brand').append(`<option value="${val.id}">${val.car_brand}</option>`);
                            });
                        } else {
                            $('#car_brand').html(`<option value="">No option for this company</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });

        $('#car_brand').change(function () {
            let brand_id = $('#car_brand').val();
 
            if (brand_id.length <= 0) {
                $('#car_model').html(`<option value=""> SELECT Model</option>`);
            } else {
                $.ajax({
                    url: '{{ URL("getModelByBrandIdAjax") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: brand_id
                    },
                    success: data => {
                        if (Object.keys(data).length > 0) {
                            $('#car_model').html('');
                            $.each(data, (key, val) => {
                                $('#car_model').append(`<option value="${val.id}">${val.car_model}</option>`);
                            });
                        } else {
                            $('#car_model').html(`<option value="">No option for this brand</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });

        $('#carSearchForm').submit(function () {
            event.preventDefault();

            // if any dropdown is not selected, show error
            if ($('#car_company').val().length == 0 || $('#car_brand').val().length == 0 || $('#car_model').val().length == 0) {
                alertify.alert('Please check input');
            } else {
                let car_company = $('#car_company').val();
                let car_brand = $('#car_brand').val();
                let car_model = $('#car_model').val();

                console.log(`car_company: ${car_company}\n
                    car_brand: ${car_brand}\n
                    car_model: ${car_model}`);

                $.ajax({
                    url: '{{ URL("searchCar") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        company_id: car_company,
                        brand_id: car_brand,
                        model_id: car_model
                    },
                    success: data => {
                        console.log(data); // test 
                        // result div
                        $('#searchResult').html(data)

                        $('#searchResultContainer').css('display', 'block')
                    },
                    error: err => {
                        alertify.alert('An error occured!');
                        console.log(err);
                    }
                });
            }
        })

    })

    $(document).ready(function () {
        let slider = $("#slider__new");

        if ($("[name='anchor']").length) {
            window.location = '#' + $("[name='anchor']").val();
        }

        slider.not('.slick-initialized').slick({
            autoplay: true,
            vertical: false,
            dots: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            customPaging: function (slider, i) {},
            responsive: [{
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




    function quantityWiseChangeValue(quantityId, priceId, tdId, price, shippingCharge, productId) {
        addToCart(productId);
        var value = 0;
        var quantityVal = parseInt($('#' + quantityId).val()) + 1;
        $('#' + quantityId).val(quantityVal);
        var total = price * quantityVal;
        $('#' + priceId).val(total);
        $('#' + tdId).html('৳' + total);
        var totalAmount = $("input[name='price[]']")
            .map(function () {
                return $(this).val();
            }).get();

        for (var i = 0; i < totalAmount.length; i++) {
            value += parseInt(totalAmount[i]);
        }


        $('#totalAmount').html('৳' + value);
        $('#totalAmountWithCharge').html('৳' + (value + shippingCharge));

    }







    var globalDataArray = new Array();
    var globalTotalPages;

    function addToCart(id) {
        var base_url = "{{ url('/') }}";

        $.ajax({
            url: base_url + '/addToCart',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                // console.log(response);
                alertify.success('Added To the Cart');

                $("#cartSymbol").text(response.cart.totalQty);
                $('#cartSymbolTwo').text(response.cart.totalQty);
                $("#totalCartAmount").text('৳' + response.cart.totalPrice);

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



    function decreaseToCart(id) {
        var base_url = "{{ url('/') }}";

        $.ajax({
            url: base_url + '/decreaseToCart',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                // console.log(response);
                $("#cartSymbol").text(response.cart.totalQty);
                $('#cartSymbolTwo').text(response.cart.totalQty);
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



    function removeItem(id) {
        $.ajax({
            url: '{{ url("removeItemFromCart") }}',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "item_id": id
            },
            success: function (response) {

                $.ajax({
                    url: '{{url("getSidecartData")}}',
                    type: 'get',
                    success: function (response) {
                        $('#sideNavCartData').html(response);
                        var totalPrice = $('#getTotalAmount').val();
                        var totalQuantity = $('#getTotalQuantity').val();

                        if (totalQuantity > 0) {
                            $("#cartSymbol").text(totalQuantity);
                            $('#cartSymbolTwo').text(totalQuantity);
                            $("#totalCartAmount").text(totalPrice);
                        } else {
                            $("#cartSymbol").text(0);
                            $('#cartSymbolTwo').text(0);
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
        } else {
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







    function minusQuantity(quantityId, priceId, tdId, price, shippingCharge, productId) {
        var quantityVal = parseInt($('#' + quantityId).val());

        if (quantityVal > 1) {
            decreaseToCart(productId);
            var value = 0;

            $('#' + quantityId).val(quantityVal - 1);
            var total = price * quantityVal;
            $('#' + priceId).val(total);
            $('#' + tdId).html('৳' + total);
            var totalAmount = $("input[name='price[]']")
                .map(function () {
                    return $(this).val();
                }).get();

            for (var i = 0; i < totalAmount.length; i++) {
                value += parseInt(totalAmount[i]);
            }


            $('#totalAmount').html('৳' + value);
            $('#totalAmountWithCharge').html('৳' + (value + shippingCharge));

        } else {

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
<script src="{{ asset('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script>


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
