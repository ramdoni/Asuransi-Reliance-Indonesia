@section('title', 'Recovery Claim')
@section('parentPageTitle', 'Expense')
<div class="clearfix row">
    <div class="col-md-7">
        <div class="card">
            <div class="body">
                <form wire:submit.prevent="save">
                    <table class="table pl-0 mb-0 table-striped">
                        <tr>
                            <th>{{ __('Voucher Number') }}</th>
                            <td>
                                {{$no_voucher}}
                                <div class="float-right">
                                    <label class="fancy-radio">
                                        <input type="radio" value="1" wire:model="type" /> 
                                        <span><i></i>Konven</span>
                                    </label> 
                                    <label class="fancy-radio">
                                        <input type="radio" value="2" wire:model="type" />
                                        <span><i></i>Syariah</span>
                                    </label> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:35%">{{ __('Claim Payable') }}</th>
                            <td>
                                <div wire:ignore>
                                    <select class="form-control select_expense_id" wire:model="expense_id" id="expense_id">
                                        <option value=""> --- Select --- </option>
                                        @foreach(\App\Models\Expenses::where('reference_type','Claim')->get() as $item)
                                        <option value="{{$item->id}}">{{$item->no_voucher}} / {{$item->recipient}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('no_polis')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('Reference Date') }}</th>
                            <td>
                                <input type="date" class="form-control col-md-6" wire:model="reference_date" />
                                @error('reference_date')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </td>
                        </tr>
                        
                        <tr>
                            <th>{{ __('Reference No') }}</th>
                            <td>
                                <input type="text" class="form-control" wire:model="reference_no" />
                                @error('reference_no')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('Payment Amount')}}</th>
                            <td><input type="text" class="form-control format_number col-md-6" wire:model="payment_amount" /></td>
                        </tr>
                        {{-- <tr>
                            <th>{{ __('Outstanding Balance')}}</th>
                            <td>{{format_idr($this->outstanding_balance)}}</td>
                        </tr> --}}
                        <tr>
                            <th>{{__('From Bank Account')}}</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select class="form-control from_bank_account" id="from_bank_account_id" wire:model="from_bank_account_id" {{$is_readonly?'disabled':''}}>
                                            <option value=""> --- {{__('Select')}} --- </option>
                                            @foreach (\App\Models\BankAccount::where('is_client',1)->orderBy('owner','ASC')->get() as $bank)
                                                <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                                            @endforeach
                                        </select>
                                        @error('from_bank_account_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 px-0 pt-2">
                                        @if(!$is_readonly)
                                        <a href="#" data-toggle="modal" data-target="#modal_add_bank"><i class="fa fa-plus"></i> Add Bank</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>{{__('To Bank Account')}}</th>
                            <td>
                                <select class="form-control" wire:model="to_bank_account_id" {{$is_readonly?'disabled':''}}>
                                    <option value=""> --- {{__('Select')}} --- </option>
                                    @foreach (\App\Models\BankAccount::where('is_client',0)->orderBy('bank','ASC')->get() as $bank)
                                        <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                                    @endforeach
                                </select>
                                @error('bank_account_id')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>{{__('Payment Date')}}*<small>{{__('Default today')}}</small></th>
                            <td>
                                <input type="date" class="form-control col-md-6" {{$is_readonly?'disabled':''}} wire:model="payment_date" />
                                @error('payment_date')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </td>
                        </tr>
                        
                        <tr>
                            <th>{{__('Bank Charges')}}</th>
                            <td><input type="text" {{$is_readonly?'disabled':''}} class="form-control format_number col-md-6" wire:model="bank_charges" /></td>
                        </tr>
                        <tr>
                            <th>{{__('Description')}}</th>
                            <td>
                                <textarea style="height:100px;" class="form-control" wire:model="description"></textarea>
                            </td>
                        </tr>
                    </table>
                    <hr />
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="submit" class="ml-3 btn btn-primary" {{!$is_submit?'disabled':''}}><i class="fa fa-save"></i> {{ __('Submit') }}</button>
                    <div wire:loading>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="body">
                <table class="table table-striped table-hover m-b-0 c_list table-nowrap">
                    <tr>
                        <th>No Voucher</th>
                        <td>:</td>
                        <td>{!!isset($data->no_voucher) ? no_voucher($data) : ''!!}</td>
                    </tr>
                    <tr>
                        <th>Payment Date</th>
                        <td>:</td>
                        <td>{!!isset($data->payment_date) ? date('d-M-Y',strtotime($data->payment_date)) : ''!!}</td>
                    </tr>
                    <tr>
                        <th>Voucher Date</th>
                        <td>:</td>
                        <td>{!!isset($data->created_at) ? date('d-M-Y',strtotime($data->created_at)) : ''!!}</td>
                    </tr>
                    <tr>
                        <th>Debit Note / Kwitansi</th>
                        <td>:</td>
                        <td>{!!isset($data->reference_no) ? $data->reference_no : ''!!}</td>
                    </tr>
                    <tr>
                        <th>Policy Number / Policy Holder</th>
                        <td>:</td>
                        <td>{!!isset($data->recipient) ? $data->recipient : ''!!}</td>
                    </tr>
                    <tr>
                        <th>From Bank Account</th>
                        <td>:</td>
                        <td>{!!isset($data->from_bank_account->no_rekening) ? $item->from_bank_account->no_rekening .' - '.$item->from_bank_account->bank.' an '.$item->from_bank_account->owner : ''!!}</td>
                    </tr>
                    <tr>
                        <th>To Bank Account</th>
                        <td>:</td>
                        <td>{!!isset($data->bank_account->no_rekening) ? $item->bank_account->no_rekening .' - '.$item->bank_account->bank.' an '.$item->bank_account->owner : ''!!}</td>
                    </tr>
                    <tr>
                        <th>Bank Charges</th>
                        <td>:</td>
                        <td>{!!isset($data->bank_charges) ? format_idr($data->bank_charges) : ''!!}</td>
                    </tr>
                    <tr>
                        <th>Payment Amount</th>
                        <td>:</td>
                        <td>{!!isset($data->payment_amount) ? format_idr($data->payment_amount) : ''!!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div wire:ignore.self class="modal fade" id="modal_add_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <livewire:income-recovery-claim.add-bank />
    </div>
</div>
@push('after-scripts')
<script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
<script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
<style>
    .select2-container .select2-selection--single {height:36px;padding-left:10px;}
    .select2-container .select2-selection--single .select2-selection__rendered{padding-top:3px;}
    .select2-container--default .select2-selection--single .select2-selection__arrow{top:4px;right:10px;}
    .select2-container {width: 100% !important;}
</style>
@endpush
@section('page-script')
    Livewire.on('init-form', () =>{
        setTimeout(function(){
            init_form();
        },1500);
    });
    function init_form(){
        $('.format_number').priceFormat({
            prefix: '',
            centsSeparator: '.',
            thousandsSeparator: '.',
            centsLimit: 0
        });
        
        select__2 = $('.select_expense_id').select2();
        $('.select_expense_id').on('change', function (e) {
            let elementName = $(this).attr('id');
            var data = $(this).select2("val");
            @this.set(elementName, data);
        });
        var selected__ = $('.select_expense_id').find(':selected').val();
        if(selected__ !="") select__2.val(selected__);

        select_from_bank = $('.from_bank_account').select2();
        $('.from_bank_account').on('change', function (e) {
            let elementName = $(this).attr('id');
            var data = $(this).select2("val");
            @this.set(elementName, data);
        });
        var selected__from_bank = $('.from_bank_account').find(':selected').val();
        if(select_from_bank !="") select_from_bank.val(selected__from_bank);
        
        $('.select_to_bank').each(function(){
            select_to_bank = $(this).select2();
            $(this).on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });
            var selected_to_bank = $(this).find(':selected').val();
            if(selected_to_bank !="") select_to_bank.val(selected_to_bank);
        });
    }
    setTimeout(function(){
        init_form()
    })
@endsection