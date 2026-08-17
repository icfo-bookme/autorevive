<div class="modal-dialog">
    <div class="modal-content animated flipInX">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title" style="font-size: 18px;">Update Investment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="reinvestmentUpdateForm" method="post">
                @csrf
                <input type="hidden" name="reinvestment_id" value="{{$reinvestmentData->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-1">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter reinvestment amount" min="0" step="any" value="{{$reinvestmentData->amount}}">
                    </div>
                    <div class="form-group">
                        <label for="input-1">Date</label>
                        <input type="date" name="date" class="form-control" max="{{date('Y-m-d')}}" value="{{$reinvestmentData->date}}">
                    </div>
                    <div class="form-group">
                        <label for="input-1">Description</label>
                        <textarea name="description" id="" cols="8" rows="10" class="form-control" placeholder="Enter description...">{{$reinvestmentData->description}}</textarea>
                    </div>
                </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save changes </button>
        </div>
        </form>
    </div>
</div>
