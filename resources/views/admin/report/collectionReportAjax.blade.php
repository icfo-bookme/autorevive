@php
    $total = 0;
@endphp
@foreach ($collections as $collection)
@php
    $item_total = $collection->order_details->sum('price');
    $total += $item_total;
@endphp
{{-- <tr style="text-align:center;" onclick="window.open('{{url('completedOrderDetailsView',$collection->id)}}');"> --}}
<tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$collection->id)}}');">

    <td>{{$loop->iteration}}</td>
    <td>#0101{{$collection->id}}</td>
    <td>
        <a class="custom_textDecoration" style="cursor: pointer">
            {{$collection->first_name}} {{$collection->last_name}}
        </a>
    </td>
    <td>{{$collection->phone_number}}</td>
    {{-- <td>{{$collection->email}}</td> --}}
    <td>{{$collection->created_at}}</td>
    <td>{{ $item_total }}</td>
</tr>
@endforeach

@if ($collections->count() > 0)
<tr>
    <th colspan="5" class="text-right">Total</th>
    <td class="text-center">{{ $total }}</td>
</tr>
@endif
