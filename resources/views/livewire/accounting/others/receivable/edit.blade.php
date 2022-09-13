@section('title', 'Receivable')
@section('parentPageTitle', "Transaction Number : {$data->reference_no}")
<div class="clearfix row">
    <div class="col-md-7">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save()">
                    @if(isset($data->others_payment))
                        <table class="table">
                            <thead>
                                <tr style="background: #eee;">
                                    <th style="width:10px">No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            @php($total=0)
                            @foreach($data->others_payment as $k => $item)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$item->transaction_date ? date('d-F-Y',strtotime($item->transaction_date)) : '-'}}</td>
                                    <td>{{$item->description}}</td>
                                    <td class="text-right">{{format_idr($item->payment_amount)}}</td>
                                </tr>
                                @php($total+= $item->payment_amount)
                            @endforeach
                            <tr  style="background: #eee;">
                                <th></th>
                                <th></th>
                                <th class="text-right">Total</th>
                                <th class="text-right">{{format_idr($total)}}</th>
                            </tr>
                        </table>
                        <table class="table">
                            <thead>
                                <tr style="background: #eee;">
                                    <th style="width:10px">No</th>
                                    <th>COA</th>
                                    <th>Description</th>
                                    <th class="text-right">Debit</th>
                                    <th class="text-right">Credit</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($num=1)
                                @foreach($data->income_other_coa as $k => $item_other)
                                    <tr>
                                        <td>{{$num}}</td>
                                        <td>
                                            <div wire:ignore>
                                                <select class="form-control select2" wire:model="coa_id_temp.{{$k}}">
                                                    <option value=""> --- Select --- </option>
                                                    @foreach($coa_groups as $group)
                                                        <optgroup label="{{isset($group->name) ? $group->name : ''}}">
                                                            @foreach($group->coa as $coa)
                                                                <option value="{{$coa->id}}">{{$coa->name}} ({{$coa->code}})</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('coa_id_temp.'.$k)
                                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="description_temp.{{$k}}" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-right" wire:model="debit_temp.{{$k}}" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-right" wire:model="kredit_temp.{{$k}}" />
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" wire:loading.remove wire:target="delete_temp({{$k}})" wire:click="delete_temp({{$k}})" class="text-danger"><i class="fa fa-trash"></i></a>
                                            <span wire:loading wire:target="delete_temp({{$k}})">
                                                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                                <span class="sr-only">{{ __('Loading...') }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                    @php($num++)
                                @endforeach
                                @foreach($add_coas as $k => $item)
                                    <tr>
                                        <td>{{$num}}</td>
                                        <td>
                                            <div wire:ignore>
                                                <select class="form-control select2" id="coa_id.{{$k}}">
                                                    <option value=""> --- Select --- </option>
                                                    @foreach($coa_groups as $group)
                                                        <optgroup label="{{isset($group->name) ? $group->name : ''}}">
                                                            @foreach($group->coa as $coa)
                                                                <option value="{{$coa->id}}">{{$coa->name}} ({{$coa->code}})</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('coa_id.'.$k)
                                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="description.{{$k}}" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-right" wire:model="debit.{{$k}}" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control text-right" wire:model="kredit.{{$k}}" />
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" wire:loading.remove wire:target="delete({{$k}})" wire:click="delete({{$k}})" class="text-danger"><i class="fa fa-trash"></i></a>
                                            <span wire:loading wire:target="delete({{$k}})">
                                                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                                <span class="sr-only">{{ __('Loading...') }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                    @php($num++)
                                @endforeach
                                <tfoot style="background: #eee;">
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th class="text-right">{{format_idr($total_debit)}}</th>
                                        <th class="text-right">{{format_idr($total_kredit)}}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <span wire:loading wire:target="add">
                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                            <span class="sr-only">{{ __('Loading...') }}</span>
                                        </span>
                                        <a href="javascript:void(0)" wire:loading.remove wire:target="add" wire:click="add"><i class="fa fa-plus"></i> Add</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                    <hr>
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @if($data->status==0)
                        <a href="javascript:void(0)" wire:click="save_as_draft" class="ml-3 btn btn-warning">Save as Draft</a>
                        <button type="submit" class="ml-2 btn btn-primary"><i class="fa fa-save"></i> {{ __('Submit') }}</button>
                    @endif
                    <span wire:loading wire:target="save">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <style>
        .select2-container .select2-selection--single {height:36px;padding-left:10px;}
        .select2-container .select2-selection--single .select2-selection__rendered{padding-top:3px;}
        .select2-container--default .select2-selection--single .select2-selection__arrow{top:4px;right:10px;}
        .select2-container {width: 100% !important;}
    </style>
    <script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
    <script>
        Livewire.on('init-form', () =>{
            init_form();
        });
        function init_form(){
            $(".select2").each(function(k,v){
                var select_ = $(this);
                var id = $(this).attr('id');

                select_.select2();
                select_.on('select2:select', function (e) {
                    var data = e.params.data;
                    @this.set(id,data.id);
                    setTimeout(function(){
                        select_.select2().val(data.id).trigger("change")
                    },1000);
                });
            });
            
            $('.format_number').priceFormat({
                prefix: '',
                centsSeparator: '.',
                thousandsSeparator: '.',
                centsLimit: 0
            });
            
            select__2 = $('.to_bank_account').select2();
            $('.to_bank_account').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });
            var selected__ = $('.to_bank_account').find(':selected').val();
            if(selected__ !="") select__2.val(selected__);
        }   
        setTimeout(function(){
            init_form()
        })
    </script>
@endpush