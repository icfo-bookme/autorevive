@php
 $total = 0;
@endphp
@foreach ($orders as $order)
{{-- <tr style="text-align:center;" onclick="window.open('{{url('paymentCollectionDetails',$order->id)}}');"> --}}
{{-- <tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$order->id)}}');"> --}}
<tr style="text-align:center;" onclick="window.open('{{url('completedOrderDetailsView',$order->id)}}');">
    <td>{{$loop->iteration}}</td>
    @if ($order->delivery_type == 'delivery' || $order->delivery_type == 'pickup')
    <td>#0101{{$order->id}}</td>
        @else
        <td>#0202{{$order->id}}</td>
        @endif
    <td>
        <a class="custom_textDecoration" style="cursor: pointer">
            {{$order->first_name}} {{$order->last_name}}

        </a>
    </td>
    <td>{{$order->phone_number}}</td>
    {{-- <td>{{$order->email}}</td> --}}
    {{-- <td>{{$subTotal = $order->order_details->where('soft_delete',0)->sum('price')+$deliveryCharge->amount}}</td> --}}
    <td>{{$order->payment->payment_method->payment_method}}</td>
    <td>{{$order->created_at}}</td>
    <td>{{$subTotal = $order->order_details->where('soft_delete',0)->sum('price')}}</td>

    @php
      $total+= $subTotal;
    @endphp
</tr>
@endforeach
<tr>
<th colspan="6" class="text-center">Total</th>
<td class="text-center">{{$total}}</td>
</tr>
