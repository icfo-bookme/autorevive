@extends('layouts.backend.master')
@section('content')


{{-- <div class="row match-height">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-form-center">Role Create</h4>
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
                        <p>Create Role</p>
                    </div> --}}

                    <form class="form" id="roleInsertForm" method="post">
                         {{-- @csrf --}}
                        
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="eventInput1">Role Name</label>
                                        <input type="text" id="eventInput1" class="form-control" placeholder="Role Name" name="name">
                                                                         
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="form-actions center">
                            
                            <button type="submit" class="btn btn-primary"  >
                                <i class="icon-check2"></i> Save
                            </button>
                           <button type='reset' class="btn btn-danger">Clear</button>
                        </div>
                    </form>	

                {{-- </div>
            </div>
        </div>
    </div>
</div> --}}


<script>

$(document).ready(function(){
 
    $("#roleInsertForm").submit(function(){
        event.preventDefault();
        var formData = $("#roleInsertForm").serialize();

       
       
        $.ajax({
            type: 'post',
            url: './roleInsert',
            data:formData+"&_token={{ csrf_token() }}",
            dataType: 'json',
           
            success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                      console.log(data);

                       alertify.alert('something went wrong!',data.errors.name, function(){ alertify.success('Ok'); });
                    }else{
                         alertify.success('Successfully created!');
                        $("#roleInsertForm").trigger("reset");
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
