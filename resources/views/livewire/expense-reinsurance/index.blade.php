@section('title', 'Reinsurance')
@section('parentPageTitle', 'Expense')
@section('title-right')
<h6 class="mt-2">
    <small>Received </small>  <strong class="text-info cursor-pointer" wire:click="$set('status',2)">Rp. {{format_idr($received)}}</strong>
    <small>Outstanding</small> <strong class="text-danger">Rp. {{format_idr($outstanding)}}</strong>
    <small>Total </small><strong class="text-success">Rp. {{format_idr($received+$outstanding)}}</strong></h6>
@endsection
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="mb-2 row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" wire:model="unit">
                            <option value=""> --- Unit --- </option>
                            <option value="1"> Konven </option>
                            <option value="2"> Syariah</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" wire:model="status">
                            <option value=""> --- Status --- </option>
                            <option value="1"> Unpaid </option>
                            <option value="2"> Paid</option>
                            <option value="3"> Outstanding</option>
                            <option value="4"> Draft</option>
                        </select>
                    </div>
                    <div class="col-md-5">
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
                                <th>No Voucher</th>                                    
                                <th>Payment Date</th>                                    
                                <th>Voucher Date</th>  
                                <th>Debit Note / Kwitansi</th>
                                <th>Policy Number / Policy Holder</th>                    
                                <th>Total</th>                                               
                                <th>From Bank Account</th>
                                <th>To Bank Account</th>
                                <th>Outstanding Balance</th>
                                <th>Payment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$data->firstItem()+$k}}</td>
                                <td><a href="{{route('expense.reinsurance-premium.detail',['id'=>$item->id])}}">{!!status_expense($item->status)!!}</a></td>
                                <td>
                                    <a href="{{route('expense.reinsurance-premium.detail',['id'=>$item->id])}}">{{$item->no_voucher}}</a>
                                    @if($item->type==1)
                                    <span class="badge badge-danger" title="Konven">K</span>
                                    @else
                                    <span class="badge badge-info" title="Syariah">S</span>
                                    @endif
                                </td>
                                <td>{{$item->payment_date?date('d M Y', strtotime($item->payment_date)):'-'}}</td>
                                <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{$item->recipient ? $item->recipient : '-'}}</td>
                                <td>{{isset($item->nominal) ? format_idr($item->nominal) : '-'}}</td>
                                <td>{{isset($item->bank_account->no_rekening) ? $item->bank_account->no_rekening .' '.$item->bank_account->bank.' an '.$item->bank_account->owner : '-'}}</td>
                                <td>{{isset($item->from_bank_account->no_rekening) ? $item->from_bank_account->no_rekening .' '.$item->from_bank_account->bank.' an '. $item->bank_account->owner : '-'}}</td>
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