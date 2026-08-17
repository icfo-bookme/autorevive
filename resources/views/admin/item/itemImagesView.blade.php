@extends('layouts.backend.master')
@section('content')
    <div class="float-right mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#modal-image-insert">
            New Image
        </button>
    </div>


<div class="row">

    @foreach($itemImages as $image)
	   <div class="col-12 col-lg-4">
	    <div class="card">
		  <img src="{{asset($image->image_path)}}" class="card-img-top" alt="Card image cap">
			<div class="card-body">
				<h4 class="card-title">Item Name : {{$image->item->name}}</h4>
                <hr>
                
                <button class="btn badge badge-primary" onclick="editImage({{$image->id}})">
                    <i aria-hidden="true" class="fa fa-pencil-square-o"></i>
                </button>


                <button class="btn badge badge-danger" onclick="deleteImage({{$image->id}})">
                    <i aria-hidden="true" class="fa fa-trash"></i>
                </button>
			</div>
		</div>
	   </div>
       @endforeach
       

     </div><!--End Row-->






     <!-- modal body goes here -->
<div class="modal fade" id="modal-image-update" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Update Image</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="imageUpdateForm">
                   <div class="form-group">
                       <label for="input-1">Image</label>
                        <input type="hidden" id="itemId" name="item_id" value="{{$itemId}}">
                        <input type="hidden" id="itemImageId" name="item_image_id">
                       <input type="file" class="form-control" name="image" onchange="imageValidateAndPreview(this,'image0')" id="image0" accept="image/*">
                   </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" onclick="updateImage()" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>







<!-- modal body goes here -->
<div class="modal fade" id="modal-image-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Image</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="imageInsertForm">
                   <div class="form-group">
                       <label for="input-1">Image</label>
                        <input type="hidden" id="itemId" name="item_id" value="{{$itemId}}">
                       <input type="file" class="form-control" name="image" onchange="imageValidateAndPreview(this,'image0')" id="image0" accept="image/*">
                   </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" onclick="submitImage()" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>









 <script>


    function editImage(id){
       $('#itemImageId').val(id);
       $('#modal-image-update').modal('show');
    }


    function imageValidateAndPreview(data,id) {
            var id = $(data).attr('id');
            if (data.files && data.files[0]) {
                var reader = new FileReader();

                var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
                if ($.inArray($(data).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    alertify.warning("Only '.jpeg','.jpg', '.png', '.gif' formats are allowed.");

                    $('#'+id).val('');

                } else {
                    reader.onload = function(e) {
                };
                    reader.readAsDataURL(data.files[0]);
                }
            }
    }





    function deleteImage(id){
       alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("itemImageDeleteAjax")}}',
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






 function updateImage(id) {
        alertify.confirm("Are You Sure To Update This?",
        function () {

                var formData = new FormData($('#imageUpdateForm')[0]);
                $.ajax({
                    type: 'post',
                    url: '{{URL("itemImageUpdateAjax")}}',
                    data: formData,
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    timeout: 600000,
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            alertify.warning('Something Went Wrong');
                        } else {
                            $('#modal-image-update').modal('hide');
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




    function submitImage(){
         alertify.confirm("Are You Sure To Submit This?",
        function () {

                var formData = new FormData($('#imageInsertForm')[0]);
                $.ajax({
                    type: 'post',
                    url: '{{URL("itemImageInsertAjax")}}',
                    data: formData,
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    timeout: 600000,
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            alertify.warning('Something Went Wrong');
                        } else {
                            $('#modal-image-insert').modal('hide');
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

</script>
@endsection