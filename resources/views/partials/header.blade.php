@php
$cart = Session::has('cart') ? Session::get('cart') : null;

@endphp
<style>
    .login__form {
        margin-top: -5px !important;
    }

    .list_item {
        text-decoration: none !important;
        color: #494949 !important;
        display: block !important;
        background: #ffffff !important;
        /* padding: 12px 0; */
        padding: 10px 0px 0px 0px;
    }

    /* .list_item:hover{
  background: #C70909 !important;
} */

    .sub_category {
        background: #e9e9e9 !important;
        color: #494949 !important;
        text-decoration: none !important;
        padding-left: 30px !important;
        padding: 10px;
        cursor: pointer;
    }

    /* .sub_category:hover{
  background: #e9e9e9 !important;
} */
    .catgory_link {
        padding: 5px 10px;
    }

    .list_item a {
        color: #555 !important;
    }

    .list_item a:hover {
        color: red !important;
    }

    .sub_category_list_item {
        display: none;
    }

    .show {
        display: block !important;
    }

    .checkOut_categories_title {
        background: #C70909;
        padding: 0 30px 0 55px;
        position: relative;
        cursor: pointer;
        height: 50px;
        line-height: 50px;
        border-radius: 3px 3px 0 0;
    }

    .checkOut_categories_title h2 {
        font-size: 14px;
        text-transform: uppercase;
        font-weight: 500;
        line-height: 26px;
        color: #fff;
        cursor: pointer;
        margin-bottom: 0;
        display: inline-block;
    }

    .checkOut_categories_title::before {
        content: "\f394";
        color: #fff;
        display: inline-block;
        font-family: Ionicons;
        position: absolute;
        font-size: 22px;
        line-height: 0px;
        left: 20px;
        top: 50%;
        transform: translatey(-50%);
    }

    .categories_menu_toggler {
        background-color: rgb(255, 255, 255);
        border: 1px solid rgb(235, 235, 235);
        position: absolute;
        width: 100%;
        top: 100%;
        z-index: 9;
        height: 450px;
        overflow: auto;
        display: none;
    }

</style>
<div class="offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open canvas_open_sm">
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>
                    <div class="call_support">
                        <p><i class="icon-phone-call" aria-hidden="true"></i> <span>Call us: <a
                                    href="tel: 01302068886">01302068886</a></span></p>

                    </div>

                    <div class="header_top_links">
                        <ul>
                            {{-- @auth
                                <li><a onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">Logout</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <li><a href="{{ url('login') }}">login</a></li>
                                <li><a href="{{ url('register') }}">Register</a></li>
                            @endauth --}}
                            @if (Auth::guest())
                                <li><a href="{{ url('login') }}" target="_self">LOGIN</a></li>
                                <li><a href="{{ url('register') }}">Register</a></li>

                            @else
                                <li><a href='#' onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a></li>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            @endif

                        </ul>
                    </div>


                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            {{-- <li class="menu-item-has-children active">
                                <a href="{{url("/")}}">Home</a>
                            </li> --}}
                            <li class="menu-item-has-children">
                                <a href="{{ url('shopview') }}">Shop</a>
                            </li>

                            <li class="menu-item-has-children">
                                <a href="{{ url('shopview?offer=onsale') }}">Offer</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ url('myAccountView') }}">my account</a>
                            </li>
                            {{-- <li class="menu-item-has-children">
                                <a href="{{url("wishList")}}"> Wishlist</a>
                            </li> --}}
                            <li class="menu-item-has-children">
                                {{-- <a href="{{ url('contactFormView') }}"> Contact Us</a> --}}
                                <a href="{{ url('connectWithUs') }}"> Contact Us</a>
                            </li>
                            {{-- <li class="menu-item-has-children">
                                <a href="{{url("checkout")}}">Checkout</a>
                            </li> --}}

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<header>
    <div class="main_header">
        <!--header middel start-->
        <!--header top start-->
        <div class="header_top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-5" id="topHeader-left" style="margin-top: -15px">
                        <div class="header_account">
                            <ul>
                                <li className="language">
                                    <i className="icon-phone-call" aria-hidden="true" /></i>
                                    <span>
                                        Call us:
                                        <a href="tel: 01888-022244">
                                            01888-022244
                                        </a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7" id="topHeader-right" style="margin-top: -15px">
                        <div class="header_top_links text-right">
                            <ul>
                                @if (Auth::user() == null)
                                    <li><a href="#" data-toggle="dropdown" id="logout"
                                            class="nav-item nav-link dropdown-toggle mr-3 default__bg">login</a>
                                        <div class="dropdown-menu login__form" style="margin-top: -20px">
                                            @error('email')
                                                {{-- <small class="text-danger" style="font-size: 12px">{{ $message }}</small> --}}
                                                <div class="boxDanger mt-3">
                                                    <p>{{ $message }}</p>
                                                </div>
                                            @enderror
                                            @error('password')
                                                {{-- <small class="text-danger">{{ $message }}</small> --}}
                                                <div class="boxDanger mt-3">
                                                    <p>{{ $message }}</p>
                                                </div>
                                            @enderror
                                            <form action="{{ url('login') }}" method="POST">
                                                @csrf
                                                <div class="form-group my-2">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control" name="email" required
                                                        value="{{ old('email') }}">

                                                </div>
                                                <div class="form-group my-2">
                                                    <label for="">Password</label>
                                                    <a href="{{ url('password/reset') }}"
                                                        class="float-right default__bg">
                                                        <small>Forgot?</small>
                                                    </a>
                                                    <input type="password" class="form-control" name="password"
                                                        required value="{{ old('password') }}">

                                                </div>
                                                <input type="submit" class="btn btn-primary btn-block my-3"
                                                    value="Login">
                                            </form>
                                            <div class="clearfix text-center">
                                                <span class="text-muted">
                                                    <small>Don't have an account?</small>
                                                    <a href="{{ url('register') }}" class="default__bg">Sign
                                                        Up</a>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <div class="drop-down show">
                                            <a href="" class="dropdown-toggle default__bg" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Account
                                            </a>
                                            <div class="dropdown-menu mt-3 topAccount"
                                                aria-labelledby="dropdownMenuLink"
                                                style="width: auto; min-width: auto; padding: 0;">
                                                <a href="{{ url('myAccountView') }}"
                                                    class="dropdown-item default__bg"><i class="fa fa-user"></i>
                                                    Order History</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="default__bg" onclick="logout()">Logout</a>
                                    </li>

                                @endisset


                                <!-- <li><a href="cart.html">Shopping Cart</a></li>
     <li><a href="checkout.html">Checkout</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header top start-->

    <div class="header_middle h_middle_two pb__16">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                    <div class="logo" style="margin-top: -15px;">
                        <a href="{{ url('/') }}"><img
                                src="{{ asset('mazley_assets/img/logo/automax-lg.png') }}" alt=""></a>
                    </div>
                </div>

                <div class="col-lg-10 col-md-6 col-sm-6 col-6">
                    <div class="header_right_box">

                        <!-- <div class="search_container" id="checkOutSearhContainer">
