<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content animated flipInX">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title" style="font-size: 18px;">Cost Log</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table id="costlog" class="table table-bordered" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($final as $data)
                            <tr>
                                <td>{{$data->category->name}}</td>
                                <td>{{$data->subcategory->name}}</td>
                                <td>{{$data->amount}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->description}}</td>
                                <td>{{$data->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
