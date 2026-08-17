@extends('layouts.master')
@section('title')
About Us
@endsection
@section('content')
@include('partials.navBar')
@section('styles')
{{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
<link href="{{asset('styles/shop_styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('styles/shop_responsive.css')}}" rel="stylesheet" type="text/css"> --}}
<link rel="stylesheet" type="text/css" href="{{asset('styles/blog_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('styles/blog_responsive.css')}}">
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

<div class="home">
    <div class="home_background parallax-window" data-parallax="scroll"
        data-image-src="{{asset('img/images/shop_background.jpg')}}">
    </div>
    <div class="home_overlay"></div>
    <div class="home_content d-flex flex-column align-items-center justify-content-center">
        <h2 class="home_title" style="font-size: 48px;">About US</h2>
    </div>
</div>

<!-- Blog -->

<div class="blog">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="text-center our-custom-header">
                    <h1 class="pb-3">Our Story</h1>
                </div>
                <div class="row text-left  ">

                    <div class="col-md-6">
                        <div class="service_left_text_top wow fadeInUp"
                            style="visibility: visible; animation-name: fadeInUp;">
                            <p>MediTools is an online shop for personal healthcare items essentials for home users. Our goal is to deliver all essential healthcare items for home users at a n affordable price right to their door steps</p>
                            <p>Meditools is gaining trust of thousands of loyal customers for delivering only genuine and quality products at an reasonable price. Our strength is our highly rated customer service and fast delivery</p>
                            <p>Meditools also provide wholesale price for bulk items.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service_left_text_top wow fadeInUp"
                            style="visibility: visible; animation-name: fadeInUp;">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, quos. Placeat ratione magni
                                dolor hic officiis distinctio perspiciatis incidunt est.</p>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Impedit fugit harum vero
                                debitis voluptas maiores minus ad, nisi sit sint!</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi distinctio excepturi
                                animi sint, corrupti nam quibusdam ratione deserunt incidunt ipsam.</p>
                        </div>

                    </div>
                </div>
            </div>

            {{-- <div class="col-sm-12 py-3">
                <div class="text-center our-custom-header">
                    <h1 class="border-bottom pb-3">Our Aim</h1>
                </div>
                <div class="card my-4">
                    <div class="row no-gutters">
                        <div class="col-md-6" style="background: #422F95;">
                            <div class="card-body text-white">
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/demo.PNG')}}" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9 pt-3">
                                        <h4 class="text-white">Embrace Change</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/demo.PNG')}}" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9 pt-3">
                                        <h4 class="text-white">Embrace Change</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/demo.PNG')}}" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9 pt-3">
                                        <h4 class="text-white">Embrace Change</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/demo.PNG')}}" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9 pt-3">
                                        <h4 class="text-white">Embrace Change</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>


                                <!-- <h5 class="card-title">Card title</h5>
                            <p class="text-white">It's a broader card with text below as a natural lead-in to extra content. This content is a little longer.</p>
                            <p class="text-white"><small >Last updated 3 mins ago</small></p> -->

                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="{{asset('img/images/card-images.PNG')}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 py-3">
                <div class="text-center our-custom-header">
                    <h1 class="border-bottom pb-3">Our Promise</h1>
                </div>
                <div class="card my-4">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <img src="{{asset('img/images/promise.PNG')}}" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6 custom_bg">
                            <div class="card-body text-white">
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/shopping-cart.png')}}" width="80" height="80"
                                            alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 class="text-white">Biggest Variety</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/shopping-online.png')}}" width="80" height="80"
                                            alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 class="text-white">Best Price</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/commerce-and-shopping.png')}}" width="80"
                                            height="80" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 class="text-white">Ease And Speed</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-sm-3">
                                        <img src="{{asset('img/images/home-delivery.png')}}" width="80" height="80"
                                            alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 class="text-white">Fast Delivery</h4>
                                        <p class="text-white text-jsutify">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Laborum fuga, minus veniam iure voluptatem beatae rerum
                                            porro ad quia expedita!</p>
                                    </div>
                                </div>


                                <!-- <h5 class="card-title">Card title</h5>
                          <p class="text-white">It's a broader card with text below as a natural lead-in to extra content. This content is a little longer.</p>
                          <p class="text-white"><small >Last updated 3 mins ago</small></p> -->

                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>









<script>

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



  function decreaseToCart(id){
  var base_url =  {!! json_encode(url('/')) !!}

  $.ajax({
    url: base_url+'/decreaseToCart',
    type: 'POST',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
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
              $('#cartSymbolTwo').text(totalQuantity);
              $("#totalCartAmount").text(totalPrice);
              }else{
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
@push('footerasset')

<script src="{{ asset('styles/bootstrap4/popper.js') }}"></script>
<script src="{{ asset('styles/bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TweenMax.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TimelineMax.min.js') }}"></script>
<script src="{{ asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/animation.gsap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
<script src="{{ asset('plugins/easing/easing.js') }}"></script>
<script src="{{ asset('js/blog_custom.js') }}"></script>

@endpush
