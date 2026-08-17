@extends('layouts.master')
@section('title')
HOME
@endsection
@section('content')

{{-- <div id="fullNav">
    @include('partials.navBar')
<div> --}}

@section('styles')
{{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
<link href="{{asset('styles/shop_styles.css')}}" rel="stylesheet" type="text/css">
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

<!-- Home -->

{{-- <div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{asset('img/images/shop_background.jpg')}}">
</div>
<div class="home_overlay"></div>
<div class="home_content d-flex flex-column align-items-center justify-content-center">
    <h2 class="home_title">Shop</h2>
</div>
</div> --}}

<!-- Shop -->

<div class="shop_area shop_reverse">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <!--sidebar widget start-->
                <aside class="sidebar_widget">
                    <div class="widget_list widget_categories">
                        <h3>Categories</h3>
                        {{-- <ul>
                                <li><a href="#">Cameras & Camcoders</a></li>
                                <li class="widget_sub_categories"><a href="javascript:void(0)">Computer & Networking</a>
                                    <ul class="widget_dropdown_categories">
                                        <li><a href="#">Computer</a></li>
                                        <li><a href="#">Networking</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Games & Consoles</a></li>
                                <li><a href="#">Headphone & Speaker</a></li>
                                <li><a href="#">Movies & Video Games</a></li>
                                <li><a href="#">Smartphone</a> </li>
                                <li><a href="#">Uncategorized</a></li>
                            </ul> --}}
                        <ul>
                            @foreach ($allCategories as $category)
                            {{-- @dd(count($allCategories[1]->sub_category)) --}}
                            @if(count($category->sub_category) > 0)
                            <li class="widget_sub_categories">
                                <a onclick="searchProductByCategory({{ $category->id }})" class="active">{{ $category->name }}</a>
                                <ul class="widget_dropdown_categories" style="display: none">
                                    @foreach ($category->sub_category as $sub_category)
                                    <li>
                                        <a
                                            onclick="searchProductBySubCategory({{ $sub_category->id }})">{{ $sub_category->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li>
                                <a onclick="searchProductByCategory({{ $category->id }})"
                                    style="cursor:pointer">{{ $category->name }}</a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget_list widget_filter">
                        <h3>Price</h3>
                        <form id="rangeForm">
                            <div id="slider-range"></div>
                            <button type="button" onclick="filterByPrice()" id="rangeFormBtn">Filter</button>
                            <input type="text" name="text" id="amount" />
                        </form>
                    </div>
                    <div class="widget_list widget_categories">
                        <h3>Manufacturer</h3>
                        <ul>
                            @foreach ($brands as $brand)
                            <li>
                                <input id="check1" name="manufacturer_name" type="radio" value="{{ $brand->id }}">
                                <label for="check1">{{ $brand->name }}</label>
                                <span class="checkmark"></span>
                            </li>
                            @endforeach
                            {{-- <li>
                                    <input id="check1" name="manufacturer_name" type="radio">
                                    <label for="check1">Calvin Klein (8)</label>
                                    <span class="checkmark"></span>
                                </li>
                                <li>
                                    <input id="check2" name="manufacturer_name" type="radio">
                                    <label for="check2">Diesel (8)</label>
                                    <span class="checkmark"></span>
                                </li>
                                <li>
                                    <input id="check3" name="manufacturer_name" type="radio">
                                    <label for="check3">Tommy Hilfiger (8)</label>
                                    <span class="checkmark"></span>
                                </li>
                                <li>
                                    <input id="check4" name="manufacturer_name" type="radio">
                                    <label for="check4">Versace (8)</label>
                                    <span class="checkmark"></span>
                                </li> --}}
                        </ul>
                    </div>
                    <div class="widget_list widget_categories">
                        <h3>Category</h3>
                        <ul>
                            @foreach ($allCategories as $category)
                            <li>
                                <input id="check5" name="category_name" type="radio" value="{{ $category->id }}">
                                <label for="check5">{{ $category->name }}</label>
                                <span class="checkmark"></span>
                            </li>
                            @endforeach
                            {{-- <li>
                                    <input id="check5" name="category_name" type="radio" value="1">
                                    <label for="check5">Accessories (8)</label>
                                    <span class="checkmark"></span>
                                </li>
                                <li>
                                    <input id="check6" name="category_name" type="radio" value="2">
                                    <label for="check6">Dresses (8)</label>
                                    <span class="checkmark"></span>
                                </li>
                                <li>
                                    <input id="check7" name="category_name" type="radio" value="3">
                                    <label for="check7">Handbags (8)</label>
                                    <span class="checkmark"></span>
                                </li>
                                <li>
                                    <input id="check8" name="category_name" type="radio" value="4">
                                    <label for="check8">Tops (8)</label>
                                    <span class="checkmark"></span>
                                </li> --}}
                        </ul>
                    </div>
                </aside>
                <!--sidebar widget end-->
            </div>
            <div class="col-lg-9 col-md-12">

                <!--shop banner area start-->
                <div class="shop_banner_area mb-30">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop_banner_thumb">
                                <img src="{{asset('mazley_assets/img/bg/banner23.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--shop banner area end-->
                <!--shop toolbar start-->
                <div class="shop_toolbar_wrapper">
                    <div class="shop_toolbar_btn">
                        <button data-role="grid_4" type="button" class="active btn-grid-4" data-toggle="tooltip"
                            title="4"></button>
                        <button data-role="grid_3" type="button" class=" btn-grid-3" data-toggle="tooltip"
                            title="3"></button>
                        <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip"
                            title="List"></button>
                    </div>
                    <div>
                        <form action="#">
                            <select name="orderby" class="form-control" id="short" onchange="sortByParam(this.value)">
                                <option selected value="average">Sort by average rating</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="time">Sort by newness</option>
                                <option value="price_asc">Sort by price: low to high</option>
                                <option value="price_desc">Sort by price: high to low</option>
                                {{-- <option value="name">Product Name: Z</option> --}}
                                <option value="name">Sort by Name</option>
                            </select>
                        </form>
                    </div>
                    <div class="page_amount">
                        {{-- <p>Showing 1–9 of {{ count($allProducts) }} results</p> --}}
                    </div>
                </div>
                <!--shop toolbar end-->
                <div id="allProducts" class="row shop_wrapper">
                    @foreach ($allProducts as $item)
                    <div class="col-lg-3 col-md-4 col-12 ">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ URL($item->thumbnail) }}" alt=""></a>
                                    <a class="secondary_img" href="{{url('singleProductDetails',$item->id)}}"><img
                                            src="{{ URL($item->thumbnail) }}" alt=""></a>
                                    {{-- <div class="label_product">
                                                <span class="label_sale">-56%</span>
                                            </div> --}}
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$item->id)}}" title="quick view"><i
                                                class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content grid_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a
                                                href="{{url('singleProductDetails',$item->id)}}">{{ $item->name }}</a>
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
                                            <span class="old_price">৳{{ $item->regular_price }}</span>
                                            <span class="current_price">৳{{ $item->sales_price }}</span>
                                        </div>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="add_to_cart"><a href="#" onclick="addToCart({{ $item->id }})"
                                                    title="Add to cart">Add to
                                                    cart</a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                        class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="#" title="Add to Compare"><i
                                                        class="icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product_content list_content">
                                    <div class="left_caption">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a href="product-details.html">{{ $item->name }}</a>
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
                                            <span class="old_price">৳{{ $item->regular_price }}</span>
                                            <span class="current_price">৳{{ $item->sales_price }}</span>
                                        </div>
                                        <div class="product_desc">
                                            <p>{{ $item->details }}</p>
                                        </div>
                                    </div>
                                    <div class="right_caption">
                                        <p class="text_available">Availability: <span>In Stock</span></p>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart"><a href="#" onclick="addToCart({{ $item->id }})"
                                                        title="Add to cart">Add
                                                        to
                                                        cart</a></li>
                                                <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                                            class="icon-heart"></i> Add to
                                                        Wishlist</a></li>
                                                <li class="compare"><a href="#" title="compare"><i
                                                            class="icon-rotate-cw"></i>Add to Compare</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    @endforeach
                </div>

                {{-- pagination --}}
                {{-- <div class="shop_toolbar t_bottom">
                        <div class="pagination">
                            <ul>
                                <li class="current">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#">next</a></li>
                                <li><a href="#">>></a></li>
                            </ul>
                        </div>
                    </div> --}}

                <div class="shop_toolbar t_bottom">
                    <div id="pagination" class="pagination">
                        {{ $allProducts->fragment("featuredProducts")->links() }}
                    </div>
                </div>

                <!--shop toolbar end-->
                <!--shop wrapper end-->
            </div>
        </div>
    </div>
