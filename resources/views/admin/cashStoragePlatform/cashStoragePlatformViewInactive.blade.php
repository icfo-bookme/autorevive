@extends('layouts.backend.master')
@section('content')
<style>
    .alertify-notifier .ajs-message.ajs-error {
        color: #fff !important;
        background: rgba(217, 92, 92, 0, 95);
        text-shadow: -1px -1px 0 rgba(0, 0, 0, 0, 5);
    }
</style>

<div class="mb-3">
    <a href="/cashStoragePlatformView" class="btn btn-primary">Active</a>
    <a href="/cashStoragePlatformViewInactive" class="btn btn-outline-primary">Inactive</a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Ending Balance Inactive</div>

            <div class="card-body">
               
                <div class="clearfix"></div>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-8 col-sm-8 col-md-8">
                        <div class="table-responsive">
                            <table id="classTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cash Platform</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="drag_able">
                                    @foreach ($all_platforms as $cash_platform)
                                    <tr class="balanceRow deleteRow{{ $cash_platform->id }}">
                                        <td class="platformName">{{ $cash_platform->name }}</td>
                                        <td><input type="text" class="form-control amount" value={{ $cash_platform->amount }} onkeyup=matchBalance()></td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="activatePlatform({{ $cash_platform->id }})"
                                                style="padding: 5px 10px;" class="btn btn-default btn-xs border btn-success"
                                                data-toggle="tooltip" title="" data-original-title="Activate">
                                                <i class="fa fa-undo"></i>
                                            </a>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>




<script>
   
    function activatePlatform(platformId) {
        alertify.confirm('Are You Sure you want to activate?', 'Data will be activated', function() {
            $.ajax({
                type: 'post',
                url: '{{URl("cashStoragePlatformRestoreAjax")}}',
                dataType: 'json',
                data: {
                    platformId
                },
                success: function(response) {
                    if (response.status) {
                        $('.deleteRow' + platformId).remove();
                        balanceCheck();
                        alertify.success(response.message);
                    } else {
                        alertify.error(response.message);
                        console.log(response.data);
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
        }, function() {
            alertify.error('Cancel')
        });
    }

</script>
@endsection