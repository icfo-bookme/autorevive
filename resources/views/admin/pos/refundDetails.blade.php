@extends('layouts.backend.master')
@section('content')
<style>
    .whiteSpace_normal{
        white-space: normal !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .must{
    color: red;
    font-size: 15px;
    font-weight: bold
    }
    .table td, .table th{
        font-size: 12px !important;
    }

    .screenFull {
    display: block;
    z-index: 9999;
    position: fixed;
    width: 100% !important;
    height: 100% !important;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    overflow: auto;
    }
    .btn__size{
        width: 30px !important;
        height: 30px !important;
        border-radius: 50%;
    }
    .custom__btn{
        background: #efefef;
        border: none;
    }
    .btn__size i {
        color: #585858;
    }
</style>

<div class="conatiner">
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h5>Refund Details View</h5>
                </div>
                <div class="card-body">
                    <form id="item_detail_form" action="">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3">
                                <label for="input-10" class="col-form-label">First Name<span class="must">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    required="required" onkeyup="firstName(this.value)">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Last Name<span class="must">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    required="required" onkeyup="lastName(this.value)">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Phone Number<span class="must">*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    required="required" onchange="autoFill(this.value)" onkeyup="phone(this.value)">
                            </div>
                            {{-- <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Company Name<span class="must">*</span></label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    required="required">
                            </div> --}}
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Email<span class="must">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" required="required" onkeyup="emailHandler(this.value)">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">District</label>
                                <input type="text" class="form-control" id="district" name="district">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Thana</label>
                                <input type="text" class="form-control" id="thana" name="thana">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Area</label>
                                <input type="text" class="form-control" id="area" name="area">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Road No</label>
                                <input type="text" class="form-control" id="road_no" name="road_no">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">House No</label>
                                <input type="text" class="form-control" id="house_no" name="house_no">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="input-11" class="col-form-label">Flat No</label>
                                <input type="text" class="form-control" id="flat_no" name="flat_no">
                            </div>
                            {{-- <div class="col-sm-4">
                                <label for="input-11" class="col-form-label">Address1</label>
                                <textarea class="form-control" rows="2" id="address_1" name="address_1"
                                    required="required" spellcheck="false"></textarea>
                            </div>
                            <div class="col-sm-4">
                                <label for="input-11" class="col-form-label">Address2</label>
                                <textarea class="form-control" rows="2" id="address_2" name="address_2"
                                    required="required" spellcheck="false"></textarea>
                            </div> --}}
                            <div class="col-sm-4">
                                <label for="input-11" class="col-form-label">Order Notes</label>
                                <textarea class="form-control" rows="2" id="order_notes" name="order_notes"
                                   spellcheck="false"></textarea>
                            </div>
                            {{-- <div class="col-lg-12 col-sm-12 mt-3 mb-3">
                                <label for="items">Item List</label>
                                <select class="form-control valid" id="itemId" name="items"
                                    onchange="selectProduct(this.value)" required="" aria-invalid="false">
                                    <option value="">Select Item</option>
                                    @foreach ($allProducts as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-lg-12">
                                <label for="">Item List<span class="must">*</span></label>
                                {{-- <select class="js-select2" name="" id=""></select> --}}
                                <select class="valid js-select2" id="itemId" name="items"
                                    onchange="selectProduct(this.value)" required="" aria-invalid="false">
                                    <option value="">Select Item</option>
                                    <option value=""  ></option>
                                   
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="row">
                    <div class="col-sm-12 mb-4">
                        <div class="table-reponsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_tbl">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-lg-12 px-5 pb-5">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_tbl">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Details</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group" style="box-shadow: none">
                        <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span
                                class="float-right" id="totalAmount">৳0</span></li>
                        <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span
                            class="float-right" id="shippingCharge">৳0</span></li>
                        <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span class="float-right"
                                id="totalAmountWithShipping">৳0</span></li>
                    </ul>
                    <div class="form-group">
                        {{-- <input type="checkbox" name="checkShipping" id="checkShipping">  Shipping --}}
                       
                        <input type="text" class="form-control" name="checkShipping" id="checkShipping"  placeholder="shipping charge">  
                    </div>
                     <div class="mx-auto my-3">
                            <div class="row">
                               
                                    <div class="col-lg-6">
                                        <div class="icheck-material-primary mr-2">
                                            <input type="radio" class="radio" id="" name="payment_method_id" value="Cash">
                                            <label for="">Cash</label>
                                        </div> 
                                    </div>
                              
                               
                            </div>
                        </div>
                    <button id="checkOut" class="btn btn-secondary btn-round waves-effect waves-light m-1 shadow btn-block" >Sale</button>
                    {{-- <a onclick="invoiceModal({{ $orders->id }})" style="padding: 5px 10px;color: #fff;cursor: pointer;"
                        class="btn badge badge-primary" data-toggle="tooltip" title="" data-original-title="Invoice">



                    </a> --}}
                </div>
            </div>
            
            <div class="row">
             <div class="col-sm-12" >
                <div class="invoice p-3" id="invoiceMaxiMin" style="background-color: #FFF;">

        <div id="invoiceElement">
            <div class="text-right" id="maxiMizeMin">
                <button id="maximize" class="custom__btn btn__size" onclick="maximize()"><i class="fa fa-window-restore" aria-hidden="true"></i></button>
                <button id="minimize" class="custom__btn btn__size" onclick="minimize()"><i class="fa fa-minus" aria-hidden="true"></i></button>
                {{-- <span onclick="maximize()"><i class="fa fa-arrows-alt" aria-hidden="true"></i></span>
                <span onclick="minimize()"><i class="fa fa-minus" aria-hidden="true"></i></span> --}}
            </div>
             {{-- <header style="padding: 10px 0; margin-bottom: 20px; border-bottom: 1px solid #3989c6;">            
            <div class="address-shop text-center">
                <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" class="pb-2" width="200" alt="">
                <p>Wireless Moor, Zakir Hossain Road West Khulshi, Chattogram 4000</p>
                <p>automart@technova.com</p>
            </div>
        </header> --}}
        <main id="invoiceDiv">
            <div class="d-flex justify-content-between">
                <div class="invoice-img">
                    <h3 style="color: #3989c6;font-size: 14px; line-height: 18px">INVOICE TO:</h3>
                    <p style="font-size: 11px">Name- <span id="firstName"></span><span id="lastName"></span></p>
                    <p style="font-size: 11px">Contact Number - <span id="phone"></span></p>
                    <p style="font-size: 11px">Email - <span id="emailAddress"></span></p>
                    {{-- <p style="font-size: 11px">Email - <span id="email"></span></p> --}}
                </div>
                <div class="address-shop">
                    <h3 style="color: #3989c6;font-size: 14px;line-height: 18px">INVOICE #8</h3>
                    <p style="font-size: 11px" id="dateFormat"></p style="font-size: 11px">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr> 
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                         <tbody id="selected_tbl_invoice">

                        </tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td colspan="1">Sub Total</td>
                            <td><span class="float-right" id="totalAmountInvoice">৳0</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="1">Shipping</td>
                            <td><span class="float-right" id="shippingChargeInvoice">৳0</span></td>
                        </tr>
                        <tr>
                            <td ></td>
                            <td colspan="1">Grand Total</td>
                            <td><span class="float-right" id="totalAmountWithShippingInvoice">৳0</span></td>
                        </tr>
                    </tfoot>
                </table>
                {{-- <ul class="list-group" style="box-shadow: none">
                    <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span
                            class="float-right" id="totalAmountInvoice">৳0</span></li>
                    <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span
                        class="float-right" id="shippingChargeInvoice">৳0</span></li>
                    <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span class="float-right"
                            id="totalAmountWithShippingInvoice">৳0</span></li>
                </ul> --}}
                </div>
                <div class="row no-print">
                    <div class="col-lg-12">
                    <div class="float-sm-right">
                      {{-- <a href="javascript:void(0)" class="btn btn-primary m-1 donwloadBtn" download><i class="fa fa-download"></i> Download</a> --}}
                        <a href="javascript:void(0)" id="previewBtn" class="btn btn-primary m-1" onclick="printDiv('invoiceElement')"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
             </div>
            </div>
        </main>
        </div>
            </div>
            </div>
        </div>
       
    </div>
</div>

 <!-- loader modal -->
 <div class="modal" id="preloader" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
         <img src="{{asset('assets/images/preloader.gif')}}"
             style="display: block;margin: auto;margin-top:50%;width: 10%;">
     </div>
 </div>


 <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="invoice_detail_modal">
          <h6>Invoice details will go here...</h6>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>

  <script>     
    function printDiv(divName) {
        $('#maxiMizeMin').hide();
        $('#previewBtn').hide();
        $('.donwloadBtn').hide();
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function() {
           location.reload();
        }, 1000);

    }
    // bootstrap tooltip script
    

     function firstName(val){
      $('#firstName').text(val);
     }
     function lastName(val){
      $('#lastName').text(" " + val);
     }
     function phone(val){
      $('#phone').text(val);
     }
     function emailHandler(val){
      $('#emailAddress').text(val);
     }


     let d = new Date();
     let month = d.getMonth()+1;
     let day = d.getDate();
     let year = d.getFullYear();
     $('#dateFormat').append(`<p>Date: ${day}/${month}/${year} </p>`)
     
    // maximize and minimize 
    $('#minimize').hide();
    function maximize(){
        $('#invoiceMaxiMin').addClass('screenFull');
        $('#maximize').hide();
        $('#minimize').show();
        
        
    }
    function minimize(){
        $('#invoiceMaxiMin').removeClass('screenFull');
        $('#maximize').show();
        $('#minimize').hide();
    }
    //  autofill input in salesview

    function autoFill(val) {
           let mble_num = val;
            $.ajax({
                url: '{{url("getUserDataToAutofill")}}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                    mble_num: mble_num
                },
                success: function (response) {
                    console.log(response.allUsers);
                    $('#first_name').val(response.allUsers.name); 
                    $('#last_name').val(response.allUsers.name);
                    $('#firstName').text(response.allUsers.name);
                    $('#emailAddress').text(response.allUsers.email);
                    $('#company_name').val("");
                    $('#email').val(response.allUsers.email);
                    $('#country').val(response.allUsers.country);
                    $('#district').val(response.allUsers.district);
                    $('#city').val(response.allUsers.city);
                    $('#thana').val(response.allUsers.thana);
                    $('#area').val(response.allUsers.area);
                    $('#road_no').val(response.allUsers.road_no);
                    $('#house_no').val(response.allUsers.house_no);
                    $('#flat_no').val(response.allUsers.flat_no);
                    
                    
                },
                error: function () {
                    alert("error");
                }
            });
        }

    let base_url = '{{ URL("/") }}';
   
    $(document).ready(function () {
        
        $('#selected_tbl_invoice').on("DOMSubtreeModified", function () {
            $('#shippingChargeInvoice').text("৳"+$('#checkShipping').val());
            calculateTotal();
        });

        // sale
        $('#checkOut').on('click', () => {
            checkOut();
        });

        // onchange count, change price
        $('tr td:nth-child(3) input').on('change', () => {
            //
        });

        // oncheck add/remove shipping charge
        $('#checkShipping').change(function () {
            if (this.checked) {
               $('#shippingCharge').text("৳"+$('#checkShipping').val());
            } else {
                $('#shippingCharge').text("৳"+$('#checkShipping').val());
            }
            calculateTotal();
        });
        $('#checkShipping').change(function () {
            if (this.checked) {
               $('#shippingChargeInvoice').text("৳"+$('#checkShipping').val());
            } else {
               $('#shippingChargeInvoice').text("৳"+$('#checkShipping').val());
            }
            calculateTotal();
        });

        $(".js-select2").select2({
            closeOnSelect: true
        });
        $(".js-select2-multi").select2({
            closeOnSelect: false
        });

    });





    /*
        ========================
        =====|My Functions|=====
        ========================
    */
    function selectProduct(id) {
        /*
            if item isn't selected yet, add row
            else, increase quantity by 1
        */
        if (!itemAlreadySelected(id)) {
            $.ajax({
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                url: '{{ URL("/getProductByIdAjax") }}',
                success: data => {
                    if (Object.keys(data).length > 0) {
                        console.log(data);
                        $('#selected_tbl').append(`<tr id="item_${data.id}" data-price="${data.sales_price}">
                        
                            <td class="whiteSpace_normal" id="item_${data.id}_title">${data.name}</td>
                            <td class="whiteSpace_normal"><img src="${data.thumbnail}" width="50" height="50"></td>
                            <td class="whiteSpace_normal" style="min-width: 200px;">
                                <button class="btn btn-danger btn-sm text-white"
                                    onclick="decreaseItemCount(${data.id}, ${data.sales_price})"
                                    style="cursor: pointer;">-</button>
                                <input id="item_${data.id}_count"
                                    onkeyup="changeTotal(${data.sales_price}, 'item_${data.id}_count', 'item_${data.id}_total')"
                                    type="text" class="form-control w-50 d-inline-block" value="1" min="1">
                                <button class="btn btn-success btn-sm text-white"
                                    onclick="increaseItemCount(${data.id}, ${data.sales_price})"
                                    style="cursor: pointer">+</button>
                            </td>
                            <td class="whiteSpace_normal" id="item_${data.id}_total">${data.sales_price}</td>
                            <td class="whiteSpace_normal">
                                <span onclick="removeItem(${data.id})" class="badge badge-danger py-3 px-2"
                                    style="cursor: pointer;min-width:45px">X</span>
                            </td>
                        </tr>`);


                        $('#selected_tbl_invoice').append(`<tr id="item_invoice_${data.id}" data-price="${data.sales_price}">
                            <td class="whiteSpace_normal" id="item_invoice_${data.id}_title">${data.name}</td>
                            <td class="whiteSpace_normal">
                                <input id="item_invoice_${data.id}_count"
                                    type="text" class="form-control w-50 d-inline-block qnty" value="1" min="1" readonly style="background: transparent !important;border: none !important;">
                            <td class="whiteSpace_normal" id="item_invoice_${data.id}_total">${data.sales_price}</td>
                            
                        </tr>`)
                        alertify.success("Item added!");
                    }
                },
                error: err => {
                    alertify.error(err);
                }
            });
        } else {
            
        }
    }

    function removeItem(id) {
        let item_id = `#item_${id}`;
        let item_invoice_id = `#item_invoice_${id}`;
        if (!!$(item_id).remove()) {
            alertify.error('Item removed!');
        }
        if (!!$(item_invoice_id).remove()) {
            alertify.error('Item removed!');
        }
    }


    function increaseItemCount(id, amount) {
        let item_id = `#item_${id}_count`;
        let item_invoice_id = `#item_invoice_${id}_count`;

        let present_count = Number($(item_id).val());
        let present_total = Number($(`#item_${id}_total`).html());
        // let unit_price = present_total / present_count;
        let total = Number($(`#item_${id}_total`).html());
        $(item_id).val(present_count += 1);
        $(item_invoice_id).val(present_count);

        total += amount;
        $(`#item_${id}_total`).html(total);
        $(`#item_invoice_${id}_total`).html(total);
        $(`#item_${id}_total`).html(amount * $(item_id).val());
    }

    function decreaseItemCount(id, amount) {
        let item_id_count = `#item_${id}_count`;
        let item_invoice_id = `#item_invoice_${id}_count`;

        let present_count = Number($(item_id_count).val());
        let total = Number($(`#item_${id}_total`).html());

        if (present_count <= 0) {
            present_count = 0;
            $(item_id_count).val(present_count);
            $(item_invoice_id).val(present_count);
            $(`#item_${id}_total`).html("0");
            $(`#item_invoice_${id}_total`).html("0");
        } else {
            present_count -= 1;
            $(item_id_count).val(present_count);
            $(item_invoice_id).val(present_count);

            total -= amount;
            $(`#item_${id}_total`).html(total)
            $(`#item_invoice_${id}_total`).html(total)
        }
    }
    

    function changeTotal(price, thisId, target) {
        let count = $(`#${thisId}`).val();
        if (count <= 0) {
            $(`#${thisId}`).val("0");
            $(`#${target}`).text("0");
        }
        let total = price * count;
        $(`#${target}`).text(total);
    }
    
    function itemAlreadySelected(id) {
        let item_id = `#item_${id}`;
        if ($(item_id).html()) {
            return true;
        }
        return false;
    }


    
 


    // to calculate total (when table data changes)
    function calculateTotal() {
        let subtotal = Number($('#totalAmount').text().split('৳')[1]);
        let shipping = Number($('#shippingCharge').text().split('৳')[1]);
        let grand_total = subtotal + shipping;
       

        subtotal = 0;
        document.querySelectorAll('#selected_tbl tr').forEach(e => {
            let id = `#${e.id}_total`;
            subtotal += Number($(id).text());
        });
       
        if (subtotal == 0) {
            $('#totalAmount').text(`৳${0}`);
            $('#totalAmountWithShipping').text(`৳${0}`);
            $('#totalAmountInvoice').text(`৳${0}`);
            $('#totalAmountWithShippingInvoice').text(`৳${0}`);
        } else {
            grand_total = subtotal + shipping;
            $('#totalAmount').text(`৳${subtotal}`);
            $('#totalAmountWithShipping').text(`৳${grand_total}`);
            $('#totalAmountInvoice').text(`৳${subtotal}`);
            $('#totalAmountWithShippingInvoice').text(`৳${grand_total}`);
        }
    }

    function getOrderDetail() {
        let orderDetail = {};
        let items_details_list = [];

        orderDetail['first_name'] = $('#first_name').val();
        orderDetail['last_name'] = $('#last_name').val();
        orderDetail['phone_number'] = $('#phone_number').val();
        orderDetail['company_name'] = $('#company_name').val();
        orderDetail['email'] = $('#email').val();
        orderDetail['city'] = $('#city').val();
        orderDetail['country'] = $('#country').val();
        orderDetail['district'] = $('#district').val();
        orderDetail['thana'] = $('#thana').val();
        orderDetail['area'] = $('#area').val();
        orderDetail['road_no'] = $('#road_no').val();
        orderDetail['house_no'] = $('#house_no').val();
        orderDetail['flat_no'] = $('#flat_no').val();
        orderDetail['order_notes'] = $('#order_notes').val();
        orderDetail['shippingChargeApplied'] =  $('#checkShipping').val();
        orderDetail['totalAmount'] = Number($('#totalAmount').text().split('৳')[1]);
        orderDetail['totalAmountWithShipping'] = Number($('#totalAmountWithShipping').text().split('৳')[1]);

        document.querySelectorAll('#selected_tbl tr').forEach(e => {
            let item_details = {
                title: $(`#${e.id}_title`).text(),
                quantity: $(`#${e.id}_count`).val(),
                product_id: e.id.split('_')[1],
                price: $(`#${e.id}`).data('price'),
            };

            items_details_list.push(item_details);
        });

        orderDetail['items_details_list'] = items_details_list;

        return orderDetail;
    }

    function checkOut() {
        alertify.confirm("Are You Sure To Submit This?",
            function () {
                $('#preloader').modal('show');
                let payment_method = $("input[class='radio']:checked").val();
                $.ajax({
                    url: '{{ URL("salesInsert") }}',
                    type: 'POST',
                    data: {
                        orderDetail: getOrderDetail(),
                        payment_method:payment_method
                    },
                    success: data => {
                        $('#preloader').modal('hide');


                        if (data.message == "Success") {


                            alertify.success(data.message);
                            printDiv('invoiceElement');

                            // $('#item_detail_form').trigger('reset');
                            // $('#selected_tbl').html('');
                            // $('#selected_tbl_invoice').html('');
                            $('#firstName').text('');
                            $('#emailAddress').text('');
                            $('#phone').text('');
                            window.open('./salesInvoicePrintViewUser/'+data.order_id)
                         
                            // printInvoiceSale();

                        //  window.location.href = "{{URL::to('invoicePrintViewUser/${data.order_id}')}}"
                        } else {
                            if (typeof data == 'object') {
                                alertify.error("<span class='text-white'>An error occured! Please check you input!</span>");
                                $.each(data, (k, v) => {
                                    if (k == 'errors') {
                                        $.each(v, (key, val) => {
                                            console.log(val[0]);
                                            setTimeout(() => {
                                                alertify.error(`<span class='text-white'>${val[0]}</span>`);
                                            }, 1000);
                                            // let makeErrorAlert = () => alertify.error(`<span class='text-white'>${val[0]}</span>`);
                                            // waitFunc(makeErrorAlert, 1000);
                                        });
                                    }
                                });
                            }
                        }
                    },
                    error: function (jqXHR, exception) {
                        $('#preloader').modal('hide');
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
    }



</script>




@endsection
