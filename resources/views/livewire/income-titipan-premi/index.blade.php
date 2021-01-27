@section('title', 'Titipan Premi')
@section('parentPageTitle', 'Income')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="mb-2 row">
                    <div class="col-md-2">
                        <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                    </div>
                    <div class="col-md-1 pl-0">
                        <select class="form-control" wire:model="unit">
                            <option value=""> --- Unit --- </option>
                            <option value="1"> Konven </option>
                            <option value="2"> Syariah</option>
                        </select>
                    </div>
                    <div class="px-0 col-md-1">
                        <select class="form-control" wire:model="status">
                            <option value=""> --- Status --- </option>
                            <option value="1"> Unpaid </option>
                            <option value="2"> Paid</option>
                            <option value="3"> Outstanding</option>
                        </select>
                    </div>
                    <div class="col-md-2 pr-0">
                        <input type="text" class="form-control" wire:model="payment_date" placeholder="Payment Date" onfocus="(this.type='date')" />
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" wire:model="voucher_date" placeholder="Voucher Date" onfocus="(this.type='date')" />
                    </div>
                    <div class="col-md-2 px-0">
                        <a href="{{route('income.titipan-premi.insert')}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Titipan Premi</a>
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
                                <th>Outstanding Balance</th>
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
                                <td>{{isset($item->titipan_premi) ? format_idr($item->titipan_premi->sum('nominal')) : '-'}}</td>
                                <td>{{format_idr($item->nominal - $item->titipan_premi->sum('nominal'))}}</td>
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