@extends('layouts.backend.master')
@section('content')

<div class="row ">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">
                    <i class="fa fa-user-circle-o"></i>
                    Engine Setup</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-8">
                        <form id="carEngineInsertForm">
                            <div class="form-group">
                                <label for="">Company</label>
                               <select class ="form-control" name="company" id="company">
                                   <option value=""> SELECT COMPANY</option>
                                   @foreach ($companyData as $data)
                                      <option value="{{$data->id}}">{{$data->car_company}}</option>
                                    @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                                <label for="">Car Brand</label>
                                <select class ="form-control" name="car_brand" id="car_brand">
                                    <option value=""> SELECT BRAND</option>
                                </select>
                            </div>
			                <div class="form-group">
                                <label for="">Car Model</label>
                               <select class ="form-control" name="car_model" id="car_model">
                                   <option value=""> SELECT MODEL</option>
                               </select>
                            </div>
                            <div class="form-group">
                                <label for="">Car Engine</label>
                                <input type="text" class="form-control" name="car_engine" placeholder="car engine" id="" required>
                            </div>

                            <div class="text-center">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var counter = 1;
    $(document).ready(function () {

        $('#company').change(function () {
            let company_id = $('#company').val();

            if (company_id.length <= 0) {
                $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
            } else {
                $.ajax({
                    url: '{{ URL("getBrandByCompanyIdAjax") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: company_id
                    },
                    success: data => {
                        $('#car_brand').html('<option value=""> SELECT BRAND</option>');
                        $.each(data, (key, val) => {
                            $('#car_brand').append(`<option value="${val.id}">${val.car_brand}</option>`);
                        });
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });


        $('#car_brand').change(function () {
            let brand_id = $('#car_brand').val();

            if (brand_id.length <= 0) {
                $('#car_model').html(`<option value=""> SELECT Model</option>`);
            } else {
                $.ajax({
                    url: '{{ URL("getModelByBrandIdAjax") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: brand_id
                    },
                    success: data => {
                        if (Object.keys(data).length > 0) {
                            $('#car_model').html('<option value=""> SELECT MODEL</option>');
                            $.each(data, (key, val) => {
                                $('#car_model').append(`<option value="${val.id}">${val.car_model}</option>`);
                            });
                        } else {
                            $('#car_model').html(`<option value="">No option for this brand</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });



        /**
         * @name fromOnSubmit
         * @role Submit The form
         * @param
         * @return json response
         *
         */


        $('#carEngineInsertForm').submit(function () {
            event.preventDefault();
            alertify.confirm("Are You Sure To Submit This?",
                function () {
                 var formData = $("#carEngineInsertForm").serialize();
                 $.ajax({
                    type: 'post',
                    url: '{{URL("carEngineInsertAjax")}}',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.warning("please input all the fields properly");
                        } else if(data == 'Success') {
                            //alert(data);
                            alertify.success(data);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000);


                        }
                        else{
                            //  alertify.warning('Something Went Wrong');

                            console.log(data);

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

    function clearForm() {
        $('#carEngineInsertForm').trigger("reset");
    }

</script>

@endsection
