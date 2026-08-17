{{-- @dd($orders) --}}
@extends('layouts.backend.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Item Price Edit Requests </div>

                <div class="card-body">
    
                    <div class="clearfix"></div><div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav-tabs-primary">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><span class="hidden-xs">Pending</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabe-2"><span class="hidden-xs">Approved</span></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="tabe-1" class="tab-pane active">
                                <div class="table-responsive">
                                    <table id="classTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Id</th>
                                                <th>User Name</th>
                                                <th>Previous URL</th>
                                                <th>Requested URL</th>
                                                <th>Requested At</th>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody class="drag_able">
                                            @foreach($requests as $request)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $request->user_id }}</td>
                                                <td>{{ $request->requested_by }}</td>
                                                <td>{{ $request->previous_url }}</td>
                                                <td>{{ $request->current_url }}</td>
                                                <td>{{ $request->created_at }}</td>
                                                <td>
                                                    <button class="btn btn-default btn-xs border"
                                                        onclick="approve({{ $request->id }})">
                                                        <i class="fa fa-check icon__size"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            <div id="tabe-2" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table id="classTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Id</th>
                                                <th>User Name</th>
                                                <th>Previous URL</th>
                                                <th>Requested URL</th>
                                                <th>Requested At</th>
                                                <th>Approved By</th>
                                                <th>Approved At</th>
                                            </tr>
                                        </thead>
                                        <tbody class="drag_able">
                                            @foreach($approved_requests as $request)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $request->user_id }}</td>
                                                <td>{{ $request->requested_by }}</td>
                                                <td>{{ $request->previous_url }}</td>
                                                <td>{{ $request->current_url }}</td>
                                                <td>{{ $request->created_at }}</td>
                                                <td>{{ $request->approved_by }}</td>
                                                <td>{{ $request->updated_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>


    <script>

    $(document).ready(function () {

        var table = $('#classTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        });
        
    });

    function approve(id) {
        alertify.confirm("Are you sure to approve this?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{ URL("approveEditRequest") }}',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.warning('Something Went Wrong');
                        } else {
                            alertify.success(data);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000)
                        }
                    },

                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            alertify.warning(msg);

                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            alertify.warning(msg);
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            alertify.warning(msg);
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            alertify.warning(msg);
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            alertify.warning(msg);
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            alertify.warning(msg);
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            alertify.warning(msg);
                        }
                    }
                });
            },
            function () {
                alertify.error('Canceled');
            }).setHeader('<em> CONFIRM </em> ');
    }



    </script>

@endsection
