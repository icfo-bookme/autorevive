<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" />
        <title>Automart</title>
        <style>
            .box1{
                padding: 25px 15px;
                margin: 50px 0 0 0;
                border: 2px solid #ececec;
                background-color: #fff;
            }
            .box2{
                padding: 25px 15px;
                border: 2px solid #ececec;
                background-color: #fff;
                letter-spacing: 0.5px;
            }
            .box3{
                padding: 10px 15px;
                border: 2px solid #ececec;
                background-color: #efeeee;
                letter-spacing: 0.5px;

            }
            .container-content{
                width: 646px;
                margin: 0 auto;
            }
            .table-bordered td, .table-bordered th {
                border: 1px solid #dee2e6!important;
            }
        </style>
    </head>
    <body>
        <section>
            <div style="padding: 25px; background-color:#f8f9fa" class="container">
            <div class="container-content">
                    <div class="box1">
                        <div style="text-align: center; margin-top: 15px;">
                            <img src="https://i.ibb.co/3CPF5Gv/automax-lg.png" width="150" alt="Automart">
                        </div>
                        <h5 style="text-align: center;font-size: 17px; background-color: #c70909;padding: 10px; color: #fff">Thank you for your purchase</h5>
                        <p style="font-weight: 600; font-size: 17px; color: #000; margin-bottom: 5px;">Delivery Details</p>
                        <table>
                            <tr style="font-size: 15px; color: #000;">
                                <td style="width: 100px;">Invoice Id:</td>
                                <td>#0202{{ $orderCode }}</td>
                            </tr>
                            <tr style="font-size: 15px; color: #000;">
                                <td style="width: 100px;">Name:</td>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr style="font-size: 15px; color: #000;">
                                <td style="width: 100px;">Phone:</td>
                                <td>{{ $number }}</td>
                            </tr>
                            <tr style="font-size: 15px; color: #000;">
                                <td style="width: 100px;">Email:</td>
                                <td>{{ $email }}</td>
                            </tr>
                            <tr style="font-size: 15px; color: #000;">
                                <td style="width: 100px;">Address:</td>
                                <td>{{ $address }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="box2">
                        <p style="font-weight: 600; font-size: 17px; color: #000; margin-bottom: 5px; margin-top: 0px;">Order Details</p>
                        
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" cellpadding="5" style="color: #000; width: 100%;">
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
                                                $shipmentCharge = $orderInfo->is_shipment_charge_applied ? $orderInfo->is_shipment_charge_applied : 0;
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
                                                    <td style="color: #000">৳{{ @$orderInfo->discount_amount }}</td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2">Grand Total</td>
                                                <td style="color: #000">৳{{ $totalAmount + $shipmentCharge - @$orderInfo->discount_amount }}</td>
                                            </tr>

                                            @if ($orderInfo->payment_due > 0 && $orderInfo->is_due_paid == 0)
                                                @php
                                                    $paid__amount = $totalAmount + $shipmentCharge - @$orderInfo->discount_amount - @$orderInfo->payment_due;
                                                @endphp
                                                @if ($paid__amount != 0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td colspan="2">Paid</td>
                                                        <td style="color: #000">৳{{ $paid__amount }}</td>
                                                    </tr>
                                                @endif

                                                @if (@$orderInfo->payment_due != 0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td colspan="2">Due</td>
                                                        <td style="color: #000">৳{{ @$orderInfo->payment_due }}</td>
                                                    </tr>
                                                @endif

                                                @if (@$totalPaid != 0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td colspan="2">Due Paid</td>
                                                        <td style="color: #000">৳{{ @$totalPaid }}</td>
                                                    </tr>
                                                @endif

                                                @if (@$payment_due != 0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td colspan="2">Remaining Due</td>
                                                        <td style="color: #000">৳{{ @$payment_due }}</td>
                                                    </tr>
                                                @endif
                                            @endif

                                        </tfoot>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="box3">
                        {{-- <a style="text-decoration: none;" href="https://automart.com.bd/contactFormView"><p style="font-weight: 600; text-align: center; color: #000;">Help Center | Contact Us</p></a> --}}
                        <a style="text-decoration: none;" href="https://automart.com.bd/connectWithUs"><p style="font-weight: 600; text-align: center; color: #000;">Help Center | Contact Us</p></a>
                        <div style="text-align: center; margin-bottom: 23px;">
                            <img src="https://i.ibb.co/3CPF5Gv/automax-lg.png" width="130" alt="Automart">
                        </div>
                        <div style="width: 115px; margin: 0 auto; padding-bottom: 10px;">
                            <a style="padding: 5px;" href="https://www.facebook.com/automartltd/"><img src="https://i.ibb.co/DR65kvw/facebook.png" style="width: 25px;"></a>
                            <a style="padding: 5px;" href="https://automart.com.bd/"><img src="https://i.ibb.co/pyrDCby/web.png" style="width: 25px;"></a>
                            {{-- <a style="padding: 5px;" href="https://automart.com.bd/contactFormView"><img src="https://i.ibb.co/XLTbMWz/phone.png" style="width: 24px;"></a> --}}
                            <a style="padding: 5px;" href="https://automart.com.bd/connectWithUs"><img src="https://i.ibb.co/XLTbMWz/phone.png" style="width: 24px;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
