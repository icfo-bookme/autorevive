@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Models View</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="modelTable" class="table table-bordered" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand</th>
                                <th>Name</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($roles) --}}
                            @foreach ($models as $model)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$model->brandName->car_brand}}</td>
                                <td>{{$model->car_model}}</td>
                                <td>{{$model->created_by}}</td>
                                <td>{{$model->updated_by}}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs" onclick="modelEdit({{$model->id}})">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    <button class="btn btn-danger btn-xs" onclick="modelDelete({{$model->id}})">
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
                <form id="carModelUpdateForm">
                <h4 class="form-header text-uppercase text-center">
                    <i class="fa fa-user-circle-o"></i>
                    Model Update
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
                    <label for="input-1" class="col-sm-3 col-form-label">Model Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="car_model" name="car_model" placeholder="model name" required>
                        <input type="hidden" name="model_id" id="model_id" >
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
        var table = $('#modelTable').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
        });

        table.buttons().container()
            .appendTo('#modelTable_wrapper .col-md-6:eq(0)');




        $('#carModelUpdateForm').submit(function () {
                event.preventDefault();

                alertify.confirm("Are You Sure To Update This?",
                    function () {
                    //  $("#subcategory_id").prop( "disabled", false);
                    var formData = $('#carModelUpdateForm').serialize();
                        $.ajax({
                            type: 'post',
                            url: '{{url("carModelUpdateAjax")}}',
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


        function modelEdit(id) {

            $.ajax({
                type: 'post',
                url: './getCarModelInfoAjax',
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
                        $('#model_id').val(data.id);
                        $('#car_model').val(data.car_model);
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


        function modelDelete(id) {
            alertify.confirm("Are You Sure To Delete This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './carModelDeleteAjax',
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

            $('#carModelUpdateForm').trigger("reset");
            $('#largesizemodal').modal('hide');

        }




</script>




@endsection
