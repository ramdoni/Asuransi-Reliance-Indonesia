@section('title', $data->no_voucher)
@section('parentPageTitle', 'Journal')
<div class="clearfix row">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="saveToJournal">
                    <div class="row">
                        <div class="pr-6 col-md-4">
                            <table class="table pl-0 mb-0 table-striped">
                                <tr>
                                    <th>{{ __('Voucher Number')}}</th>
                                    <td>{{$data->no_voucher}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Voucher Date')}}</th>
                                    <td>{{date('d M Y',strtotime($data->created_at))}}</td>
                                </tr>
                                @if(isset($uw))
                                <tr>
                                    <th>{{ __('Policy Number / Policy Holder')}}</th>
                                    <td>{{$uw->pemegang_polis}}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="mt-3 form-group table-responsive">
                        <table class="table pl-0 mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coas as $item)
                                <tr>
                                    <td>{{$item->coa->name}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{format_idr($item->debit)}}</td>
                                    <td>{{format_idr($item->kredit)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($is_reclass)
                        <br />
                        <h5>Reclassification</h5>
                        <table class="table pl-0 mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th></th>
                                </tr>
                            </thead>
                                    @foreach($count_account as $k => $form)
                                    <tr>
                                        <td style="width:40%;">
                                            <div>
                                                <select class="form-control select2" id="coa_id.{{$k}}" wire:model="coa_id.{{$k}}" {{$is_readonly?'disabled':''}} wire:change="setNoVoucher({{$k}})">
                                                    <option value=""> --- Account -- </option>
                                                    @foreach(\App\Models\CoaGroup::orderBy('name','ASC')->get() as $group)
                                                        <optgroup label="{{$group->name}}">
                                                            @foreach(\App\Models\Coa::where('coa_group_id',$group->id)->orderBy('name','ASC')->get() as $i)
                                                            <option value="{{$i->id}}">{{$i->name}} / {{$i->code}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                                @error("coa_id.".$k)
                                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" {{$is_readonly?'disabled':''}} wire:model="description_coa.{{$k}}" />
                                        </td>
                                        <td style="width:10%;">
                                            <input type="text" class="form-control format_number" wire:model="debit.{{$k}}" {{$is_readonly?'disabled':''}} wire:input="sumDebit" />
                                            @error("debit.{{$k}}")
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                            @enderror
                                        </td>
                                        <td style="width:10%;"> 
                                            <input type="text" class="form-control format_number" wire:model="kredit.{{$k}}" {{$is_readonly?'disabled':''}} wire:input="sumKredit" />
                                            @error("kredit.{{$k}}")
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                            @enderror
                                        </td>
                                        <td>
                                            @if(!$is_readonly)
                                                @if($k!=0)<a href="javascript:void(0)" wire:click="deleteAccountForm({{$k}})" class="text-danger"><i class="fa fa-trash"></i></a>@endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <hr>
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @if($is_reclass)
                    <button type="button" class="ml-3 btn btn-danger" wire:click="cancel_reclass">{{__('Cancel')}}</button>
                    <button type="submit" {{!$is_submit_journal?'disabled':''}} class="ml-3 btn btn-warning"><i class="fa fa-save"></i> {{ __('Submit to Journal') }}</button>
                    @else
                    <button type="button" class="ml-3 btn btn-info" wire:click="reclass">{{ __('Reclassification') }}</button>
                    @endif
                </form> 
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
<script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
<script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
<style>
    .select2-container .select2-selection--single {height:36px;}
    .select2-container .select2-selection--single .select2-selection__rendered{padding-top:3px;}
    .select2-container--default .select2-selection--single .select2-selection__arrow{top:4px;right:10px;}
    .select2-container {width: 100% !important;}
</style>
@endpush
@section('page-script')

document.addEventListener("livewire:load", () => {
		init_form();
    });
    Livewire.on('changeForm', () =>{
        setTimeout(function(){
            init_form();
        },500);
    });
    function init_form(){
        $('.format_number').priceFormat({
            prefix: '',
            centsSeparator: '.',
            thousandsSeparator: '.',
            centsLimit: 0
        });
        $('.select2').each(function(){
            var select__2 = $(this).select2();
            $(this).on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });
            var selected__ = $(this).find(':selected').val();
            if(selected__ !="") select__2.val(selected__);
        });
    }
@endsection