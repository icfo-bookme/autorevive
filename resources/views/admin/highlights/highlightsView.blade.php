@extends('layouts.backend.master')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Highlights View</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="companyTable" class="table table-bordered highlightTable" style="width: 100% !important;">
                            <thead>
                            <tr>
                                <th>#</th>                             
                                <th>Type</th>
                                <th>Id</th>
                                <th>Summary</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($highlights as $highlight)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="custom_textDecoration"><a style="cursor: pointer"
                                        @if($highlight->type=="PURCHASE")
                                        { onclick="window.open('{{url('purchaseInfoView',$highlight->type_id)}}');" }
                                        @elseif($highlight->type=="SALE")
                                        {
                                        onclick="window.open('{{url('completedOrderDetailsView',$highlight->type_id)}}');"
                                        }
                                        @else
                                        {
                                        onclick="window.open('{{url('pendingOrderDetailsView',$highlight->type_id)}}');"
                                        }
                                        @endif>{{$highlight->type}}</a>
                                    </td>
                                    <td>{{$highlight->type_id}}</td>
                                    <td>{{$highlight->summary}}</td>
                                    <td>{{$highlight->created_by}}</td>
                                    <td>{{$highlight->created_at}}</td>
                                    <td>
                                        <button class="btn btn-danger btn-xs"
                                                onclick="highlightsDelete({{$highlight->id}})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
    
            var table = $('.highlightTable').DataTable({
                "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
            });

        });


        function highlightsDelete(id) {
            alertify.confirm("Are You Sure To Delete This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './highlightsDelete',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        dataType: 'json',

                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {
                                alertify.warning('Something Went Wrong');
                            } else {
                                //alert(data);
                                // alertify.success(data);
                                console.log("success")
                                alertify.error('Successfully Data Deleted');
                                $('#preloader').modal('hide');
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
