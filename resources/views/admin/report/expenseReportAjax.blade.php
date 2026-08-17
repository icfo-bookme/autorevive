@php
    $total = 0;
@endphp

@foreach ($costs as $cost)
    <tr style="text-align:center;">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $cost->category->name }}</td>
        <td>{{ $cost->subcategory->name }}</td>
        <!-- <td>{{ $cost->description }}</td> -->
        <td>
            <div class="description">
                <span class="description-popover" data-toggle="popover" title="Full Description"
                    data-content="{{ $cost->description }}" data-trigger="hover"
                    class="truncated-description">{{ \Illuminate\Support\Str::limit($cost->description, 30) }}</span>
                @if (strlen($cost->description) > 30)
                    <a href="#" class="see-more" data-toggle="modal"
                        data-target="#descriptionModal{{ $loop->iteration }}">See More</a>
                    <!-- Modal -->
                    <div class="modal fade" id="descriptionModal{{ $loop->iteration }}" tabindex="-1" role="dialog"
                        aria-labelledby="descriptionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="descriptionModalLabel">Full Description</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="white-space: normal; padding: 10px">
                                    {{ $cost->description }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </td>
        <td>{{ $cost->date }}</td>
        <td>{{ date('Y-m-d', strtotime($cost->created_at)) }}</td>
        <td>{{ $amount = $cost->amount }}</td>
        @php
            $total += $amount;
        @endphp
    </tr>
@endforeach

<tr>
    <!-- <td colspan="5" style="text-align:right;">Total =</td>
    Edited by monir : 30.04.2024 -->
    <td colspan="6" style="text-align:right;">Total =</td>
    <td class="text-center">{{ $total }}</td>

</tr>

<script>
    $(document).ready(function() {
        $('.description-popover').popover();
    });
</script>
