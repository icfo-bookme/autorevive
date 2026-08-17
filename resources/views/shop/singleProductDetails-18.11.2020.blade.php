@extends('layouts.master')
@section('title')
HOME
@endsection
@section('content')
{{-- @include('partials.navBar') --}}
@section('styles')
{{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
<link href="{{asset('styles/shop_styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('styles/shop_responsive.css')}}" rel="stylesheet" type="text/css"> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{asset('styles/product_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('styles/product_responsive.css')}}"> --}}
@endsection
@if (isset($anchor))
<input type="hidden" name="anchor" id="anchor" value="{{ $anchor }}">
@endif

{{-- mazley theme details UI --}}
<div class="product_page_bg">
    <div class="container">
        <!--product details start-->
        <div class="product_details">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{asset($productDetails->thumbnail)}}"
                                    data-zoom-image="{{asset($productDetails->thumbnail)}}" alt="big-1">
                            </a>
                        </div>
                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                @foreach($productDetails->item_images as $itemImages)
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update=""
                                        data-image="{{asset($itemImages->image_path)}}"
                                        data-zoom-image="{{asset($itemImages->image_path)}}">
                                        <img src="{{asset($itemImages->image_path)}}" alt="zo-th-1" />
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="product_d_right">
                        <form action="#">

                            <h3><a href="#">{{$productDetails->name}}</a></h3>
                            {{-- <div class="product_nav">
                                    <ul>
                                        <li class="prev"><a href="product-details.html"><i class="fa fa-angle-left"></i></a></li>
                                        <li class="next"><a href="variable-product.html"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                </div> --}}
                            <div class="product_rating">
                                <ul>
                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                    <li class="review"><a href="#">(1 customer review )</a></li>
                                </ul>
                            </div>
                            <div class="price_box">
                                <span class="old_price">৳{{$productDetails->regular_price}}</span>
                                <span class="current_price">৳{{$productDetails->sales_price}}</span>
                            </div>
                            <div class="product_desc">
                                <p>{{$productDetails->details}}</p>
                            </div>
                            {{-- <div class="product_variant color">
                                    <h3>Available Options</h3>
                                    <label>color</label>
                                    <ul>
                                        <li class="color1"><a href="#"></a></li>
                                        <li class="color2"><a href="#"></a></li>
                                        <li class="color3"><a href="#"></a></li>
                                        <li class="color4"><a href="#"></a></li>
                                    </ul>
                                </div> --}}
                            <div class="product_variant quantity">
                                {{-- <label>quantity</label>
                                <input min="1" max="100" value="1" type="number"> --}}
                                <button class="button" type="submit" onclick="addToCart({{$productDetails->id}})">add to
                                    cart</button>

                            </div>
                            {{-- <div class=" product_d_action">
                                <ul>
                                    <li><a href="#" title="Add to wishlist">+ Add to Wishlist</a></li>
                                    <li><a href="#" title="Add to wishlist">+ Compare</a></li>
                                </ul>
                            </div> --}}
                            <div class="product_meta">
                                <span>Category: <a href="#">{{$productDetails->category->name}}</a></span>
                            </div>

                        </form>
                        <div class="priduct_social">
                            <ul>
                                <li><a class="facebook" href="#" title="facebook"><i class="fa fa-facebook"></i>
                                        Like</a></li>
                                <li><a class="twitter" href="#" title="twitter"><i class="fa fa-twitter"></i> tweet</a>
                                </li>
                                <li><a class="pinterest" href="#" title="pinterest"><i class="fa fa-pinterest"></i>
                                        save</a></li>
                                <li><a class="google-plus" href="#" title="google +"><i class="fa fa-google-plus"></i>
                                        share</a></li>
                                <li><a class="linkedin" href="#" title="linkedin"><i class="fa fa-linkedin"></i>
                                        linked</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--product details end-->

        <!--product info start-->
        <div class="product_d_info">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info"
                                        aria-selected="false">Description</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet"
                                        aria-selected="false">Specification</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                                        aria-selected="false">Reviews (1)</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="product_info_content">
                                    <p>{{$productDetails->details}}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel">
                                <div class="product_d_table">
                                    <form action="#">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="first_child">Compositions</td>
                                                    <td>Polyester</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Styles</td>
                                                    <td>Girly</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Properties</td>
                                                    <td>Short Dress</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="product_info_content">
                                    <p>Fashion has been creating well-designed collections since 2010. The brand offers
                                        feminine designs delivering stylish separates and statement dresses which have
                                        since evolved into a full ready-to-wear collection in which every item is a
                                        vital part of a woman's wardrobe. The result? Cool, easy, chic looks with
                                        youthful elegance and unmistakable signature style. All the beautiful pieces are
                                        made in Italy and manufactured with the greatest attention. Now Fashion extends
                                        to a range of accessories including shoes, hats, belts and more!</p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                <div class="reviews_wrapper">
                                    <h2>1 review for Donec eu furniture</h2>
                                    <div class="reviews_comment_box">
                                        <div class="comment_thmb">
                                            <img src="{{ asset('mazley_assets/img/blog/comment2.jpg') }}" alt="">
                                        </div>
                                        <div class="comment_text">
                                            <div class="reviews_meta">
                                                <div class="product_rating">
                                                    <ul>
                                                        <li><a href="#"><i class="ion-android-star-outline"></i></a>
                                                        </li>
                                                        <li><a href="#"><i class="ion-android-star-outline"></i></a>
                                                        </li>
                                                        <li><a href="#"><i class="ion-android-star-outline"></i></a>
                                                        </li>
                                                        <li><a href="#"><i class="ion-android-star-outline"></i></a>
                                                        </li>
                                                        <li><a href="#"><i class="ion-android-star-outline"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <p><strong>admin </strong>- September 12, 2018</p>
                                                <span>roadthemes</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="comment_title">
                                        <h2>Add a review </h2>
                                        <p>Your email address will not be published.Thank you. </p>
                                    </div>
                                    <div class="product_rating mb-10">
                                        <h3>Your rating</h3>
                                        <ul>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product_review_form">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="review_comment">Your review </label>
                                                    <textarea name="comment" id="review_comment"></textarea>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="author">Name</label>
                                                    <input id="author" type="text">

                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="email">Email </label>
                                                    <input id="email" type="text">
                                                </div>
                                            </div>
                                            <button type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--product info end-->

        <!--product area start-->
        {{-- <section class="product_area related_products">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                        <div class="title_content">
                            <h2><span>Related</span> Products</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="product_carousel product_details_column5 owl-carousel">
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product1.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product2.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-56%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                            <span class="old_price">৳320.00</span>
                                            <span class="current_price">৳120.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product3.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product4.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-52%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Lorem Ipsum Lec</a></h4>
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
                                            <span class="old_price">৳310.00</span>
                                            <span class="current_price">৳110.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product9.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product10.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-56%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Mauris Vel Tellus</a>
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
                                            <span class="old_price">৳420.00</span>
                                            <span class="current_price">৳180.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product1.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product2.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-52%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Cas Meque Metus</a></h4>
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
                                            <span class="old_price">৳420.00</span>
                                            <span class="current_price">৳180.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product3.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product4.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_new">new</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Letraset Sheets</a></h4>
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
                                            <span class="old_price">৳320.00</span>
                                            <span class="current_price">৳120.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product7.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product8.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-52%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                            <span class="old_price">৳320.00</span>
                                            <span class="current_price">৳120.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                </div>
            </div>
        </section> --}}
        <!--product area end-->

        <!--product area start-->
        {{-- <section class="product_area upsell_products">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style2">
                        <div class="title_content">
                            <h2><span>Upsell</span> Products</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="product_carousel product_details_column5 owl-carousel">
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product1.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product2.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-52%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Cas Meque Metus</a></h4>
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
                                            <span class="old_price">৳420.00</span>
                                            <span class="current_price">৳180.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product3.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product4.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_new">new</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Letraset Sheets</a></h4>
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
                                            <span class="old_price">৳320.00</span>
                                            <span class="current_price">৳120.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product7.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product8.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-52%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                            <span class="old_price">৳320.00</span>
                                            <span class="current_price">৳120.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product1.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product2.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-56%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                            <span class="old_price">৳320.00</span>
                                            <span class="current_price">৳120.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product3.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product4.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-52%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Lorem Ipsum Lec</a></h4>
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
                                            <span class="old_price">৳310.00</span>
                                            <span class="current_price">৳110.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    <div class="col-lg-3">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img
                                            src="assets/img/product/product9.jpg" alt=""></a>
                                    <a class="secondary_img" href="product-details.html"><img
                                            src="assets/img/product/product10.jpg" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-56%</span>
                                    </div>
                                    <div class="quick_button">
                                        <a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                        <h4 class="product_name"><a href="product-details.html">Mauris Vel Tellus</a>
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
                                            <span class="old_price">৳420.00</span>
                                            <span class="current_price">৳180.00</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                </div>
            </div>
        </section> --}}
        <!--product area end-->
    </div>
</div>

{{-- <!-- Recently Viewed -->

	<div class="viewed">
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
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_1.jpg" alt=""></div>
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
								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_2.jpg" alt=""></div>
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
								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_3.jpg" alt=""></div>
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
								<div class="viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_4.jpg" alt=""></div>
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
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_5.jpg" alt=""></div>
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
								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_6.jpg" alt=""></div>
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


@endsection

@section('scripts')

<script>
    $(document).ready(function () {
        loadCartData();
    });

    function loadCartData() {
        $.ajax({
            url: 'http://103.115.25.104/automaxProject/public/getSidecartData',
            type: 'get',
            success: function (response) {

                $('#sideNavCartData').html(response);

            },
            error: function () {
                alert("error");
            }
        });
    }


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
        var base_url = '{{ URL("/") }}';

        $.ajax({
            url: base_url + '/addToCart',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                console.log(response.cart.totalQty);
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
                            $("#totalCartAmount").text('৳' + totalPrice);
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







    function decreaseToCart(id) {
        var base_url = '{!!json_encode(url('/')) !!}';

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


    function minusQuantity(quantityId, priceId, tdId, price, shippingCharge, productId) {
        var quantityVal = parseInt($('#' + quantityId).val());

        if (quantityVal > 1) {
            var value = 0;

            decreaseToCart(productId);

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






{{-- <script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('js/shop_custom.js')}}"></script>
<script src="{{asset('plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('plugins/easing/easing.js')}}"></script>
<script src="{{asset('js/product_custom.js')}}"></script> --}}



@endsection


{{-- @include('partials.footer') --}}


@push('footerasset')
{{--
<script src="{{ asset('styles/bootstrap4/popper.js') }}"></script>
<script src="{{ asset('styles/bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TweenMax.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TimelineMax.min.js') }}"></script>
<script src="{{ asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/animation.gsap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
<script src="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
<script src="{{ asset('plugins/easing/easing.js') }}"></script>
<script src="{{ asset('js/product_custom.js') }}"></script> --}}

@endpush
