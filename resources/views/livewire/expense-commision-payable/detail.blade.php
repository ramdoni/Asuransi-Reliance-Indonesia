@section('title', 'Commision Payable #'.$data->no_voucher)
@section('parentPageTitle', 'Expense')
<div class="clearfix row">
    <div class="col-md-7">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table pl-0 mb-0 table-striped">
                                <tr>
                                    <th>{{ __('Voucher Number')}}</th>
                                    <td>{{$data->no_voucher}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Voucher Date')}}</th>
                                    <td>{{date('d M Y',strtotime($data->created_at))}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Policy Number / Policy Holder')}}</th>
                                    <td>{{$data->recipient}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Debit Note / Kwitansi Number')}}</th>
                                    <td>{{$data->reference_no}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Reference Date')}}</th>
                                    <td>{{$data->reference_date}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Total Payment Amount')}}</th>
                                    <td>{{format_idr($payment_amount)}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Description')}}</th>
                                    <td>
                                        <textarea class="form-control" {{$is_readonly?'disabled':''}} wire:model="description"></textarea>
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
                                    <th>{{__('From Bank Account')}}</th>
                                    <td>
                                        <select class="form-control" wire:model="from_bank_account_id" {{$is_readonly?'disabled':''}}>
                                            <option value=""> --- {{__('Select')}} --- </option>
                                            @foreach (\App\Models\BankAccount::where('is_client',0)->orderBy('bank','ASC')->get() as $bank)
                                                <option value="{{ $bank->id}}">{{ $bank->no_rekening}} ({{ $bank->bank}} an {{$bank->owner}})</option>
                                            @endforeach
                                        </select>
                                        @error('from_bank_account_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{__('To Bank Account')}}</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <select class="form-control bank_account" id="bank_account_id" wire:model="bank_account_id" {{$is_readonly?'disabled':''}}>
                                                    <option value=""> --- {{__('Select')}} --- </option>
                                                    @foreach (\App\Models\BankAccount::where('is_client',1)->orderBy('owner','ASC')->get() as $bank)
                                                        <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                                                    @endforeach
                                                </select>
                                                @error('bank_account_id')
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
                                    <th>{{__('Bank Charges')}}</th>
                                    <td><input type="text" {{$is_readonly?'disabled':''}} class="form-control format_number col-md-6" wire:model="bank_charges" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @if(!$is_readonly)
                    <button type="submit" class="ml-3 btn btn-primary"><i class="fa fa-save"></i> {{ __('Submit') }}</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5 px-0">
        <div class="card mt-0">
            <div wire:loading style="position:absolute;right:0;">
                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
            <div class="body" style="max-height:700px;overflow-y:scroll">
                <h6 class="text-success">{{$data->reference_no}}</h6>
                <hr />
                <table class="table pl-0 mb-0 table-striped table-nowrap"> 
                    @foreach(\Illuminate\Support\Facades\Schema::getColumnListing('konven_komisi') as $column)
                    @if($column=='id' || $column=='created_at'||$column=='updated_at') @continue @endif
                    <tr>
                        <th style="width:40%;">{{ ucfirst($column) }}</th>
                        <td style="width:60%;">{{ in_array($column,['total_up','total_premi_gross','disc_pot_langsung','premi_netto_yg_dibayarkan','perkalian_biaya_penutupan','fee_base','biaya_fee_base']) ? format_idr($data->komisi->$column) : $data->komisi->$column }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<div wire:ignore.self class="modal fade" id="modal_add_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <livewire:expense-commision-payable.add-bank />
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
    document.addEventListener("livewire:load", () => {
        init_form();
    });
    Livewire.on('changeForm', () =>{
        setTimeout(function(){
            init_form();
        },500);
    });
    var select__2;
    function init_form(){
        $('.format_number').priceFormat({
            prefix: '',
            centsSeparator: '.',
            thousandsSeparator: '.',
            centsLimit: 0
        });
        select__2 = $('.bank_account').select2({
            placeholder: ' --- {{__('Select')}} --- ',
        });
        $('.bank_account').on('change', function (e) {
            let elementName = $(this).attr('id');
            var data = $(this).select2("val");
            @this.set(elementName, data);
        });
        var selected__ = $('.bank_account').find(':selected').val();
        if(selected__ !="") select__2.val(selected__);
    }
    Livewire.on('init-form',()=>{
        init_form();
    });
    Livewire.on('emit-add-bank',id=>{
        $("#modal_add_bank").modal('hide');
        select__2.val(id);
    })
@endsection