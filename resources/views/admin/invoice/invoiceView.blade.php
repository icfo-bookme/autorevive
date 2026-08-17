@extends('layouts.backend.master')
@section('content')

<style>
.custom__mt{
        margin-top: 200px !important;
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
        <main id="mainDiv">
            <style>
                body{
                    background:#fff;
                    }
            </style>
            <div class="div">
                <div class="invoice-img" style="display: inline-block;">
                    <h3 style="color: #3989c6;">INVOICE TO:</h3>
                    <div>{{$orderInfo->first_name}} {{$orderInfo->last_name}}</div>
                    <div>Address - {{$orderInfo->address_1}},{{$orderInfo->city}}.</div>
                    <div>Contact Number - {{$orderInfo->phone_number}}</div>
                    <div>Email -  {{$orderInfo->email}} </div>
                </div>
                <div class="address-shop" style="float: right;">
                    <h3 style="color: #3989c6;">INVOICE #{{$orderInfo->id}}</h3>
                    <div>Date of Invoice: {{date("d/m/Y")}}</div>
                    <div>Due Date: {{date('d/m/Y',strtotime($orderInfo->created_at))}}</div>
                </div>
            </div>
            <div class="margin: 25px 0;">
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
                            <td>৳{{$shippingCharge->amount}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>৳{{$totalAmount + $shippingCharge->amount}}</td>
                        </tr>
                    </tfoot>
                </table>

                </div>
            </div>
        </main>
            
        </div>



    <div class="row no-print">
			<div class="col-lg-12">
			<div class="float-sm-right">
                <a href="javascript" target="_blank" class="btn btn-primary m-1" onclick="printDiv('invoiceElement')"><i class="fa fa-print"></i> Print</a>
                {{-- <a href="#" target="_blank" class="btn_primary" onclick=""><i
                        class="fa fa-print"></i> Cancel from invoiceView.blade.php</a> --}}
		    </div>
        </div>
     </div>



</div>





     

  

 <script>
 
    function printDiv(divName){
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
@endsection


