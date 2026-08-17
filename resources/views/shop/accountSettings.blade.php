@extends('layouts.master')
@section('title')
HOME
@endsection
@section('content')
@include('partials.navBar')
@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
  <link href="{{asset('styles/shop_styles.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('styles/shop_responsive.css')}}" rel="stylesheet" type="text/css"> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('styles/contact_styles.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('styles/contact_responsive.css')}}">
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

<div class="my-account-setting py-5">
    <div class="row justify-content-center">
        <form id="AccountSettingsForm" style="width: 100%;">
          @csrf
            <div class="col-sm-6 mx-auto">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value={{Auth::user()->first_name}}  placeholder="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="text" name="email" value="{{Auth::user()->email}}" placeholder="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" name="pass" id="password" placeholder="New password" class="form-control">
                </div>

                 <div id="password-feedback" style="display:none" class="invalid-feedback text-danger">
                        Password Doesn't Match
                  </div>

                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" name="confirmPass" id="password-confirm" onkeyup="verifyPass()" placeholder="Confirm password" class="form-control">
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary mr-2">Save</button>
                <button class="btn btn-secondary mr-2">Cancel</button>
            </div>
        </form>
  
    </div>
</div>


<script>


	$("#AccountSettingsForm").submit(function() {
		event.preventDefault();
		alertify.confirm('Are You Sure ?', ' Do you want to change your Account Information?', function () {

			$.ajax({
                type: 'post',
                url: '{{URl("accountSettingsAjax")}}',
                data: $('#AccountSettingsForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
						// $( "#contact_form" ).trigger( "reset" );
                        alertify.error('Something Went Wrong');
                       
                    }else {
                        //alert(data);
                        alertify.success(data);
						
						            $( "#AccountSettingsForm" ).trigger( "reset" );
                        setTimeout(function () {
                            location.reload(true);
                        }, 1000)


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
    
    
    
    
    
    //   var globalDataArray      = new Array();
    //   var globalTotalPages ;
    
    //   function addToCart(id){
    //   var base_url =  {!! json_encode(url('/')) !!}
    
    //   $.ajax({
    //     url: base_url+'/addToCart',
    //     type: 'POST',
    //     data:{  "_token": "{{ csrf_token() }}",id:id} ,
    //     success: function (response) {
    //       $("#cartSymbol").text(response.cart.totalQty);
    //     },
    //     error: function () {
    //       alert("error");
    //     }
    //   });
    //   }





      function verifyPass() {
            // alert();
            var password = $("#password").val();
            var confirmPass = $("#password-confirm").val();
            // console.log(password);
            // console.log(confirmPass);
            if (password != confirmPass) {
                $("#password-feedback").show();
                $("#save").attr('disabled', true);
                //$("#password-confirm").removeClass("border-primary").addClass("border-danger");
                $("#password-confirm").css("border", "2px solid #DA4453")
            } else {
                // console.log("hello");
                $("#password-feedback").hide();
                $("#save").prop('disabled', false);
                //$("#password-confirm").removeClass("border-danger").addClass("border-primary");
                $("#password-confirm").css("border", "");
            }
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


    function categoryRedirect(id){
       var option = $(id).val();
       window.open("{{URL('shopByCat')}}/"+option);
    }

   function openSideNav() {
        // $('.mini_cart')[0].classList.toggle('active');
        $('.mini_cart').addClass('active');
        $('.off_canvars_overlay').addClass('active');
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
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
    <script src="{{asset('js/contact_custom.js')}}"></script>
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
     <script src="{{ asset('plugins/easing/easing.js') }}"></script>
     <script src="{{ asset('js/contact_custom.js') }}"></script>

     @endpush