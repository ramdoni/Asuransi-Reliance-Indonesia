<div class="modal-content">
    <div class="modal-body">
        @if(isset($voucher->no_voucher))
            <p>
                No Voucher : <label class="mb-0">{{isset($voucher->no_voucher)?$voucher->no_voucher:'-'}}</label><br />
                Payment Date : {{date('d-M-Y',strtotime($voucher->created_at))}}<br />
                <span>{{isset($voucher->from_bank->no_rekening) ? $voucher->from_bank->no_rekening .'- '.$voucher->from_bank->bank.' an '. $voucher->from_bank->owner : '-'}}</sp>
            </p>    
            <span class="alert alert-info">Amount : {{format_idr($voucher->amount)}}</span>
            <span class="alert alert-success">Balance Usage : {{format_idr($voucher->balance_usage)}}</span>
            <span class="alert alert-warning">Balance Remain : {{format_idr($voucher->balance_remain)}}</span>
        @endif
    </div>
    <form wire:submit.prevent="save">
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover m-b-0 c_list">
                    <thead>
                        <tr>     
                            <th>No</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Debit Note / Kwitansi</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $item)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$item->transaction_table}}</td>
                            <td>{{date('d-M-Y',strtotime($item->created_at))}}</td>
                            <td>{{$item->no_debit_note}}</td>
                            <td class="text-right">{{format_idr($item->amount)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>