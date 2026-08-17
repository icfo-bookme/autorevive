@php
    $totalItems = 0;
    $totalDelayCount = 0;
    $count = 0;

    $total = 0;
@endphp
@foreach ($shipments as $shipment)
@if($shipment->orderReport)
<tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$shipment->orderReport->id)}}');">

    <td>{{ ++$count }}</td>
    <td>#0101{{$shipment->orderReport->id}}</td>
    <td>{{$shipment->orderReport->first_name}} {{$shipment->orderReport->last_name}}</td>
    <td>{{$shipment->user->first_name." ".$shipment->user->last_name}}</td>
    <td>{{$shipment->deadline_time}}</td>
    <td>{{$shipment->completed_at}}</td>
    <td>
        {{
            $shipment->difference
                ? $shipment->difference > 0
                    ? $shipment->difference." minute"
                    : abs($shipment->difference)." minute early"
                : null
        }}
    </td>
    <td>{{$shipment->orderReport->created_at}}</td>
    <td>{{$shipment->orderReport->total_price[0]->total}}</td>


    @php
        $totalItems += 1;
        $totalDelayCount += $shipment->difference > 0 ? 1 : 0;


        $total+= $shipment->orderReport->total_price[0]->total;

    @endphp
</tr>
@endif
@endforeach

@if ($totalItems > 0)
@php $delay_percentage = $totalDelayCount / $totalItems * 100; @endphp
<tr>
    <td class="text-right" colspan="6">Delay =</td>
    <td class="text-center" title="{{ $delay_percentage }}">{{ round($delay_percentage, 2) }}%</td>
    <td class="text-right">Total =</td>
    <td class="text-center">{{$total}}</td>

</tr>
@endif
