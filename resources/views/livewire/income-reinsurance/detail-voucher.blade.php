<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> 
                @if(isset($data->id))
                    {{$data->reference_no}}
                @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true close-btn">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover m-b-0 c_list">
                    <thead>
                        <tr>     
                            <th>No</th>
                            <th>No Voucher</th>
                            <th>Voucher Date</th>
                            <th>Settle Date</th>
                            <th>Payment Date</th>
                            <th class="text-right">Amount</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data->bank_books_direct))
                            @foreach($data->bank_books_direct as $k => $bank)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$bank->no_voucher}}</td>
                                    <td>{{date('d-M-Y',strtotime($bank->created_at))}}</td>
                                    <td>{{date('d-M-Y',strtotime($bank->created_at))}}</td>
                                    <td>{{date('d-M-Y',strtotime($bank->payment_date))}}</td>
                                    <td class="text-right">{{isset($bank->item()->where('transaction_id',$data->id)->first()->amount)?format_idr($bank->item()->where('transaction_id',$data->id)->first()->amount) : 0}}</td>
                                    <td>{{$bank->note}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span wire:loading>
                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    <span class="sr-only">{{ __('Loading...') }}</span>
                </span>
            </div>
        </div>
    </div>
</div>