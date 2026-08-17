{{--@include('partials.backend.header')--}}


<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;flex-direction: column;">
                    <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                        <div class="text-center">
                            <h6 style="margin: 0px">Automart</h6>
                            <h5><b>Physical Stock Count History</b></h5>
                        </div>
                    </div>
                    <div style="width: 80%; border: 1px dashed #dee2e6;"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="discrepancyReportTable" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Item Id</th>
                                    <th>Item Name</th>
                                    <th>Barcode</th>
                                    <th>Quantity</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                    <th>Creation Time</th>
                                    <th>Update Time</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($stockCountSheet as $stock)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$stock->id}}</td>
                                    <td>{{$stock->item_id}}</td>
                                    <td>{{$stock->item_name}}</td>
                                    <td>{{$stock->barcode}}</td>
                                    <td>{{$stock->quantity}}</td>
                                    <td>{{$stock->created_by}}</td>
                                    <td>{{$stock->updated_by}}</td>
                                    <td>{{$stock->created_at}}</td>
                                    <td>{{$stock->updated_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
