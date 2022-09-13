<div class="body">
    <div class="mb-2 row">
        <div class="col-md-3">
            <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
        </div>
        <div class="col-md-7">
            <a href="javascript:;" class="btn btn-info" wire:click="downloadExcel"><i class="fa fa-download"></i> Download</a>
            <span wire:loading>
                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                <span class="sr-only">{{ __('Loading...') }}</span>
            </span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover m-b-0 c_list">
            <thead>
                <tr>
                    <th>No</th>                                    
                    <th>Status</th>                                          
                    <th>Created Date</th>                                    
                    <th>Transaction Date</th>                                    
                    <th>Payment Date</th>
                    <th>No Voucher</th>          
                    <th>Transaction Number</th>          
                    <th>Description</th>                    
                    <th>Amount</th>     
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $k => $item)
                <tr>
                    <td style="width: 50px;">{{$k+1}}</td>
                    <td>
                        <a href="#">
                            @if($item->status==0)
                                <span class="badge badge-warning">Draft</span>
                            @endif
                            @if($item->status==1)
                                <span class="badge badge-info">Unpaid</span>
                            @endif
                            @if($item->status==2)
                                <span class="badge badge-success">Settle</span>
                            @endif
                        </a>
                    </td>
                    <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                    <td>
                        @if(isset($item->others_payment))
                            {{implode(', ', $item->others_payment->pluck('transaction_date')->toArray())}}
                        @endif
                    </td>
                    <td>{{$item->payment_date ? date('d M Y', strtotime($item->payment_date)) : '-'}}</td>
                    <td>{{$item->no_voucher ? $item->no_voucher : '-'}}</td>
                    <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                    <td>
                        @if(isset($item->others_payment))
                            {{implode(', ', $item->others_payment->pluck('description')->toArray())}}
                        @endif
                    </td>
                    <td>{{isset($item->payment_amount) ? format_idr($item->payment_amount) : '-'}}</td>
                    <td>
                        @if($item->status==0)
                            <a href="{{route('accounting.others.receivable',$item->id)}}" class="badge badge-info badge-active"><i class="fa fa-edit"></i> Assign COA</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <br />
    {{$data->links()}}
</div>