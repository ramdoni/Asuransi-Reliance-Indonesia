@section('title', $data->debit_note)
@section('parentPageTitle', 'Income')
<div class="clearfix row">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>{{ __('No Voucher') }}</label>
                            <input type="text" class="form-control" readonly wire:model="no_voucher" >
                            @error('code')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <label>{{ __('Date') }}</label>
                            <input type="date" class="form-control" wire:model="no_voucher" >
                            @error('code')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('Rekening Bank') }}</label>
                            <select class="form-control" wire:model="rekening_bank_id">
                                <option value=""> --- Select --- </option>
                                @foreach(\App\Models\BankAccount::orderBy('bank','ASC')->get() as $i)
                                <option value="{{ $i->id}}">{{$i->bank}} - {{$i->no_rekening}} - {{$i->owner}}</option>
                                @endforeach
                            </select>
                            @error('code')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($count_account as $k => $form)
                                <tr>
                                    <td style="width:40%;">
                                        <select class="form-control" wire:model="">
                                            <option value=""> --- Account -- </option>
                                            @foreach(\App\Models\Coa::orderBy('name','ASC')->get() as $i)
                                            <option value="{{$i->id}}">{{$i->name}} / {{$i->code}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" />
                                    </td>
                                    <td style="width:20%;">
                                        <input type="text" class="form-control" />
                                    </td>
                                    <td>
                                        @if($k>0)
                                        <a href="javascript:void(0)" wire:click="deleteAccountForm({{$k}})" class="text-danger"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th class="text-right" colspan="2">Received Amount</th>
                                    <th>{{$amount}}</th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="2">Outstanding Balance</th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                        <p><a href="javascrip:void(0)" class="btn btn-info" wire:click="addAccountForm"><i class="fa fa-plus"></i> Account</a></p>
                    </div>
                    <hr>
                    <a href="{{route('account-receivable')}}"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="submit" class="ml-3 btn btn-primary"><i class="fa fa-save"></i> {{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>