<form>
<div class="hover_category">
<select class="select_option" name="select" id="categori2"
    onchange="categoryRedirect(this);">
    <option><a class="clc">All Category</a></option>
    @foreach ($allCategories as $category)

    <option value="{{ $category->id }}">
        {{ $category->name }}
    </option>

    @endforeach
</select>
</div>
<div class="search_box">
<input placeholder="Search product..." type="search" id="searchPost">
</div>
</form>
</div> -->

                        <div class="header_configure_area">

                            {{-- <div class="mini_cart_wrapper">
                                    <a href="javascript:void(0)">
                                        <i class="icon-shopping-bag2"></i>

                                        @if (isset($cart))
                                        <span class="cart_price"
                                            id="totalCartAmount">৳{{number_format($cart->totalPrice,2)}} <i
                                    class="ion-ios-arrow-down"></i></span>
                                <span class="cart_count" id="cartSymbol">{{$cart->totalQty}}</span>
                                @else
                                <span class="cart_price" id="totalCartAmount">৳0.00 <i
                                        class="ion-ios-arrow-down"></i></span>
                                <span class="cart_count" id="cartSymbol">0</span>

                                @endif
                                </a>
                                <div class="mini_cart">
                                    <div class="mini_cart_inner">
                                        <div id="sideNavCartData"></div>

                                    </div>
                                </div>

                            </div> --}}

                        </div>
                    </div>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 pt-3" style="display: none;" id="checkOutsmScreen">
                    <div class="">
                        <form>
                            <div class="hover_category">
                                <select class="select_option w-100" name="select" id="categori2"
                                    onchange="categoryRedirect(this);">
                                    <option><a class="clc">All Category</a></option>
                                    @foreach ($allCategories as $category)

                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="search_box mt-3">
                                <input placeholder="Search product..." type="search" id="searchPost">
                                <button type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header middel end-->
    <!--header bottom satrt-->
    <div class="header_bottom sticky-header">
        <div class="container">
            <div class="row align-items-center">
                <div class=" col-lg-4">
                    <div class="d-flex justify-content-start">
                        <ul class="flex-item" style="margin-right: 20px;">
                            <li class="mega_items"><a href="{{ url('/') }}"
                                    style="line-height: 0; margin-top: -5px; color: rgb(255, 255, 255);"><i
                                        class="fa fa-home fa-2x"></i></a></li>
                        </ul>
                        <div class="categories_menu" id="cateGoryBox" style="width: 100%;">

                            <div class="checkOut_categories_title">
                                <h2 class="">ALL CATEGORIES</h2>
                            </div>
                            <div class="categories_menu_toggler">

                                <ul>
                                    @foreach ($allCategories as $category)
                                        @if ($category->sub_category->count() > 0)
                                            <li class="list_item">
                                                <span
                                                    class="catgory_link d-flex  justify-content-between align-items-center">
                                                    <a target="_blank"
                                                        href="{{ URL('/shopByCategory') }}/{{ $category->id }}"
                                                        style="color: #555, display: inline-block;">{{ $category->name }}</a>
                                                    <span class="fa fa-caret-down pr-3 caret__down"
                                                        id="category_id_{{ $category->id }}"
                                                        style="cursor: pointer;"></span>
                                                </span>
                                                <ul class="sub_category_list_item">
                                                    @foreach ($category->sub_category as $subcategory)
                                                        <li class="sub_category"
                                                            id="subCategory_id_{{ $subcategory->id }}">
                                                            <a target="_blank"
                                                                href="{{ url('shopBySubCategory', $subcategory->id) }}">
                                                                {{ $subcategory->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li class="list_item" id="{{ $category->id }}"><a
                                                    class="catgory_link" target="_blank"
                                                    href="{{ URL('/shopByCategory') }}/{{ $category->id }}">{{ $category->name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="main_menu menu_position text-left">
                        <nav>
                            <ul>
                                {{-- <li><a class="active" href="{{url('/')}}">Home</a></li> --}}
                                <li class="mega_items"><a href="{{ url('shopview') }}">Shop</a></li>
                                <li class="mega_items"><a href="{{ url('shopview') }}">Offer</a></li>
                                {{-- <li><a href="blog.html">blog</li> --}}
                                {{-- <li><a href="{{url('myAccountView')}}">My Account</a></li> --}}
                                {{-- <li><a href="#">About Us</a></li> --}}
                                {{-- <li class="menu-item-has-children">
                                    <a href="{{url("wishList")}}"> Wishlist</a>
                                </li> --}}
                                {{-- <li class="mega_items"><a href="{{ URL('contactFormView') }}"> Contact Us</a></li> --}}
                                <li class="mega_items"><a href="{{ URL('connectWithUs') }}"> Contact Us</a></li>
                                {{-- <li class="menu-item-has-children">
                                    <a href="{{url("checkout")}}">Checkout</a>
                                </li> --}}

                                {{-- @if (!Auth::check())
                                <li><a href="{{url('login')}}"> login</a></li>
                                @endif --}}
                                <!-- <li><a href="contact.html"> Contact Us</a></li> -->
                            </ul>
                        </nav>
                    </div>
                </div>
                {{-- <div class="col-lg-3">
                    <div class="call_support text-right">
                        <p><i class="icon-phone-call" aria-hidden="true"></i> <span>Call us: <a
                                    href="tel:+8801828-444999">01828-444999</a></span></p>

                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!--header bottom end-->
</div>
</header>
<!--header area end-->
<script>
    //  $(window).scroll(function () {
    //             if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
    //                 $('.btn__cart__float').css("bottom", "155px")
    //                 $('.fb-button').css("bottom", "125px");
    //                 $('.req').css("bottom", "100px");
    //             } else {
    //                 $('.btn__cart__float').css("bottom", "20px")
    //                 $('.req').css("bottom", "20px");
    //                 $('.fb-button').css("bottom", "20px");
    //             }
    //         });



    $('.checkOut_categories_title').click(function() {
        $('.categories_menu_toggler').toggleClass("show");
    });

    $('.caret__down').click(function() {
        if ($('.sub_category_list_item').hasClass('show')) {
            if (!$(this).parent().siblings('.sub_category_list_item').hasClass('show')) {
                $('.sub_category_list_item').removeClass('show');
            }
        }
        $(this).parent().siblings('.sub_category_list_item').toggleClass('show');
    });

    // $(document).click(function (e) {
    //  if (!$(e.target).is('#cateGoryBox')) {
    //$('.categories_menu_toggler ').removeClass('show');
    //}
    //});
    $(document).mouseup(function(e) {
        var container = $("#cateGoryBox");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.categories_menu_toggler ').removeClass('show');
            $('.sub_category_list_item ').removeClass('show');
        }
    });




    function categoryRedirect(id) {
        var option = $(id).val();
        window.open("{{ URL('shopByCategory') }}/" + option);
    }

    function openSideNav() {
        // $('.mini_cart')[0].classList.toggle('active');
        $('.mini_cart').addClass('active');
        $('.off_canvars_overlay').addClass('active');
    }

    function closeSideNav() {
        $('.mini_cart.active').removeClass('active');
        $('.off_canvars_overlay').removeClass('active');
    }
</script>
