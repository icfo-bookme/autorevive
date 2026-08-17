@extends('layouts.backend.master')
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Items View</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="itemTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Brand</th>
                                    <th>Barcode</th>
                                    <th>Length</th>
                                    <th>Height</th>
                                    <th>Width</th>
                                    <th>Regular price</th>
                                    <th>Minimum price</th>
                                    <th>Thumbnail</th>
                                    <th>Sales Type</th>
                                    <th>Publish/Pending</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- @dd($roles) --}}
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ isset($item->category->name) ? $item->category->name : '' }}
                                        </td>
                                        <td>{{ $item->sub_category->name }}</td>
                                        <td>{{ $item->brand->name }}</td>
                                        <td>{{ $item->barcode }}</td>
                                        <td>{{ $item->length }}</td>
                                        <td>{{ $item->height }}</td>
                                        <td>{{ $item->width }}</td>
                                        <td>{{ $item->regular_price }}</td>
                                        <td>{{ $item->sales_price }}</td>
                                        <td>
                                            <img src="{{ asset($item->thumbnail) }}" class="img-thumbnail">
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $item->sales_type }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->is_published == 1)
                                                <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_by }}</td>
                                        <td>{{ $item->updated_by }}</td>
                                        <td>
                                            <button class="btn btn-info btn-xs"
                                                onclick="window.open(`{{ url('itemImageInfo', $item->id) }}`)">
                                                <i class="fa fa-info-circle"></i>
                                            </button>

                                            <button class="btn btn-primary btn-xs" onclick="itemEdit({{ $item->id }})">
                                                <i class="fa fa-pencil"></i>
                                            </button>

                                            <button class="btn btn-danger btn-xs"
                                                onclick="itemDelete({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
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


    {{-- Role Update Module --}}
    <div class="modal fade" id="roleEditModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content border-info">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white">Role Update</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="roleUpdateForm">
                        {{-- <h4 class="form-header text-uppercase text-center">
                                <i class="fa fa-user-circle-o"></i>
                                Role Insert
                            </h4> --}}
                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Role Name</label>
                            <div class="col-sm-10">
                                <input type="hidden" id="roleId" name="id" value="">
                                <input type="text" class="form-control" id="roleName" name="roleName" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-info"><i class="fa fa-check-square-o"></i> Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Item Update Modal --}}
    <div class="modal fade" id="largesizemodal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ID="dismiss" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="itemUpdateForm">
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                            Item Update
                        </h4>

                        <div class="form-group row">
                            <input type="hidden" id="itemId" name="id">
                            <div class="col-sm-6">
                                <label for="input-1" class="col-sm-6 col-form-label">Category</label>
                                <select class="form-control form-control-sm" name="category_id" id="category_id"
                                    onchange="getSubCategory()">
                                    <option disabled selected value="">---select---</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label for="input-1" class="col-sm-6 col-form-label">Subategory</label>
                                <select class="form-control form-control-sm" name="subcategory_id" id="subcategory_id">
                                    <option disabled selected value="">---select---</option>
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Brands</label>
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
                            <label for="input-1" class="col-sm-2 col-form-label">Item Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="item name"
                                    required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Car Company</label>
                            <div class="col-sm-10">
                                <select name="company" id="car_company" class="form-control">
                                    <option value="">Select car company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->car_company }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Car Brand</label>
                            <div class="col-sm-10">
                                <select name="brand" id="car_brand" class="form-control">
                                    <option value="">Select car brand</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Car Model</label>
                            <div class="col-sm-10">
                                <select name="model_pivot[]" id="car_model_multiple" class="form-control" multiple>
                                    <option value="">Select car model</option>
                                </select>
                            </div>
                        </div>



                        {{-- <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Model</label>
                            <div class="col-sm-10">
                                <select name="model_pivot[]" id="car_model_multiple" class="form-control" multiple>
                                    <option value="">Select model</option>
                                    @foreach ($carModels as $model)

                                        <option value="{{ $model->id }}">{{ $model->car_model }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Model</label>
                        <div class="col-sm-10">
                            <select name="model" id="car_model" class="form-control" >
                                <option value="">Select model</option>
                                @foreach ($carModels as $model)
                                <option value="{{ $model->id }}">{{ $model->car_model }}</option>
                              @endforeach
                            </select>
                        </div>
                    </div> --}}




                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Barcode</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="barcode" name="barcode" placeholder="barcode"
                                    required readOnly>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Length</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="length" name="length" placeholder="length">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Height</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="height" name="height" placeholder="height">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Width</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="width" name="width" placeholder="width">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Minimum Order Quantity</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" class="form-control" name="minimum_order_quantity"
                                    id="minimum_order_quantity" placeholder="minimum order quantity" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Regular Price</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" class="form-control" id="regular_price"
                                    name="regular_price" placeholder="regular price" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Minimum Price</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" class="form-control" id="sales_price"
                                    name="sales_price" placeholder="Sales price" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Thumbnail</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="thumbnail" accept="image/*" id="thumbnail"
                                    onchange="imageValidateAndPreview(this,'thumbnail')">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Item Details</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="details" rows="3" placeholder="item details"
                                    name="details"></textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Sales Type</label>
                            <div class="col-sm-10">

                                <select class="form-control form-control-sm" id="sales_type" name="sales_type">
                                    <option disabled selected value="">---select---</option>
                                    <option value="asUsual">As Usual</option>
                                    <option value="featured">Featured</option>
                                    <option value="special">Special Offer</option>
                                    <option value="onsale">On sale</option>
                                    <option value="bestrated">Best Rated</option>
                                    <option value="dealOfTheWeek">Deal of the week</option>

                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Section</label>
                            <div class="col-sm-10">

                                <select class="form-control form-control-sm" id="section_id" name="section">
                                    <option disabled selected value="">---select---</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Publish Status</label>
                            <div class="col-sm-10">

                                <select class="form-control form-control-sm" name="is_published" id="is_published">
                                    <option disabled selected value="">---select---</option>
                                    <option value="1">Publish</option>
                                    <option value="0">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input-1" class="col-sm-12 col-form-label">Add Specificatons</label>
                            <hr>
                            <div class="col-sm-12">

                                <table class="table table-sm">
                                    <tbody id="specification_container">
                                        {{-- <tr>
                                        <td>
                                            <input type="text" class="form-control spec_name" name="spec_name[]" placeholder="specification name" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control spec_details" name="spec_details[]" placeholder="specification details" required>
                                        </td>
                                        <td>
                                           <button class="btn btn-danger" onclick="deleteSpecification()">X</button>
                                        </td>
                                    </tr> --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">

                                <button type="button" class="btn btn-primary" id="add-row" onclick="addSpecification()">
                                    <div class="fonticon-wrap">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </button>

                                {{-- <button type="button" class="btn btn-danger" id="delete-row" onclick="deleteSpecification()">
                                <div class="fonticon-wrap">
                                    <i class="icon-minus"></i>
                                </div>
                            </button> --}}

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Add Tags</label>
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

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                    <button type="button" class="btn btn-dark" onclick="clearForm()"><i class="fa fa-times"></i>
                        Cancel</button>

                    </form>
                </div>

            </div>
        </div>
    </div>



    <script>
        let tagList = [];
        let tagCount = 0;
        $(document).ready(function() {

            var table = $('#itemTable').DataTable({
                lengthChange: false,
                stateSave: true,
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });

            table.buttons().container()
                .appendTo('#itemTable_wrapper .col-md-6:eq(0)');

            //Disable form submit by enter
            $('#itemUpdateForm').keypress(
            function(event){
                if (event.which == '13') {
                event.preventDefault();
                }
            });


            $('#itemUpdateForm').submit(function() {
                event.preventDefault();

                alertify.confirm("Are You Sure To Update This?",
                    function() {
                        $("#subcategory_id").prop("disabled", false);
                        let multipleSelect = $('#car_model_multiple').val();
                        var formData = new FormData($('#itemUpdateForm')[0]);
                        console.log(tagList);
                        formData.append('tags', tagList);
                        formData.append('model_pivot', multipleSelect);
                        $.ajax({
                            type: 'post',
                            url: '{{ url('itemUpdateAjax') }}',
                            data: formData,
                            dataType: 'json',
                            enctype: 'multipart/form-data',
                            processData: false,
                            cache: false,
                            contentType: false,
                            timeout: 600000,
                            success: function(data) {
                                console.log(data);
                                if (typeof data.errors !== 'undefined') {
                                    $.each(data.errors, (key, val) => {
                                        alertify.error(
                                            `<span class="text-white">${val[0]}</span>`
                                        );
                                    });

                                } else {
                                    alertify.success(data);
                                    clearForm();
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000)

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

                    },
                    function() {
                        alertify.error('Cancel');
                    }).setHeader('<em> CONFIRM </em> ');
            });


        });



        function itemEdit(id) {
            $.ajax({
                type: 'post',
                url: '{{ URL('getItemInfoAjax') }}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {

                    console.log(data);
                    if (typeof data.errors !== 'undefined') {
                        alertify.warning("Something went wrong");
                    } else {
                        $('#largesizemodal').modal('show');

                        $("#itemUpdateForm")[0].reset();
                        $('#itemId').val(data.id);
                        $('#subcategory_id').val(data.sub_category_id);
                        $('#category_id').val(data.category_id);
                        $('#brand_id').val(data.brand_id);

                        $('#car_company').val(data.car_company_id);
                        $('#car_brand').val(data.car_brand_id);
                        $('#car_model_multiple').select2();

                        if (data.car_company_id != null) {
                            if (data.car_company_id.toString().length > 0) {
                                showBrandsForCompany(data.car_company_id, data.car_brand_id);
                            }
                        }


                        if (data.car_brand_id != null) {
                            if (data.car_brand_id.toString().length > 0) {
                                const carModels = [];
                                data.check_model.forEach(element => {
                                    carModels.push(element.car_model_id);
                                });

                                if (carModels.length === 0) {
                                    console.log("No model");
                                    $('#car_model_multiple').html(`<option value=""> SELECT Model</option>`);
                                } else {
                                    console.log("Yes model");
                                    showModelsForBrand(data.car_brand_id, carModels);
                                }

                            }else{
                                $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
                                $('#car_model_multiple').html(`<option value=""> SELECT Model</option>`);

                            }
                        } else {
                            $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
                            $('#car_model_multiple').html(`<option value=""> SELECT Model</option>`);
                        }


                        $('#car_model').val(data.car_model_id);
                        $('#name').val(data.name);
                        $('#barcode').val(data.barcode);
                        $('#length').val(data.length);
                        $('#height').val(data.height);
                        $('#width').val(data.width);
                        $('#minimum_order_quantity').val(data.minimum_order_quantity)
                        $('#regular_price').val(data.regular_price);
                        $('#sales_type').val(data.sales_type);
                        $('#details').summernote('code', data.details);
                        $('#section_id').val(data.section_id);
                        $('#sales_price').val(data.sales_price);
                        $('#is_published').val(data.is_published);
                        const carModels = [];
                        // data.check_model.forEach(element => {
                        //     carModels.push(element.car_model_id);
                        // });
                        // $('#car_model_multiple').select2();
                        $('#car_model_multiple').val(carModels).trigger('change');


                        tagList = [];

                        $('#tags_container').html('');

                        data.tags.map(tag => {
                            $('#tags_container').append(
                                `<span id="tag_${tag.id}" class="badge badge-primary p-2 mx-1"
                        style="border-radius: 25px;cursor: pointer;">${tag.tag_text} <i class="fa fa-close" style="cursor: pointer" onclick="removeTag(${tag.id})"></i></span>`
                            );

                            tagList.push(tag.tag_text);
                        });

                        if (data.item_specification) {
                            $('#specification_container').empty();
                            data.item_specification.map(itemSpec => {

                                $('#specification_container').append(`<tr>
                                <td>
                                    <input type="text" class="form-control spec_name" name="spec_name[]"
                                        placeholder="specification name" required value="${itemSpec.name}">
                                </td>
                                <td>
                                    <input type="text" class="form-control spec_details" name="spec_details[]"
                                        placeholder="specification details" required value="${itemSpec.details}">
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteSpecification()">X</button>
                                </td>
                            </tr>`);
                            });
                        }

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


        /**
         * @name itemDelete
         * @role send ajax request to delete a role
         * @param role id
         * @return json response
         *
         */
        function itemDelete(id) {
            alertify.confirm("Are You Sure To Delete This?",
                function() {
                    $.ajax({
                        type: 'post',
                        url: './itemDeleteAjax',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (typeof data.errors !== 'undefined') {

                                alertify.warning('Something Went Wrong');
                            } else {
                                //alert(data);
                                alertify.success(data);
                                setTimeout(function() {
                                    location.reload(true);
                                }, 1000)

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

                },
                function() {
                    alertify.error('Canceled');
                }).setHeader('<em> CONFIRM </em> ');

        }



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
                    if (typeof data.errors !== 'undefined') {
                        alertify.warning(data.errors.name);
                    } else {
                        var html = "";

                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }

                        html += '<option disabled selected value="">---select---</option>';

                        $('#subcategory_id').empty();
                        $('#subcategory_id').append(html);
                        $("#subcategory_id").prop("disabled", false);
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


        function clearForm() {
            $('#subcategory_id').val('');
            $("#category_id").val('');
            $('#brand_id').val('');
            $('#itemUpdateForm').trigger("reset");
            $('#largesizemodal').modal('hide');
        }

        /*
            ----------------------------
                Item search dropdowns
            ----------------------------
        */
        $('#car_company').change(function() {
            let company_id = $('#car_company').val();

            if (company_id.length <= 0) {
                $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
            } else {
                $.ajax({
                    url: '{{ URL('getBrandByCompanyIdAjax') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: company_id
                    },
                    success: data => {
                        $('#car_model_multiple').html(`<option value=""> SELECT Model</option>`);

                        $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
                        if (Object.keys(data).length > 0) {
                            $.each(data, (key, val) => {
                                $('#car_brand').append(
                                    `<option value="${val.id}">${val.car_brand}</option>`);
                            });
                        } else {
                            $('#car_brand').html(
                                `<option value="">No option for this company</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });


        function showBrandsForCompany(company_id, brand_id) {
            $.ajax({
                url: '{{ URL('getBrandByCompanyIdAjax') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: company_id
                },
                success: data => {
                    $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
                    if (Object.keys(data).length > 0) {
                        $.each(data, (key, val) => {
                            if (val.id == brand_id) {
                                $('#car_brand').append(
                                    `<option value="${val.id}" selected>${val.car_brand}</option>`);
                            } else {
                                $('#car_brand').append(
                                    `<option value="${val.id}" >${val.car_brand}</option>`);
                            }
                        });
                    } else {
                        $('#car_brand').html(
                            `<option value="">No option for this company</option>`);
                    }
                },
                error: err => {
                    console.error(err);
                }
            });
        }


        $('#car_brand').change(function() {
            let brand_id = $('#car_brand').val();

            if (brand_id.length <= 0) {
                $('#car_model_multiple').html(`<option value=""> SELECT Model</option>`);

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
                            $('#car_model_multiple').html(`<option value="">Select model</option>`);
                            $.each(data, (key, val) => {
                                $('#car_model_multiple').append(
                                    `<option value="${val.id}">${val.car_model}</option>`);
                            });
                        } else {
                            $('#car_model_multiple').html(
                                `<option value="">No option for this brand</option>`);
                        }
                    },
                    error: err => {
                        console.error(err);
                    }
                });
            }
        });

        function showModelsForBrand(brand_id, carModels) {
            console.log("Car models are " + carModels);
            $.ajax({
                url: '{{ URL('getModelByBrandIdAjax') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: brand_id
                },
                success: data => {
                    if (Object.keys(data).length > 0) {
                        $('#car_model_multiple').html(`<option value="">Select model</option>`);
                        $.each(data, (key, val) => {
                            console.log("Car model id = " + val.id);
                            if (carModels.includes(val.id)) {
                                console.log("Includes");
                                $('#car_model_multiple').append(
                                    `<option value="${val.id}" selected>${val.car_model}</option>`);
                            } else {
                                $('#car_model_multiple').append(
                                    `<option value="${val.id}">${val.car_model}</option>`);
                            }

                        });
                    } else {
                        $('#car_model_multiple').html(
                            `<option value="">No option for this brand</option>`);
                    }

                    // $('#car_model_multiple').val(carModels).trigger('change');
                },
                error: err => {
                    console.error(err);
                }
            });
        }


        function addSpecification() {
            let markup = `<tr>
                        <td>
                            <input type="text" class="form-control spec_name" name="spec_name[]" placeholder="specification name" required>
                        </td>
                        <td>
                            <input type="text" class="form-control spec_details" name="spec_details[]" placeholder="specification details" required>
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteSpecification()">X</button>
                        </td>
                    </tr>`;

            $("#specification_container").append(markup);
        }

        function deleteSpecification() {
            // if ($("#specification_container tr").length != 1) {
            //     $("#specification_container tr:last").remove();
            // }
            var td = event.target.parentNode;
            var tr = td.parentNode;
            tr.parentNode.removeChild(tr);
        }


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
                                    onclick="removeTag(${tagCount})"></i>
                                </span>`;
                    }

                })

                $('#tags_container').append(tagContainerDiv);
                $('#tags').val('');
            }
        });

        function removeTag(tag_id) {
            let tag_text = $('#tag_' + tag_id).text().trim();

            let index = tagList.indexOf(tag_text);

            if (index > -1) {
                tagList.splice(index, 1);
            }

            $('#tag_' + tag_id).remove();

            alertify.success("Tag successfully removed");
        }
    </script>

@endsection
