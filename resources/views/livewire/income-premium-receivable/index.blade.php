@section('title', 'Premium Receivable')
@section('parentPageTitle', 'Home')
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
                            <option value="4"> Premi tidak tertagih</option>
                        </select>
                    </div>
                    <div class="col-md-2 pr-0">
                        <input type="text" class="form-control" wire:model="payment_date" placeholder="Payment Date" onfocus="(this.type='date')" />
                    </div>
                    <div class="col-md-1">
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
                                <th>Aging</th>
                                <th>Due Date</th>
                                <th>Debit Note / Kwitansi</th>
                                <th>Policy Number / Policy Holder</th> 
                                <th>Cancelation</th>                   
                                <th>Endorsement</th>                   
                                <th>Total</th>                                               
                                <th>From Bank Account</th>
                                <th>To Bank Account</th>
                                <th>Outstanding Balance</th>
                                <th>Bank Charges</th>
                                <th>Payment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php($num=$data->firstItem())
                        @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$num}}</td>
                                <td><a href="{{route('income.premium-receivable.detail',['id'=>$item->id])}}">{!!status_income($item->status)!!}</a></td>
                                <td>
                                    <a href="{{route('income.premium-receivable.detail',['id'=>$item->id])}}">{{$item->no_voucher}}</a>
                                    @if($item->type==1)
                                    <span class="badge badge-danger" title="Konven">K</span>
                                    @else
                                    <span class="badge badge-info" title="Syariah">S</span>
                                    @endif
                                </td>
                                <td>{{$item->payment_date?date('d M Y', strtotime($item->payment_date)):'-'}}</td>
                                <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td>{{date('d M Y', strtotime($item->reference_date))}}</td>
                                <td>{{calculate_aging($item->reference_date)}}</td>
                                <td>{{$item->due_date?date('d M Y',strtotime($item->due_date)):''}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{$item->client ? $item->client : '-'}}</td>
                                <td>
                                    @if($item->type ==1)
                                        {{ isset($item->cancelation_konven)?format_idr($item->cancelation_konven->sum('nominal')):0 }}
                                    @else
                                        {{ isset($item->cancelation_syariah)?format_idr($item->cancelation_syariah->sum('nominal')):0 }}
                                    @endif
                                </td>
                                <td>
                                    @if($item->type ==1)
                                        {{ isset($item->endorsemement_konven)?format_idr($item->endorsement_konven->sum('nominal')):0 }}
                                    @else
                                        {{ isset($item->endorsemement_syariah)?format_idr($item->endorsement_syariah->sum('nominal')):0 }}
                                    @endif
                                </td>
                                <td>{{isset($item->nominal) ? format_idr($item->nominal) : '-'}}</td>
                                <td>{{isset($item->from_bank_account->no_rekening) ? $item->from_bank_account->no_rekening .'- '.$item->from_bank_account->bank.' an '. $item->from_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->bank_account->no_rekening) ? $item->bank_account->no_rekening .' - '.$item->bank_account->bank.' an '. $item->bank_account->owner : '-'}}</td>
                                <td>{{isset($item->outstanding_balance) ? format_idr($item->outstanding_balance) : '-'}}</td>
                                <td>{{isset($item->bank_charges) ? format_idr($item->bank_charges) : '-'}}</td>
                                <td>{{isset($item->payment_amount) ? format_idr($item->payment_amount) : '-'}}</td>
                            </tr>
                        @php($num++)
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