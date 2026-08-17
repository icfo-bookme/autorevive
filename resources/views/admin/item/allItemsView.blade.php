@extends('layouts.backend.master')
@section('content')
    <style>

        .table td {
            padding: 5px ;
        }
        div.dataTables_wrapper div.dataTables_processing{
            background-color: transparent !important;
            z-index: 1 !important;
            box-shadow:none !important;
        }
        .processingColor{
            color: #7934f3;
        }

    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> All Items View</div>
                <div class="card-body">
                     <div class="row mb-3">
                    <div class="col-md-3">
                        <label><strong>Public Status Filter</strong></label>
                        <select id="publicFilter" class="form-control">
                            <option value="">All</option>
                            <option value="1">Publish</option>
                            <option value="0">Pending</option>
                        </select>
                    </div>


                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary mr-2" id="filterBtn">
                            <i class="fa fa-filter"></i> Filter
                        </button>

                        <button class="btn btn-secondary" id="resetBtn">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>

                    <div class="table-responsive">
                        <table id="itemTable" class="table table-bordered table-hover table-checkable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Brand</th>
                                {{-- <th>Barcode</th> --}}
                                <th>Length</th>
                                <th>Height</th>
                                <th>Width</th>
                                <th>Regular price</th>
                                <th>Offer price</th>
                                <th>Minimum price</th>
                                <th>Thumbnail</th>
                                <th>Sales Type</th>
                                <th>Publish/Pending</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
                                    <option disabled value="">Select car company</option>
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
                                    <option disabled value="">Select car model</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Barcode</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="barcode" name="barcode"
                                       placeholder="barcode"
                                       required readOnly>
                            </div>
                        </div> --}}

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
                                <input type="number" step="any" min="0" class="form-control"
                                       name="minimum_order_quantity"
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

                        {{-- sales price is the offer price --}}
                        <div class="form-group row">
                            <label for="input-1" class="col-sm-2 col-form-label">Offer Price</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" class="form-control" id="sales_price"
                                       name="sales_price" placeholder="Sales price" required>
                            </div>
                        </div>

                        {{-- this minimum price is just a record for admins --}}
                        <div class="form-group row">
                            <label for="minimum_price" class="col-sm-2 col-form-label">Minimum Price</label>
                            <div class="col-sm-10">
                                <input type="number" step="any" min="0" class="form-control" id="minimum_price"
                                       name="minimum_price" placeholder="Minimum price" required>
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
                        {{--                </div>--}}

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-dark" onclick="clearForm()"><i class="fa fa-times"></i>
                                Cancel
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    <script>
        let tagList = [];
        let tagCount = 0;

        $(document).ready(function () {
            const csrf_token = "{{ csrf_token() }}";
            // #### DATATABLE
            var dataTable = $('#itemTable').DataTable({
                responsive: true,
                lengthMenu: [5, 10, 25, 50, 100, 500],
                pageLength: 10,
                stateSave: true,
                language: {
                    'lengthMenu': 'Display _MENU_',
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw processingColor"></i>'
                },
                scrollY: 450,
                scrollX: true,
                scrollCollapse: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: route('listAllItems'),
                    data: function (data) {
                        data._token = csrf_token;
                        data.ispublic = $('#publicFilter').val();
                    },
                    type: 'post',
                },
                columns: [
                    {data: 'name', name: 'name', "orderable": true, "searchable": true, width: "10%"},
                    {
                        data: 'data_category_name',
                        name: 'category.name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_subcategory_name',
                        name: 'sub_category.name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_brand_name',
                        name: 'brand.name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    // {data: 'barcode', name: 'barcode', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'length', name: 'length', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'height', name: 'height', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'width', name: 'width', "orderable": true, "searchable": true, width: "10%"},
                    {
                        data: 'regular_price',
                        name: 'regular_price',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {data: 'sales_price', name: 'sales_price', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'minimum_price', name: 'minimum_price', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'data_image', name: 'thumbnail', "orderable": false, "searchable": false, width: "10%"},
                    {
                        data: 'data_sales_type',
                        name: 'data_sales_type',
                        "orderable": false,
                        "searchable": false,
                        width: "10%"
                    },
                    {
                        data: 'data_publication_status',
                        name: 'data_publication_status',
                        "orderable": false,
                        "searchable": false,
                        width: "10%"
                    },
                    {data: 'created_by', name: 'created_by', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'updated_by', name: 'updated_by', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'action', name: 'action', "orderable": false, searchable: false, width: "10%"},
                ],
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });

              $('#filterBtn').on('click', function () {
        dataTable.ajax.reload();
    });

    // RESET BUTTON
    $('#resetBtn').on('click', function () {
        $('#publicFilter').val('');
        dataTable.ajax.reload();
    });

            //Disable form submit by enter
            $('#itemUpdateForm').keypress(
                function (event) {
                    if (event.which == '13') {
                        event.preventDefault();
                    }
                });

            $('#itemUpdateForm').submit(function () {
                event.preventDefault();

                alertify.confirm("Are You Sure To Update This?",
                    function () {
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
                            success: function (data) {
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
                                    dataTable.ajax.reload(null, false);
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

        });

        function itemEdit(id) {
            $.ajax({
                type: 'post',
                url: '{{ URL('getItemInfoAjax') }}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {

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
                                    $('#car_model_multiple').html(`<option disabled value=""> SELECT Model</option>`);
                                } else {
                                    console.log("Yes model");
                                    showModelsForBrand(data.car_brand_id, carModels);
                                }

                            } else {
                                $('#car_brand').html(`<option disabled value=""> SELECT BRAND</option>`);
                                $('#car_model_multiple').html(`<option disabled value=""> SELECT Model</option>`);

                            }
                        } else {
                            $('#car_brand').html(`<option disabled value=""> SELECT BRAND</option>`);
                            $('#car_model_multiple').html(`<option disabled value=""> SELECT Model</option>`);
                        }


                        $('#car_model').val(data.car_model_id);
                        $('#name').val(data.name);
                        // $('#barcode').val(data.barcode);
                        $('#length').val(data.length);
                        $('#height').val(data.height);
                        $('#width').val(data.width);
                        $('#minimum_order_quantity').val(data.minimum_order_quantity)
                        $('#regular_price').val(data.regular_price);
                        $('#sales_type').val(data.sales_type);
                        $('#details').summernote('code', data.details);
                        $('#section_id').val(data.section_id);
                        $('#sales_price').val(data.sales_price);
                        $('#minimum_price').val(data.minimum_price);
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

        /**
            * @name itemDelete
            * @role send ajax request to delete a role
            * @param role id
            * @return json response
            *
            */
        function itemDelete(id) {
            alertify.confirm("Are You Sure To Delete This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './itemDeleteAjax',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if(response.status === true){
                                alertify.success(response.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else if(response.status === 'validation-error'){
                                    $.each(response.data, function(index, value){
                                        alertify.error(value[0]);
                                    })
                            }else {
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

                },
                function () {
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
                success: function (data) {
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

        function clearForm() {
            $('#subcategory_id').val('');
            $("#category_id").val('');
            $('#brand_id').val('');
            $('#itemUpdateForm').trigger("reset");
            $('#largesizemodal').modal('hide');
        }

        $('#car_company').change(function () {
            let company_id = $('#car_company').val();

            if (company_id.length <= 0) {
                $('#car_brand').html(`<option disabled value=""> SELECT BRAND</option>`);
            } else {
                $.ajax({
                    url: '{{ URL('getBrandByCompanyIdAjax') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: company_id
                    },
                    success: data => {
                        $('#car_model_multiple').html(`<option disabled value=""> SELECT Model</option>`);

                        $('#car_brand').html(`<option disabled value=""> SELECT BRAND</option>`);
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

        $('#car_brand').change(function () {
            let brand_id = $('#car_brand').val();

            if (brand_id.length <= 0) {
                $('#car_model_multiple').html(`<option disabled value=""> SELECT Model</option>`);

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
                            $('#car_model_multiple').html(`<option disabled value="">Select model</option>`);
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
                        $('#car_model_multiple').html(`<option disabled value="">Select model</option>`);
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

        $('#tags').on('keyup', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            if (e.key === 'Enter' || e.keyCode === 13) {
                let tag = $('#tags').val().trim().toLowerCase();
                let tags = tag.split(" ");
                let tagContainerDiv = "";

                $.each(tags, function (index, value) {
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

         function itemPublishEdit(id) {
            $.ajax({
                type: 'post',
                url: '{{ URL('ItemPublicationInfoChangeAjax') }}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {

                    console.log(data);
                    if (typeof data.errors !== 'undefined') {
                        alertify.warning("Something went wrong");
                    } else {
                        alertify.success(data);
                        $('#itemTable').DataTable().ajax.reload(null, false);
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

@endsection
