<div class="modal-dialog">
    <div class="modal-content animated flipInX">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title" style="font-size: 18px;">Edit Fund</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="fundUpdateForm" method="post">
            @csrf
            <input type="hidden" name="fund_insert_id" value="{{$fundData->id}}">
            <div class="modal-body">
                <label for="input-1">Category Name</label>
                <select class="form-control" name="category_id" id="categoryIdUpdate">
                    <option selected disabled value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{$category->id == $fundData->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="form-group">
                    <label for="input-1">Sub Category Name</label>
                    <select class="form-control" name="subcategory_id" id="subcategories-section-update">
                        <option selected disabled value="">Select sub category</option>
                        @foreach($fundSubCategories as $subcategory)
                            <option value="{{$subcategory->id}}" {{$subcategory->id == $fundData->subcategory_id ? 'selected' : ''}}>{{$subcategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="input-1">Amount</label>
                    <input type="number" name="amount" class="form-control" placeholder="Enter fund amount" min="0" step="any" value="{{$fundData->amount}}">
                </div>
                <div class="form-group">
                    <label for="input-1">Date</label>
                    <input type="date" name="date" class="form-control" max="{{date('Y-m-d')}}" value="{{$fundData->date}}">
                </div>
                <div class="form-group">
                    <label for="input-1">Description (Option)</label>
                    <textarea name="description" id="" cols="8" rows="10" class="form-control" placeholder="Enter description...">{{$fundData->description}}</textarea>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
            </div>
        </form>
    </div>
</div>
