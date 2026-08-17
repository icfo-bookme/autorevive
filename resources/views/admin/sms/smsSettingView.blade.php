@extends('layouts.backend.master')
@section('content')
    <style>

        .diplay--block {
            display: block !important;
        }

        .summary--container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .summary--container p {
            margin-bottom: 0px;
        }

        .nav.nav-tabs .nav-item .nav-link.active {
            border: 0;
            border-bottom: 2px solid #55595c !important;
        }

        table.dataTable {
            width: 100% !important;
        }

        .dropdown--menu {
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            font-size: 1rem;
            color: #373a3c;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.18rem;
        }

        .editable {
            width: 300px;
            height: 200px;
            border: 1px solid #ccc;
            padding: 5px;
            resize: both;
            overflow: auto;
        }
        /* switch slider */
        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        .switch input {
        opacity: 0;
        width: 0;
        height: 0;
        }

        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
        .table td, .table th{
            padding: 5px 5px !important;
        }
        .linkTag:hover {
        text-decoration: underline;
        color: blue;
        cursor: pointer;
        }
    </style>

    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="card border border-dark">
                <div class="card-header text-white" style="background-color: #2c3e50;"><i class="icon-badge"></i> SMS Settings
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12 col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                                        href="#tab1" aria-expanded="true">After Sale</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2"
                                        aria-expanded="false">After Approve Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3"
                                        aria-expanded="false">First Sale</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true"
                                    aria-labelledby="base-tab1">
                                    <div class="row" style="display: flex;justify-content:center;align-items:center">
                                        <div class="col-lg-8">
                                            <form action="" id="afterSaleForm">
                                                @csrf
                                                <input type="hidden" name="type" value="after_sale">
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"
                                                        style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label for="">Status: </label>
                                                    </div>
                                                    <div class="col-lg-2" style="display: flex;justify-content: flex-start;align-items:center;">
                                                        <label class="switch">
                                                            <input type="checkbox" id="switchafterSale" name="switch" {{isset($afterSaleSetting['status']) ? ($afterSaleSetting['status'] == 1 ? "checked" : "") : ""}}>
                                                            <span class="slider round"></span>
                                                          </label>
                                                    </div>

                                                </div>
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4" style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label>Personalize:</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <button type="button" class="btn btn-primary btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">SMS Body Personalize
                                                        </button>
                                                        <div class="dropdown-menu dropdown--menu">
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[order_id]]')">Order ID</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[first_name]]')">First Name</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[last_name]]')">Last Name</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[phone]]')">Phone</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[email]]')">Email</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"
                                                        style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label for="">SMS Body: </label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <textarea name="sms_body" id="afterSale" cols="40" rows="6" class="form-control">{{isset($afterSaleSetting['sms_body']) ? $afterSaleSetting['sms_body']:''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"></div>
                                                    <div class="col-lg-8">
                                                        <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save Setting</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab2" aria-expanded="true"
                                    aria-labelledby="base-tab2">
                                    <div class="row" style="display: flex;justify-content:center;align-items:center">
                                        <div class="col-lg-8">
                                            <form action="" id="afterApproveOrderForm">
                                                @csrf
                                                <input type="hidden" name="type" value="after_approve_order">
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"
                                                        style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label for="">Status: </label>
                                                    </div>
                                                    <div class="col-lg-2" style="display: flex;justify-content: flex-start;align-items:center;">
                                                        <label class="switch">
                                                            <input type="checkbox" id="switchafterApproveOrder" name="switch" {{isset($afterApproveOrderSetting['status']) ? ($afterApproveOrderSetting['status'] == 1 ? "checked" : "") : ""}}>
                                                            <span class="slider round"></span>
                                                          </label>
                                                    </div>

                                                </div>
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4" style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label>Personalize:</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <button type="button" class="btn btn-primary btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">SMS Body Personalize
                                                        </button>
                                                        <div class="dropdown-menu dropdown--menu">
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[order_id]]')">Order ID</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[first_name]]')">First Name</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[last_name]]')">Last Name</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[phone]]')">Phone</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[email]]')">Email</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"
                                                        style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label for="">SMS Body: </label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <textarea name="sms_body" id="afterApproveOrder" cols="40" rows="6" class="form-control">{{isset($afterApproveOrderSetting['sms_body']) ? $afterApproveOrderSetting['sms_body']:''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"></div>
                                                    <div class="col-lg-8">
                                                        <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save Setting</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab3" aria-expanded="true"
                                    aria-labelledby="base-tab3">
                                    <div class="row" style="display: flex;justify-content:center;align-items:center">
                                        <div class="col-lg-8">
                                            <form action="" id="afterFirstSaleForm">
                                                @csrf
                                                <input type="hidden" name="type" value="after_first_sale">
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"
                                                        style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label for="">Status: </label>
                                                    </div>
                                                    <div class="col-lg-2" style="display: flex;justify-content: flex-start;align-items:center;">
                                                        <label class="switch">
                                                            <input type="checkbox" id="switchafterFirstSale" name="switch" {{isset($afterFirstSaleSetting['status']) ? ($afterFirstSaleSetting['status'] == 1 ? "checked" : "") : ""}}>
                                                            <span class="slider round"></span>
                                                          </label>
                                                    </div>

                                                </div>
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4" style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label>Personalize:</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <button type="button" class="btn btn-primary btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">SMS Body Personalize
                                                        </button>
                                                        <div class="dropdown-menu dropdown--menu">
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[order_id]]')">Order ID</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[first_name]]')">First Name</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[last_name]]')">Last Name</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[phone]]')">Phone</a>
                                                            <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[email]]')">Email</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"
                                                        style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                        <label for="">SMS Body: </label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <textarea name="sms_body" id="afterFirstSale" cols="40" rows="6" class="form-control">{{isset($afterFirstSaleSetting['sms_body']) ? $afterFirstSaleSetting['sms_body']:''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 15px !important;">
                                                    <div class="col-lg-4"></div>
                                                    <div class="col-lg-8">
                                                        <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save Setting</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="font-size: 23px;text-align: center">SMS Settings</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav-tabs-info">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><span class="hidden-xs">After Sale</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabe-2"><span class="hidden-xs">After Approve Order</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabe-3"><span class="hidden-xs">First Sale</span></a>
                                </li>                       
                            </ul>
              
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="tabe-1" class="tab-pane active">
                                    <div class="col-lg-8">
                                        <form action="" id="afterSaleForm">
                                            @csrf
                                            <input type="hidden" name="type" value="after_sale">
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"
                                                    style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label for="">Status: </label>
                                                </div>
                                                <div class="col-lg-2" style="display: flex;justify-content: flex-start;align-items:center;">
                                                    <label class="switch">
                                                        <input type="checkbox" id="switchafterSale" name="switch" {{isset($afterSaleSetting['status']) ? ($afterSaleSetting['status'] == 1 ? "checked" : "") : ""}}>
                                                        <span class="slider round"></span>
                                                      </label>
                                                </div>

                                            </div>
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4" style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label>Personalize:</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <button type="button" class="btn btn-info btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">SMS Body Personalize
                                                    </button>
                                                    <div class="dropdown-menu dropdown--menu">
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[first_name]]')">First Name</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[last_name]]')">Last Name</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[order_id]]')">Order ID</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[e_invoice]]')">E-Invoice</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[phone]]')">Phone</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterSale('[[email]]')">Email</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"
                                                    style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label for="">SMS Body: </label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <textarea name="sms_body" id="afterSale" cols="40" rows="6" class="form-control">{{isset($afterSaleSetting['sms_body']) ? $afterSaleSetting['sms_body']:''}}</textarea>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <button type="submit" class="btn btn-info"><i class="icon-save"></i> Save Setting</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tabe-2" class="tab-pane fade">
                                    <div class="col-lg-8">
                                        <form action="" id="afterApproveOrderForm">
                                            @csrf
                                            <input type="hidden" name="type" value="after_approve_order">
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"
                                                    style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label for="">Status: </label>
                                                </div>
                                                <div class="col-lg-2" style="display: flex;justify-content: flex-start;align-items:center;">
                                                    <label class="switch">
                                                        <input type="checkbox" id="switchafterApproveOrder" name="switch" {{isset($afterApproveOrderSetting['status']) ? ($afterApproveOrderSetting['status'] == 1 ? "checked" : "") : ""}}>
                                                        <span class="slider round"></span>
                                                      </label>
                                                </div>

                                            </div>
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4" style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label>Personalize:</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <button type="button" class="btn btn-info btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">SMS Body Personalize
                                                    </button>
                                                    <div class="dropdown-menu dropdown--menu">
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[first_name]]')">First Name</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[last_name]]')">Last Name</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[order_id]]')">Order ID</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[e_invoice]]')">E-Invoice</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[phone]]')">Phone</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterApproveOrder('[[email]]')">Email</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"
                                                    style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label for="">SMS Body: </label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <textarea name="sms_body" id="afterApproveOrder" cols="40" rows="6" class="form-control">{{isset($afterApproveOrderSetting['sms_body']) ? $afterApproveOrderSetting['sms_body']:''}}</textarea>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <button type="submit" class="btn btn-info"><i class="icon-save"></i> Save Setting</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tabe-3" class="tab-pane fade">
                                    <div class="col-lg-8">
                                        <form action="" id="afterFirstSaleForm">
                                            @csrf
                                            <input type="hidden" name="type" value="after_first_sale">
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"
                                                    style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label for="">Status: </label>
                                                </div>
                                                <div class="col-lg-2" style="display: flex;justify-content: flex-start;align-items:center;">
                                                    <label class="switch">
                                                        <input type="checkbox" id="switchafterFirstSale" name="switch" {{isset($afterFirstSaleSetting['status']) ? ($afterFirstSaleSetting['status'] == 1 ? "checked" : "") : ""}}>
                                                        <span class="slider round"></span>
                                                      </label>
                                                </div>

                                            </div>
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4" style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label>Personalize:</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <button type="button" class="btn btn-info btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">SMS Body Personalize
                                                    </button>
                                                    <div class="dropdown-menu dropdown--menu">
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[first_name]]')">First Name</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[last_name]]')">Last Name</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[order_id]]')">Order ID</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[e_invoice]]')">E-Invoice</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[phone]]')">Phone</a>
                                                        <a class="dropdown-item" href="#" onclick="setPersonalizationAfterFirstSale('[[email]]')">Email</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"
                                                    style="display: flex;justify-content:flex-end;align-items:flex-end">
                                                    <label for="">SMS Body: </label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <textarea name="sms_body" id="afterFirstSale" cols="40" rows="6" class="form-control">{{isset($afterFirstSaleSetting['sms_body']) ? $afterFirstSaleSetting['sms_body']:''}}</textarea>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 15px !important;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <button type="submit" class="btn btn-info"><i class="icon-save"></i> Save Setting</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        function setPersonalizationAfterSale(val) {
            var cursorPos = $('#afterSale').prop('selectionStart');
            var v = $('#afterSale').val();
            var textBefore = v.substring(0, cursorPos);
            var textAfter = v.substring(cursorPos, v.length);
            $('#afterSale').val(textBefore + val + textAfter);
        }
        function setPersonalizationAfterApproveOrder(val) {
            var cursorPos = $('#afterApproveOrder').prop('selectionStart');
            var v = $('#afterApproveOrder').val();
            var textBefore = v.substring(0, cursorPos);
            var textAfter = v.substring(cursorPos, v.length);
            $('#afterApproveOrder').val(textBefore + val + textAfter);
        }
        function setPersonalizationAfterFirstSale(val) {
            var cursorPos = $('#afterFirstSale').prop('selectionStart');
            var v = $('#afterFirstSale').val();
            var textBefore = v.substring(0, cursorPos);
            var textAfter = v.substring(cursorPos, v.length);
            $('#afterFirstSale').val(textBefore + val + textAfter);
        }

        /**
         * Inserts/Updates After Sale SMS settings
         */
        $('#afterSaleForm').submit(function (event) {
            event.preventDefault();

            alertify.confirm('Are You Sure ?', 'SMS settings will be updated', function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("smsSettingUpsert")}}',
                    data: $('#afterSaleForm').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if(response.status === true){
                            alertify.success(response.message);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else if(response.status === false){
                            alertify.error("<span class='text-white'>"+response.message+"</span>");
                        }  else if(response.status === "validation-error"){
                            for (let key in response.data) {
                                if (response.data.hasOwnProperty(key)) {
                                    alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                                }
                            }
                        }
                    }
                });

            }, function () {
                alertify.error("<span class='text-white'>Cancelled!</span>");
            });
        });

        /**
         * Inserts/Updates After Approve Order SMS settings
         */
        $('#afterApproveOrderForm').submit(function (event) {
            event.preventDefault();

            alertify.confirm('Are You Sure ?', 'SMS settings will be updated', function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("smsSettingUpsert")}}',
                    data: $('#afterApproveOrderForm').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if(response.status === true){
                            alertify.success(response.message);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else if(response.status === false){
                            alertify.error("<span class='text-white'>"+response.message+"</span>");
                        }  else if(response.status === "validation-error"){
                            for (let key in response.data) {
                                if (response.data.hasOwnProperty(key)) {
                                    alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                                }
                            }
                        }
                    }
                });

            }, function () {
                alertify.error("<span class='text-white'>Cancelled!</span>");
            });
        });

        /**
         * Inserts/Updates After First Sale SMS settings
         */
         $('#afterFirstSaleForm').submit(function (event) {
            event.preventDefault();

            alertify.confirm('Are You Sure ?', 'SMS settings will be updated', function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("smsSettingUpsert")}}',
                    data: $('#afterFirstSaleForm').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if(response.status === true){
                            alertify.success(response.message);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else if(response.status === false){
                            alertify.error("<span class='text-white'>"+response.message+"</span>");
                        }  else if(response.status === "validation-error"){
                            for (let key in response.data) {
                                if (response.data.hasOwnProperty(key)) {
                                    alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                                }
                            }
                        }
                    }
                });

            }, function () {
                alertify.error("<span class='text-white'>Cancelled!</span>");
            });
        });

        

        /**
         * disable or enable with switch for after sale setting
         */
        $("#switchafterSale").on("change", function(event) {
            if ($(this).is(":checked")) {
                $('#switchafterSale').val(1);
            } else {
                $('#switchafterSale').val(0);
            }
        });

        /**
         * disable or enable with switch for after approve order setting
         */
         $("#switchafterApproveOrder").on("change", function(event) {
            if ($(this).is(":checked")) {
                $('#switchafterApproveOrder').val(1);
            } else {
                $('#switchafterApproveOrder').val(0);
            }
        });

        /**
         * disable or enable with switch for first sale setting
         */
         $("#switchafterFirstSale").on("change", function(event) {
            if ($(this).is(":checked")) {
                $('#switchafterFirstSale').val(1);
            } else {
                $('#switchafterFirstSale').val(0);
            }
        });

    </script>
@endsection