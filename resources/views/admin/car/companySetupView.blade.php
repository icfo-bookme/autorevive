@extends('layouts.backend.master')
@section('content')

<div class="row ">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">
                    <i class="fa fa-user-circle-o"></i>
                    Company Setup
                </h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-8">
                        {{-- Form starts --}}
                        <form id="companyInsertForm">
                            <div class="form-group">
                                <label for="">Car company</label>
                                <input type="text" class="form-control" name="car_company" placeholder="car company" id="" required>
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



        /**
         * @name fromOnSubmit
         * @role Submit The form
         * @param
         * @return json response
         *
         */


        $('#companyInsertForm').submit(function () {
            event.preventDefault();
            alertify.confirm("Are You Sure To Submit This?",
                function () {
                 var formData = $("#companyInsertForm").serialize();
                 $.ajax({
                    type: 'post',
                    url: '{{URL("companyInsertAjax")}}',
                    data: formData + '&_token={{ csrf_token() }}',
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
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');
        });

    });

    function clearForm() {
        $('#companyInsertForm').trigger("reset");
    }

</script>

@endsection
