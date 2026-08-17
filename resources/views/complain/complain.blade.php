@extends('layouts.backend.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h5 >All Complains</h5>
                   
                </div>
                <div class="card-body">
                     <div class="float-right ">
                         <button class="btn btn-primary mr-1 mb-2" data-toggle="modal" data-target="#complainModal">
                             Add Complain
                         </button>
                     </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Complain</th>
                                    <th>Complain Detail</th>
                                    <th>Delivery Man</th>
                                    <th>Created At</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @isset($complains)
                                @foreach ($complains as $complain)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $complain->complain }}</td>
                                    <td>{{ $complain->complain_detail }}</td>
                                    <td>{{ $complain->deliveryTeam->name }}</td>
                                    <td>{{ $complain->created_at }}</td>
                                    {{-- <td>
                                        <button type="button" class="btn btn-info btn-sm">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </td> --}}
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- card --}}
        <div class="modal fade" id="complainModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Complain</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Delivery Man</p>
                        <div class="form-group">
                            <select type="text" id="delivery_man" name="delivery_man" class="form-control">
                                <option value="">Select Delivery Man</option>
                                @foreach($deliveryTeam as $deliveryMan)
                                <option value="{{ $deliveryMan->id }}">{{ $deliveryMan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="complain" id="complain" required>
                                <option value="">Select Comaplain Type</option>
                                <option value="Bad Behaviour">Bad Behaviour</option>
                                <option value="Late Delivery">Late Delivery</option>
                                <option value="Damaged Product">Damaged Product</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="4" id="complain_detail" name="complain_detail" required=""
                                spellcheck="false" placeholder="Your complain"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="insertComplain()" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function insertComplain() {
    alertify.confirm(
        'Confirm Title', 
        'Confirm Message', function () {
            $.ajax({
                url: '{{ URL("admin/insertComplainAjax") }}',
                type: 'POST',
                data: {
                    id: $('#delivery_man').val(),
                    complain: $('#complain').val(),
                    complain_detail: $('#complain_detail').val()
                },
                success: data => {
                    console.log(data);
                    if (data == 'Success') {
                        alertify.success(data);
                        setTimeout(() => location.reload(), 1000);
                    }
                },
                error: err => {
                    alertify.error('Error!')
                }
            });
        }, 
        function () {
            alertify.error('Cancel');
        }
    );
}
</script>
@endsection
