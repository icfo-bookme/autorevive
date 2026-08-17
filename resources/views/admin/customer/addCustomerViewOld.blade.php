@extends('layouts.backend.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Add New Customer</div>

                <div class="card-body" >
                    <form id="add_users_credentials" action="">
                        <h5 class="text-center">Fill the input field to register new customer</h5>
                        <div class="form-group row" id="inputFieldContainer">
                            <div class="col-sm-3 col-md-4 col-lg-3 mb-3">
                                <label class="col-form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name">
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-3 mb-3">
                                <label class="col-form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name">
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-3 mb-3">
                                <label class="col-form-label">Phone Number<span class="must text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    required="required">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label class="col-form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">District</label>
                                <input type="text" class="form-control" id="district" name="district">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Thana</label>
                                <input type="text" class="form-control" id="thana" name="thana">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Area</label>
                                <input type="text" class="form-control" id="area" name="area">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Road No</label>
                                <input type="text" class="form-control" id="road_no" name="road_no">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">House No</label>
                                <input type="text" class="form-control" id="house_no" name="house_no">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Flat No</label>
                                <input type="text" class="form-control" id="flat_no" name="flat_no">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Car Number</label>
                                <input type="text" class="form-control" id="car_no" name="car_no">
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Order Notes</label>
                                <textarea class="form-control" rows="2" id="order_notes" name="order_notes" spellcheck="true"></textarea>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="input-11" class="col-form-label">Customer Notes</label>
                                <textarea class="form-control" rows="2" id="customer_notes" name="customer_notes"></textarea>
                            </div>
                        </div>

                    </form>
                    <div class="col-md-12 my-3" id="data_form">
                        <hr>
                        <button type="button" class="btn btn-primary" id="add-row" onclick="addNewUser()">
                            <div class="fonticon-wrap">
                                <i class="fa fa-plus"></i>
                            </div>
                        </button>

                        <button type="button" class="btn btn-danger" id="delete-row" onclick="deleteRow()">
                            <div class="fonticon-wrap">
                                <i class="icon-minus"></i>
                            </div>
                        </button>

                    </div>
                    <div class="form-footer text-center">
                        <button type="button" class="btn btn-success" onclick="submitHandler()"><i
                                class="fa fa-check-square-o"></i> SAVE</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                class="fa fa-times"></i>Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let count = 1;

        function addNewUser() {
            let htmlMarkUp = `<hr>
            <form id=add_users_credentials_${count}>
                <div class="form-group row">
                    <div class="col-lg-12"><h5 class="text-center">Fill the input field to register new customer</h5></div>
        <div class="col-sm-3 col-md-4 col-lg-3 mb-3">
                            <label class="col-form-label">First Name</label>
                            <input type="text" class="form-control" id=first_name name=first_name[]>
                        </div>
                        <div class="col-sm-3 col-md-4 col-lg-3 mb-3">
                            <label class="col-form-label">Last Name</label>
                            <input type="text" class="form-control" id=last_name name=last_name[]>
                        </div>
                        <div class="col-sm-3 col-md-4 col-lg-3 mb-3">
                            <label class="col-form-label">Phone Number<span class="must text-danger">*</span></label>
                            <input type="text" class="form-control" id=phone_number name=phone_number[]
                                required="required">
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="col-form-label">Email</label>
                            <input type="text" class="form-control" id=email name=email[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Country</label>
                            <input type="text" class="form-control" id=country name=country[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">District</label>
                            <input type="text" class="form-control" id=district name=district[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">City</label>
                            <input type="text" class="form-control" id=city name=city[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Thana</label>
                            <input type="text" class="form-control" id=thana name=thana[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Area</label>
                            <input type="text" class="form-control" id=area name=area[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Road No</label>
                            <input type="text" class="form-control" id=road_no name=road_no[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">House No</label>
                            <input type="text" class="form-control" id="house_no" name="house_no">
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Flat No</label>
                            <input type="text" class="form-control" id=flat_no name=flat_no[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Car Number</label>
                            <input type="text" class="form-control" id=car_no name=car_no[]>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Order Notes</label>
                            <textarea class="form-control" rows="2" id=order_notes name=order_notes[] spellcheck="true"></textarea>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="input-11" class="col-form-label">Customer Notes</label>
                            <textarea class="form-control" rows="2" id=customer_notes name=customer_notes[]></textarea>
                        </div>
                    </div>
                </form>
            `

            $('#data_form').prepend(htmlMarkUp);
            count++;
        }

        function submitHandler() {
            $('form').each(function() {
                var form = $(this);
                var getData = form.serialize();
                console.log("getData", getData);
                $.ajax({
                        type: 'post',
                        url: './addCustomer',
                        data: getData,
                        dataType: 'json',
                        enctype: 'multipart/form-data',
                        processData: false,
                        cache: false,
                        contentType: false,
                        timeout: 600000,
                        success: function(response) {
                            console.log(response);
                        },

                        error: function(jqXHR, exception) {
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
            });
            // var formData = $('#add_users_credentials').serialize();
            // console.log("formData", formData);
        }
    </script>
@endsection
