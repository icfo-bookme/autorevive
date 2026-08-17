<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Automart</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('mazley_assets/img/favicon-32x32.png')}}"  />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0px;
            box-sizing: border-box;
            overflow-x: hidden;
            /* display: flex;
            background: #fff;
            align-items: center;
            height: 100vh;
            width: 100vw; */
        }

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

        .custom__mt {
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

        @media print {
            .invoice {
                -webkit-print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body>

    <div class="container" style="margin-top: 50px;margin-bottom: 50px">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-sm-10 col-md-10 col-lg-10">
                <div class="card" style="border-radius: 30px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center"><img src="{{ asset('mazley_assets/img/logo/automax-lg.png') }}" width="150" alt=""></div>
                        <div class="invoice" style="background-color: #FFF; padding: 20px;">
                            <div id="invoiceElement">
                                @php
                                    $shipmentCharge = $orderInfo->is_shipment_charge_applied ? $orderInfo->is_shipment_charge_applied : 0;
                                    
                                @endphp

                                <main id="mainDiv">
                                    <style>
                                        body {
                                            background: #fff;
                                        }
                                    </style>

                                    <div class="div">
                                        <div class="invoice-img" style="float: left;display: inline-block;">
                                            <h3 style="color: #3989c6; font-size: 18px;line-height: 20px">DATE:
                                                {{ !empty($invoice_date) ? $invoice_date : date('d/m/Y') }}</h3>
                                            <h3 style="color: #3989c6;font-size: 18px;line-height: 20px">INVOICE TO:
                                            </h3>
                                            <p style="font-size: 16px;color: #000;">NAME:
                                                {{ ucwords($orderInfo->first_name . ' ' . $orderInfo->last_name) }}</p>
                                            <p style="font-size: 16px;color: #000;">EMAIL: {{ $orderInfo->email }}</p>
                                            <p style="font-size: 16px;color: #000;">PHONE:
                                                {{ $orderInfo->phone_number }}
                                            </p>
                                        </div>
                                        <div class="address-shop" style="float: right; ">
                                            <h3 style="color: #3989c6; font-size: 18px;line-height: 20px">
                                                INVOICE
                                                @if ($orderInfo->delivery_type == 'delivery' || $orderInfo->delivery_type == 'pickup')
                                                    #0101{{ $orderInfo->id }}
                                                @else
                                                    #0202{{ $orderInfo->id }}
                                                @endif
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12 col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" cellspacing="0" cellpadding="5"
                                                    style="color: #000;">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                style="padding: 15px 8px;background-color: black !important;color: #fff;">
                                                                #
                                                            </th>
                                                            <th
                                                                style="padding: 15px 8px;background-color: black !important;color: #fff;">
                                                                Product</th>
                                                            <th
                                                                style="padding: 15px 8px;background-color: black !important;color: #fff;">
                                                                Qty</th>
                                                            <th
                                                                style="padding: 15px 8px;background-color: black !important;color: #fff;">
                                                                Unit Price</th>
                                                            <th
                                                                style="padding: 15px 8px;background-color: black !important;color: #fff;">
                                                                Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        @php
                                                            $totalAmount = 0;
                                                        @endphp
                                                        @foreach ($orderDetailsInfo as $item)
                                                            <tr>
                                                                <td style="padding: 12px 8px;color: #000;">
                                                                    {{ $loop->iteration }}</td>
                                                                <td style="padding: 12px 8px;color: #000;">
                                                                    {{ $item->item->name }} </td>
                                                                <td style="padding: 12px 8px;color: #000;">
                                                                    {{ $item->quantity }}
                                                                </td>
                                                                <td style="padding: 12px 8px;color: #000;">
                                                                    ৳{{ $item->unit_price }}</td>

                                                                @php
                                                                    $totalAmount += $item->unit_price * $item->quantity;
                                                                @endphp

                                                                <td style="color: #000">
                                                                    ৳{{ $item->unit_price * $item->quantity }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">Subtotal</td>
                                                            <td style="color: #000">৳{{ $totalAmount }}</td>
                                                        </tr>
                                                        @if ($shipmentCharge != 0)
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">Shipping Charge</td>
                                                                <td style="color: #000">৳{{ $shipmentCharge }}</td>
                                                            </tr>                                                            
                                                        @endif
                                                        @if ($orderInfo->discount_amount)
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">Discount</td>
                                                                <td style="color: #000">৳
                                                                    {{ @$orderInfo->discount_amount }}
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">Grand Total</td>
                                                            <td style="color: #000">৳
                                                                {{ $totalAmount + $shipmentCharge - @$orderInfo->discount_amount }}
                                                            </td>
                                                        </tr>

                                                        @if ($orderInfo->payment_due > 0 && $orderInfo->is_due_paid == 0)
                                                            @php
                                                                $paid__amount = $totalAmount + $shipmentCharge - @$orderInfo->discount_amount - @$orderInfo->payment_due;
                                                            @endphp
                                                            @if ($paid__amount != 0)
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="2">Paid</td>
                                                                    <td style="color: #000">৳ {{ $paid__amount }}</td>
                                                                </tr>
                                                            @endif

                                                            @if (@$orderInfo->payment_due != 0)
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="2">Due</td>
                                                                    <td style="color: #000">৳
                                                                        {{ @$orderInfo->payment_due }}
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            @if (@$totalPaid != 0)
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="2">Due Paid</td>
                                                                    <td style="color: #000">৳ {{ @$totalPaid }}</td>
                                                                </tr>
                                                            @endif

                                                            @if (@$payment_due != 0)
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="2">Remaining Due</td>
                                                                    <td style="color: #000">৳ {{ @$payment_due }}</td>
                                                                </tr>
                                                            @endif
                                                        @endif

                                                    </tfoot>
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="border-bottom: 1px solid #000;font-size: 16px;color: black; width: 70px;">
                                            Remarks</p>
                                        <p style="font-size: 16px;color: black;">
                                            <span id="addRemarks"
                                                style="font-size: 14px !important;">{{ $orderInfo->remarks }}</span>
                                        </p>
                                    </div>
                                    <div id="spaceDiv">
                                        <div
                                            style="display: flex;justify-content: flex-end;align-items: center; margin-top: 50px;">
                                            {{-- <div>
                                                <p
                                                    style="border-bottom: 1px solid #000;font-size: 16px; width: 100px;  color: #000;">
                                                    Received By</p>
                                            </div> --}}
                                            <div>
                                                <p
                                                    style="border-bottom: 1px solid #000;font-size: 16px; width: 130px;color: #000;">
                                                    Yours
                                                    Sincerely</p>
                                                <p
                                                    style="font-size: 16px; width: 130px;color: #000; text-align: center; line-height: 16px;">
                                                    Automart</p>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </main>
                        </div>

                        <div class="row no-print">
                            <div class="col-lg-12">
                                <div class="float-sm-right btn__center mb-5">
                                    <a href="javascript:void(0)" class="btn_primary"
                                        onclick="printDiv('invoiceElement')"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script>
        function printDiv(divName) {
            var getDivName = document.getElementById('mainDiv');
            getDivName.style.marginTop = "200px";
            $('#spaceDiv').css("margin-top", "400px");
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
</body>

</html>
