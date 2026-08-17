@php
$total = count($visitors);
@endphp

@foreach ($visitors as $visitor)
    <tr style="text-align:center;">

        <td>{{ $loop->iteration }}</td>
        {{-- <td>#{{ $visitor->id }}</td> --}}

        <td>{{ $visitor->visitor_ip }}</td>
        <td>{{ $visitor->visited_at }}</td>
    </tr>
@endforeach
<tr>
    <td class="d-flex justify-content-center align-items-center"> <span class="d-block">Total = </span> <span
            class="d-block">{{ $total }}</span> </td>
    <td colspan="3"></td>
</tr>
