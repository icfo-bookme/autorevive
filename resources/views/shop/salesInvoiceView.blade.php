<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    .btn_primary {
        width: 100px;
        padding: 10px 15px;
        background: #2a9df4;
        color: white;
        outline: none;
        border: 1px solid #2a9df4;
        text-decoration: none;
        margin-left: 50px;
        margin-bottom: 50px;
    }

    .custom__mt{
        margin-top: 200px !important;
    }

    @media only screen and (max-width: 600px) {
        .invoice {
            padding: 5px !important;
        }

        .custom__title {
            font-size: 18px !important;
            line-height: 18px !important;
        }

        .address-info {
            font-size: 10px !important;
            margin-bottom: 0px !important;
        }

        .btn__center {
            text-align: center !important;
        }
    }
</style>

<div class="invoice" style="background-color: #FFF; padding: 50px;">
    <div id="invoiceElement">
    {{-- <header style="padding: 10px 0; margin-bottom: 20px; border-bottom: 1px solid #3989c6;">
            
            <div class="address-shop text-center">
                <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" class="pb-2" width="200" alt="">
                <p>Wireless Moor Zakir Hossain Road West Khulshi Chattogram 4000</p>
                <p>automart@technova.com</p>
            </div>
        </header> --}}
       
        @php
        $shipmentCharge = $orderInfo->is_shipment_charge_applied
        ? $shippingCharge->amount
        : 0;
        @endphp

        <main id="mainDiv">
            <div class="div">
                <div class="invoice-img" style="float: left;display: inline-block;">
                    <h3 style="color: #3989c6;" class="custom__title">INVOICE TO:</h3>
                    <p class="address-info">{{ ucwords($orderInfo->first_name . ' ' . $orderInfo->last_name) }}</p>
                    <p class="text-capitalize address-info"><span>Flat No: {{ $orderInfo->flat_no }},</span> <span>Road
                            No: {{ $orderInfo->road_no }},</span></p>
                    <p class="text-capitalize address-info"><span>Area: {{ $orderInfo->area }},</span> <span>Thana:
                            {{ $orderInfo->thana }},</span></p>
                    <p class="text-capitalize address-info"><span>City: {{ $orderInfo->city }},</span> <span>District:
                            {{ $orderInfo->district }},</span></p>
                    <p class="text-capitalize address-info">Country: {{ $orderInfo->country }}.</p>
                </div>
                <div class="address-shop" style="float: right;">
                    <h3 style="color: #3989c6;" class="custom__title">INVOICE #{{ sprintf("%04s", $orderInfo->id) }}
                    </h3>
                    <p class="address-info">Date of Invoice: {{ date('d/m/Y') }}</p>
                    <p class="address-info">Due Date: {{ date('d/m/Y', strtotime($orderInfo->created_at)) }}</p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" cellspacing="0" cellpadding="5">
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
                                    <td style="padding: 12px 8px;">{{ $loop->iteration }}</td>
                                    <td style="padding: 12px 8px;">{{ $item->item->name }} </td>
                                    <td style="padding: 12px 8px;">{{ $item->quantity }}</td>
                                    <td style="padding: 12px 8px;">৳{{ $item->item->sales_price }}</td>

                                    @php
                                    $totalAmount += $item->item->sales_price * $item->quantity;
                                    @endphp

                                    <td>৳{{ $item->item->sales_price * $item->quantity }}</td>
                                </tr>

                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">SUBTOTAL</td>
                                    <td>৳{{ $totalAmount }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">SHIPPING CHARGES</td>
                                    <td>৳{{ $shipmentCharge }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">GRAND TOTAL</td>
                                    <td>৳{{ $totalAmount + $shipmentCharge }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="margin: 25px 0;">
                

            </div> --}}
    </div>
    </main>
</div>

<div class="row no-print">
    <div class="col-lg-12">
        <div class="float-sm-right btn__center">
            <a target="_blank" class="btn_primary" onclick="printDiv('invoiceElement')"><i
                    class="fa fa-print"></i> Print</a>
                    {{-- <a href="#" target="_blank" class="btn_primary" onclick=""><i
                        class="fa fa-print"></i> Cancel from salesInvoiceView.blade.php</a> --}}
        </div>
    </div>
</div>

</div>









<script>
    function printDiv(divName) {
        var getDivName = document.getElementById('mainDiv');
        getDivName.style.marginTop = "200px";
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
         setTimeout(function() {
                 location.reload();
          }, 1000);

    }
</script>
