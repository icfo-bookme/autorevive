@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Fund Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="introduction-box mx-auto">
                        <h5 class="text-center">Automart</h5>
                        <p class="text-center">Fund Report</p>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="">From</label>
                                <input type="date" class="form-control" id="fromDate">
                            </div>

                            <div class="col-sm-2">
                                <label for="">To</label>
                                <input type="date" class="form-control" id="toDate">
                            </div>
                            <div class="col-sm-2">
                                <label for="">Fund Category</label>
                                <select class="form-control" id="fund_cat_id" onchange="getFundSubCategories()">
                                    <option selected value="null">Select</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <label for="">Fund SubCategory</label>
                                <select class="form-control" id="fund_subcat_id">
                                    <option selected value="null">Select</option>
                                </select>
                            </div>

                            <div class="col-sm-2" style="margin-top: 1.8rem!important;">
                                <button class="btn btn-primary mr-2" onclick="ajaxCall();">Search</button>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive py-5">
                        <table class="table table-bordered" id="selectionForTest">
                            <thead class="text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="ajaxLoad">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- loader modal -->
<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src="{{ asset('assets/images/preloader.gif') }}"
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>


@endsection

<script>
    function ajaxCall() {
        var fromDate    = $('#fromDate').val();
        var toDate      = $('#toDate').val();
        var cat         = $("#fund_cat_id").val();
        var subCat      = $("#fund_subcat_id").val();
        console.log(fromDate,toDate, cat, subCat);

        $('#preloader').modal('show');
        $("#ajaxLoad").load("./fundReportAjax/" + fromDate + "/" + toDate  + "/" + cat + "/" + subCat, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $('#preloader').modal('hide');
            }
            else if(statusTxt == "error"){
                $('#preloader').modal('hide');
                alertify.error('Something went wrong');
            };
           
        });
    }


    function getFundSubCategories(){
        var id = $('#fund_cat_id').val();

        $.ajax({
            type: 'post',
            url: '{{ url('getFundSubcatBycatAjax')}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    var html = "";
                    html += '<option selected value="null">Select</option>';
                    for (var i = 0; i < response.data.length; i++) {
                        html += '<option value="' + response.data[i].id + '">' + response.data[i].name + '</option>';
                    }
                    $('#fund_subcat_id').empty();
                    $('#fund_subcat_id').append(html);
                    $("#fund_subcat_id").prop("disabled", false);
                    
                } else{
                    alertify.error("<span class='text-white'>"+response.message+"</span>");
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

</script>
