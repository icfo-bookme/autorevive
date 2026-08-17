@extends('layouts.master')
@section('title')
  HOME
@endsection
@section('content')
 <div id="fullNav">

  @include('partials.navBar')
  @section('styles')
  <link href="{{asset('styles/check_out.css')}}" rel="stylesheet" type="text/css">
  {{-- <link href="{{asset('styles/css/search.css')}}" rel="stylesheet" type="text/css"> --}}
  {{-- \\103.115.25.104\computershop\public\css\search.css --}}
@endsection

 <div> 

  
  @if (isset($anchor))
    <input type="hidden" name="anchor" id="anchor" value="{{ $anchor }}">
  @endif

  <!--================Checkout Area =================-->
  <section class=" section_gap" style="margin-top:5%;">
    <div class="container">
      <div class="alert alert-success" id="alert" role="alert" style="visibility: hidden;">
        Your order has been accepted
      </div>


       <div class="alert alert-danger" id="alert-item-problem" role="alert" style="visibility: hidden;">
      
      </div>

      <div class="billing_details">
        <div class="row">
          {{-- @if(\Auth::check()==false) --}}
          <div class="col-lg-6">
            <h3>Billing Details</h3>
            <form class="row contact_form" action="#" method="post" id="checkoutForm">
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="first" placeholder="First name" name="first_name" required="">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="last" name="last_name" placeholder="Last name">
              </div>
              <div class="col-md-12 form-group">
                <input type="text" class="form-control" id="company" name="company" placeholder="Company name">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="number" name="number" placeholder="Phone number" required="">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" required="">
              </div>
          
              <div class="col-md-12 form-group p_star" >
                <input type="text" class="form-control" id="add1" name="add1" placeholder="Address line 01" required="" >
              </div>
              <div class="col-md-12 form-group p_star">
                <input type="text" class="form-control" id="add2" name="add2" placeholder="Address line 02">
              </div>
              <div class="col-md-12 form-group p_star">
                <input type="text" class="form-control" id="city" name="city" placeholder="Town/City">
              </div>


              {{-- <div class="col-md-12 form-group">
                <div class="creat_account">
                  <input type="checkbox" id="f-option2" name="selector">
                  <label for="f-option2">Create an account?</label>
                </div>
              </div>  --}}

               <div class="col-md-12 form-group">
                {{-- <div class="creat_account">
                  <h3>Shipping Details</h3>
                  <input type="checkbox" id="f-option3" name="selector">
                  <label for="f-option3">Ship to a different address?</label>
                </div> --}}
                <textarea class="form-control" name="notes" id="message" rows="3" col="5" placeholder="Order Notes"></textarea>
              </div> 

          </div>
          {{-- @endif --}}
          <div class="col-lg-6">
            <div class="order_box" id="order_box">
              <h2>Your Order</h2>
              <table class="table table-bordered"style="width:100%" id="orderTable">
                <tr>
                  <th>Product</th>
                  <th>Image</th>
                  <th style="width:30%;text-align:right;">Quantity</th>
                  <th style="text-align:right;">Total</th>
                  <th style="text-align:right;">Action</th>
                </tr>


                @isset($cart)
                  {{-- @dd($cart->items) --}}
                  @foreach ($cart->items as $itemKey => $allItems)
                  
                    <tr>
                      <td>{{$allItems['item']->name}}</td>
                            

                             <td>
                                 <img class="img-thumbnail" src="{{ asset($allItems['item']->thumbnail) }}" alt="" style="width:50px;height:50px">
                            </td>


                            {{-- <td>
                                 <input type="number" min="1" class="form-control form-control-sm" onchange="quantityWiseChangeValue('quantity{{$loop->iteration}}','price{{$loop->iteration}}','priceTd{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{$shippingCharge->amount}})" id="quantity{{$loop->iteration}}" name="quantity[]"  value="{{$allItems['qty']}}">
                                 <input type="hidden" class="form-control form-control-sm" name="title[]"  value="{{$allItems['item']->name}}" >
                                 <input type="hidden" min="1" class="form-control form-control-sm" name="price[]"  value="{{$allItems['price']}}" id="price{{$loop->iteration}}" >
                                 <input type="hidden" min="1" class="form-control form-control-sm" name="product_id[]"  value="{{$itemKey}}" >
                            </td> --}}



                              <td>
                                 {{-- <span class="badge badge-success mr-2" style="background: rgb(71, 114, 6);cursor:pointer" onclick="quantityWiseChangeValue('quantityCheckout{{$loop->iteration}}','priceCheckout{{$loop->iteration}}','priceTdCheckout{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{$shippingCharge->amount}},{{$itemKey}})">+</span> --}}
                                 <span class="badge badge-primary ml-2" style="background: crimson;cursor:pointer" onclick="minusQuantity('quantityCheckout{{$loop->iteration}}','priceCheckout{{$loop->iteration}}','priceTdCheckout{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{$shippingCharge->amount}},{{$itemKey}})">-</span>
                                 <input type="number" min="1" class="form-control form-control-sm custom__size text-center"  onchange="quantityWiseChangeValue('quantityCheckout{{$loop->iteration}}','priceCheckout{{$loop->iteration}}','priceTdCheckout{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{$shippingCharge->amount}})" id="quantityCheckout{{$loop->iteration}}" name="quantity[]"  value="{{$allItems['qty']}}" readonly>
                                 <input type="hidden" class="form-control form-control-sm" name="title[]"  value="{{$allItems['item']->name}}" >
                                 <input type="hidden" min="1" class="form-control form-control-sm" name="price[]"  value="{{$allItems['price']}}" id="priceCheckout{{$loop->iteration}}" >
                                 <input type="hidden" min="1" class="form-control form-control-sm" name="product_id[]"  value="{{$itemKey}}" >
                                 {{-- <span class="badge badge-primary ml-2" style="background: crimson;cursor:pointer" onclick="minusQuantity('quantityCheckout{{$loop->iteration}}','priceCheckout{{$loop->iteration}}','priceTdCheckout{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{$shippingCharge->amount}},{{$itemKey}})">-</span> --}}
                                 <span class="badge badge-success mr-2" style="background: rgb(71, 114, 6);cursor:pointer" onclick="quantityWiseChangeValue('quantityCheckout{{$loop->iteration}}','priceCheckout{{$loop->iteration}}','priceTdCheckout{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{$shippingCharge->amount}},{{$itemKey}})">+</span>
                                </td>

                             <td style="text-align:right;" id="priceTdCheckout{{$loop->iteration}}">৳{{$allItems['price']}}</td>
                            <td style="float: right">
                                    <button type="button" class="btn btn-danger form-control-sm" onclick="removeItem({{$itemKey}})" style="border: none"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </td>
                            

                           
                          </tr>
                      
                  @endforeach
                @endisset
              </table>
      
              @isset($cart)
                {{-- <ul class="list list_2">
                  <li><a href="#">Subtotal <span>{{number_format($cart->totalPrice,2)}}</span></a></li>
                  <li><a href="#">Shipping <span>Flat rate: 50.00</span></a></li>
                  <li><a href="#">Total <span>{{number_format($cart->totalPrice+50.00,2)}}</span></a></li>
                </ul> --}}
                {{-- demo for UI changes --}}
                <div class="row" id="subTotal">
                  <div class="col-sm-4"></div>
                  <div class="col-sm-8">
                    <ul class="list-group">
                      <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span class="float-right" id="totalAmountCheckout">৳{{$cart->totalPrice}}</span></li>
                      <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span class="float-right">৳{{$shippingCharge->amount}}</span></li>
                      <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span class="float-right" id="totalAmountWithChargeCheckout">৳{{$cart->totalPrice+$shippingCharge->amount}}</span></a></li>
                    </ul>
                  </div>
                </div>
                {{-- <table class="table table-bordered">
                  <tr>
                    <td class="border">Subtotal</td>
                    <td>৳ 2500</td>
                  </tr>
                  <tr>
                    <th>Subtotal</th>
                    <td>৳ 2500</td>
                  </tr>
                  <tr>
                    <th>Subtotal</th>
                    <td>৳ 2500</td>
                  </tr>
                </table> --}}
              @endisset
              <div id="buttonSubmitCart">
              @isset($cart)
                <div class="payment_item mb-5">
                  <div class="creat_account py-3">
                    {{-- <input type="checkbox" id="f-option4" name="selector">
                    <label for="f-option4">I’ve read and accept the </label>
                    <a href="#">terms & conditions*</a>
                  </div> --}}
                  <input type="submit" class="btn btn-primary btn-lg btn-block">
                  <input type="button" class="btn btn-secondary btn-lg btn-block"  onclick="clearCart();" value="Clear Cart" >
                  
                </div>
                
              @endisset
              </div>
            </div>
            
          </div>
          </form>
        
          

        </div>
      </div>
    </section>



     <!-- loader modal -->
    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src='{{asset('assets/images/preloader.gif')}}'
                style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>


    <!-- confirm notice modal -->
    <div class="modal" id="notice-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content animated flipInX">
          {{-- <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> --}}
          <div class="modal-body p-1">
            <div class="text-center">
                <img src="{{asset('assets/images/computershop.jpg')}}" width="150" height="150" class="rounded-circle round-image" alt="">
            </div>
            <div class="alert alert-success " role="alert" style="background: #092c63;">
                <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
                {{-- <div class="alert-icon">
                    <i class="fa fa-check"></i>
                </div> --}}
                <div class="alert-message">
                    <span style="color: #b4bdca;"><strong style="color: lightgreen;"> <i class="fa fa-check mr-2"></i> Your Order is
                            Successfull!!!</strong> You can login and see order History</span>
                </div>
            </div>

        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-success btn-lg" data-dismiss="modal"
                style="background: #092c63;border: 1px solid #092c63;">OK</button>
        </div>
        </div>
      </div>
    </div>







    

   



 

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!--================End Checkout Area =================-->
  @endsection
  @section('scripts')
  
    <script>

      // $(document).ready(function(){
      //  $('#notice-modal').modal('show');
      // //  alert();
      // });

    
    $("#checkoutForm").submit(function(){
        event.preventDefault();
        $('#preloader').modal('show');
        var base_url         =  {!! json_encode(url('/')) !!}
       
        $.ajax({
          url: './checkoutDone',
          type: 'POST',
          data:$("#checkoutForm").serialize()+"&_token={{csrf_token()}}",
          success: function (response) {
            console.log(typeof(response));
            if(typeof response == 'undefined'){
                alert("error");
                $('#preloader').hide();
            }else if(typeof(response) == 'object'){
                $('#preloader').modal('hide');
                alertify
                .alert("<span class='text-warning'>Warning!!!</span>","Your required "+response.problemProductName.toLowerCase()+" quantity can't be less than "+response.minimumQuantity, function(){
                // alertify.message('OK');
                });
                // alertify.error();

            }else{
             $('#preloader').modal('hide');
             $('#checkoutForm').trigger("reset");
             $("#alert").css("visibility", "visible");
             $('#notice-modal').modal('show');
           
             setTimeout(function () {
                      location.href = "{{url('/')}}";
                }, 2000);
            }
          },
          error: function () {
           $('#preloader').modal('hide');
          }
        });
    });





  
    function removeItem(id){
      $.ajax({
          url: '{{ url("removeItemFromCart") }}',
          type: 'POST',
          data:{
            "_token"  : "{{ csrf_token() }}",
            "item_id" : id
          },
          success: function (response) {

            $("#orderTable").load(location.href+" #orderTable>*","");
            $("#subTotal").load(location.href+" #subTotal>*","");
            $('#buttonSubmitCart').load(location.href+" #buttonSubmitCart>*","");
            $('#fullNav').load(location.href+" #fullNav>*","");
            
          },
          error: function () {
            // alert("error");
          }
        });
    }


    function clearCart(){
      event.preventDefault();
      alertify.confirm('Are You Sure ?', ' Do you want to remove all item from your cart?', function () {
      $('#preloader').modal('show');
      $.ajax({
          url: '{{ url("clearCart") }}',
          type: 'POST',
          data:{
            "_token"  : "{{ csrf_token() }}",
          },
          success: function (response) {
            $('#preloader').modal('show');
            setTimeout(function () {
                      location.href = "{{url('/')}}";
                }, 2000);
          },
          error: function () {
           $('#preloader').modal('hide');
          }
        });

             }, function () {
             alertify.error('Cancel')
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

        
        $('#totalAmountCheckout').html('৳'+value);
        $('#totalAmountWithChargeCheckout').html('৳'+(value+shippingCharge));   
    
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
      $("#totalCartAmount").text(response.cart.totalPrice);

        //     $.ajax({
        //     url: '{{url("getSidecartData")}}',
        //     type: 'get',
        //     success: function (response) {
        //       $('#sideNavCartData').html(response);
        //     },
        //     error: function () {
        //     alert("error");
        //     }
        // });


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

        //     $.ajax({
        //     url: '{{url("getSidecartData")}}',
        //     type: 'get',
        //     success: function (response) {
        //       $('#sideNavCartData').html(response);
        //     },
        //     error: function () {
        //     alert("error");
        //     }
        // });


    },
    error: function () {
      alert("error");
    }
  });
  }









  function minusQuantity(quantityId,priceId,tdId,price,shippingCharge,productId){
    var quantityVal = parseInt($('#'+quantityId).val());

    if (quantityVal > 1) {
    
     decreaseToCart(productId);
     var value = 0;
     var xVal = quantityVal-1;
   
     $('#'+quantityId).val(xVal);
     var total = price*xVal;
     $('#'+priceId).val(total);
     $('#'+tdId).html('৳'+total);
     var totalAmount = $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();
      
        for ( var i = 0; i < totalAmount.length; i++) {
         
          value += parseInt(totalAmount[i]);
        }

        
        $('#totalAmountCheckout').html('৳'+value);
        $('#totalAmountWithChargeCheckout').html('৳'+(value+shippingCharge));   

    }else{

    }
     
  }


    </script>
    <script>
      if ($(window).width() <= 700) {
        
        $("#custom_id_sm").css("display", "block");
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
  <script src="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
  <script src="{{ asset('plugins/easing/easing.js') }}"></script>
  <script src="{{ asset('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script>
  <script src="{{ asset('js/shop_custom.js') }}"></script>

  @endpush
