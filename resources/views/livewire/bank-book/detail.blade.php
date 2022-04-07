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
                <tr x-show="insert" style="background:#d4edda">
                    <td></td>
                    <td>{{$generate_no_voucher}}</td>
                    <td>{{date('d-M-Y')}}</td>
                    <td>
                        <input type="date" class="form-control" wire:model="payment_date" />
                        @error('payment_date')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </td>
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
                        <input type="text" class="form-control text-right" wire:model="amount" placeholder="Amount" wire:keydown.enter="save" />
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
                    <th>Payment Date</th>
                    <th>Aging</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Type</th>
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
                        <td>
                            @livewire('bank-book.editable',['data'=> $item,'field'=>'payment_date'],key($item->id.time()))
                        </td>
                        <td>{{$item->date_pairing?calculate_aging($item->date_pairing):calculate_aging(date('Y-m-d',strtotime($item->created_at)))}}</td>
                        <td class="text-center">
                            @if($item->status==0)
                                <span class="badge badge-warning">Unidentity</span>
                            @else
                                <span class="badge badge-success">Settle</span>
                            @endif
                        </td>
                        <td class="text-center">@livewire('bank-book.editable',['data'=> $item,'field'=>'type'],key($item->id.time()))</td>
                        <td>@livewire('bank-book.editable',['data'=> $item,'field'=>'amount'],key($data->id+$item->id.time()))</td>
                        <td>@livewire('bank-book.editable',['data'=> $item,'field'=>'note'],key($data->id+$item->id.time()))</td>
                        <td>
                            @if($item->status==0)
                                <span wire:loading wire:target="delete({{$item->id}})">
                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    <span class="sr-only">{{ __('Loading...') }}</span>
                                </span>
                                <a href="javascript:void(0)" wire:loading.remove wire:target="delete" wire:click="delete({{$item->id}})" class="text-danger"><i class="fa fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                    @php($num++)
                @endforeach
            </tbody>
        </table>
        {{$lists->links()}}
    </div>
</div>
