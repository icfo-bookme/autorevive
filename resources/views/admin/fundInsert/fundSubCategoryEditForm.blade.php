<div class="modal-dialog">
    <div class="modal-content animated flipInX">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title" style="font-size: 18px;">Update Sub-Category</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="fundSubCategoryUpdateForm" method="post">
                @csrf
                <input type="hidden" name="subcategory_id" value="{{$subCategoryData->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-1">Category Name</label>
                        <select class="form-control" name="category_id">
                            <option selected disabled value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{$category->id == $subCategoryData->category_id ? 'selected':''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-1">Sub Category Name</label>
                        <input type="text" class="form-control" placeholder="Sub Category Name" name="name" value="{{empty($subCategoryData->name) ? null : $subCategoryData->name}}"
                               required>
                    </div>
                </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                changes</button>
        </div>
        </form>
    </div>
</div>
