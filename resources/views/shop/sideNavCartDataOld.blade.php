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
                    src="http://103.115.25.104/medicalshop/public/itemImage/c2F2bG9uLWluc3RhbnQtaGFuZC1zYW5pdGl6ZXItMjAwLW1sICgxKS5qcGczODc5MzI=.jpg"
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
{{-- @if($cart->items->count()>0) --}}
    <table class="table table-bordered table-responsive"style="width:100%" id="orderTable">
            <tr>
              <th>Product</th>
              <th>Image</th>
              <th style="width:30%;text-align:right;">Quantity</th>
              <th style="text-align:right;">Total</th>
              <th style="text-align:right;">Action</th>
            </tr>


            

           
            
            
              {{-- @dd($cart->items) --}}
              @foreach ($cart->items as $itemKey => $allItems)
              
                <tr>
                  <td style="padding: 10px 8px;vertical-align: middle;border-top: 1px solid #e9ecef;">{{$allItems['item']->name}}</td>
                        

                         <td style="padding: 10px 8px;vertical-align: middle;border-top: 1px solid #e9ecef;">
                             <img class="img-thumbnail" src="{{ asset($allItems['item']->thumbnail) }}" alt="" style="width:50px;height:50px">
                            </td>


                           <td style="padding: 10px 8px;vertical-align: middle;border-top: 1px solid #e9ecef;">
                             {{-- <span class="badge badge-success mr-2 sm_mr__2" style="background: rgb(71, 114, 6);cursor:pointer" onclick="quantityWiseChangeValue('quantity{{$loop->iteration}}','price{{$loop->iteration}}','priceTd{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{@$shippingCharge->amount}},{{$itemKey}})">+</span> --}}
                             <span class="badge badge-primary ml-2 sm_ml__2" style="background: crimson;cursor:pointer" onclick="minusQuantity('quantity{{$loop->iteration}}','price{{$loop->iteration}}','priceTd{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{@$shippingCharge->amount}},{{$itemKey}})">-</span>
                             <input type="number" min="1" class="form-control form-control-sm custom__size text-center" onchange="quantityWiseChangeValue('quantity{{$loop->iteration}}','price{{$loop->iteration}}','priceTd{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{@$shippingCharge->amount}})" id="quantity{{$loop->iteration}}" name="quantity[]"  value="{{$allItems['qty']}}" readonly>
                             <input type="hidden" class="form-control form-control-sm" name="title[]"  value="{{$allItems['item']->name}}" >
                             <input type="hidden" min="1" class="form-control form-control-sm" name="price[]"  value="{{$allItems['price']}}" id="price{{$loop->iteration}}" >
                             <input type="hidden" min="1" class="form-control form-control-sm" name="product_id[]"  value="{{$itemKey}}" >
                             {{-- <span class="badge badge-primary ml-2 sm_ml__2" style="background: crimson;cursor:pointer" onclick="minusQuantity('quantity{{$loop->iteration}}','price{{$loop->iteration}}','priceTd{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{@$shippingCharge->amount}},{{$itemKey}})">-</span> --}}
                             <span class="badge badge-success mr-2 sm_mr__2" style="background: rgb(71, 114, 6);cursor:pointer" onclick="quantityWiseChangeValue('quantity{{$loop->iteration}}','price{{$loop->iteration}}','priceTd{{$loop->iteration}}',{{$allItems['item']->sales_price}},{{@$shippingCharge->amount}},{{$itemKey}})">+</span>
                            </td>


                       




                        <td style="text-align:right;padding: 10px 8px;vertical-align: middle;border-top: 1px solid #e9ecef;" id="priceTd{{$loop->iteration}}">৳{{$allItems['price']}}</td>
                        <td style="float: right;padding: 10px 8px;vertical-align: middle;border-top: 1px solid #e9ecef;">
                                <button type="button" class="btn btn-danger form-control-sm" onclick="removeItem({{$itemKey}})" style="border: none;cursor:pointer"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </td>
                        

                       
                      </tr>
                  
              @endforeach


              <input type="hidden" id="getTotalAmount" value="{{$cart->totalPrice}}">
              <input type="hidden" id="getTotalQuantity" value="{{$cart->totalQty}}">

              
            
              
           
          </table>




          
            <div class="row" id="subTotal">
              <div class="col-sm-4"></div>
              <div class="col-sm-8">
                <ul class="list-group">
                  <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span class="float-right" id="totalAmount">৳{{$cart->totalPrice}}</span></li>
                  <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span class="float-right">৳{{@$shippingCharge->amount}}</span></li>
                  <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span class="float-right" id="totalAmountWithCharge">৳{{$cart->totalPrice+@$shippingCharge->amount}}</span></a></li>
                </ul>
              </div>
            </div>
            


          <div class="cart__btn text-center my-4">
          <a href="{{URL::to('./checkout')}}" class="btn btn-primary text-white">Proceed To Checkout</a>
          </div>

          @else

            <h5 class="text-center text-danger"> Shopping cart is empty</h5>

          @endif




           