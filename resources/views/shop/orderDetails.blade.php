
                      <table class="table table-bordered" style="width:100%;">
                        <tbody>
                            <tr class="text-white" style="background: #1b2463">
                                <td class="py-3 px-3">Image</td>
                                <td class="py-3 px-3">Product Name</td>
                                <td class="py-3 px-3">Quantity</td>
                                <td class="py-3 px-3">Price</td>
                            </tr>

                            @php
                            $total = 0;
                            $shipping_charge = $shippingChargeApplied
                                                ?   $shippingCharge->amount
                                                :   0
                            @endphp

                            @foreach($orderDetails as $details)
                            <tr >
                            <td class="py-3 px-3" ><img src={{$details->item->thumbnail}} style="width: 50px; height: 50px;object-fit: contain;" /></td>

                                <td class="py-3 px-3 hover__textDecor" onClick="window.open('singleProductDetails/{{$details->item->id}}')" style="cursor: pointer;color: #C70909">{{$details->item->name}}</td>
                                <td class="py-3 px-3">{{$details->quantity}}</td>
                                <td class="py-3 px-3">৳{{ $details->quantity * $details->item->sales_price }}</td>

                                @php
                                        $total += $details->quantity * $details->item->sales_price;
                                @endphp
                            </tr>
                            @endforeach

                            @php
                                
                            @endphp


                            <tr>
                                <td colspan="3" class="py-3" style="text-align:right;padding-right:10px;vertical-align: middle">
                                    Shipping
                                </td>
                                {{-- <td class="text-center" style="vertical-align: middle">
                                    ৳{{ $shipping_charge }}
                                </td> --}}
                                <td class="text-center" style="vertical-align: middle">
                                    ৳{{ $shippingChargeApplied }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="py-3"style="text-align:right;padding-right:10px;"> TOTAL </td>
                                {{-- <td class="text-center" style="vertical-align: middle">৳{{ $total + $shipping_charge }} </td> --}}
                                <td class="text-center" style="vertical-align: middle">৳{{ $total + $shippingChargeApplied }} </td>
                            </tr>
                        </tbody>
            </table>
