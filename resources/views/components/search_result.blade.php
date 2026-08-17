<script>
    /*---categories column7 activation---*/
    $('.categories_column7').on('changed.owl.carousel initialized.owl.carousel', function (event) {
        $(event.target).find('.owl-item').removeClass('last').eq(event.item.index + event.page.size - 1)
            .addClass('last')
    }).owlCarousel({
        loop: true,
        nav: false,
        autoplay: false,
        autoplayTimeout: 8000,
        items: 7,
        margin: 20,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 2,
            },
            576: {
                items: 3,
            },
            768: {
                items: 5,
            },
            992: {
                items: 5,
            },
            1200: {
                items: 6,
            },
            1300: {
                items: 7,
            },
        }
    });

    /*---product column6 activation---*/
    $('.product_column6').on('changed.owl.carousel initialized.owl.carousel', function (event) {
        $(event.target).find('.owl-item').removeClass('last').eq(event.item.index + event.page.size - 1)
            .addClass('last')
    }).owlCarousel({
        loop: true,
        nav: true,
        autoplay: false,
        autoplayTimeout: 8000,
        items: 6,
        margin: 20,
        dots: false,
        navText: ['<i class="ion-ios-arrow-back"></i>', '<i class="ion-ios-arrow-forward"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 2,
            },
            576: {
                items: 2,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            },
            1200: {
                items: 5,
            },

            1301: {
                items: 6,
            },
        }
    });


    /*---product column5 activation---*/
    $('.product_column5').on('changed.owl.carousel initialized.owl.carousel', function (event) {
        $(event.target).find('.owl-item').removeClass('last').eq(event.item.index + event.page.size - 1)
            .addClass('last')
    }).owlCarousel({
        loop: true,
        nav: false,
        autoplay: false,
        autoplayTimeout: 8000,
        items: 5,
        dots: false,
        margin: 30,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 2,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            },
            1200: {
                items: 5,
            },

        }
    });
</script>


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
                                <a class="active" data-toggle="tab" href="#Sellers" role="tab" aria-controls="Sellers"
                                    aria-selected="true">
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
                        <ul class="nav" id="nav-tabs" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#Sellers" role="tab" aria-controls="Sellers"
                                    aria-selected="true">
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
                <div class="product_carousel product_columnSix owl-carousel">
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
                <div class="product_carousel product_columnSix owl-carousel">

                    @foreach ($topOrders as $topOrder)
                    <article class="single_product">
                        <figure>
                            <div class="product_thumb">
                                <a class="primary_img" href="{{url('singleProductDetails',$topOrder->item->id)}}"><img
                                        src="{{ asset($topOrder->item->thumbnail) }}" alt=""></a>
                                <a class="secondary_img" href="{{url('singleProductDetails',$topOrder->item->id)}}"><img
                                        src="{{ asset($topOrder->item->thumbnail) }}" alt=""></a>
                                <div class="label_product">
                                    <span class="label_sale">-0%</span>
                                </div>
                                <div class="quick_button">
                                    <a href="{{url('singleProductDetails',$topOrder->item->id)}}" title="quick view"><i
                                            class="icon-eye"></i></a>
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
                <div class="product_carousel product_columnSix owl-carousel">
                    @foreach ($specialOffers as $specialOffer)


                    <article class="single_product">
                        <figure>
                            <div class="product_thumb">
                                <a class="primary_img" href="{{url('singleProductDetails',$specialOffer->id)}}"><img
                                        src="{{ asset($specialOffer->thumbnail) }}" alt=""></a>
                                <a class="secondary_img" href="{{url('singleProductDetails',$specialOffer->id)}}"><img
                                        src="{{ asset($specialOffer->thumbnail) }}" alt=""></a>
                                <div class="label_product">
                                    <span class="label_sale">-48%</span>
                                </div>
                                <div class="quick_button">
                                    <a href="{{url('singleProductDetails',$specialOffer->id)}}" title="quick view"><i
                                            class="icon-eye"></i></a>
                                </div>
                            </div>
                            <div class="product_content">
                                <div class="product_content_inner">
                                    <p class="manufacture_product"><a href="#">{{ $specialOffer->category->name }}</a>
                                    </p>
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
                                <a class="active" data-toggle="tab" href="#Sellers" role="tab" aria-controls="Sellers"
                                    aria-selected="true">
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
                        <p>The highest discount products of Automart </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="product_container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="product_style_left">
                        @isset($dealOfTheWeek)

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
                                    <p class="manufacture_product"><a href="#">{{ $dealOfTheWeek->category->name }}</a>
                                    </p>
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
                                {{-- @dd($onsaleProducts) --}}
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
                                                                title="Add to Wishlist"><i class="icon-heart"></i></a>
                                                        </li>
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

