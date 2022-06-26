@section('title', 'Payable')
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
                                    <th>COA</th>
                                    <th>Description</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            @php($total=0)
                            @foreach($data->others_payment as $k => $item)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td wire:ignore>
                                        <select class="form-control select2_{{$k}}" id="coa_id.{{$k}}">
                                            <option value=""> --- Select --- </option>
                                            @foreach(\App\Models\Coa::where('is_others_expense',1)->groupBy('coa_group_id')->get() as $group)
                                                <optgroup label="{{isset($group->group->name) ? $group->group->name : ''}}">
                                                    @foreach(\App\Models\Coa::where(['is_others_expense'=>1,'coa_group_id'=>$group->coa_group_id])->get() as $coa)
                                                        <option value="{{$coa->id}}">{{$coa->name}} ({{$coa->code}})</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        @error('coa_id.'.$k)
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
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
                    @endif
                    <hr>
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="submit" class="ml-3 btn btn-primary"><i class="fa fa-save"></i> {{ __('Submit') }}</button>
                    <span wire:loading wire:target="save">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>
<div wire:ignore.self class="modal fade" id="modal_add_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <livewire:expense-others.add-bank />
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
        Livewire.on('emit-add-bank',()=>{
            $("#modal_add_bank").modal("hide");    
        });
        Livewire.on('init-form', () =>{
            init_form();
        });
        function init_form(){
            @foreach($data->others_payment as $k => $item)
                $(".select2_{{$k}}").select2();
                $('.select2_{{$k}}').on('select2:select', function (e) {
                    var data = e.params.data;
                    @this.set('coa_id.{{$k}}',data.id);
                    setTimeout(function(){
                        $('.select2_{{$k}}').select2().val(data.id).trigger("change")
                    },1000);
                });
            @endforeach

            // $(".select_transaction_type").each(function(){
            //     $(this).select2();
            //     $(this).on('change', function (e) {
            //         let elementName = $(this).attr('id');
            //         var data = $(this).select2("val");
            //         @this.set(elementName, data);
            //         console.error(data);
            //         $(this).val(dt).trigger("change");
            //     });

                // var selected_transaction_type = $(this).find(':selected').val();
                // setTimeout(function(){
                //     if(selected_transaction_type !="") {
                //         $(this).val(selected_transaction_type).trigger("change");
                //         console.error('Change coa : '+selected_transaction_type);
                //     }
                // }, 1000);
            // });
            
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