<div wire:ignore.self class="modal fade" id="modal_upload_claim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form wire:submit.prevent="save">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Upload Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Type Data</label>
                        <select class="form-control" wire:model="type_data">
                            <option value=""> -- Select -- </option>
                            <option value="1">New Data</option>
                            <option value="2">Old Data</option>
                        </select>
                        @error('line_bussines')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Line Bussines</label>
                        <select class="form-control" wire:model="line_bussines">
                            <option value=""> -- Select -- </option>
                            @foreach(config('vars.line_bussines') as $k => $item)
                                <option>{{$item}}</option>
                            @endforeach
                        </select>
                        @error('line_bussines')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" class="form-control" name="file" wire:model="file" />
                        @error('file')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                        <a href="{{asset('template/claim.xlsx')}}"><i class="fa fa-download"></i> Download Template</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info close-modal"><i class="fa fa-upload"></i> Upload</button>
                </div>
                <div wire:loading>
                    <div class="page-loader-wrapper" style="display:block">
                        <div class="loader" style="display:block">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                            <p>Please wait...</p>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>