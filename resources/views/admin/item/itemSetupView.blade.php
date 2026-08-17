@extends('layouts.backend.master')
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <style>
        .must {
            color: red;
            font-size: 15px;
            font-weight: bold
        }

    </style>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <form id="itemInsertForm">
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                            Item Setup
                        </h4>

                        <div class="form-group row">

                            <div class="col-sm-6">

                                <label for="category" class="col-sm-6 col-form-label">Category<span
                                        class="must">*</span></label>
                                <select class="form-control form-control-sm" name="category_id" id="category_id"
                                    onchange="getSubCategory()">
                                    <option disabled selected value="">---select---</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-6">
                                <label for="subcategory" class="col-sm-6 col-form-label">Subcategory<span
                                        class="must">*</span></label>
                                <select class="form-control form-control-sm" name="subcategory_id" id="subcategory_id">
                                    <option disabled selected value="">---select---</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="brands" class="col-sm-2 col-form-label">Brands<span class="must">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control form-control-sm" name="brand_id" id="brand_id">
                                    <option disabled selected value="">---select---</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="item_name" class="col-sm-2 col-form-label">Item Name<span
                                    class="must">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="item name"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company" class="col-sm-2 col-form-label">Car Company</label>
                            <div class="col-sm-10">
                                <select name="company" id="car_company" class="form-control">
                                    <option disabled selected value="">Select car company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->car_company }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="car_brand" class="col-sm-2 col-form-label">Car Brand</label>
                            <div class="col-sm-10">
                                <select name="brand" id="car_brand" class="form-control">
                                    <option value="">Select car brand</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                        <label for="car_model" class="col-sm-2 col-form-label">Model</label>
                        <div class="col-sm-10">
                            <select name="model" id="car_model" class="form-control">
                                <option value="">Select car model</option>

                            </select>
                        </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="car_model" class="col-sm-2 col-form-label">Car Model</label>
                            <div class="col-sm-10">
                                <select name="model_pivot[]" id="car_model_pivot" class="form-control" multiple>
                                    <option value="">Select car model</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="width" class="col-sm-2 col-form-label">Width</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="width" name="width" placeholder="width">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="length" class="col-sm-2 col-form-label">Length</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="length" name="length" placeholder="length">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="height" class="col-sm-2 col-form-label">Height</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="height" name="height" placeholder="height">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="quantity" class="col-sm-2 col-form-label">Minimum Order Quantity</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" class="form-control" id="quantity"
                                    name="minimum_order_quantity" value="1" placeholder="minimum order quantity" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="regular_price" class="col-sm-2 col-form-label">Regular Price</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" class="form-control" id="regular_price"
                                    name="regular_price" value="0" placeholder="regular price" required>
                            </div>
                        </div>

                        {{-- sales price is the offer price --}}
                        <div class="form-group row">
                            <label for="sales_price" class="col-sm-2 col-form-label">Offer Price</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" value="0" class="form-control" id="sales_price"
                                    name="sales_price" placeholder="Sales price" required>
                            </div>
                        </div>

                        {{-- this minimum price is just a record for admins --}}
                        <div class="form-group row">
                            <label for="minimum_price" class="col-sm-2 col-form-label">Minimum Price</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" value="0" class="form-control" id="minimum_price"
                                    name="minimum_price" placeholder="Minimum price" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="thumbnail" class="col-sm-2 col-form-label">Thumbnail<span
                                    class="must">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*"
                                    id="thumbnail" onchange="imageValidateAndPreview(this,'thumbnail')" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="details" class="col-sm-2 col-form-label">Item Details<span
                                    class="must">*</span></label>
                            <div class="col-sm-10">
                                {{-- <textarea class="form-control" id="details" rows="3" placeholder="item details"name="details"></textarea> --}}
                                <textarea class="form-control" id="details" rows="3" placeholder="item details"
                                    name="details"></textarea>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="sales_type" class="col-sm-2 col-form-label">Sales Type</label>
                            <div class="col-sm-10">

                                <select class="form-control form-control-sm" name="sales_type">
                                    <option disabled value="">---select---</option>
                                    <option selected value="asUsual">As Usual</option>
                                    <option value="featured">Featured</option>
                                    <option value="special">Special Offer</option>
                                    <option value="onsale">On sale</option>
                                    <option value="bestrated">Best Rated</option>
                                    <option value="dealOfTheWeek">Deal of the week</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="section" class="col-sm-2 col-form-label">Section</label>
                            <div class="col-sm-10">

                                <select class="form-control form-control-sm" name="section">
                                    <option disabled value="">---select---</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" @if ($section->name == 'Shop') selected @endif>{{ $section->name }} </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="publish_status" class="col-sm-2 col-form-label">Publish Status<span
                                    class="must">*</span></label>
                            <div class="col-sm-10">

                                <select class="form-control form-control-sm" name="is_published">
                                    <option disabled selected value="">---select---</option>
                                    <option value="1">Publish</option>
                                    <option value="0">Pending</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="specification" class="col-sm-12 col-form-label">Add Specificatons</label>
                            <hr>
                            <div class="col-sm-12">

                                <table class="table table-sm">
                                    <tbody id="specification_container">
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control spec_name" name="spec_name[]"
                                                    placeholder="specification name">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control spec_details" name="spec_details[]"
                                                    placeholder="specification details">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">

                                <button type="button" class="btn btn-primary" id="add-specification" onclick="addSpecification()">
                                    <div class="fonticon-wrap">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </button>

                                <button type="button" class="btn btn-danger" id="delete-specification"
                                    onclick="deleteSpecification()">
                                    <div class="fonticon-wrap">
                                        <i class="icon-minus"></i>
                                    </div>
                                </button>

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="image" class="col-sm-12 col-form-label">Add Image</label>
                            <hr>
                            <div class="col-sm-12">

                                <table class="table table-sm">
                                    <tbody id="image_container">
                                        <tr>
                                            <td>
                                                <input type="file" class="form-control" name="image[]"
                                                    onchange="imageValidateAndPreview(this,'image0')" id="image0"
                                                    accept="image/*">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">

                                <button type="button" class="btn btn-primary" id="add-row" onclick="addRow()">
                                    <div class="fonticon-wrap">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </button>

                                <button type="button" class="btn btn-danger" id="delete-row" onclick="deleteRow()">
                                    <div class="fonticon-wrap">
                                        <i class="icon-minus"></i>
                                    </div>
                                </button>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tag" class="col-sm-2 col-form-label">Add Tags</label>
                            <div class="col-sm-10">
                                <input type="text" step="any" min="0" class="form-control" id="tags"
                                    placeholder="Insert Tags (Press Space key to add tag)">
                            </div>


                        </div>
                        <div class="card">
                            <div class="card-body" id="tags_container">
                                {{-- tags go in here --}}
                            </div>
                        </div>



                        <div class="form-footer text-center">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                    class="fa fa-times"></i>Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>






    <script>
        var counter = 1;
        let tagList = [];
        let tagCount = 0;

        $(document).ready(function() {

            $('#details').summernote();
            $('#car_model_pivot').select2();

            //Disabled form-submit by enter
            $('#itemInsertForm').keypress(
            function(event){
                if (event.which == '13') {
                event.preventDefault();
                }
            });


            $('#itemInsertForm').submit(function() {
                event.preventDefault();
                alertify.confirm("Are You Sure To Submit This?",
                    function() {
                        let multipleSelect = $('#car_model_pivot').val();
                        var formData = new FormData($('#itemInsertForm')[0]);

                        formData.append('tags', tagList);
                        formData.append('model_pivot', multipleSelect);
                        let regularPrice = $('#regular_price').val();
                        let offerPrice   = $('#sales_price').val();
                        console.log(regularPrice,offerPrice);
                        if(regularPrice < offerPrice) {
                            alertify.alert("Offer price can not be greater than regular price!");
                        } else {
                            $.ajax({
                            type: 'post',
                            url: './itemInsertAjax',
                            data: formData,
                            dataType: 'json',
                            enctype: 'multipart/form-data',
                            processData: false,
                            cache: false,
                            contentType: false,
                            timeout: 600000,
                            success: function(data) {

                                if (typeof data.errors !== 'undefined') {
                                    $.each(data.errors, function(propName, propVal) {
                                        alertify.error(propVal[0]);
                                    });
                                } else {
                                    alertify.success(data);
                                    clearForm();
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);

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
                        }

                    },
                    function() {
                        alertify.error('Cancel');
                    }).setHeader('<em> CONFIRM </em> ');
            });

            /**
             * @role add tag in the `tagList` array and in #tags_container
             */


            $('#tags').on('keyup', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                if (e.key === 'Enter' || e.keyCode === 13 ) {
                    let tag = $('#tags').val().trim().toLowerCase();
                    let tags = tag.split(" ");
                    let tagContainerDiv = "";

                    $.each(tags, function(index, value) {
                        if (value.length > 1 && tagList.includes(value) === false) {
                            tagList.push(value);
                            tagContainerDiv += `<span id="tag_${++tagCount}"
                                    class="badge badge-primary m-1 py-2 px-2"
                                    style="border-radius: 25px;cursor: pointer;">${value} <i class="fa fa-close"
                                    style="cursor: pointer;"
                                    onclick="removeTag('tag_${tagCount}')"></i>
                                </span>`;
                        }

                    })
                    console.log(tagList);

                    $('#tags_container').append(tagContainerDiv);
                    $('#tags').val('');
                }
            });

        });


        function removeTag(tag_id) {
            let tag_text = $('#' + tag_id).text().trim();
            console.log(tagList.indexOf(String(tag_text)));
            tagList.splice(tagList.indexOf(tag_text), 1);
            $('#' + tag_id).remove();
            console.log(tagList);
        }


        function clearForm() {
            $("#category_id").val('');
            $("#subcategory_id").prop("disabled", true);
            $('#brand_id').val('');
            $('#itemInsertForm').trigger("reset");
            
        }



        // function generateBarcode(categoryId) {
        //     $.ajax({
        //         type: 'post',
        //         url: '{{ url('generateBarcode') }}',
        //         data: {
        //             categoryId: categoryId
        //         },
        //         dataType: 'json',
        //         success: function(response) {
        //             if (response.status === true) {
        //                 $('#input_barcode').val(response.data);
        //             } else {
        //                 alertify.error(response.message);
        //             }
        //         },

        //         error: function(jqXHR, exception) {
        //             var msg = '';
        //             if (jqXHR.status === 0) {
        //                 msg = 'Not connect.Verify Network.';
        //                 alertify.warning(msg);

        //             } else if (jqXHR.status == 404) {
        //                 msg = 'Requested page not found. [404]';
        //                 alertify.warning(msg);
        //             } else if (jqXHR.status == 500) {
        //                 msg = 'Internal Server Error [500].';
        //                 alertify.warning(msg);
        //             } else if (exception === 'parsererror') {
        //                 msg = 'Requested JSON parse failed.';
        //                 alertify.warning(msg);
        //             } else if (exception === 'timeout') {
        //                 msg = 'Time out error.';
        //                 alertify.warning(msg);
        //             } else if (exception === 'abort') {
        //                 msg = 'Ajax request aborted.';
        //                 alertify.warning(msg);
        //             } else {
        //                 msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //                 alertify.warning(msg);
        //             }
        //         }
        //     });
        // }


        function getSubCategory() {
            var id = $('#category_id').val();

            $.ajax({
                type: 'post',
                url: '{{ url('getSubcategoryBycategoryAjax') }}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (typeof data.errors !== 'undefined') {
                        alertify.warning(data.errors.name);
                    } else {
                        var html = "";
                        html += '<option disabled selected value="">---select---</option>';
                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }

                        $('#subcategory_id').empty();
                        $('#subcategory_id').append(html);
                        $("#subcategory_id").prop("disabled", false);

                        // generateBarcode(id);
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
        }






        function addRow() {
            id = 'image' + counter;

            var markup = "";
            markup += "<tr>";
            markup += "<td>";
            markup += "<input type='file' class='form-control' name='image[]' onchange='imageValidateAndPreview(this," +
                id + ")' id='" + id + "' accept='image/*'>";
            markup += "</td>";
            markup += "</tr>";
            $("#image_container").append(markup);
            counter++;
        }

        function deleteRow() {
            if ($("#image_container tr").length != 1) {
                $("#image_container tr:last").remove();
            }
        }


        function addSpecification() {
            let markup = `<tr>
                        <td>
                            <input type="text" class="form-control spec_name" name="spec_name[]" placeholder="specification name">
                        </td>
                        <td>
                            <input type="text" class="form-control spec_details" name="spec_details[]" placeholder="specification details">
                        </td>
                    </tr>`;

            $("#specification_container").append(markup);
        }

        function deleteSpecification() {
            if ($("#specification_container tr").length != 1) {
                $("#specification_container tr:last").remove();
            }
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
                    reader.onload = function(e) {};
                    reader.readAsDataURL(data.files[0]);
                }
            }
        }


        /*
            ----------------------------
                Item search dropdowns
            ----------------------------
        */
        $('#car_company').change(function() {
            let company_id = $('#car_company').val();

            if (company_id.length <= 0) {
                $('#car_brand').html(`<option value=""> SELECT CAR BRAND </option>`);
            } else {
                $.ajax({
                    url: '{{ URL('getBrandByCompanyIdAjax') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: company_id
                    },
                    success: data => {
                        $('#car_brand').html(`<option  disabled selected value="">Select car brand</option>`);
                        if (Object.keys(data).length > 0) {
                            $.each(data, (key, val) => {
                                $('#car_brand').append(
                                    `<option value="${val.id}">${val.car_brand}</option>`);
                            });
                        } else {
                            $('#car_brand').html(
                                `<option value="">No option for this company</option>`);
                            // $('#car_brand').html(
                            //     `<option value="miscellaneous">Miscellaneous</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });

        $('#car_brand').change(function() {
            let brand_id = $('#car_brand').val();

            if (brand_id.length <= 0) {
                $('#car_model').html(`<option value=""> SELECT Car Model</option>`);

            } else {
                $.ajax({
                    url: '{{ URL('getModelByBrandIdAjax') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: brand_id
                    },
                    success: data => {
                        if (Object.keys(data).length > 0) {
                            $('#car_model').html(`<option value="">Select car model</option>`);
                            $.each(data, (key, val) => {
                                $('#car_model').append(
                                    `<option value="${val.id}">${val.car_model}</option>`);
                            });
                        } else {
                            $('#car_model').html(`<option value="">No option for this brand</option>`);
                            // $('#car_model').html(`<option value="miscellaneous">Miscellaneous</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });



        //TEST MULTISELECT DROPDOWN
        $('#car_brand').change(function() {
            let brand_id = $('#car_brand').val();

            if (brand_id.length <= 0) {
                $('#car_model_pivot').html(`<option value=""> SELECT Car Model</option>`);

            } else {
                $.ajax({
                    url: '{{ URL('getModelByBrandIdAjax') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: brand_id
                    },
                    success: data => {
                        if (Object.keys(data).length > 0) {
                            $('#car_model_pivot').html(`<option disabled value="">Select car model</option>`);
                            $.each(data, (key, val) => {
                                $('#car_model_pivot').append(
                                    `<option value="${val.id}">${val.car_model}</option>`);
                            });
                        } else {
                            $('#car_model_pivot').html(
                                `<option value="">No option for this brand</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });
    </script>

@endsection
