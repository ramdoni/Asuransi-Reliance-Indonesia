@section('title', 'Others Income')
@section('parentPageTitle', 'Income')
<div class="clearfix row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-0">
                    <div class="body py-2">
                        <div class="number">
                            <h6 class="text-info">Total</h6>
                            <span>{{ format_idr($total) }}</span>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                        <div class="progress-bar" data-transitiongoal="87" aria-valuenow="87" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-0">
                    <div class="body py-2">
                        <div class="number">
                            <h6 class="text-success">Payment Amount</h6>
                            <span>{{ format_idr($received) }}</span>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="87" aria-valuenow="87" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card  mb-0">
                    <div class="body py-2">
                        <div class="number">
                            <h6 class="text-warning">Outstanding</h6>
                            <span>{{ format_idr($outstanding) }}</span>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-yellow  m-b-0">
                        <div class="progress-bar" data-transitiongoal="87" aria-valuenow="87" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <option value="1"> Unpaid </option>
                            <option value="2"> Paid</option>
                            <option value="3"> Outstanding</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <a href="{{route('others-income.insert')}}" class="btn btn-success"><i class="fa fa-plus"></i> Income</a>
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
                                <th>No Voucher</th>                                    
                                <th>Payment Date</th>                                    
                                <th>Voucher Date</th>                                    
                                <th>Reference Date</th>
                                <th>Debit Note / Kwitansi</th>
                                <th>Client</th>                    
                                <th>Description</th>                    
                                <th>Amount</th>     
                                <th>From Bank Account</th>
                                <th>To Bank Account</th>
                                <th>Outstanding Balance</th>
                                <th>Bank Charges</th>
                                <th>Payment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>
                                    <a href="{{route('others-income.detail',['id'=>$item->id])}}">{!!status_expense($item->status)!!}</a>
                                    @if($item->status==4)
                                    <a href="javascript:;" class="text-danger" wire:click="delete({{$item->id}})"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                                <td><a href="{{route('others-income.detail',['id'=>$item->id])}}">{!!no_voucher($item)!!}</a></td>
                                <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td>{{date('d M Y', strtotime($item->payment_date))}}</td>
                                <td>{{date('d M Y', strtotime($item->reference_date))}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{$item->client ? $item->client : '-'}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{isset($item->nominal) ? format_idr($item->nominal) : '-'}}</td>
                                <td>{{isset($item->from_bank_account->no_rekening) ? $item->from_bank_account->no_rekening .'- '.$item->from_bank_account->bank.' an '. $item->from_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->bank_account->no_rekening) ? $item->bank_account->no_rekening .' - '.$item->bank_account->bank.' an '. $item->bank_account->owner : '-'}}</td>
                                <td>{{isset($item->outstanding_balance) ? format_idr($item->outstanding_balance) : '-'}}</td>
                                <td>{{isset($item->bank_charges) ?? format_idr($item->bank_charges)}}</td>
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