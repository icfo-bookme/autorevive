@php
 $total = 0;
@endphp
@foreach ($orders as $order)
{{-- <tr style="text-align:center;" onclick="window.open('{{url('orderDetailsView',$order->id)}}');"> --}}
<tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$order->id)}}');">

    <td>{{$loop->iteration}}</td>
    @if ($order->delivery_type == 'delivery' || $order->delivery_type == 'pickup')
        <td>#0101{{ $order->id }}</td>
    @else
        <td>#0202{{ $order->id }}</td>
    @endif
    <td class="custom_textDecoration" style="cursor: pointer">{{$order->first_name}} {{$order->last_name}}</td>
    <td>{{$order->phone_number}}</td>
    {{-- <td>{{$order->email}}</td> --}}
    <td>{{$order->created_at}}</td>
    <td>{{$order->total_price[0]->total}}</td>

    @php
    $total+= $order->total_price[0]->total;
    @endphp
</tr>
@endforeach
<tr>
    <td colspan="5" class="text-right">Total =</td>
    <td class="text-center">{{$total}}</td>
</tr>
