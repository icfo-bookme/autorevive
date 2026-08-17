<div class="modal-dialog">
    <div class="modal-content animated flipInX">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title" style="font-size: 18px;">Update Template</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="smsTemplateUpdateForm" method="post">
                @csrf
                <input type="hidden" name="template_id" value="{{$smsTemplateData->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="template-name">Template Name</label>
                        <input type="text" class="form-control" name="name" 
                            value="{{empty($smsTemplateData->name) ? null : $smsTemplateData->name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="template-body">Template Body</label>
                        <textarea cols="8" rows="10" class="form-control" name="body" required>{{empty($smsTemplateData->body) ? null : $smsTemplateData->body}}</textarea>
                    </div>
                </div>
        <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save changes </button>
            {{-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> --}}
        </div>
        </form>
    </div>
</div>
