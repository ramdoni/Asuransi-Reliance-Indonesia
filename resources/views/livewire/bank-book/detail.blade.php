<div class="tab-pane {{$active?'show active':''}}" wire:ignore.self id="bank-{{$data->id}}" x-data="{ insert:false }">
    <div class="row mb-2">
        <div class="col-md-1">
            <select class="form-control" wire:model="filter_type">
                <option value=""> - Type - </option>
                <option value="P">P - Payable</option>
                <option value="R">R - Receivable</option>
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" class="form-control" wire:model="filter_amount" placeholder="Amount" />
        </div>
        <div class="col-md-9">
            <a href="javascript:void(0)" class="btn btn-info" @click="insert = true"><i class="fa fa-plus"></i></a>
            <span wire:loading wire:target="save">
                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                <span class="sr-only">{{ __('Loading...') }}</span>
            </span>
        </div>
    </div>
    <div class="mt-3">
        <span class="alert alert-info" title="Unidentity" wire:click="$set('status',0)">Unidentity : {{$total_unidentity}}</span> 
        <span class="alert alert-info" title="Unidentity" wire:click="$set('status',1)">Settle : {{$total_settle}}</span> 
        <span class="alert alert-info" title="Opening Balance">Opening Balance : {{format_idr($opening_balance)}}</span>
        <span class="alert alert-info" title="Payable">Payable : {{format_idr($total_payable)}}</span>
        <span class="alert alert-success" title="Receivable">Receivable : {{format_idr($total_receivable)}}</span>
        <span class="alert alert-secondary" title="Balance">Balance : {{format_idr($total)}}</span> 
    </div>
    <div class="table-responsive">
        <table class="table table-striped m-b-0 c_list mt-3">
            <thead>
                <tr x-show="insert" @click.away="insert = false" style="background:#d4edda">
                    <td></td>
                    <td>{{$generate_no_voucher}}</td>
                    <td>{{date('d-M-Y')}}</td>
                    <td>
                        <select class="form-control" wire:model="type">
                            <option value=""> -- Type -- </option>
                            <option value="R">R - Receivable</option>
                            <option value="P">P - Payable</option>
                        </select>
                        @error('type')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </td>
                    <td>
                        <select class="form-control" wire:model="to_bank_account_id">
                            <option value=""> -- Bank -- </option>
                            @foreach (\App\Models\BankAccount::where('is_client',1)->orderBy('owner','ASC')->get() as $bank)
                                <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                            @endforeach
                        </select>
                        @error('to_bank_account_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </td>
                    <td>
                        <input type="text" class="form-control" wire:model="amount" placeholder="Amount" wire:keydown.enter="save" />
                        @error('amount')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </td>
                    <td><input type="text" class="form-control" wire:model="note" placeholder="Note" wire:keydown.enter="save" /></td>
                    <td>
                        <a href="javascript:void(0)" wire:click="save" class="text-success"><i class="fa fa-save"></i></a>
                        <a href="javascript:void(0)" @click="insert = false" class="text-danger"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
            </thead>
        </table>
        <br />
        <table class="table table-striped m-b-0 c_list">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Voucher Number</th>
                    <th>Voucher Date</th>
                    <th>Aging</th>
                    <th>Status</th>
                    <th class="text-center">Type</th>
                    <th>From Bank Account</th>
                    <th>Amount</th>
                    <th>Note</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php($num=$lists->firstItem())
                @foreach($lists as $item)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$item->no_voucher}}</td>
                        <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                        <td>{{$item->date_pairing?calculate_aging($item->date_pairing):calculate_aging(date('Y-m-d',strtotime($item->created_at)))}}</td>
                        <td>
                            @if($item->status==0)
                                <span class="badge badge-warning">Unidentity</span>
                            @else
                                <span class="badge badge-success">Settle</span>
                            @endif
                        </td>
                        <td class="text-center">{{$item->type}}</td>
                        <td>{{isset($item->to_bank->no_rekening) ? $item->to_bank->no_rekening .'- '.$item->to_bank->bank.' an '. $item->to_bank->owner : '-'}}</td>
                        <td>{{format_idr($item->amount)}}</td>
                        <td>{{$item->note}}</td>
                        <td></td>
                    </tr>
                    @php($num++)
                @endforeach
            </tbody>
        </table>
    </div>
</div>