<div class="modal-dialog modal-md">
    <div class="modal-content animated flipInX">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title" style="font-size: 18px;">Edit Cost</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="costUpdateForm" method="post">
            @csrf
            <input type="hidden" name="cost_insert_id" value="{{$costData->id}}">
            <div class="modal-body">
                <div class="form-group">
                    <label for="input-1">Category Name</label>
                    <select class="form-control" name="category_id" id="categoryIdUpdate">
                        <option selected disabled value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{$category->id == $costData->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="input-1">Sub Category Name</label>
                    <select class="form-control" name="subcategory_id" id="subcategories-section-update">
                        <option selected disabled value="">Select sub category</option>
                        @foreach($costSubCategories as $subcategory)
                            <option value="{{$subcategory->id}}" {{$subcategory->id == $costData->subcategory_id ? 'selected' : ''}}>{{$subcategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="input-1">Amount</label>
                    <input type="number" name="amount" class="form-control" placeholder="Enter cost amount" min="0" step="any" value="{{$costData->amount}}">
                </div>
                <div class="form-group">
                    <label for="input-1">Date</label>
                    <input type="date" name="date" class="form-control" max="{{date('Y-m-d')}}" value="{{$costData->date}}">
                </div>
                <div class="form-group">
                    <label for="input-1">Description (Option)</label>
                    <textarea name="description" id="" cols="8" rows="4" class="form-control" placeholder="Enter description...">{{$costData->description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="input-1">Reason <span style="color: red;">*</span></label>
                    <textarea name="reason" id="" cols="8" rows="4" class="form-control" placeholder="Enter Reason..."></textarea>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
            </div>
        </form>
    </div>
</div>
