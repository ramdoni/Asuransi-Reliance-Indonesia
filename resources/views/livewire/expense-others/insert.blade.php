@section('title', 'Others Expense')
@section('parentPageTitle', 'Expense')
<div class="clearfix row">
    <div class="col-md-7">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="row">
                        <div class="pr-5 col-md-6">
                            <div class="px-0 form-group col-md-12">
                                <label>{{ __('Voucher Number') }}<small>(Generate Automatic)</small></label>
                                <input type="text" class="form-control" wire:model="no_voucher" readonly >
                                @error('no_voucher')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                            <div class="px-0 form-group col-md-12">
                                <label>{{ __('Recipient') }}</label>
                                <input type="text" class="form-control" wire:model="recipient" />
                                @error('recipient')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                            <div class="px-0 form-group col-md-12">
                                <label>{{ __('Reference Type') }}</label>
                                <select class="form-control" wire:model="reference_type">
                                    <option value=""> --- Select --- </option>
                                    <option>Invoice</option>
                                    <option>Debit Note</option>
                                    <option>Credit Note</option>
                                    <option>Othes</option>
                                </select>
                                @error('reference_type')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                            <div class="px-0 form-group col-md-12">
                                <label>{{ __('Reference No') }}</label>
                                <input type="text" class="form-control" wire:model="reference_no" />
                                @error('reference_no')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('Reference Date') }} *<small>{{__('Default today')}}</small></label>
                                <input type="date" class="form-control" wire:model="reference_date" />
                                @error('reference_date')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Amount (Rp)') }}</label>
                                <input type="text" class="form-control format_number" wire:model="nominal" wire:input="calculate" />
                                @error('nominal')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('Payment Type') }}</label>
                                <select class="form-control" wire:model="payment_type">
                                    <option value=""> --- Cash / Transfer --- </option>
                                    @foreach (\App\Models\BankAccount::orderBy('bank','ASC')->get() as $bank)
                                        <option value="{{ $bank->id}}">{{ $bank->no_rekening}} ({{ $bank->bank}})</option>
                                    @endforeach
                                </select>
                                @error('payment_type')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('Payment Date') }} *<small>{{__('Default today')}}</small></label>
                                <input type="date" class="form-control" {{$is_readonly?'disabled':''}} wire:model="payment_date" />
                                @error('payment_date')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                            <div class="px-0 form-group col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" wire:model="description" placeholder="Description"></textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('Payment Amount') }} <br/> <span class="btn btn-outline-success">{{format_idr($total_payment_amount)}}</span></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('Outstanding Balance') }} <br/> <span class="btn btn-outline-danger">{{$outstanding_balance}}</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Transaction Type') }}</label>
                                <select class="form-control" wire:model="transaction_type">
                                    <option value=""> --- Select --- </option>
                                    <option value="318">Office Rent-Vehicles</option>
                                    <option value="319">Other Rent-Office</option>
                                    <option value="320">Electricity, Telephone And Water - Office</option>
                                    <option value="334">Electricity, Telephone And Water - Investment</option>
                                    <option value="321">Maintenance Of Rent Office</option>
                                    <option value="322">Maintenance Of Rent Vehicles</option>
                                    <option value="323">System & web Expenses</option>
                                    <option value="342">Jasa Giro</option>
                                    <option value="346">Gain/Loss On Sale Of Fixed Assets</option>
                                    <option value="347">Bank Charges</option>
                                    <option value="296">Salary Expenses</option>
                                    <option value="297">Insurance Expenses - Health</option>
                                    <option value="298">Insurance Expenses - Vehicles</option>
                                    <option value="299">Medical Expenses</option>
                                    <option value="300">Jamsostek</option>
                                    <option value="301">Annual Bonus</option>
                                    <option value="302">PPH 21 Expenses</option>
                                    <option value="303">PPH 25 Expenses</option>
                                    <option value="304">Training Expenses</option>
                                    <option value="305">Post Employeement Benefit</option>
                                    <option value="306">Social Contribution</option>
                                    <option value="307">House Rent</option>
                                    <option value="330">Photocopy, Stamp Duties, Postage, etc</option>
                                    <option value="331">Other Office Expenses</option>
                                    <option value="348">Other Expenses</option>
                                </select>
                                @error('payment_amount')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Payment Amount (Rp)') }}</label>
                                <input type="text" {{$is_readonly?'disabled':''}} class="form-control format_number" wire:model="payment_amount" wire:input="calculate" />
                                @error('payment_amount')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{ __('Description') }}</label>
                                <input type="text" class="form-control" wire:model="description_payment" />
                            </div>
                        </div>
                    </div>
                    @foreach($add_payment as $k => $item)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Transaction Type') }}</label>
                                <select class="form-control" wire:model="add_payment_transaction_type.{{$k}}">
                                    <option value=""> --- Select --- </option>
                                    <option value="318">Office Rent-Vehicles</option>
                                    <option value="319">Other Rent-Office</option>
                                    <option value="320">Electricity, Telephone And Water - Office</option>
                                    <option value="334">Electricity, Telephone And Water - Investment</option>
                                    <option value="321">Maintenance Of Rent Office</option>
                                    <option value="322">Maintenance Of Rent Vehicles</option>
                                    <option value="323">System & web Expenses</option>
                                    <option value="342">Jasa Giro</option>
                                    <option value="346">Gain/Loss On Sale Of Fixed Assets</option>
                                    <option value="347">Bank Charges</option>
                                    <option value="296">Salary Expenses</option>
                                    <option value="297">Insurance Expenses - Health</option>
                                    <option value="298">Insurance Expenses - Vehicles</option>
                                    <option value="299">Medical Expenses</option>
                                    <option value="300">Jamsostek</option>
                                    <option value="301">Annual Bonus</option>
                                    <option value="302">PPH 21 Expenses</option>
                                    <option value="303">PPH 25 Expenses</option>
                                    <option value="304">Training Expenses</option>
                                    <option value="305">Post Employeement Benefit</option>
                                    <option value="306">Social Contribution</option>
                                    <option value="307">House Rent</option>
                                    <option value="330">Photocopy, Stamp Duties, Postage, etc</option>
                                    <option value="331">Other Office Expenses</option>
                                    <option value="348">Other Expenses</option>
                                </select>
                                @error('add_payment_transaction_type.'.$k)
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Payment Amount (Rp)') }}</label>
                                <input type="text" {{$is_readonly?'disabled':''}} class="form-control format_number" wire:model="add_payment_amount.{{$k}}" wire:input="calculate" />
                                @error('payment_amount')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{ __('Description') }}</label>
                                <input type="text" class="form-control" wire:model="add_payment_description.{{$k}}" />
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <button type="button" class="btn btn-sm btn-info" wire:click="addPayment"><i class="fa fa-plus"></i> Payment</button>
                    <hr>
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @if($outstanding_balance==0 and $total_payment_amount!=0)
                    <button type="submit" class="ml-3 btn btn-primary"><i class="fa fa-save"></i> {{ __('Submit') }}</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
<script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
@endpush
@section('page-script')
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
    }
    setTimeout(function(){
        init_form()
    })
@endsection