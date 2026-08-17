@extends('layouts.backend.master')
@section('content')
<style>
    .must {
        color: red;
        font-size: 15px;
        font-weight: bold
    }
</style>
@include('partials.backend.header')

<div class="container">
    <div class="row py-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" width="200" alt="">
                    </div>
                    <h6 class="line-on-side text-muted text-center text-xs-center font-small-3 pt-2"><span>Create Account</span></h6>
                    <form id="adminPanelregisterForm">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="first_name" class="col-sm-4 col-form-label"><span
                                        class="must">*</span>First Name</label>
                                    <div>
                                        <input id="first_name" type="text" class="form-control" name="first_name"  required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-4 col-form-label"><span
                                        class="must">*</span>E-Mail Address</label>
                                    <div>
                                        <input id="email" type="text" class="form-control" name="email"  required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password" class="col-sm-4 col-form-label"><span
                                        class="must">*</span>Password</label>
                                    <div>
                                        <input id="password" type="password" class="form-control" name="password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="country"  class="col-sm-4 col-form-label"> Country </label>
                                    <select class="form-control" id="country" name="country">
                                        <option>Bangladesh</option>
                                        <option>USA</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="city" class="col-sm-4 col-form-label">City</label>
                                    <div>
                                        <input id="city" type="text" class="form-control" name="city">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="area" class="col-sm-4 col-form-label">Area</label>
                                    <div>
                                        <input id="area" type="text" class="form-control" name="area">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="house_no" class="col-sm-4 col-form-label">House No</label>
                                    <div>
                                        <input id="house_no" type="text" class="form-control" name="house_no">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-4 col-form-label"><span
                                        class="must">*</span>Address</label>
                                    <div>
                                        <textarea id="address" type="address" class="form-control" name="address" required></textarea>
                                        {{-- <input id="address" type="address" class="form-control" name="address" required> --}}
                                    </div>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="password-confirm" class="col-sm-4 col-form-label">Confirm Password</label>
                                    <div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="last_name" class="col-sm-4 col-form-label"><span
                                        class="must">*</span>Last Name</label>
                                    <div>
                                        <input id="last_name" type="text" class="form-control" name="last_name"  required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone" class="col-sm-4 col-form-label"><span
                                        class="must">*</span>Contact Number</label>
                                    <div>
                                        <input id="phone" type="phone" class="form-control" name="phone" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="district" class="col-sm-4 col-form-label">District</label>
                                    <div>
                                        <input id="district" type="text" class="form-control" name="district">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="thana" class="col-sm-4 col-form-label">Thana</label>
                                    <div>
                                        <input id="thana" type="text" class="form-control" name="thana">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="road_no" class="col-sm-4 col-form-label">Road No</label>
                                    <div>
                                        <input id="road_no" type="text" class="form-control" name="road_no">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="flat_no" class="col-sm-4 col-form-label">Flat No</label>
                                    <div>
                                        <input id="flat_no" type="text" class="form-control" name="flat_no">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role"  class="col-sm-4 col-form-label"> Role </label>
                                    <select id="role" name="role" class="form-control">
                                        <option value="" selected>-- SELECT ROLE --</option>
                                        @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="form-footer text-center">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> REGISTER </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>















<script>
    $(document).ready(function () {
        $('#adminPanelregisterForm').submit(function () {
            event.preventDefault();

            alertify.confirm("Are You Sure To Add This User?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './adminRegister',
                        data: $("#adminPanelregisterForm").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {

                                alertify.warning('Input Error!');
                            } else if (typeof data.warning != 'undefined') {
                                alertify.warning('Record Already Exists!');
                            }else if (data == "mailOrPhoneExists") {
                                alertify.error('User Already Exists!');
                            } else {
                                alertify.success(data);
                                $('#adminPanelregisterForm').trigger("reset");
                                setTimeout(() => location.reload(), 500);
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
        $('#adminPanelregisterForm').trigger("reset");
    }

</script>

@endsection