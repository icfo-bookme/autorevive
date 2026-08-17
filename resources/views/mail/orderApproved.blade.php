@include('partials.backend.header')

<style>
     .order-approved-image{
        width: 50% !important;
     } 
     @media only screen and (max-width: 600px) {
        /* image resposive */
         .order-approved-image{
                width: 100% !important;
        }
        
    }
       
</style>

<body>
    <div class="clearfix"></div>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div id="invoiceElement">
                {{-- <header style="padding: 10px 0; margin-bottom: 20px; border-bottom: 1px solid #3989c6;">
                    <div class="automart-logo" style="display: inline-block;">
                        <img src="https://i.ibb.co/3CPF5Gv/automax-lg.png" width="200" alt="Automart">
                    </div>
                    <div class="address-shop" style="float: right;">
                        <h3 style="margin: 0!important">Automart</h3>
                        <p style="margin: 0!important">315, Dewan Chamber, Sheikh Mujib Rd, Dewanhut, Chattogram.</p>
                        <p style="margin: 0!important">info@automart.com.bd</p>
                    </div>
                </header> --}}

                <div class="header-section">
                    <div style="text-align: center">
                        <img src="https://i.ibb.co/3CPF5Gv/automax-lg.png" width="150" alt="Automart">
                    </div>
                    <hr>
                    <h4 class="order-staus" style="color: #333 !important; font-weight: 700;text-align: center">Your order has been approved </h4>
                    <div style="text-align:center">
                        <img src="https://i.ibb.co/DG824yN/order-approved.png" class="order-approved-image" alt="Order Confirm">
                    </div>
                </div>
                <main>
                    {{-- <div>
                        <h4 class="order-staus" style="color: #333 !important; font-weight: 700;text-align: center">Your order has been approved </h4>
                        <p style="color: #f27c24 !important; font-weight: 500;text-align: center">Order </p>
                        <div style="text-align:center">
                            <img src="https://i.ibb.co/DG824yN/order-approved.png" class="order-approved-image" alt="Order Confirm">
                        </div>
                    </div> --}}
                    <div class="div" style="margin-top:10px; ">
                        <div class="invoice-img" style="display: inline-block;">
                            <h3 class="invoice-no" style="color: #3989c6;margin:0!important;margin-bottom:0!important;font-size:14px;">INVOICE TO:</h3>
                            @php
                            $address = '';
                            $address .= $orderInfo->flat_no ? 'Flat No: ' . $orderInfo->flat_no . ', ' : '';
                            $address .= $orderInfo->house_no ? 'House No: ' . $orderInfo->house_no . ', ' : '';
                            $address .= $orderInfo->road_no ? 'Road No: ' . $orderInfo->road_no . ', ' : '';
                            $address .= $orderInfo->area ? 'Area: ' . $orderInfo->area . ', ' : '';
                            $address .= $orderInfo->thana ? 'Thana: ' . $orderInfo->thana . ', ' : '';
                            $address .= $orderInfo->city ? 'City: ' . $orderInfo->city . ', ' : '';
                            @endphp

                            <div>{{$orderInfo->first_name}} {{$orderInfo->last_name}}</div>
                            {{-- <div>Address - {{$orderInfo->address_1}},{{$orderInfo->address_2}},{{$orderInfo->city}}.</div> --}}
                            <div>Address - {{ $address }}.</div>
                            <div>Contact Number - {{$orderInfo->phone_number}}</div>
                            <div>Email -  {{$orderInfo->email}} </div>

                        </div>
                        <div class="address-shop" style="float: right;">
                            <h3 class="invoice-no" style="color: #3989c6;margin-bottom:0!important;font-size:14px;">INVOICE #{{$orderInfo->id}}</h3>
                            <div>Date of Invoice: {{date("d/m/Y")}}</div>
                            <div>Due Date: {{date('d/m/Y',strtotime($orderInfo->created_at))}}</div>
                        </div>
                    </div>
                    <div>
                        <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;border: 1px solid #757575">
                            <thead>
                                <tr>
                                    <th style="padding: 15px 8px;">#</th>
                                    <th style="padding: 15px 8px;">ITEM</th>
                                    <th style="padding: 15px 8px;">QUANTITY</th>
                                    <th style="padding: 15px 8px;">PRICE</th>
                                    <th style="padding: 15px 8px;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>


                            @php
                            $totalAmount = 0;
                            @endphp
                            @foreach ($orderDetailsInfo as $item)

                                <tr>
                                    <td style="padding: 12px 8px;">{{$loop->iteration}}</td>
                                    <td style="padding: 12px 8px;">{{ $item->item->name }} </td>
                                    <td style="padding: 12px 8px;">{{$item->quantity}}</td>
                                    <td style="padding: 12px 8px;">৳{{$item->item->sales_price}}</td>

                                    @php
                                            $totalAmount += $item->item->sales_price *  $item->quantity;
                                    @endphp

                                    <td>৳{{$item->item->sales_price *  $item->quantity}}</td>
                                </tr>

                            @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">SUBTOTAL</td>
                                    <td>৳{{$totalAmount}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">SHIPPING CHARGES</td>
                                    <td>৳{{$shippingCharge}}</td>
                                </tr>
                                
                                @if($orderInfo->discount_amount)
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">DISCOUNT</td>
                                        <td>৳{{$orderInfo->discount_amount}}</td>
                                    </tr>
                                @endif
                               
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">GRAND TOTAL</td>

                                    @php
                                        $grandTotal = $totalAmount + $shippingCharge - $orderInfo->discount_amount;
                                    @endphp

                                    <td>৳{{$grandTotal}}</td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                    <div class="address-shop">
                        <p style="color: #3989c6;margin-bottom: 0!important;font-weight:bold;font-size:13px">Thank you.</p>
                        <p style="margin: 0!important;font-size:13px;font-weight:bold;">Automart</p>
                        <p style="margin: 0!important">315, Dewan Chamber, Sheikh Mujib Rd, Dewanhut, Chattogram.</p>
                        <p style="margin: 0!important">info@automart.com.bd</p>
                    </div>
                </div>
                </main>
             </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    <!-- sidebar-menu js -->
    <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

    <!-- Custom scripts -->
    <script src="{{asset('assets/js/app-script.js')}}"></script>

</body>
</html>
