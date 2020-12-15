@section('title', 'Premium Receivable '.$data->no_voucher)
@section('parentPageTitle', 'Home')
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
                                    <td>{{$data->client}}</td>
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
                                    <th>{{ __('Total')}}</th>
                                    <td>{{format_idr($data->nominal)}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Outstanding Balance')}}</th>
                                    <td>{{$outstanding_balance}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Payment Amount (Rp)') }}</label>
                                <input type="text" {{$is_readonly?'disabled':''}} class="form-control format_number" wire:model="payment_amount" wire:input="calculate" />
                                @error('payment_amount')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Payment Date') }} *<small>Default today</small></label>
                                <input type="date" class="form-control" {{$is_readonly?'disabled':''}} wire:model="payment_date" />
                                @error('payment_date')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{ __('Bank Account') }}</label>
                                <select class="form-control" wire:model="bank_account_id" {{$is_readonly?'disabled':''}}>
                                    <option value=""> --- Select --- </option>
                                    @foreach (\App\Models\BankAccount::orderBy('bank','ASC')->get() as $bank)
                                        <option value="{{ $bank->id}}">{{ $bank->no_rekening}} ({{ $bank->bank}})</option>
                                    @endforeach
                                </select>
                                @error('bank_account_id')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @if(!$is_readonly)
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