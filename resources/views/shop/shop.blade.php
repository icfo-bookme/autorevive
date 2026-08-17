@extends('layouts.master')


@section('content')




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
<style>
    .showContent{
        visibility: hidden;
    }
</style>

<div id="shopApp">
</div>



<!--breadcrumbs area start-->
{{-- <div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>shop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!--breadcrumbs area end-->

<!--shop  area start-->
<div class="shop_area shop_reverse">
    <div class="container">
        <div class="row">
{{--             
            <div class="col-lg-3 col-md-12">
                
                <aside class="sidebar_widget">
                    <div class="widget_list widget_categories">
                        <h3>Categories</h3>

                        <ul>
                            @foreach ($allCategories as $category)

                            @if(count($category->sub_category) > 0)
                            <li class="widget_sub_categories">
                                <a onclick="searchProductByCategory({{ $category->id }})" class="active">{{ $category->name }}</a>
                                <ul class="widget_dropdown_categories" style="display: none;">
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

                        </ul>
                    </div>
                   
                </aside>
                
            </div> --}}

            {{-- <div class="col-lg-9 col-md-12">

              
                <div class="shop_banner_area mb-30">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop_banner_thumb">
                                <img src="{{asset('mazley_assets/img/bg/banner23.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="shop_toolbar_wrapper">
                    <div class="shop_toolbar_btn">
                        <button data-role="grid_4" type="button" class="active btn-grid-4" data-toggle="tooltip"
                            title="4"></button>
                        <button data-role="grid_3" type="button" class=" btn-grid-3" data-toggle="tooltip"
                            title="3"></button>
                        
                    </div>
                    <div>
                        <form  action="#">
                            <select name="orderby" class="form-control" id="short" onchange="sortByParam(this.value)">
                                <option selected value="average">Sort by average rating</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="time">Sort by newness</option>
                                <option value="price_asc">Sort by price: low to high</option>
                                <option value="price_desc">Sort by price: high to low</option>
                               
                                <option value="name">Sort by Name</option>
                            </select>
                        </form>
                    </div>
                    <div class="page_amount">
                      
                    </div>
                </div>
            
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
                                   
                                    <div class="quick_button">
                                        <a href="{{url('singleProductDetails',$item->id)}}" title="quick view"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product_content grid_content">
                                    <div class="product_content_inner">
                                        <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                                        <h4 class="product_name"><a href="{{url('singleProductDetails',$item->id)}}">{{ $item->name }}</a>
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
                                            <li class="add_to_cart"><a href="#" onclick="addToCart({{ $item->id }})" title="Add to cart">Add to
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
                                        <h4 class="product_name"><a {{url('singleProductDetails',$item->id)}}>{{ $item->name }}</a>
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
                                                <li class="add_to_cart"><a href="#" onclick="addToCart({{ $item->id }})" title="Add to cart">Add
                                                        to
                                                        cart</a></li>
                                                <li class="wishlist"><a href="#" title="Add to Wishlist"><i
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



                <div class="shop_toolbar t_bottom">
                    <div id="pagination" class="pagination">
                        {{ $allProducts->fragment("featuredProducts")->links() }}
                    </div>
                </div>
              
            </div> --}}
        </div>
    </div>
</div>
<!--shop  area end-->

<!--brand area start-->
{{-- <div class="brand_area brand_padding">
    <div class="container">
        <div class="col-12">
            <div class="brand_container owl-carousel ">
                <div class="brand_list">
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand1.jpg" alt=""></a>
                    </div>
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand2.jpg" alt=""></a>
                    </div>
                </div>
                <div class="brand_list">
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand3.jpg" alt=""></a>
                    </div>
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand4.jpg" alt=""></a>
                    </div>
                </div>
                <div class="brand_list">
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand5.jpg" alt=""></a>
                    </div>
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand6.jpg" alt=""></a>
                    </div>
                </div>
                <div class="brand_list">
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand7.jpg" alt=""></a>
                    </div>
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand8.jpg" alt=""></a>
                    </div>
                </div>
                <div class="brand_list">
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand1.jpg" alt=""></a>
                    </div>
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand2.jpg" alt=""></a>
                    </div>
                </div>
                <div class="brand_list">
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand3.jpg" alt=""></a>
                    </div>
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand4.jpg" alt=""></a>
                    </div>
                </div>
                <div class="brand_list">
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand5.jpg" alt=""></a>
                    </div>
                    <div class="single_brand">
                        <a href="#"><img src="assets/img/brand/brand6.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!--brand area end-->

<!-- modal area start-->
{{-- <div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/productbig1.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/productbig2.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/productbig3.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/productbig4.jpg" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab"
                                                aria-controls="tab1" aria-selected="false"><img
                                                    src="assets/img/product/product2.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab"
                                                aria-controls="tab2" aria-selected="false"><img
                                                    src="assets/img/product/product6.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link button_three" data-toggle="tab" href="#tab3" role="tab"
                                                aria-controls="tab3" aria-selected="false"><img
                                                    src="assets/img/product/product9.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab4" role="tab"
                                                aria-controls="tab4" aria-selected="false"><img
                                                    src="assets/img/product/product3.jpg" alt=""></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>Sit voluptatem rhoncus sem lectus</h2>
                                </div>
                                <div class="modal_price mb-10">
                                    <span class="new_price">৳64.99</span>
                                    <span class="old_price">৳78.99</span>
                                </div>
                                <div class="modal_description mb-15">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum
                                        ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui
                                        nemo ipsum numquam, reiciendis maiores quidem aperiam, rerum vel recusandae </p>
                                </div>
                                <div class="variants_selects">
                                    <div class="variants_size">
                                        <h2>size</h2>
                                        <select class="select_option">
                                            <option selected value="1">s</option>
                                            <option value="1">m</option>
                                            <option value="1">l</option>
                                            <option value="1">xl</option>
                                            <option value="1">xxl</option>
                                        </select>
                                    </div>
                                    <div class="variants_color">
                                        <h2>color</h2>
                                        <select class="select_option">
                                            <option selected value="1">purple</option>
                                            <option value="1">violet</option>
                                            <option value="1">black</option>
                                            <option value="1">pink</option>
                                            <option value="1">orange</option>
                                        </select>
                                    </div>
                                    <div class="modal_add_to_cart">
                                        <form action="#">
                                            <input min="1" max="100" step="2" value="1" type="number">
                                            <button type="submit">add to cart</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal_social">
                                    <h2>Share this product</h2>
                                    <ul>
                                        <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                        <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- modal area end-->
<script src="{{asset('react/app.js')}}"></script>
@endsection


@section('scripts')

<script>
  $(document).ready(function(){



    // $.ajax({
    //       url: '{{url("getSidecartData")}}',
    //       type: 'get',
    //       success: function (response) {
    //         $('#sideNavCartData').html(response);
    //       },
    //       error: function () {
    //       alert("error");
    //       }
    //   });

    })
    $(document).ready(function () {

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
    // searchProductBySubCategory

    function searchProductByCategory(id) {
        $.ajax({
            url: 'searchProductByCategory',
            type: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (data) {
                $('#allProducts').empty();
                $('#pagination').empty();
                $('#allProducts').html(data);
                $('#pagination').html(
                    `{{ $allProducts->fragment("featuredProducts")->links() }}`);
            },
            error: function (err) {
                console.error(err);
                alert("error");
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

    function getProductByBrand(id) {

        $.ajax({
            url: 'getProductByBrandAjax',
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

    // function addToCart(id) {
    //     var base_url = '{!! json_encode(url(' / ')) !!}';

    //     $.ajax({
    //         url: '{{ URL("addToCart") }}',
    //         type: 'POST',
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             id: id
    //         },
    //         success: function (response) {
    //             alertify.success('Added To the Cart');
    //             $("#cartSymbol").text(response.cart.totalQty);
    //             $('#cartSymbolTwo').text(response.cart.totalQty);
    //             $("#totalCartAmount").text('৳' + response.cart.totalPrice);

    //             $.ajax({
    //                 url: '{{url("getSidecartData")}}',
    //                 type: 'get',
    //                 success: function (response) {
    //                     $('#sideNavCartData').html(response);
    //                 },
    //                 error: function () {
    //                     alert("error");
    //                 }
    //             });

    //         },
    //         error: function () {
    //             alert("error");
    //         }
    //     });
    // }

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

    // function removeItem(id) {
    //     $.ajax({
    //         url: '{{ url("removeItemFromCart") }}',
    //         type: 'POST',
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "item_id": id
    //         },
    //         success: function (response) {

    //             $.ajax({
    //                 url: '{{url("getSidecartData")}}',
    //                 type: 'get',
    //                 success: function (response) {
    //                     $('#sideNavCartData').html(response);
    //                     var totalPrice = $('#getTotalAmount').val();
    //                     var totalQuantity = $('#getTotalQuantity').val();

    //                     if (totalQuantity > 0) {
    //                         $("#cartSymbol").text(totalQuantity);
    //                         $('#cartSymbolTwo').text(totalQuantity);
    //                         $("#totalCartAmount").text(totalPrice);
    //                     } else {
    //                         $("#cartSymbol").text(0);
    //                         $('#cartSymbolTwo').text(0);
    //                         $("#totalCartAmount").text(0);
    //                     }

    //                 },
    //                 error: function () {
    //                     alert("error");
    //                 }
    //             });


    //         },
    //         error: function () {
    //             // alert("error");
    //         }
    //     });
    // }

    function openNav() {
        // if ($(window).width() <= 700) {
        //     var size = '100vw';
        // } else {
        //     var size = '35vw';
        // }

        // document.getElementById("mySidenav").style.width = size;

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
        document.getElementsByClassName('mini_cart')[0].classList.toggle('active');
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

</script>
@endsection
{{-- @section('scripts')
// <script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
// <script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
// <script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
// <script src="{{asset('js/shop_custom.js')}}"></script>

// @endsection --}}


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
<script src="{{ asset('js/shop_custom.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}

@endpush

{{-- @include('partials.footer') --}}
