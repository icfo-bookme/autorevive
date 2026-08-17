<div class="modal-dialog">
    <div class="modal-content animated flipInX">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title" style="font-size: 18px;">Edit Draft</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="draftUpdateForm" method="post">
            @csrf
            <input type="hidden" name="draft_id" value="{{$draftData->id}}">
            <div class="modal-body">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" class="form-control"min="0" step="any" value="{{$draftData->amount}}">
                </div>
                <div class="form-group">
                    <label for="note">Note (Option)</label>
                    <textarea name="note" id="" cols="8" rows="10" class="form-control" placeholder="Enter note...">{{$draftData->note}}</textarea>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
            </div>
        </form>
    </div>
</div>
