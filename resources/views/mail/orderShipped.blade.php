<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Automart</title>
    <style>
        .order-shipped-image{
                width: 50% !important;
        }

        /* image resposive */
        @media only screen and (max-width: 600px) {
            .order-shipped-image{
                width: 100% !important;
            }
        }

    </style>
  </head>
  <body>
      <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header-section">
                    <div style="text-align: center">
                        <img src="https://i.ibb.co/3CPF5Gv/automax-lg.png" width="150" alt="Automart">
                    </div>
                    <hr>
                    <h4 class="order-status" style="color: #333 !important; font-weight: 700;text-align: center">Your order has been shipped.</h4>
                    <div style="text-align:center">
                        <img src="https://i.ibb.co/WGhbtgb/order-shipped.png" class="order-shipped-image" alt="Order Shipped">
                    </div>
                </div>

                <div class="" style="margin-top:10px;">
                    <h3 style="color: #3989c6; margin-bottom:0!important;font-size:14px;">Shipped Address:</h3>

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
                    <div>Invoice Id - #0101{{$orderInfo->id}}</div>

                </div>

                <div class="address-shop">
                    <p style="color: #3989c6;margin-bottom: 0!important;font-weight:bold;font-size:13px">Thank you.</p>
                    <p style="margin: 0!important;font-size:13px;font-weight:bold;">Automart</p>
                    <p style="margin: 0!important">315, Dewan Chamber, Sheikh Mujib Rd, Dewanhut, Chattogram.</p>
                    <p style="margin: 0!important">info@automart.com.bd</p>
                </div>
                
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
