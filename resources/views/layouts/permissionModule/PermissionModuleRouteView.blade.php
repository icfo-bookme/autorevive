@extends('layouts.backend.master')
@section('content')

<div class="row">
   
                <h4 class="card-title">Permission Module Route View</h4>
               
                <div class="table-responsive">
                    <table class="table" id="BinTable">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Permission Module</th>
                                <th>Route</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($moduleRoutes as $mRoute)
                            <tr>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{$mRoute->permission->name}}</td>
                                <td>{{$mRoute->route}}</td>
                                <td>{{$mRoute->created_by}}</td>

                                <td>

                                    <a href="javascript:void(0)" id="edit-module" data-id="{{ $mRoute->id }}"
                                        class="btn btn-info">Edit</a>

                                    <a href="javascript:void(0)" id="delete-module" data-id="{{ $mRoute->id }}"
                                        class="btn btn-primary">Delete</a>



                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="moduleRoute-update-modal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Module Route Name</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="form" id="moduleRouteEditForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <div class="form-body">


                                                <div class="form-group">
                                                    <label for="projectinput6">Module</label>
                                                    <select id="module" name="module" class="form-control">
                                                        <option selected="" disabled=""> --SELECT MODULE-- </option>
                                                        @foreach ($modules as $module)
                                                        <option value="{{$module->id}}">{{$module->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    @csrf
                                                    <input type="hidden" name="id" id="id">
                                                    <label for="eventInput1">Route</label>
                                                    <input type="text" class="form-control" placeholder="Route URL"
                                                        id="route" name="route">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="editModuleRoute()">Save
                                    changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                            </div>
                        </div>
                    </div>
                </div>
             


<script type="text/javascript">
    $(document).ready(function () {



        $('body').on('click', '#edit-module', function () {
            var moduleRoute_id = $(this).data('id');
            //console.log(role_id);

            $('#moduleRoute-update-modal').modal('show');


            $.ajax({
                type: 'post',
                url: './getPermissionModuleDetailsByidAjax',
                data: {
                    id: moduleRoute_id
                },
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        // the variable is defined
                       // console.log(data);
                    } else {
                        //console.log(data);
                        // console.log(data.id);
                        // console.log(data.name);

                        $('#id').val(data.id);
                        $('#module').val(data.permission_modules_id);
                        $('#route').val(data.route);

                    }


                },
                error: function (data) {

                }

            });
        });


        $('body').on('click', '#delete-module', function () {
            var module_id = $(this).data('id');
            //console.log(role_id);

           
                 alertify.confirm('Are You Sure ?', 'Data Will Be Deleted', function () {
                    $.ajax({
                        type: 'post',
                        url: './PermissionModuleDetailsDeleteAjax',
                        data: {
                            id: module_id
                        },
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {
                                alertify.error('Error');

                            } else {
                               
                              alertify.success('Succcessfully deleted!');
                              setTimeout(function () {
                              location.reload(true);
                              }, 1000);

                            }


                        },
                        error: function (data) {
                            console.log(data);
                        }

                    });

                 }, function () {
                         alertify.error('Cancel');
                 });



        });
    });

    function editModuleRoute() {

        event.preventDefault()
        var module_id = $("#id").val();
        console.log(module_id);
        $.ajax({
            type: 'post',
            url: './PermissionModuleDetailsUpdateAjax',
            data: $("#moduleRouteEditForm").serialize(),
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {
                    // the variable is defined
                    alertify.error( data.errors.module_id + "\n" + data.errors.route);
                } else {
                    // alert(data);
                    // console.log(data);
                    $('#moduleRoute-update-modal').modal('hide');
                   alertify.success('Success');
                    setTimeout(function () {
                                 location.reload(true);
                     }, 1000);

                }


            },
            error: function (data) {

            }

        });

    }

    function reload(timeoutPeriod) {
        setTimeout("location.reload(true);", timeoutPeriod);
    }

</script>

@endsection
