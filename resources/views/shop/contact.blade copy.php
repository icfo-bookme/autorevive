@extends('layouts.master')
{{-- @section('title')
HOME
@endsection --}}
@section('content')
{{-- @include('partials.navBar') --}}
@section('styles')

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


  {{-- <div class="contact_page_bg">
    
    
    <div class="container">
        
        <div class="contact_area">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                   <div class="contact_message content">
                        <h3>contact us</h3>    
                        
                        <ul>
                            <li><i class="fa fa-fax"></i> Address: bti Landmark(4th Floor) <br>&nbsp;Wireless Moor <br>  Zakir Hossain Road West Khulshi<br> Chattogram 4000</li>
                            <li><i class="fa fa-phone"></i><a href="#">01828-444999</a></li>
                            <li><i class="fa fa-envelope-o"></i> automart@technova.com</li>
                        </ul>             
                    </div> 
                </div>
                <div class="col-lg-6 col-md-12">
                   <div class="contact_message form">
                        <h3>Have a question?</h3>   
                        <form id="contact_form">
                          @csrf
                            <p>  
                               <label>Name</label>
                                <input id="contact_form_name"  name="contact_form_name" placeholder="Name *" type="text" required> 
                            </p>
                            <p>       
                               <label>Email</label>
                                <input id="contact_form_email" name="contact_form_email" placeholder="Email *" type="email" required>
                            </p>
                            <p>          
                               <label>Number</label>
                                <input id="contact_form_phone" name="contact_form_phone" placeholder="Number *" type="text" required>
                            </p>    
                            <div class="contact_textarea">
                                <label>Your Message</label>
                                <textarea id="contact_form_message" placeholder="Message *" name="message"  class="form-control2"  required></textarea>     
                            </div>   
                            <button type="submit" id="contact_form_submit" class="btn btn-primary"> Send Message</button>  
                            <p class="form-messege"></p>
                        </form> 

                    </div> 
                </div>
            </div>   
        </div>
        
    </div>
  </div> --}}

  <div id="contactApp">
  
  </div>

	
<script src="{{asset('react/app.js')}}"></script>










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


	$("#contact_form").submit(function() {
		event.preventDefault();
		alertify.confirm('Are You Sure ?', ' Do you want to send this mail?', function () {

			$.ajax({
                type: 'post',
                url: '{{URl("contactMailSendAjax")}}',
                data: $('#contact_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
						// $( "#contact_form" ).trigger( "reset" );
                        alertify.error('Something Went Wrong');
                       
                    }else {
                        //alert(data);
                        alertify.success(data);
						
						$( "#contact_form" ).trigger( "reset" );
                        // setTimeout(function () {
                        //     location.reload(true);
                        // }, 1000)


                    }


                },

                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                    }

                }


            });

		}, function () {
		alertify.error('Cancel')
		});
	});


    function searchProductByCategory(id)
    {
        
      $.ajax({
        url: 'searchProductByCategory',
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
        url: 'getProductByBrandAjax',
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

  // function addToCart(id){
  // var base_url =  {!! json_encode(url('/')) !!}

  // $.ajax({
  //   url: base_url+'/addToCart',
  //   type: 'POST',
  //   data:{  "_token": "{{ csrf_token() }}",id:id} ,
  //   success: function (response) {
  //   // console.log(response);
  //     $("#cartSymbol").text(response.cart.totalQty);
  //     $('#cartSymbolTwo').text(response.cart.totalQty);
  //     $("#totalCartAmount").text(response.cart.totalPrice);

  //           $.ajax({
  //           url: '{{url("getSidecartData")}}',
  //           type: 'get',
  //           success: function (response) {
  //             $('#sideNavCartData').html(response);
  //           },
  //           error: function () {
  //           alert("error");
  //           }
  //       });


  //   },
  //   error: function () {
  //     alert("error");
  //   }
  // });
  // }



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
    // function openNav() {

    // if ($(window).width() <= 700) {
		// var size = '100vw';
    // }else{
    //     var size = '35vw';
    // }

    //  document.getElementById("mySidenav").style.width = size;


    // $.ajax({
    //         url: '{{url("getSidecartData")}}',
    //         type: 'get',
    //         success: function (response) {

    //           $('#sideNavCartData').html(response);

    //         },
    //         error: function () {
    //         alert("error");
    //         }
    //     });    



    // }

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
    
    @section('scripts')
    {{-- <script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
    <script src="{{asset('js/shop_custom.js')}}"></script> --}}
    {{-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
    <script src="{{asset('js/contact_custom.js')}}"></script> --}}
    @endsection
    
    
    
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
    <script src="{{ asset('plugins/easing/easing.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA
    "></script>
    <script src="{{ asset('js/contact_custom.js') }}"></script> --}}

     @endpush
    