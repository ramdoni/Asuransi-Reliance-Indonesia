@section('title', 'Cancelation #'.$data->no_voucher)
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
                                    <th>{{ __('Total')}}</th>
                                    <td>{{format_idr($data->nominal)}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Bank Account')}}</th>
                                    <td>{{ isset($data->bank_account->no_rekening) ? $data->bank_account->no_rekening .' - '.$data->bank_account->bank.' an '.$data->bank_account->owner :'' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Payment Amount')}}</th>
                                    <td>
                                        <input type="text" class="form-control col-md-6 format_number" {{$is_readonly?'disabled':''}} wire:model="payment_amount" />
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <th>{{ __('Outstanding Balance')}}</th>
                                    <td>{{$outstanding_balance}}</td>
                                </tr> --}}
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
                            </table>
                        </div>
                    </div>
                    <hr />
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="submit" class="ml-3 btn btn-primary"><i class="fa fa-save"></i> {{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
<script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
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
    }
    setTimeout(function(){
        init_form()
    })
@endsection