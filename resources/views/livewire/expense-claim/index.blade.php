@section('title', 'Claim Payable')
@section('parentPageTitle', 'Expense')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="mb-2 row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" wire:model="status">
                            <option value=""> --- Status --- </option>
                            <option value="2"> Paid</option>
                            <option value="4"> Draft</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" wire:model="type">
                            <option value=""> --- Unit --- </option>
                            <option value="1">[K] Konven </option>
                            <option value="2">[S] Syariah</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <a href="{{route('expense.claim.insert')}}" class="btn btn-info"><i class="fa fa-plus"></i> Claim</a>
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
                                <th>From Bank Account</th>
                                <th>To Bank Account</th>
                                <th>Bank Charges</th>
                                <th>Payment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>
                                    <a href="{{route('expense.claim.detail',['id'=>$item->id])}}">{!!status_expense($item->status)!!}</a>
                                    @if($item->status==4)
                                    <a href="javascript:;" title="Delete Claim" class="text-danger" wire:click="delete({{$item->id}})"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                                <td><a href="{{route('expense.claim.detail',['id'=>$item->id])}}">{!!no_voucher($item)!!}</a></td>
                                <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td>{{date('d M Y', strtotime($item->payment_date))}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{$item->recipient ? $item->recipient : '-'}}</td>
                                <td>{{isset($item->from_bank_account->no_rekening) ? $item->from_bank_account->no_rekening .' - '.$item->from_bank_account->bank.' an '.$item->from_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->bank_account->no_rekening) ? $item->bank_account->no_rekening .' - '.$item->bank_account->bank.' an '.$item->bank_account->owner : '-'}}</td>
                                <td>{{isset($item->bank_charges) ? format_idr($item->bank_charges) : '-'}}</td>
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