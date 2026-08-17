@extends('layouts.backend.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form id="roleInsertForm">
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                        Role Insert
                    </h4>
                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Role Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-1" name="roleName" required>
                        </div>
                    </div>
                    <div class="form-footer text-center">
                        <!-- <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i>
                            CANCEL</button> -->
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                class="fa fa-times"></i>Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {



        /**
         * @name fromOnSubmit
         * @role Submit The form
         * @param
         * @return json response
         *
         */


        $('#roleInsertForm').submit(function () {
            event.preventDefault();

            alertify.confirm("Are You Sure To Submit This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './roleInsertAjaxRequest',
                        data: $("#roleInsertForm").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {

                                alertify.warning(data.errors.name);
                            } else {
                                //alert(data);
                                alertify.success(data.message);
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

    function clearForm() {
        $('#roleInsertForm').trigger("reset");
    }

</script>

@endsection