</div>

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
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="{{asset('img/images/view_1.jpg')}}" alt=""></div>
<div class="viewed_content text-center">
    <div class="viewed_price">৳225<span>৳300</span></div>
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
        <div class="viewed_image"><img src="{{asset('img/images/view_2.jpg')}}" alt=""></div>
        <div class="viewed_content text-center">
            <div class="viewed_price">৳379</div>
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
        <div class="viewed_image"><img src="{{asset('img/images/view_3.jpg')}}" alt=""></div>
        <div class="viewed_content text-center">
            <div class="viewed_price">৳225</div>
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
        <div class="viewed_image"><img src="{{asset('img/images/view_4.jpg')}}" alt=""></div>
        <div class="viewed_content text-center">
            <div class="viewed_price">৳379</div>
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
        <div class="viewed_image"><img src="{{asset('img/images/view_5.jpg')}}" alt=""></div>
        <div class="viewed_content text-center">
            <div class="viewed_price">৳225<span>৳300</span></div>
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
        <div class="viewed_image"><img src="{{asset('img/images/view_6.jpg')}}" alt=""></div>
        <div class="viewed_content text-center">
            <div class="viewed_price">৳375</div>
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
    <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ asset('img/images/brands_2.jpg') }}"
            alt=""></div>
</div>
<div class="owl-item">
    <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ asset('img/images/brands_3.jpg') }}"
            alt=""></div>
