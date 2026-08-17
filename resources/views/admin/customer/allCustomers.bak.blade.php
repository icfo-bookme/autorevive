{{-- @dd($customers) --}}
@extends('layouts.backend.master')
@section('content')
    <style>
        .contentHide {
            display: none;
        }

        .alertify-notifier .ajs-message.ajs-error {
            color: #fff !important;
            background: rgba(217, 92, 92, 0, 95);
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0, 5);
        }

    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Customer View</div>

                <div class="card-body">
                    <div class="float-left my-3">
                        <button class="btn btn-outline-info" onclick="window.open('{{url('smsTemplateView')}}')">Add Template</button>
                        <button class="btn btn-outline-info" onclick="sentSms()">SMS</button>
                    </div>
                    <div class="float-right my-3">
                        <button class="btn btn-success" id="togglerHandlerBtn">New Customer</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="classTable" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th><input id="selectAll" value="1" type="checkbox"></th>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Car Numbers</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="drag_able">
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td><input type="checkbox" name="printcheck[]" class="printcheck" value="{{$customer->phone}}" onclick="selectedUsers({{$customer->phone}},this)"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a class="custom_textDecoration"
                                                onclick="getCustomerOrderHistory({{ $customer->id }})"
                                                style="cursor: pointer">
                                                {{ $customer->first_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="custom_textDecoration"
                                                onclick="getCustomerOrderHistory({{ $customer->id }})"
                                                style="cursor: pointer">
                                                {{ $customer->last_name }}
                                            </a>
                                        </td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>
                                            {{ $customer->car_no }}
                                            {{-- @foreach ($customer->car_numbers($customer->email) as $car_no)
                                                {{ $car_no->car_no }} <br />
                                            @endforeach --}}

                                        </td>
                                        <td>{{ $customer->created_at }}</td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                onclick="getCustomerOrderHistory({{ $customer->id }})"
                                                style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                                data-toggle="tooltip" title="" data-original-title="Edit">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="editCustomerInfo({{ $customer->id }})"
                                                style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                                data-toggle="tooltip" title="" data-original-title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 contentHide" id="showAddnewForm">
            <div class="card">
                <div class="card-header text-center">
                    <h4>New Customer</h4>
                </div>
                <div class="card-body">
                    <form id="customerInfoInsertForm">
                        @csrf
                        <div class="row" id="customerInfo">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">First Name <span class="must text-danger">*</span></th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone <span class="must text-danger">*</span></th>
                                                <th scope="col">Car Number</th>
                                            </tr>
                                        </thead>

                                        <tbody id="customer_details">
                                            <tr>
                                                <td class="my-3">
                                                    <input type="text" class="form-control checkValid" id="first_name"
                                                        name="first_name[]" placeholder="first name">
                                                </td>

                                                <td class="my-3">
                                                    <input type="text" class="form-control" id="last_name"
                                                        name="last_name[]" placeholder="last name">
                                                </td>

                                                <td class="my-3">
                                                    <input type="email" class="form-control" id="email" name="email[]"
                                                        placeholder="email">
                                                </td>

                                                <td class="my-3">
                                                    <input type="text" class="form-control checkValid" id="phone_number"
                                                        name="phone_number[]" placeholder="phone number"
                                                        required="required">
                                                </td>

                                                <td class="my-3">
                                                    <input type="text" class="form-control" id="car_no" name="car_no[]"
                                                        placeholder="car number">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 my-3">
                                <button type="button" class="btn btn-primary" id="add-row" onclick="addRow()">
                                    <div class="fonticon-wrap"><i class="fa fa-plus"></i></div>
                                </button>

                                <button type="button" class="btn btn-danger" id="delete-row" onclick="deleteRow()">
                                    <div class="fonticon-wrap"><i class="icon-minus"></i></div>
                                </button>
                            </div>

                        </div>

                        <div class="form-footer text-center">
                            <button type="button" class="btn btn-success" onclick="submitCustomerInfo()"><i
                                    class="fa fa-check-square-o"></i> SAVE</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                    class="fa fa-times"></i>Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- customer order details modal --}}
    <div class="modal fade bd-example-modal-lg" id="order_history_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" style="overflow: scroll" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Car No.</th>
                                        <th>Order Note</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="order_history">
                                    {{--  --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- order history --}}
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLongTitle">Order History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="historyBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    {{-- customer info edit modal --}}
    <div class="modal fade" id="editCustomerInfoModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated flipInX">
                <div class="modal-header">
                    <h4 class="modal-title " style="font-size: 18px;">Customer Info Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" style="padding: 0px 50px;">
                    <form class="form" method="POST" id="editCustomerInfoForm">
                        <div class="form-group row" id="inputFieldContainer">
                            <input type="hidden" class="form-control checkValidModal" id="customer_id"
                                name="customer_id">
                            <div class="col-sm-3 col-md-4 col-lg-6 mb-3">
                                <label class="col-form-label">First Name<span class="must text-danger">*</span></label>
                                <input type="text" class="form-control checkValidModal" id="update_first_name"
                                    name="update_first_name">
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-6 mb-3">
                                <label class="col-form-label">Last Name</label>
                                <input type="text" class="form-control" id="update_last_name" name="update_last_name">
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-6 mb-3">
                                <label class="col-form-label">Phone Number<span class="must text-danger">*</span></label>
                                <input type="text" class="form-control checkValidModal" id="update_phone_number"
                                    name="update_phone_number" required="required">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="col-form-label">Email</label>
                                <input type="text" class="form-control" id="update_email" name="update_email">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">Country</label>
                                <input type="text" class="form-control" id="update_country" name="update_country">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">District</label>
                                <input type="text" class="form-control" id="update_district" name="update_district">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">City</label>
                                <input type="text" class="form-control" id="update_city" name="update_city">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">Thana</label>
                                <input type="text" class="form-control" id="update_thana" name="update_thana">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">Area</label>
                                <input type="text" class="form-control" id="update_area" name="update_area">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">Road No</label>
                                <input type="text" class="form-control" id="update_road_no" name="update_road_no">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">House No</label>
                                <input type="text" class="form-control" id="update_house_no" name="update_house_no">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">Flat No</label>
                                <input type="text" class="form-control" id="update_flat_no" name="update_flat_no">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">Car Number</label>
                                <input type="text" class="form-control" id="update_car_no" name="update_car_no">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="input-11" class="col-form-label">Address</label>
                                <input type="text" class="form-control" id="update_address" name="update_address">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="col-form-label">How Did You Hear About AUTOMART?</label>
                            <br />
                            @foreach ($referrals as $referral)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="referral_method[]" id="{{ $referral->id }}" value="{{ $referral->id }}">
                                    <label class="form-check-label">{{ $referral->referral_method }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-footer text-center">
                            <button type="button" class="btn btn-success" onclick="updateUserInfo()"><i
                                    class="fa fa-check-square-o"></i> SAVE</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                    class="fa fa-times"></i>Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- sms modal -->
    <div class="modal fade" id="modal-sms" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title" style="font-size: 18px;">SMS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="smsForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="sms-template">Template</label>
                        <select class="form-control" name="templateName" id="templateName">
                            <option selected disabled value="">Please Select Template</option>
                            @foreach ($smsTemplates as $smsTemplate)
                                <option value="{{ $smsTemplate->id }}">{{ $smsTemplate->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="sms-body">SMS Body</label>
                            <textarea cols="8" rows="10" class="form-control" name="smsBody" id="smsBody"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-info" name = "sendSms" id = "sendSms"><i class="fa fa-check-square-o"></i> Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>

        let selected_customerPhone_array =[];
        $(document).ready(function() {
            var table = $('#classTable').DataTable({
                "aLengthMenu": [
                    [10, 50, 100, 500, 1000, -1],
                    [10, 50, 100, 500, 1000, "ALL"]
                ],
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
            });

            $("#togglerHandlerBtn").click(function() {
                $(this).text(function(i, text) {
                    return text === "New Customer" ? "Hide" : "New Customer";
                });
                $('#showAddnewForm').toggleClass("contentHide");
                window.scrollTo(0, document.body.scrollHeight);
            });

            $('#selectAll').click( function(event){
                selected_customerPhone_array = [];

                if(this.checked){
                    $('.printcheck:checkbox').each(function(){
                        this.checked = true;
                        selected_customerPhone_array.push($(this).val());
                    });
                }else{
                    $('.printcheck:checkbox').each(function(){
                        this.checked = false;
                        selected_customerPhone_array.pop();
                    });
                }
                console.log(selected_customerPhone_array);
            });

            $("#templateName").change(function(){
                var id = $("#templateName").val();
                $.ajax({
                    type: 'post',
                    url: '{{URL("getTemplateBody")}}',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            alertify.warning("Something went wrong");
                        } else {
                            console.log(data);
                            $('#smsBody').val(data.body);
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

            });

            $('#smsForm').submit(function (event) {
                event.preventDefault();
                var smsBody = $("#smsBody").val();
                if(smsBody.length > 0){
                    alertify.confirm('Are You Sure ?', 'SMS will be sent', function () {
                        $.ajax({
                            type: 'post',
                            url: '{{URl("sendSmsAllUser")}}',
                            data: {
                                recipients:selected_customerPhone_array,
                                smsBody:smsBody
                            },
                            dataType: 'json',
                            success: function (response) {
                                if(response.status === true){
                                    alertify.success(response.message);
                                    $('#smsForm')[0].reset();
                                    $('#modal-sms').modal('hide');
                                    
                                } else if(response.status === false){
                                    alertify.error("<span class='text-white'>"+response.message+"</span>");

                                }  else if(response.status === "validation-error"){
                                    for (let key in response.data) {
                                        if (response.data.hasOwnProperty(key)) {
                                            alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                                        }
                                    }

                                }
                            }
                        });

                    }, function () {
                        alertify.error("<span class='text-white'>Cancelled!</span>");
                    });
                }else{
                    alertify.error("Please select template")
                }
                
                
            });


        });

        var count = 0;
        var customerCount = [];

        function addRow() {
            var markup = "";

            markup += "<tr>";

            markup += '<td>';
            markup += '<input type="text" class="form-control checkValid" id="first_name" name="first_name[]" placeholder="first name">';
            markup += '</td>'

            markup += '<td>';
            markup += '<input type="text" class="form-control" id="last_name" name="last_name[]" placeholder="last name">';
            markup += '</td>';

            markup += '<td>';
            markup += '<input type="email" class="form-control" id="email" name="email[]" placeholder="email">';
            markup += '</td>';

            markup += '<td>';
            markup += '<input type="text" class="form-control checkValid" id="phone_number" name="phone_number[]" placeholder="phone number" required="required">';
            markup += '</td>';

            markup += '<td>';
            markup += '<input type="text" class="form-control" id="car_no" name="car_no[]" placeholder="car number">';
            markup += '</td>';

            markup += "</tr>";

            $("#customerInfo table tbody").append(markup);
            customerCount.push(count);
            count++;
        }


        function deleteRow() {
            if ($("#customerInfo table tbody tr").length != 1) {
                $("#customerInfo table tbody tr:last").remove();
                customerCount.pop();
            }
        }


        function submitCustomerInfo() {
            var empty_fields = [];
            $(".checkValid").each(function() {
                if ($(this).val().length != 0) {
                    return;
                } else {
                    empty_fields.push($(this).attr('name'));
                    event.preventDefault();
                }
            });
            if (empty_fields.length > 0) {
                // console.log("empty_fields", empty_fields);
                if (empty_fields.includes('first_name[]') && empty_fields.includes('phone_number[]')) {
                    alertify.error('first name is required');
                    alertify.error('phone number is required');
                } else if (empty_fields.includes('first_name[]')) {
                    alertify.error('first name is required');
                } else if (empty_fields.includes('phone_number[]')) {
                    alertify.error('phone number is required');
                }
            } else {
                alertify.confirm("Are You Sure To Submit This?",
                    function() {
                        $('#preloader').modal('show');
                        var formData = new FormData($('#customerInfoInsertForm')[0]);
                        console.log("form data", formData);
                        $.ajax({
                            type: 'post',
                            url: './addCustomer',
                            data: formData,
                            dataType: 'json',
                            enctype: 'multipart/form-data',
                            processData: false,
                            cache: false,
                            contentType: false,
                            timeout: 600000,
                            success: function(response) {
                                console.log(response);
                                $('#preloader').modal('hide');
                                if (response.status === true) {
                                    alertify.success(response.message);
                                    document.getElementById("customerInfoInsertForm").reset();
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);

                                } else if (response.status === 'validation-error') {
                                    $.each(response.data, function(index,value){
                                        alertify.error(value[0]);
                                    });

                                } else if (response.status === 'customer-exists') {
                                    alertify.error(response.message);
                                } else {
                                    alertify.error(response.message)
                                }
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

                    },
                    function() {
                        alertify.error('Cancel');
                    }).setHeader('<em> CONFIRM </em> ')
            }

        }


        function editCustomerInfo(id) {
            console.log("customer id", id);
            $.ajax({
                url: "{{ URL('getCustomerDetailsById') }}",
                method: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    let tempDataFor = response.data.customerreferrals;
                    tempDataFor.forEach(function(item) {
                       $("input[name='referral_method[]']").map(function() {
                           if(this.id == item.referral_id){
                             $(this).attr('checked', true)
                           }
                       });
                    });

                    if (response.status === true) {
                        console.log(response.data);
                        $('#customer_id').val(response.data.customer.id);
                        $('#update_first_name').val(response.data.customer.first_name);
                        $('#update_last_name').val(response.data.customer.last_name);
                        $('#update_phone_number').val(response.data.customer.phone);
                        $('#update_email').val(response.data.customer.email);
                        $('#update_country').val(response.data.customer.country);
                        $('#update_district').val(response.data.customer.district);
                        $('#update_city').val(response.data.customer.city);
                        $('#update_thana').val(response.data.customer.thana);
                        $('#update_area').val(response.data.customer.area);
                        $('#update_house_no').val(response.data.customer.house_no);
                        $('#update_road_no').val(response.data.customer.road_no);
                        $('#update_flat_no').val(response.data.customer.flat_no);
                        $('#update_car_no').val(response.data.customer.car_no);
                        $('#update_address').val(response.data.customer.address);
                        $("#editCustomerInfoModal").modal('show');
                    }
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    }
                }
            });
        }


        function updateUserInfo() {
            event.preventDefault();
            var empty_fields = [];
            $(".checkValidModal").each(function() {
                if ($(this).val().length != 0) {
                    return;
                } else {
                    empty_fields.push($(this).attr('name'));
                    event.preventDefault();
                }
            });
            if (empty_fields.length > 0) {
                console.log("empty field", empty_fields);
                if (empty_fields.includes('update_first_name') && empty_fields.includes('update_phone_number')) {
                    alertify.error('first name is required');
                    alertify.error('phone number is required');
                } else if (empty_fields.includes('update_first_name')) {
                    alertify.error('first name is required');
                } else if (empty_fields.includes('update_phone_number')) {
                    alertify.error('phone number is required');
                }
                //   $('#warningModal').modal('show');
            } else {
                alertify.confirm('Are You Sure ?', 'UserInfo Will Be Updated', function() {
                    // let getUserInfoData = $('#editCustomerInfoForm').serialize();
                    // console.log("getUserInfoData", getUserInfoData);
                    // return getUserInfoData;
                    $('#preloader').modal('show');
                    $.ajax({
                        url: "{{ URL('userInformationUpdate') }}",
                        method: "POST",
                        data: $('#editCustomerInfoForm').serialize(),
                        success: function(response) {
                            if (response.status === true) {
                                alertify.success(response.message);
                                $('#preloader').modal('hide');
                                setTimeout(function() {
                                    location.reload(true);
                                }, 1000);

                            } else if (response.status === 'customer-exists') {
                                alertify.error(response.message);

                            }  else if (response.status === 'validation-error') {
                                $.each(response.data, (index, value) => {
                                    alertify.error(value[0]);
                                });

                            } else {
                                alertify.error(response.message);
                            }

                        },
                        error: function(jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.Verify Network.';
                                alertify.warning(msg);
                                $('#preloader').modal('hide');

                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                                alertify.warning(msg);
                                $('#preloader').modal('hide');
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                                alertify.warning(msg);
                                $('#preloader').modal('hide');
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                                alertify.warning(msg);
                                $('#preloader').modal('hide');
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                                alertify.warning(msg);
                                $('#preloader').modal('hide');
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                                alertify.warning(msg);
                                $('#preloader').modal('hide');
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                alertify.warning(msg);
                                $('#preloader').modal('hide');
                            }
                        }
                    });
                }, function() {
                    alertify.error('Cancel')
                });
            }
        }



        function getCustomerOrderHistory(id) {
            $.ajax({
                url: '{{ URL('getCustomerOrderHistoryAjax') }}',
                type: 'POST',
                data: {
                    id: id
                },
                success: data => {
                    console.log(data);
                    count = 0;
                    $('#order_history').html('');
                    $.each(data, (key, val) => {
                        let noteLength = 10;
                        let status = '';
                        let orderCode = val.order_code == null ? '' : val.order_code;
                        let orderNote = String(val.order_note).length > noteLength ?
                            val.order_notes.substr(0, noteLength) + '...' :
                            String(val.order_notes);

                        val.is_approve == 1 ?
                            status += '<span class="badge badge-primary">Approved</span> ' :
                            status += '<span class="badge badge-danger">Not-approved</span> ';
                        val.shipment_assigned == 1 ?
                            status += '<span class="badge badge-primary">Shipped</span> ' :
                            '';
                        val.is_rejected == 0 ?
                            status += '' :
                            status += '<span class="badge badge-danger">Rejected</span> ';

                        $('#order_history').append(`
                    <tr>
                        <td>${++count}</td>
                        <td class="invoice_id" data-id="${val.id}">${String(val.id).padStart(4, '0')}</td>
                        <td>${val.car_no ? val.car_no : ''}</td>
                        <td>${val.order_notes ? val.order_notes : ''}</td>
                        <td>${status}</td>
                    </tr>`);
                    });
                    $('#order_history_modal').modal('show');

                    $('.invoice_id').click((e) => showOrderHistory(e.target.dataset.id));
                },
                error: err => {
                    console.error(err);
                }
            });
        }

        function showOrderHistory(id) {
            $.ajax({
                url: "{{ URL('orderHistory') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: ({
                    data
                }) => {
                    console.log(data);
                    let html = `
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Created AT</th>
                                    <th>Approved AT</th>
                                    <th>Shipment Assigned</th>
                                    <th>Shipment Assigned AT</th>
                                    <th>Shipment Completed AT</th>
                                    <th>Payment Collected AT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${data.created_at ? data.created_at : ''}</td>
                                    <td>${data.approved_at ? data.approved_at : ''}</td>
                                    <td>${data.shipment.user.name ? data.shipment.user.name : ''}</td>
                                    <td>${data.shipment_assigned_at ? data.shipment_assigned_at : ''}
                                    </td>
                                    <td>${data.shipment_completed_at ? data.shipment_completed_at :
                                        ''}</td>
                                    <td>${data.payment_collected_at ? data.payment_collected_at : ''}
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>`;

                    $("#historyBody").html(html);
                    $('#order_history_modal').modal('hide');
                    $('#historyModal').modal('show');
                },
                error: err => console.error(err)
            });
        }

        function selectedUsers(phone,value){
            if (value.checked==true) {
                selected_customerPhone_array.push(phone);
            } else {
                let index = selected_customerPhone_array.indexOf(phone);
                if(index > -1) {
                    selected_customerPhone_array.splice(index,1);
                }
            }
            console.log('final',selected_customerPhone_array);
        }

        function sentSms(){
            if(selected_customerPhone_array.length==0){
                alertify.alert("Please Select Recipients");
            }
            else{
                $("#modal-sms").modal("show");
            }
        }


        function clearForm() {
            $('#customerInfoInsertForm').trigger('reset');
            history.go(0);
        }


    </script>
@endsection
