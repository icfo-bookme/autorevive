@extends('layouts.backend.master')
@section('content')


            
                <h4 class="card-title" id="basic-layout-form">Role Assign</h4>
                
                    <form class="form" id="roleModuleAssignForm">
                        @csrf
                        <div class="form-body">

                            <h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>


                            <div class="row">

                                <div class="col-md-5">
                                  <div class="form-group">
                                      <label for="projectinput5">Roles</label>
                                      <select id="role" name="role" class="form-control">
                                          <option selected="" disabled="">--SELECT ROLE--</option>
                                          @foreach ($roles as $role)
                                          <option value="{{$role->id}}">{{$role->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>

                                    <div class="form-group">
                                        <label for="projectinput6">Module</label>
                                        <select id="module" name="module" class="form-control">
                                            <option selected="" disabled="">--SELECT MODULE--</option>
                                            @foreach ($modules as $module)
                                            <option value="{{$module->id}}">{{$module->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>




                                    <div class="form-actions center">
                                        <button type="submit" class="btn btn-primary" onclick="roleModuleAssign()">
                                            <i class="icon-check2"></i> Save
                                        </button>
                                        <button type="button" class="btn btn-warning mr-1" onclick="clearForm()">
                                            <i class="icon-cross2"></i> Cancel
                                        </button>

                                    </div>

                                </div>

                                <div class=col-md-7>
                                    <div class="table-responsive">
                                        <h4 style="text-align: center;">Route Table of Selected Module</h4>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    {{-- <th>Module Name</th> --}}
                                                    <th>Route</th>
                                                </tr>
                                            </thead>
                                            <tbody id="routeTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </form>
                

<script>
    $(document).ready(function () {
        $("#module").change(function () {
            var module_id = this.value;
            //alert(status);
            $("#routeTableBody").html("");
            var counter = 1;
            var routeTableBody = "";

            $.ajax({
                type: 'get',
                url: './getRouteByPermissionModule/' + module_id,
                success: function (data) {
                    //console.table(data);
                    for (var i = 0; i < data.length; i++) {
                        //console.log(data);
                        //console.log(data[i].created_by);
                        routeTableBody += '<tr>';
                        routeTableBody += '<td>' + counter +
                            '</td>';
                        routeTableBody += '<td>' +
                            data[i].route + '</td>';
                        routeTableBody += '</tr>';
                        counter++;

                    }
                    // console.log(routeTableBody);
                    $("#routeTableBody").append(routeTableBody);
                }
            });


        });
    });

    function roleModuleAssign() {

        event.preventDefault();


        $.ajax({
            type: 'post',
            url: './PermissionModuleRoleAssignInsertAjax',
            
            data: $("#roleModuleAssignForm").serialize(),
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {
                    // the variable is defined
                    //console.log(data.errors);
                     alertify.error( data.errors.module_id + ' ' + data.errors.role_id);
                }else {
                    clearForm();
                    $("#routeTableBody").html("");
                     alertify.success('Success');
                                 setTimeout(function () {
                                 location.reload(true);
                                 }, 1000);
                }

            }
        });
    }

    function clearForm() {
        $('#roleModuleAssignForm').trigger("reset");
         $("#routeTableBody").empty();
    }

</script>


@endsection