</div>
<div class="owl-item">
    <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ asset('img/images/brands_4.jpg') }}"
            alt=""></div>
</div>
<div class="owl-item">
    <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ asset('img/images/brands_5.jpg') }}"
            alt=""></div>
</div>
<div class="owl-item">
    <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ asset('img/images/brands_6.jpg') }}"
            alt=""></div>
</div>
<div class="owl-item">
    <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ asset('img/images/brands_7.jpg') }}"
            alt=""></div>
</div>
<div class="owl-item">
    <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ asset('img/images/brands_8.jpg') }}"
            alt=""></div>
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
{{-- 
<div class="newsletter">
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
        <input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
        <button class="newsletter_button">Subscribe</button>
    </form>
    <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
</div>
</div>
</div>
</div>
</div>
</div> --}}


<!-- loader modal -->
<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src='{{asset('assets/images/preloader.gif')}}'
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>


<script>
    $(document).ready(function () {
        // console.log(1);

        loadCartData();
        //close category in window click
        window.addEventListener('mouseup', function(event){
            const box = document.getElementById('box1');
            if(event.target !=box && event.target.parentNode != box){
                box.style.display = 'none';
            }
        })



        $("#rangeForm").submit(function () {
            event.preventDefault();
            $('#preloader').modal('show');
            // var base_url =  {!! json_encode(url('/')) !!}
            $.ajax({
                url: '{{url("getProductByRange")}}',
                type: 'POST',
                data: $("#rangeForm").serialize() + "&_token={{csrf_token()}}",
                dataType: 'html',
                success: function (response) {
                    if (typeof response == 'undefined') {
                        alert("error");
                        $('#preloader').hide();
                    } else {

                        // $('#rangeForm').trigger("reset");
                        $('#allProducts').empty();
                        $('#pregination').empty();
                        $('#allProducts').html(response);
                        setTimeout(function () {
                            $('#preloader').modal('hide');
                        }, 1000);

                    }
                },
                error: function () {
                    $('#preloader').modal('hide');
                }
            });
        });

        $('input[name="category_name"]').on('change', function () {
            let selected = $('input[name="category_name"]:checked').val();
            console.log(selected);
            searchProductByCategory(selected);
        });

        $('input[name="manufacturer_name"]').on('change', function () {
            let selected = $('input[name="manufacturer_name"]:checked').val();
            console.log(selected);
            getProductByBrand(selected);
        });

    });

    function filterByPrice() {
        let range_str = $('#rangeForm #amount').val().split(' - ');
        let price_range = {
            from: range_str[0].split('৳')[1],
            to: range_str[1].split('৳')[1]
        };

        $.ajax({
            url: '{{url("getProductByRange")}}',
            type: 'POST',
            data: {
                from: price_range.from,
                to: price_range.to,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'html',
            success: function (response) {
                if (typeof response == 'undefined') {
                    alert("error");
                    $('#preloader').hide();
                } else {
                    $('#rangeForm').trigger("reset");
                    $('#allProducts').empty();
                    $('#pagination').empty();
                    $('#allProducts').html(response);
                    $('#pagination').html(
                        `{{ $allProducts->fragment("featuredProducts")->links() }}`
                    );

                    setTimeout(function () {
                        $('#preloader').modal('hide');
                    }, 1000);
                }
            },
            error: function () {
                $('#preloader').modal('hide');
            }
        });
    }

    function searchProductByCategory(id) {

        $.ajax({
            url: '{{url("searchProductByCategory")}}',
            type: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (data) {

                $('#allProducts').empty();
                $('#pregination').empty();
                $('#allProducts').html(data);
            },

            error: function () {
                alert("error");
            }
        });
    }



    function getProductByBrand(id) {

        $.ajax({
            url: '{{url("getProductByBrandAjax")}}',
            type: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (data) {

                $('#allProducts').empty();
                $('#pregination').empty();
                $('#allProducts').html(data);
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
        var base_url = '{{ URL("/") }}'

        $.ajax({
            url: base_url + '/addToCart',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                alertify.success('Added To the Cart');
                $("#cartSymbol").text(response.cart.totalQty);
                $('#cartSymbolTwo').text(response.cart.totalQty);
                $("#totalCartAmount").text('৳' + response.cart.totalPrice);
                /*
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
                */

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
        var base_url = '{{ URL("/") }}';

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


    function loadCartData() {
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

    function sortByParam(param) {   
        console.log(param);

        $.ajax({
            url: '{{ URL("sortProductByParam") }}',
            type: 'POST',
            data: {
                sort_param: param,
                _token: '{{ csrf_token() }}'
            },
            success: data => {
                console.log(data);
                $('#allProducts').empty();
                $('#pagination').empty();
                $('#allProducts').html(data);
                $('#pagination').html(
                    `{{ $allProducts->fragment("featuredProducts")->links() }}`);
            },
            error: err => {
                console.error(err);
            }
        });
    }

    function searchProductBySubCategory(id) {
        $.ajax({
            url: '{{ URL("searchProductBySubCategory") }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (data) {
                $('#allProducts').empty();
                $('#pagination').empty();
                $('#allProducts').html(data);
                $('#pagination').html(
                    `{{ $allProducts->fragment("featuredProducts")->links() }}`
                );
            },
            error: function (err) {
                console.error(err);
                alert("error");
            }
        });
    }

</script>

{{-- @section('scripts')
<script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
<script src="{{asset('js/shop_custom.js')}}"></script>
@endsection --}}



@endsection
{{-- @include('partials.footer') --}}

@push('footerasset')

{{-- <script src="{{ asset('styles/bootstrap4/popper.js') }}"></script>
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
<script src="{{ asset('js/shop_custom.js') }}"></script> --}}

@endpush
