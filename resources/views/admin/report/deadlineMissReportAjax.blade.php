@php
    $totalDelivery = 0;
    $totalDelay = 0;

    $total = 0;
@endphp

@foreach ($shipments as $shipment)
@php
    $totalDelivery += 1;
    if ($shipment->difference > 0) {
        $totalDelay += 1;
    }
@endphp

<tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$shipment->order_id)}}');">
    <td>{{$loop->iteration}}</td>
    <td>#0101{{$shipment->order_id}}</td>
    <td>
        <a class="custom_textDecoration" style="cursor: pointer">
            {{$shipment->user->first_name." ".$shipment->user->last_name}}
        </a>
    </td>
    <td>{{$shipment->deadline_time}}</td>
    <td>{{$shipment->completed_at}}</td>
    <td>{{$shipment->difference}} Minute </td>
    <td>{{$shipment->orders->total_price[0]->total}}</td>

    @php
    $total+= $shipment->orders->total_price[0]->total;
    @endphp
</tr>
@endforeach
<tr>
    <td colspan="6" style="text-align:right;">Total =</td>
    <td class="text-center">{{$total}}</td>

</tr>

{{-- @if ($totalDelay > 0)
<tr>
    <th colspan="5" class="text-right">Delay</th>
    <td class="text-center">{{ round($totalDelay / $totalDelivery * 100, 2) }}%</td>
</tr>
@endif --}}
