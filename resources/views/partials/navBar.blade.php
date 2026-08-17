
 <!--header area start-->

 <div class="">
    <a href="" class="float-add-to-cart"></a>
</div>

<!--offcanvas menu area start-->
<div class="off_canvars_overlay">
            
</div>
<div class="offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="offcanvas_menu_wrapper">
                    <div class="canvas_close">
                          <a href="javascript:void(0)"><i class="ion-android-close"></i></a>  
                    </div>
                    <div class="call_support">
                        <p><i class="icon-phone-call" aria-hidden="true"></i> <span>Call us: <a href="tel:+8801828-444999">01828-444999</a></span></p>

                    </div>
                    <div class="header_account">
                        <ul>
                            <li class="language"><a href="#"><img src="{{asset('mazley_assets/img/logo/language.png')}}" alt=""> english <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_language">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Germany</a></li>
                                    <li><a href="#">Japanese</a></li>
                                </ul>
                            </li>
                            <li class="currency"><a href="#">USD <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_currency">
                                    <li><a href="#">EUR – Euro</a></li>
                                    <li><a href="#">GBP – British Pound</a></li>
                                    <li><a href="#">INR – India Rupee</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="header_top_links">
                        <ul>
                            <li><a href="{{url('register')}}">Register</a></li>
                            <li><a href="{{url('login')}}">login</a></li>
                            {{-- <li><a href="">Shopping Cart</a></li>
                            <li><a href="checkout.html">Checkout</a></li> --}}
                        </ul>
                    </div> 
                    {{-- <div class="search_container">
                        <form action="#">
                           <div class="hover_category">
                                
                                
                           </div>
                            
                        </form>
                    </div>  --}}
                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class="menu-item-has-children active">
                                <a href="{{url('/')}}">Home</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{url('shopview')}}">Shop</a>
                            </li>
                            {{-- <li class="menu-item-has-children">
                                <a href="#">blog</a>
                            </li> --}}
                           
                            <li class="menu-item-has-children">
                                <a href="#">my account</a>
                            </li>
                            {{-- <li class="menu-item-has-children">
                                <a href="#">About Us</a>
                            </li> --}}
                            <li class="menu-item-has-children">
                                {{-- <a href="{{ URL('contactFormView') }}"> Contact Us</a> --}}
                                <a href="{{ URL('connectWithUs') }}"> Contact Us</a>
                            </li>
                        </ul>
                    </div>
                    <div class="offcanvas_footer">
                        <span><a href="#"><i class="fa fa-envelope-o"></i> info@yourdomain.com</a></span>
                        <ul>
                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--offcanvas menu area end-->
