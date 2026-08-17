   <style>
       body {
           background: #fff !important;
       }

   </style>
   @foreach($barcodeArray as $data)<div style="padding: 15px 15px;  margin-bottom: 50px"">
            <h3 style="text-align: center">{{$data['name']}}</h3>
         <div style="display: flex;flex-direction: row;
            align-items: flex-start;
            flex-wrap: wrap;">@for($i = 0; $i< $data['quantity']; $i++) 
           <div style="width: 400px;height: auto; margin: 20px 0;">
                <p style="text-align: center">{{$data['is_sales_price_show'] == 1 ? "৳".$data['sales_price']:''}}</p>
                <div style="display: flex; justify-content: center; ">
                     <div>
                        {!! DNS1D::getBarcodeHTML($data['barcode'], 'C128') !!}
                     </div>
                </div>
                 <center>
                     <p>{{$data['barcode']}}</p>
                 </center>
           </div>
       @endfor
   </div>
   </div>
   @endforeach
