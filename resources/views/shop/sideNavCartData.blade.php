{{-- <table class="table table-bordered" style="width:100%" id="orderTable">
    <tbody>
        <tr>
            <th>Product</th>
            <th>Image</th>
            <th style="width:30%;text-align:right;">Quantity</th>
            <th style="text-align:right;">Total</th>
            <th style="text-align:right;">Action</th>
        </tr>
        <tr>
            <td>Savlon</td>
            <td>
                <img class="img-thumbnail"
                    src="{{ asset('itemImage/c2F2bG9uLWluc3RhbnQtaGFuZC1zYW5pdGl6ZXItMjAwLW1sICgxKS5qcGczODc5MzI=.jpg') }}"
                    alt="" style="width:50px;height:50px">
            </td>
            <td>
                <input type="number" min="1" class="form-control form-control-sm"
                    onchange="quantityWiseChangeValue('quantity1','price1','priceTd1',390,120)" id="quantity1"
                    name="quantity[]" value="1">
                <input type="hidden" class="form-control form-control-sm" name="title[]" value="Savlon">
                <input type="hidden" min="1" class="form-control form-control-sm" name="price[]" value="390"
                    id="price1">
                <input type="hidden" min="1" class="form-control form-control-sm" name="product_id[]" value="2">
            </td>

            <td style="text-align:right;" id="priceTd1">৳390.00</td>
            <td style="float: right">
                <button type="button" class="btn btn-danger form-control-sm" onclick="removeItem(2)"
                    style="border: none"><i class="fa fa-times" aria-hidden="true"></i></button>
            </td>

        </tr>

    </tbody>
</table> --}}




@if(isset($cart))
<div class="cart_close">
  <div class="cart_text">
      <h3>Cart</h3>
  </div>
  <div class="mini_cart_close">
      <a href="javascript:void(0)" onclick="closeSideNav()"><i class="icon-x"></i></a>
  </div>
</div>

@foreach ($cart->items as $itemKey => $allItems)
<div class="cart_item">
  <div class="cart_img">
      <a href="#"><img src="{{ asset($allItems['item']->thumbnail) }}" alt=""></a>
  </div>
   <div class="cart_info">
       <a href="#">{{$allItems['item']->name}}</a>
       <p>Qty: {{ $allItems['qty'] }} X <span> ৳{{ $allItems['price'] }} </span></p>
   </div>
   <div class="cart_remove">
       <a href="#" onclick="removeItem({{$itemKey}})"><i class="ion-android-close"></i></a>
   </div>
</div>
@endforeach
<input type="hidden" id="getTotalAmount" value="{{$cart->totalPrice}}">
<input type="hidden" id="getTotalQuantity" value="{{$cart->totalQty}}">


<div class="mini_cart_table">
  <div class="cart_total">
      <span>Sub total:</span>
      <span class="price" id="totalAmount">৳{{$cart->totalPrice}}</span>
  </div>
  <div class="cart_total mt-10">
    <span>Shipping:</span>
    <span class="price">৳{{@$shippingCharge->amount}}</span>
  </div>
  <div class="cart_total mt-10">
      <span>total:</span>
      <span class="price" id="totalAmountWithCharge">৳{{$cart->totalPrice+@$shippingCharge->amount}}</span>
      
  </div>
</div>

<div class="mini_cart_footer">
  {{-- <div class="cart_button">
       <a href="cart.html">View cart</a>
   </div> --}}
   <div class="cart_button">
       <a class="active" href="{{URL::to('./checkout')}}">Proceed To Checkout</a>
   </div>

</div>





{{-- @if($cart->items->count()>0) --}}
   

          @else

            <h5 class="text-center text-danger"> Shopping cart is empty</h5>

          @endif 
           

