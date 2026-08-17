@extends('layouts.backend.master')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Companies View</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="companyTable" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($roles) --}}
                                @foreach ($cars as $car)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$car->car_company}}</td>
                                    <td>{{$car->created_by}}</td>
                                    <td>{{$car->updated_by}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick="companyEdit({{$car->id}})">
                                            <i class="fa fa-pencil"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs" onclick="companyDelete({{$car->id}})">
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


    <div class="modal fade" id="largesizemodal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="companyUpdateForm">
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                          Company Update
                    </h4>


                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Company Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="car_company" name="car_company" placeholder="company name" required>
                            <input type="hidden" name="company_id" id="company_id" >
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                        <button type="button" class="btn btn-dark" onclick="clearForm()"><i class="fa fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                    </form>
                </div>

            </div>
        </div>
    </div>




    <script>
        $(document).ready(function () {
            var table = $('#companyTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
            });

            table.buttons().container()
                .appendTo('#companyTable_wrapper .col-md-6:eq(0)');




            $('#companyUpdateForm').submit(function () {
                    event.preventDefault();

                    alertify.confirm("Are You Sure To Update This?",
                        function () {
                        //  $("#subcategory_id").prop( "disabled", false);
                        var formData = $('#companyUpdateForm').serialize();
                            $.ajax({
                                type: 'post',
                                url: '{{url("companyUpdateAjax")}}',
                                data: formData + '&_token={{ csrf_token() }}',
                                success: function (data) {
                                    if (typeof data.errors !== 'undefined') {
                                        alertify.warning(data.errors.name);
                                    } else {
                                        alertify.success(data);
                                        clearForm();
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
                            alertify.error('Cancel');
                        }).setHeader('<em> CONFIRM </em> ');
                });


        });


            function companyEdit(id) {

                $.ajax({
                    type: 'post',
                    url: './getCompanyInfoAjax',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.warning("Something went wrong");
                        } else {
                            console.log(data);
                            $('#company_id').val(data.id);
                            $('#car_company').val(data.car_company);
                            $('#largesizemodal').modal('show');

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

            }


            function companyDelete(id) {
                alertify.confirm("Are You Sure To Delete This?",
                    function () {
                        $.ajax({
                            type: 'post',
                            url: './companyDeleteAjax',
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


            function clearForm() {

                $('#companyUpdateForm').trigger("reset");
                $('#largesizemodal').modal('hide');

            }

    </script>

@endsection
