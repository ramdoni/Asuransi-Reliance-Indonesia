@section('title', 'Premium Deposit')
@section('parentPageTitle', 'Income')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="mb-2 row">
                    <div class="col-md-2">
                        <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                    </div>
                    <div class="px-0 col-md-1">
                        <select class="form-control" wire:model="status">
                            <option value=""> --- Status --- </option>
                            <option value="1"> Outstanding </option>
                            <option value="2"> Complete</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('income.titipan-premi.insert')}}" class="btn btn-info"><i class="fa fa-plus"></i> Premium Deposit</a>
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
                                <th>Reference No</th>                                      
                                <th>From Bank Account</th>
                                <th>To Bank Account</th>
                                <th>Payment Amount</th>
                                <th>Premium Receive</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>
                                    <a href="{{route('income.titipan-premi.detail',['id'=>$item->id])}}">
                                    @if($item->status==1)
                                    <span class="badge badge-warning">Outstanding</span>
                                    @endif
                                    @if($item->status==2)
                                    <span class="badge badge-success">Completed</span>
                                    @endif
                                    </a>
                                </td>
                                <td><a href="{{route('income.titipan-premi.detail',['id'=>$item->id])}}">{{$item->no_voucher}}</a></td>
                                <td>{{$item->payment_date?date('d M Y', strtotime($item->payment_date)):'-'}}</td>
                                <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td>{{date('d M Y', strtotime($item->reference_date))}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{isset($item->from_bank_account->no_rekening) ? $item->from_bank_account->no_rekening .'- '.$item->from_bank_account->bank.' an '. $item->from_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->bank_account->no_rekening) ? $item->bank_account->no_rekening .' - '.$item->bank_account->bank.' an '. $item->bank_account->owner : '-'}}</td>
                                <td>{{isset($item->nominal) ? format_idr($item->nominal) : '-'}}</td>
                                <td>{{format_idr($item->payment_amount)}}</td>
                                <td>{{format_idr($item->outstanding_balance)}}</td>
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