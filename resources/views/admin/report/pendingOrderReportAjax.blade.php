@php
$total = 0;
@endphp

@foreach ($orders as $order)
<tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$order->id)}}');">
    <td>{{$loop->iteration}}</td>
    <td>#0101{{$order->id}}</td>
    <td class="custom_textDecoration">{{$order->first_name}} {{$order->last_name}}</td>
    <td>{{$order->phone_number}}</td>
    {{-- <td>{{$order->email}}</td> --}}
    <td>{{$order->created_at}}</td>
    <td>{{$subTotal = $order->order_details->where('soft_delete',0)->sum('price')}}</td>
    @php
        $total+= $subTotal
    @endphp
</tr>
@endforeach
<tr>
    <td colspan="5" style="text-align:right;">Total =</td>
    <td class="text-center">{{$total}}</td>
</tr>
