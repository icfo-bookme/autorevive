@extends('layouts.backend.master')
@section('content')
@php 
    $role = App\admin\UserRolesModel::where('user_id', 49)->pluck('role_id')->toArray();
    dd(in_array(4, $role));
@endphp
{{-- @dd(Auth::user()->role) --}}

<div class="conatiner">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Add Banner Info</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-8">
                            <form id="siteDetailForm">
                                @csrf
                                <div class="form-group">
                                    <label for="">Banner Text</label>
                                    <input type="text" name="banner_text" class="form-control"
                                        value="{{ $websiteDetails->banner_text }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Banner Image</label>
                                    <input type="file" name="banner_image_path" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Site Logo</label>
                                    <input type="file" name="logo_path" class="form-control">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#siteDetailForm').submit(function () {
    event.preventDefault();
    alertify.confirm("Are You Sure To Submit This?",
        function () {
            var formData = new FormData($('#siteDetailForm')[0]);
            $.ajax({
                type: 'post',
                url: './insertSiteDetails',
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
                        alertify.success(data);
                        setTimeout(function () {
                            location.reload();
                        }, 2000);

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


</script>

@endsection
