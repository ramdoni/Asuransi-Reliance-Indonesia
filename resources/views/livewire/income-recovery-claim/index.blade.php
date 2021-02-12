@section('title', 'Recovery Claim')
@section('parentPageTitle', 'Income')

<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="mb-2 row">
                    <div class="col-md-2">
                        <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                    </div>
                    <div class="col-md-10">
                        <a href="{{route('income.recovery-claim.insert')}}" class="btn btn-info"><i class="fa fa-plus"></i> Recovery Claim</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>                                    
                                <th>Status</th>                                    
                                <th>No Voucher</th>                                    
                                <th>Payment Date</th>                                    
                                <th>Voucher Date</th>                                    
                                <th>Reference Date</th>
                                <th>Debit Note / Kwitansi</th>
                                <th>Policy Number / Policy Holder</th>                    
                                <th>Total</th>                                               
                                <th>No Rekening</th>
                                <th>Outstanding Balance</th>
                                <th>Payment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td><a href="{{route('income.reinsurance.detail',['id'=>$item->id])}}">{!!status_income($item->status)!!}</a></td>
                                <td><a href="{{route('income.reinsurance.detail',['id'=>$item->id])}}">{{$item->no_voucher}}</a></td>
                                <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td>{{$item->payment_date?date('d M Y', strtotime($item->payment_date)):'-'}}</td>
                                <td>{{$item->reference_date?date('d M Y', strtotime($item->reference_date)):'-'}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{$item->client ? $item->client : '-'}}</td>
                                <td>{{isset($item->nominal) ? format_idr($item->nominal) : '-'}}</td>
                                <td>{{isset($item->bank_account->no_rekening) ? $item->bank_account->no_rekening .'('.$item->bank_account->bank.')' : '-'}}</td>
                                <td>{{isset($item->outstanding_balance) ? format_idr($item->outstanding_balance) : '-'}}</td>
                                <td>{{isset($item->payment_amount) ? format_idr($item->payment_amount) : '-'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
                {{$data->links()}}
            </div>
        </div>
    </div>
</div>