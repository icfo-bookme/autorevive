@php
 $total = 0;
@endphp
@foreach ($sales as $sale)
{{-- <tr style="text-align:center;" onclick="window.open('{{url('saleDetailsView',$sale->order_id)}}');"> --}}
{{-- <tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$sale->order_id)}}');"> --}}
<tr style="text-align:center;">
    @php
        $grand_total = ($sale->total_price[0]->total + $sale->is_shipment_charge_applied) - $sale->discount_amount;
    @endphp

    <td onclick="window.open('{{url('completedOrderDetailsView',$sale->order_id)}}');">{{$loop->iteration}}</td>
    <td>
        <a onclick="invoiceModal({{ @$sale->order_id }})"
           style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
           data-toggle="tooltip" title="" data-original-title="Invoice">
            #0202{{$sale->order_id}}
        </a>
    </td>
    <td>{{date('Y-m-d',strtotime($sale->completed_at))}}</td>
    <td onclick="window.open('{{url('completedOrderDetailsView',$sale->order_id)}}');">
        <a class="custom_textDecoration" style="cursor: pointer;color:#C70909">
            {{$sale->first_name}} {{$sale->last_name}}
        </a>
    </td>
    <td>{{$sale->phone_number}}</td>
    <td>{{$sale->invoice_date}}</td>
    <td>{{$sale->created_at}}</td>
    {{-- <td>{{date('Y-m-d',strtotime($sale->created_at))}}</td> --}}
    <td>{{$sale->sales_by}}</td>
    <td>{{ $grand_total }}</td>

    @php
    $total+= $grand_total;
    @endphp
</tr>
@endforeach
<tr>
    <th colspan="8" class="text-center">Total</th>
    <td class="text-center">{{$total}}</td>
</tr>




