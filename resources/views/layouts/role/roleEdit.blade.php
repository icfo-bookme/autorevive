@extends('layouts.backend.master')
@section('content')
<div class="row match-height">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-form-center">Role Edit Option</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">

                    <div class="card-text">
                        <p>Change Role Name</p>
                    </div>

                    <form class="form" id="roleInsertForm" method="post">
                         @csrf
                        
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-body">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="roleId"  type="text" value="{{ $role->id }}">
                                        <label for="eventInput1">Role Name</label>
                                        <input type="text" id="eventInput1" class="form-control" placeholder="Role Name" name="name" value='{{ $role->name }}'>
                                                                         
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="form-actions center">
                            
                            <button type="submit" class="btn btn-primary"  >
                                <i class="icon-check2"></i> Save
                            </button>
                            <a href="{{  url('/roles-view')}}" type="button" class="btn btn-danger mr-1">
                                <i class="icon-cross2"></i> Cancel || Back
                            </a>
                        </div>
                    </form>	

                </div>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function(){
 
    $("#roleInsertForm").submit(function(){
        event.preventDefault();
        var role_id = $("#roleId").val();
        var formData = $("#roleInsertForm").serialize();

       
       
        $.ajax({
            type: 'post',
            url: '../updateRole',
            data:formData+"&_token={{ csrf_token() }}"+"&roleId="+role_id,
            dataType: 'json',
           
            success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        // the variable is defined

                        //alert(data.errors.name);
                        swal({
                        title: data.errors.name,
                        text: "Enter The Value",
                        type:"warning"
                        });
                    }

                    else{
                        //alert(data);
                        swal(data,"Data Saved!", "success")
                        $('#role-update-modal').modal('hide');
                        document.getElementById("roleInsertForm").reset();
                         location.reload(true);
                    }
            },
            error: function (data) {
                if (data == 'Error') {
                    alert('error');
                }

            }

        });
    });
});
</script>
@endsection
