@extends('layouts.backend.master')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Engines View</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="engineTable" class="table table-bordered">
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
                                @foreach ($engines as $engine)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$engine->car_engine}}</td>
                                    <td>{{$engine->created_by}}</td>
                                    <td>{{$engine->updated_by}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick="engineEdit({{$engine->id}})">
                                            <i class="fa fa-pencil"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs" onclick="engineDelete({{$engine->id}})">
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
                    <form id="carEngineUpdateForm">
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                        Brand Update
                    </h4>


                    <div class="form-group row">
                        <label for="input-1" class="col-sm-3 col-form-label">Company Name</label>
                        <div class="col-sm-9">
                            <select class ="form-control" name="company_id" id="company_id">
                                <option value=""> SELECT COMPANY</option>
                                @foreach ($companies as $company)
                                    <option value="{{$company->id}}">{{$company->car_company}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-3 col-form-label">Brand Name</label>
                        <div class="col-sm-9">
                            <select class ="form-control" name="brand_id" id="brand_id">
                                <option value=""> SELECT BRAND</option>
                                @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->car_brand}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-3 col-form-label">Brand Name</label>
                        <div class="col-sm-9">
                            <select class ="form-control" name="model_id" id="model_id">
                                <option value=""> SELECT MODEL</option>
                                @foreach ($models as $model)
                                    <option value="{{$model->id}}">{{$model->car_model}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-3 col-form-label">Engine Name</label>
                        <input type="hidden" name="engine_id" id="engine_id" >
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="car_engine" name="car_engine" placeholder="engine name" required>
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


            var table = $('#engineTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });

            table.buttons().container()
                .appendTo('#engineTable_wrapper .col-md-6:eq(0)');




            $('#carEngineUpdateForm').submit(function () {
                    event.preventDefault();

                    alertify.confirm("Are You Sure To Update This?",
                        function () {
                        //  $("#subcategory_id").prop( "disabled", false);
                        var formData = $('#carEngineUpdateForm').serialize();
                            $.ajax({
                                type: 'post',
                                url: '{{url("carEngineUpdateAjax")}}',
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


            function engineEdit(id) {

                $.ajax({
                    type: 'post',
                    url: './getCarEngineInfoAjax',
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
                            $('#company_id').val(data.company_id);
                            $('#brand_id').val(data.brand_id);
                            $('#model_id').val(data.model_id);
                            $('#engine_id').val(data.id);
                            $('#car_engine').val(data.car_engine);
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


            function engineDelete(id) {
                alertify.confirm("Are You Sure To Delete This?",
                    function () {
                        $.ajax({
                            type: 'post',
                            url: './carEngineDeleteAjax',
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

                $('#carEngineUpdateForm').trigger("reset");
                $('#largesizemodal').modal('hide');

            }




    </script>


@endsection
