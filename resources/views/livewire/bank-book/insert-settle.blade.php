<div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
        <form wire:submit.prevent="save">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Settle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <table class="table table-bordered">
                        <tr style="background:#eee">
                            <th>No Voucher</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        @php($total=0)
                        @foreach($bank_book_id as $item)
                            <tr>
                                <td>{{$item->no_voucher}}</td>
                                <td class="text-right">{{format_idr($item->amount)}}</td>
                            </tr>
                            @php($total +=$item->amount)
                        @endforeach
                        <tr style="background:#eee">
                            <th>Total</th>
                            <th class="text-right">{{format_idr($total)}}</th>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" wire:model="type">
                        <option value="">-- select --</option>
                        <option>Premium Receivable</option>
                        <option>Reinsurance Premium</option>
                        <option>Recovery Claim</option>
                        <option>Recovery Refund</option>
                    </select>
                    @error('type')
                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                    @enderror
                </div>
                @if($type=='Premium Receivable')
                    <div class="form-group">
                        <label>Debit Note / Kwitansi</label>
                        <select class="form-control" id="select-premi">
                            <option value="">-- select --</option>
                            @foreach($premium_receivable as $item)
                                <option value="{{$item->id}}">{{$item->reference_no}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
    </div>
</div>