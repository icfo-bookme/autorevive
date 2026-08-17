@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Delivery Men View</div>

            <div class="card-body">
                {{-- <div class="float-right mb-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-team-insert">New
                        Member</button>
                </div>
                <div class="clearfix"></div> --}}
                <div class="table-responsive">
                    <table id="classTable" class="table table-bordered" style="width: 100% !important">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact Number</th>
                                {{-- <th>Alt Contact Number</th> --}}
                                <th>Address</th>
                                <th>NID</th>
                                <th>Created By</th>
                                {{-- <th>Updated By</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($deliveryTeam as $member)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$member->user->first_name}}</td>
                                <td>{{$member->user->last_name}}</td>
                                <td>{{$member->user->phone}}</td>
                                {{-- <td>{{$member->alt_contact_number}}</td> --}}
                                <td>{{$member->user->address}}</td>
                                <td> <img src="{{asset($member->user->NID)}}" style="width:30px;height:30px" class="img-thumbnail"> </td>
                                <td>{{$member->created_by}}</td>
                                {{-- <td>{{$member->updated_by}}</td> --}}
                                <td>

                                    <a href="javascript:void(0)" onclick="viewHistory({{$member->user->id}})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="editMember({{$member->user->id}})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    {{-- Can't delete. Foregn key constraint fails --}}
                                    {{-- <a href="javascript:void(0)" onclick="deleteTeamMember({{$member->user->id}})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" title="" data-original-title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a> --}}
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


{{-- modal delivery team history --}}
<div class="modal fade" id="modal_team_history" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Delivery History</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Invoice ID</th>
                                <th>Deadline Date</th>
                                <th>Deadline Time</th>
                                <th>Completed At</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody id="teamHistoryContainer">
                            {{--  --}}
                        </tbody>

                    </table>
                </div>
            </div>
            {{-- <div class="modal-footer justify-content-center"> --}}
                {{-- <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save changes
                </button> --}}
            {{-- </div> --}}
        </div>
    </div>
</div>


<!-- modal new subject -->
{{-- <div class="modal fade" id="modal-team-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Add New Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="teamInsertForm">


                    <div class="form-group">
                        <label for="input-1">Name</label>
                        <input type="text" class="form-control" id="category_name" placeholder="name" name="name"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Contact Number</label>
                        <input type="number" class="form-control" id="contact_number" placeholder="contact number"
                            name="contact_number" required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Alt Contact Number</label>
                        <input type="number" class="form-control" id="alt_contact_number"
                            placeholder="alt contact number" name="alt_contact_number" required>
                    </div>


                    <div class="form-group">
                        <label for="input-1">Address</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address"
                            placeholder="address"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="input-1">NID</label>
                        <input type="file" class="form-control" name="NID" accept="image/*" id="NID"
                            onchange="imageValidateAndPreview(this,'NID')" required>
                    </div>


            </div> --}}
            {{-- <div class="modal-footer justify-content-center">

            </div> --}}
            {{-- </form>
        </div>
    </div>
</div> --}}









<!-- modal body goes here -->
<div class="modal fade" id="modal-member-update" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Update Team Member Info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="teamUpdateForm">


                    <div class="form-group">
                        <label for="input-1">First Name</label>
                        <input type="text" class="form-control" id="first_name" placeholder="name" name="first_name" required>

                        <input type="hidden" class="form-control" id="team_id" name="id">
                    </div>

                    <div class="form-group">
                        <label for="input-1">Last Name</label>
                        <input type="text" class="form-control" id="last_name" placeholder="name" name="last_name" required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="contact number"
                            name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Contact Number</label>
                        <input type="number" class="form-control" id="phone" placeholder="contact number"
                            name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Country</label>
                        <input type="text" class="form-control" id="country" placeholder="contact number" name="country"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">District</label>
                        <input type="text" class="form-control" id="district" placeholder="contact number" name="district"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">City</label>
                        <input type="text" class="form-control" id="city" placeholder="contact number"
                            name="city" required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Thana</label>
                        <input type="text" class="form-control" id="thana" placeholder="contact number" name="thana"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Area</label>
                        <input type="text" class="form-control" id="area" placeholder="contact number" name="area"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Road No</label>
                        <input type="text" class="form-control" id="road_no" placeholder="contact number" name="road_no"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">House No</label>
                        <input type="text" class="form-control" id="house_no" placeholder="contact number" name="house_no"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Flat No</label>
                        <input type="text" class="form-control" id="flat_no" placeholder="contact number" name="flat_no"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">NID</label>
                        <input type="file" class="form-control" name="NID" accept="image/*" id="NID"
                            onchange="imageValidateAndPreview(this,'NID')" >
                    </div>

                    {{--

                        name
                        email
                        phone
                        country
                        district
                        city
                        thana
                        area
                        road_no
                        house_no
                        flat_no

                    --}}

                    {{-- <div class="form-group">
                        <label for="input-1">Alt Contact Number</label>
                        <input type="number" class="form-control" id="team_alt_contact_number"
                            placeholder="alt contact number" name="alt_contact_number" required>
                    </div> --}}


                    {{-- <div class="form-group">
                        <label for="input-1">Address</label>
                        <textarea class="form-control" id="team_address" rows="3" name="address"
                            placeholder="address"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="input-1">NID</label>
                        <input type="file" class="form-control" name="NID" accept="image/*" id="team_NID"
                            onchange="imageValidateAndPreview(this,'team_NID')">
                    </div> --}}
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    $(document).ready(function () {
        var table = $('#classTable').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true
        });

        table.buttons().container()
            .appendTo('#classTable_wrapper .col-md-6:eq(0)');




        $('#teamInsertForm').submit(function () {
            event.preventDefault();
            alertify.confirm("Are You Sure To Submit This?",
                function () {
                    var formData = new FormData($('#teamInsertForm')[0]);
                    $.ajax({
                        type: 'post',
                        url: './deliveryTeamInsertAjax',
                        data: formData,
                        dataType: 'json',
                        enctype: 'multipart/form-data',
                        processData: false,
                        cache: false,
                        contentType: false,
                        timeout: 600000,
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {
                                alertify.warning('input field empty');
                            } else {
                                $('#modal-team-insert').modal('hide');
                                alertify.success(data);

                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

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



        $('#teamUpdateForm').submit(function () {
            event.preventDefault();
            alertify.confirm("Are You Sure To Update This?",
                function () {
                    var formData = new FormData($('#teamUpdateForm')[0]);
                    $.ajax({
                        type: 'post',
                        url: './deliveryTeamUpdateAjax',
                        data: formData,
                        dataType: 'json',
                        enctype: 'multipart/form-data',
                        processData: false,
                        cache: false,
                        contentType: false,
                        timeout: 600000,
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {
                                alertify.warning('input field empty');
                            } else {
                                $('#modal-member-update').modal('hide');
                                alertify.success(data);

                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

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



    //     $('#categoryUpdateForm').submit(function () {
    //         event.preventDefault();

    //         $.ajax({
    //             type: 'post',
    //             url: '{{URl("categoryUpdateAjax")}}',
    //             data: $('#categoryUpdateForm').serialize(),
    //             dataType: 'json',
    //             success: function (data) {
    //                 if (typeof data.errors !== 'undefined') {
    //                     alertify.warning('Something Went Wrong');
    //                     $('#modal-category-update').modal('hide');
    //                 } else {
    //                     //alert(data);
    //                     alertify.success(data);
    //                     $('#modal-category-update').modal('hide');

    //                     setTimeout(function () {
    //                         location.reload(true);
    //                     }, 1000)
    //                 }
    //             },

    //             error: function (jqXHR, exception) {
    //                 var msg = '';
    //                 if (jqXHR.status === 0) {
    //                     msg = 'Not connect.Verify Network.';
    //                     alertify.warning(msg);

    //                 } else if (jqXHR.status == 404) {
    //                     msg = 'Requested page not found. [404]';
    //                     alertify.warning(msg);
    //                 } else if (jqXHR.status == 500) {
    //                     msg = 'Internal Server Error [500].';
    //                     alertify.warning(msg);
    //                 } else if (exception === 'parsererror') {
    //                     msg = 'Requested JSON parse failed.';
    //                     alertify.warning(msg);
    //                 } else if (exception === 'timeout') {
    //                     msg = 'Time out error.';
    //                     alertify.warning(msg);
    //                 } else if (exception === 'abort') {
    //                     msg = 'Ajax request aborted.';
    //                     alertify.warning(msg);
    //                 } else {
    //                     msg = 'Uncaught Error.\n' + jqXHR.responseText;
    //                     alertify.warning(msg);
    //                 }

    //             }


    //         });
    //     });
    // });

    /**
     * @name editClass
     * @role fetch info and load them into modal for edit
     * @param delivery man's id
     * @return
     *
     */

    function viewHistory(id) {
        $.ajax({
            url: '{{ URL("getTeamsDeliveryHistoryAjax") }}',
            type: 'POST',
            data: {
                id: id
            },
            success: data => {
                let count = 0;
                let historyView = ``;
                $.each(data, (key, val) => {
                    if (val.order_report) {
                        historyView += `
                            <tr>
                                <td>${++count}</td>
                                <td>${val.user.first_name}</td>
                                <td>${val.user.last_name}</td>
                                <td>${String(val.order_id).padStart(4, '0')}</td>
                                <td>${val.deadline_date == null ? '' : val.deadline_date}</td>
                                <td>${val.deadline_time == "0000-00-00 00:00:00" ? '' : val.deadline_time}</td>
                                <td>${val.completed_at == null ? '' : val.completed_at}</td>
                                <td>${val.created_at}</td>
                            </tr>
                            `;
                    }
                });

                $('#teamHistoryContainer').html('');
                $('#teamHistoryContainer').html(historyView);
                $('#modal_team_history').modal('show');
            },
            error: err => {
                console.error(err);
            }
        });
    }


    function editMember(id) {

        // alert(id);
        $.ajax({
            type: 'post',
            url: '{{URL("getMemberDetails")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {

                    alertify.warning("Something went wrong");
                } else {

                    $('#team_id').val(data.id);
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#country').val(data.country);
                    $('#district').val(data.district);
                    $('#city').val(data.city);
                    $('#thana').val(data.thana);
                    $('#area').val(data.area);
                    $('#road_no').val(data.road_no);
                    $('#house_no').val(data.house_no);
                    $('#flat_no').val(data.flat_no);
                  //  $('#NID').val(data.NID);

                    // $('#team_id').val(data.id);
                    // $('#team_name').val(data.name);
                    // // $('#team_contact_number').val(data.contact_number);
                    // $('#team_contact_number').val(data.phone);
                    // $('#team_alt_contact_number').val(data.alt_contact_number);
                    // $('#team_address').val(data.address);
                    $('#modal-member-update').modal('show');

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



    /**
     * @name deleteClass
     * @role send ajax request to delete a class
     * @param role id
     * @return json response
     *
     */
    function deleteTeamMember(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("deliveryTeamDeleteAjax")}}',
                    data: {
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


    function imageValidateAndPreview(data, id) {
        var id = $(data).attr('id');
        if (data.files && data.files[0]) {
            var reader = new FileReader();

            var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
            if ($.inArray($(data).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alertify.warning("Only '.jpeg','.jpg', '.png', '.gif' formats are allowed.");

                $('#' + id).val('');

            } else {
                reader.onload = function (e) {};
                reader.readAsDataURL(data.files[0]);
            }
        }
    }

    $(function () {
        $(".drag_able").sortable();
        $(".drag_able").disableSelection();
    });

</script>
@endsection
