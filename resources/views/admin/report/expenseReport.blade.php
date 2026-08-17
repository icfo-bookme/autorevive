@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Expense Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="introduction-box mx-auto">
                        <h5 class="text-center">Automart</h5>
                        <p class="text-center">Expense Report</p>
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
                                <label for="">Cost Category</label>
                                <select class="form-control" id="cost_cat_id" onchange="getCostSubCategories()">
                                    <option selected value="null">Select</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <label for="">Cost SubCategory</label>
                                <select class="form-control" id="cost_subcat_id">
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
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Created At</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="ajaxLoad">
                            </tbody>
                            <tr>
                                <th colspan="6" style="text-align:right">Total:</th>
                                <th id="totalAmount"></th> 
                            </tr>
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
        <img src="{{ asset('assets/images/preloader.gif') }}" style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>


@endsection

<script>
//  $(document).ready(function (){
//     const csrf_token = "{{ csrf_token() }}";
   
//  })
function ajaxCall() {
        var fromDate    = $('#fromDate').val();
        var toDate      = $('#toDate').val();
        var cat         = $("#cost_cat_id").val();
        var subCat      = $("#cost_subcat_id").val();
        const csrf_token = "{{ csrf_token() }}";

        console.log(fromDate,toDate, cat, subCat);
        

        var dataTable=$('#selectionForTest').DataTable({
                destroy:true,
                responsive: true,
                lengthMenu: [5, 10, 25, 50, 100, 500],
                pageLength: 10,
                stateSave: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                paging: false, // Disable pagination
                ajax: {
                    url: route('expenseReportAjax'),
                    data: function (data) {
                        data._token = csrf_token;
                        data._fromDate = fromDate;
                        data._toDate = toDate;
                        data._cat = cat;
                        data._subCat = subCat;

                        
                    },
                    type: 'post',
                    dataSrc: function (json) {
    
    var totalAmount = parseInt(json.totalAmount);  
    
    $('#totalAmount').html(' ' + totalAmount);  
    return json.data;  
}
                },
                columns:[
                    {
                data: null,
                name: 'sl',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1; 
                }
            },
                    {data: 'data_category', name: 'category.name'},
                    {data: 'data_subcategory', name: 'subcategory.name'},
                    {data: 'data_description', name: 'description.name'},
                    {data: 'date', name: 'date'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'amount', name: 'amount'},


                ],
                // dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                // buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                buttons: [
        'copy',
        {
    extend: 'excel',
    customize: function (xlsx) {
        var sheet = xlsx.xl.worksheets['sheet1.xml'];

        var sheetData = $(sheet).find('sheetData row');

        $(sheetData).each(function () {
            var row = $(this);

            var descriptionCell = row.find('c[r^="D"]');

            if (descriptionCell.length) {
                var descriptionText = descriptionCell.find('is t').text();

                descriptionText = descriptionText
                    .replace('See More', '')  
                    .replace('Full Description', '')  
                    .replace('Close', '')  
                    .replace('×', '')  
                    .replace(/[\r\n]+/g, ' ')  
                    .trim();  

                if (descriptionText.length > 30) {
                    descriptionText = descriptionText.substring(30).trim();
                    descriptionText = descriptionText.replace(/^\.*\s*/, '').trim();  
                }

                descriptionCell.find('is t').text(descriptionText);
            }
        });

        var sheetDataElem = $(sheet).find('sheetData');

        var titles = `
            <row r="1">
                <c t="inlineStr" r="A1">
                    <is><t>Automart</t></is>
                </c>
            </row>
            <row r="2">
                <c t="inlineStr" r="A2">
                    <is><t>Expense Report</t></is>
                </c>
            </row>`;
        sheetDataElem.prepend(titles);

        // Append the total amount at the bottom
        var totalAmount = $('#totalAmount').text();
        var totalRow = `
            <row>
                <c t="inlineStr">
                    <is><t>Total Amount</t></is>
                </c>
                <c t="inlineStr">
                    <is><t>${totalAmount}</t></is>
                </c>
            </row>`;
        sheetDataElem.append(totalRow);

       
    }
},
        {
    extend: 'pdf',
    customize:  function (doc) {
                doc.content[1].table.body.forEach(function(row) {
                    var descriptionHtml = row[3].text;  
                    var tempDiv = document.createElement("div");
                    tempDiv.innerHTML = descriptionHtml;

                    var plainTextDescription = tempDiv.textContent || tempDiv.innerText || "";

                    plainTextDescription = plainTextDescription
                        .replace('See More', '')  
                        .replace('Full Description', '')  
                        .replace('Close', '')  
                        .replace('×', '')  
                        .replace(/[\r\n]+/g, ' ') 
                        .trim();  

                    
                    
                    // if (descriptionLines.length > 1 && descriptionLines[0].trim() === descriptionLines[1].trim()) {
                    //     descriptionLines.splice(1, 1);  // Remove the duplicate line
                    // }

                     if (plainTextDescription.length > 30) {
            plainTextDescription = plainTextDescription.substring(30).trim();  
            plainTextDescription = plainTextDescription.replace(/^\.*\s*/, '').trim();  
        }

                    
                    row[3].text = plainTextDescription;    
                });

        

        // Append total amount to the bottom of the document 
        var totalAmount = $('#totalAmount').text();
        doc.content.push({
            table: {
                widths: ['*', 'auto'],  
                body: [
                    [{
                        text: 'Total:',
                        alignment: 'right',
                        bold: true,
                        border: [false, true, false, false],  
                        margin: [0, 5, 10, 5]  
                    },
                    {
                        text: totalAmount,
                        alignment: 'right',
                        bold: true,
                        border: [false, true, false, false],  
                        margin: [0, 5, 0, 5]
                    }]
                ]
            },
            layout: {
                hLineWidth: function (i, node) {
                    return (i === node.table.body.length - 1) ? 0.5 : 0;  
                },
                hLineColor: function (i, node) {
                    return '#d3d3d3';  
                }
            }
        });
    }
},
        {
            extend: 'print',
            customize: function (win) {
                // Remove previous Automart if exists in the print
                $(win.document.body).find('h5:contains("Automart")').remove();
                
                // Append 'Automart' and 'Expense Report' at the top of the print view
                $(win.document.body).prepend(`
                    <h5 class="text-center"><strong>Automart</strong></h5>
                    <p class="text-center"><strong>Expense Report</strong></p>
                `);

                // Append total amount to the bottom of the print view
                var totalAmount = $('#totalAmount').text();
                $(win.document.body).append('<div class="text-right"><strong>Total Amount: ' + totalAmount + '</strong></div>');
            }
        },
        'colvis'
    ],
               
    })



        // $('#preloader').modal('show');
        // $("#ajaxLoad").load("./expenseReportAjax/" + fromDate + "/" + toDate  + "/" + cat + "/" + subCat, function(responseTxt, statusTxt, xhr){
        //     if(statusTxt == "success"){
        //         $('#preloader').modal('hide');
        //     }
        //     else if(statusTxt == "error"){
        //         $('#preloader').modal('hide');
        //         alertify.error('Something went wrong');
        //     };
           
        // });
    }


    // function ajaxCall() {
    //     var fromDate    = $('#fromDate').val();
    //     var toDate      = $('#toDate').val();
    //     var cat         = $("#cost_cat_id").val();
    //     var subCat      = $("#cost_subcat_id").val();
    //     console.log(fromDate,toDate, cat, subCat);

    //     $('#preloader').modal('show');
    //     $("#ajaxLoad").load("./expenseReportAjax/" + fromDate + "/" + toDate  + "/" + cat + "/" + subCat, function(responseTxt, statusTxt, xhr){
    //         if(statusTxt == "success"){
    //             $('#preloader').modal('hide');
    //         }
    //         else if(statusTxt == "error"){
    //             $('#preloader').modal('hide');
    //             alertify.error('Something went wrong');
    //         };
           
    //     });
    // }


    function getCostSubCategories(){
        var id = $('#cost_cat_id').val();

        $.ajax({
            type: 'post',
            url: '{{ url('getCostSubcatBycatAjax')}}',
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
                    $('#cost_subcat_id').empty();
                    $('#cost_subcat_id').append(html);
                    $("#cost_subcat_id").prop("disabled", false);
                    
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
