@extends('layouts.master')
@section('title')
HOME
@endsection
@section('content')
@include('partials.navBar')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
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

	<!-- Home -->

	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{asset('img/images/shop_background.jpg')}}"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">Shop</h2>
		</div>
    </div>
    
	<!-- Shop -->

	<div class="shop">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<!-- Shop Sidebar -->
					<div class="shop_sidebar">
						<div class="sidebar_section">


							<div class="sidebar_title">Categories</div>
							<ul class="sidebar_categories">

								<li><a class="clc" onclick="searchProductByCategory(0)" style="cursor:pointer">All Category</a></li>
								@foreach($allCategories as $category)

								<li><a onclick="searchProductByCategory({{ $category->id }})" style="cursor:pointer">{{ $category->name }}</a></li>
								
								@endforeach


							</ul>
						</div>
						{{-- <div class="sidebar_section filter_by_section">
							<div class="sidebar_title">Filter By</div>
							<div class="sidebar_subtitle">Price</div>
							<div class="filter_price">
								<div id="slider-range" class="slider_range"></div>
								<p>Range: </p>
								<p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
							</div>
						</div> --}}


						<div class="sidebar_section filter_by_section mb-2">
							<div class="sidebar_title">Filter By</div>
							<div class="sidebar_subtitle">Price</div>
							<form id="rangeForm">
							<input type="number" class="custom-input-field mr-2" placeholder="From" min="0" name="from" required> <input type="number" class="custom-input-field" name="to" min="0" placeholder="To" required>
							<button type="submit" class="btn btn-primary price-filter-btn" style="cursor: pointer"><i class="fa fa-play" aria-hidden="true"></i></button>
							</form>
            </div>
            <div class="clearfix"></div>
            <br>
						
						
						<div class="sidebar_section">
							<div class="sidebar_subtitle brands_subtitle" style="font-size: 18px;">Brands</div>
							<ul class="brands_list">
								<li class="brand" onclick="getProductByBrand(0)" style="cursor:pointer">All Brands</li>
								@foreach($brands as $brand)
								<li class="brand" onclick="getProductByBrand({{$brand->id}})" style="cursor:pointer">{{$brand->name}}</li>
								@endforeach
								
							</ul>
						</div>
					</div>

				</div>

				<div class="col-lg-9">
					
					<!-- Shop Content -->

					<div class="shop_content">
						<div class="shop_bar clearfix">
							<div class="shop_product_count">Products</div>
							<div class="shop_sorting">
								<span>Sort by:</span>
								<ul>
									<li>
										<span class="sorting_text">highest rated<i class="fas fa-chevron-down"></span></i>
										<ul>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>highest rated</li>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>name</li>
											<li class="shop_sorting_button"data-isotope-option='{ "sortBy": "price" }'>price</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>

						<div id="allProducts">
						<div class="product_grid">
							<div class="product_grid_border"></div>

					
							@foreach($allProducts as $item)
							<!-- Product Item -->
							<div class="product_item is_new">
								<div class="product_border"></div>
								<a href="{{url('singleProductDetails',$item->id)}}" tabindex="0">
								<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{asset($item->thumbnail)}}" alt=""></div>
								</a>
								<div class="product_content">
									<div class="product_price">৳{{$item->sales_price}}</div>
									<div class="product_name"><div class="px-2 text-truncate"><a href="{{url('singleProductDetails',$item->id)}}" tabindex="0">{{$item->name}}<small style="font-size: 55%">(Min Order {{$item->minimum_order_quantity}})</small></a></div></div>
									<button class="btn customized-btn" onclick="addToCart({{$item->id}})">Add to Cart</button>
								</div>
								<div class="product_fav"><i class="fas fa-heart"></i></div>
								<ul class="product_marks">
									{{-- <li class="product_mark product_discount">-25%</li>
									<li class="product_mark product_new">new</li> --}}
								</ul>
							</div>

							@endforeach
						
							
							


						</div>
						</div>	

						<!-- Shop Page Navigation -->

						<div class="shop_page_nav d-flex flex-row" id="pregination">
							{{-- <div class="page_prev d-flex flex-column align-items-center justify-content-center"><i class="fas fa-chevron-left"></i></div> --}}
							<ul class="page_nav d-flex flex-row">
								 {!! $allProducts->render()!!}
							</ul>
							{{-- <div class="page_next d-flex flex-column align-items-center justify-content-center"><i class="fas fa-chevron-right"></i></div> --}}
						</div>

					</div>

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


<!-- loader modal -->
    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src='{{asset('assets/images/preloader.gif')}}'
                style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>


<script>


$(document).ready(function() {

	$("#rangeForm").submit(function(){
        event.preventDefault();
        $('#preloader').modal('show');
        // var base_url =  {!! json_encode(url('/')) !!}
        $.ajax({
          url     : '{{url("getProductByRange")}}',
          type    : 'POST',
		  data    : $("#rangeForm").serialize()+"&_token={{csrf_token()}}",
		  dataType: 'html',
          success: function (response) {
            if(typeof response == 'undefined'){
                alert("error");
                $('#preloader').hide();
            }else{
            
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
	
});

function searchProductByCategory(id){
    
  $.ajax({
    url: '{{url("searchProductByCategory")}}',
    type: 'get',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
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



  function getProductByBrand(id){

	$.ajax({
    url: '{{url("getProductByBrandAjax")}}',
    type: 'get',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
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

{{-- @section('scripts')
<script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
<script src="{{asset('js/shop_custom.js')}}"></script>
@endsection --}}



@endsection
{{-- @include('partials.footer') --}}

@push('footerasset')

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

@endpush
