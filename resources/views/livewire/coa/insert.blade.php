@section('title', __('COA Type'))
@section('parentPageTitle', 'Home')

<div class="row clearfix">
    <div class="col-md-4">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="form-group">
                        <label>{{ __('COA Group') }}</label>
                        <select class="form-control" wire:model="coa_group_id">
                            <option value=""> --- Select --- </option>
                            @foreach(\App\Models\CoaGroup::orderBy('name','ASC')->get() as $k =>$i)
                            <option value="{{$i->id}}">{{$i->name}} / {{$i->code}}</option>
                            @endforeach
                        </select>
                        @error('coa_group_id')
                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label>{{ __('Code') }}</label>
                            <input type="text" class="form-control" wire:model="code" >
                            @error('code')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>{{ __('Code Voucher') }}</label>
                            <input type="text" class="form-control"  wire:model="code_voucher" >
                            @error('code_voucher')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Account Name') }}</label>
                        <input type="text" class="form-control"  wire:model="name" >
                        @error('name')
                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('COA Type') }}</label>
                        <select class="form-control" wire:model="coa_type_id">
                            <option value=""> --- Select --- </option>
                            @foreach(\App\Models\CoaType::orderBy('name','ASC')->get() as $k =>$i)
                            <option value="{{$i->id}}">{{$i->name}}</option>
                            @endforeach
                        </select>
                        @error('coa_type_id')
                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        <textarea class="form-control" wire:model="description" style="height:100px;"></textarea>
                        @error('description')
                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </div>
                    <hr>
                    <a href="{{route('coa')}}"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="submit" class="btn btn-primary ml-3"><i class="fa fa-save"></i> {{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>