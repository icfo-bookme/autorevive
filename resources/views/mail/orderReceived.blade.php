<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Automart</title>
    <style>
        .order-confirm-image{
                width: 60% !important;
        }
        
        /* image resposive */
        @media only screen and (max-width: 600px) {
            .order-confirm-image{
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
                        {{-- \\103.115.25.104\medicalshop\public\img\images\medcalShop-logo.png --}}
                        <img src="https://i.ibb.co/3CPF5Gv/automax-lg.png" width="150" alt="Automart">
                    </div>
                    <hr>
                    <h4 style="color: #333 !important; font-weight: 700;text-align: center">Your order has been confirmed </h4>
                    <div style="text-align:center">
                        <img src="https://i.ibb.co/3BYPvqv/oreder-confirmd.png" class="order-confirm-image" alt="Order Confirm">
                    </div>
                    {{-- <p style="color: #f27c24 !important; font-weight: 500;text-align: center">Order #602633664962821</p> --}}
                </div>

                <div class="msg-box" style=" background: #f0f0f0!important;padding: 20px;margin-top:10px">
                    <h3 style="font-weight: bold !important; font-size: 16px !important;">Hello {{$name}},</h3>
                    <p class="">
                        Your order has been
                        placed on @php echo date("H:i:s d-m-Y"); @endphp via <b>Cash On Delivery</b>. You will be updated with
                        another email after your item(s) has been shipped. Your invoice is <b>{{$orderCode}}.</b>
                    </p>
                    <br>
                    <p>Shipment will arrive within 2/3 days.</p>
                    <p style="color: #3989c6;margin-bottom: 0!important;"><b>Shipment Address:</b></p>
                    <p style="margin-top: 0!important;">
                        {{$name}} <br>
                        Phone: {{$number}} <br>
                        Email Address: <span style="color: #33a2b2!important;">{{$email}}</span><br>
                        {{$address}} <br>
                    </p>
                    <div class="address-shop">
                        <p style="color: #3989c6;margin-bottom: 0!important;font-weight:bold;font-size:13px">Thank you.</p>
                        <p style="margin: 0!important;font-size:13px;font-weight:bold;">Automart</p>
                        <p style="margin: 0!important">315, Dewan Chamber, Sheikh Mujib Rd, Dewanhut, Chattogram.</p>
                        <p style="margin: 0!important">info@automart.com.bd</p>
                    </div>
                </div>

                
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
