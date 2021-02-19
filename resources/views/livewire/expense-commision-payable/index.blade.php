@section('title', 'Commision Payable')
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
                        <select class="form-control" wire:model="unit">
                            <option value=""> --- Unit --- </option>
                            <option value="1">[K] Konven </option>
                            <option value="2">[S] Syariah</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" wire:model="status">
                            <option value=""> --- Status --- </option>
                            <option value="2"> Paid</option>
                            <option value="4"> Draft</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <a href="{{route('expense.commision-payable.insert')}}" class="btn btn-success"><i class="fa fa-plus"></i> Commision Payable</a>
                        <a href="javascript:;" class="btn btn-info" wire:click="downloadExcel"><i class="fa fa-download"></i> Download</a>
                        <div wire:loading>
                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-b-0 c_list">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>                                    
                                <th rowspan="2">Status</th>                                    
                                <th rowspan="2">No Voucher</th>                                      
                                <th rowspan="2">Voucher Date</th>  
                                <th rowspan="2">Debit Note / Kwitansi</th>
                                <th rowspan="2">Policy Number / Policy Holder</th>      
                                <th colspan="4" class="text-center">Fee Base</th>
                                <th colspan="4" class="text-center">Maintenance</th>
                                <th colspan="4" class="text-center">Admin Agency</th>
                                <th colspan="4" class="text-center">Agen Penutup</th>
                                <th colspan="4" class="text-center">Operasional Agency</th>
                                <th colspan="4" class="text-center">Handling Fee Broker</th>
                                <th colspan="4" class="text-center">Referal Fee</th>
                            </tr>
                            <tr>
                                <th>Biaya</th>
                                <th>Nama Penerima</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Biaya</th>
                                <th>Nama Penerima</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Biaya</th>
                                <th>Nama Penerima</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Biaya</th>
                                <th>Nama Penerima</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Biaya</th>
                                <th>Nama Penerima</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Biaya</th>
                                <th>Nama Penerima</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Biaya</th>
                                <th>Nama Penerima</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$data->firstItem()+$k}}</td>
                                <td>
                                    <a href="{{route('expense.commision-payable.detail',['id'=>$item->id])}}">{!!status_expense($item->status)!!}</a>
                                    @if($item->status==4)
                                    <a href="javascript:;" class="text-danger" wire:click="delete({{$item->id}})"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                                <td><a href="{{route('expense.commision-payable.detail',['id'=>$item->id])}}">{!!no_voucher($item)!!}</a></td>
                                <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{$item->recipient ? $item->recipient : '-'}}</td>
                                
                                <td>{{isset($item->payment_fee_base->payment_amount) ? format_idr($item->payment_fee_base->payment_amount) : '-'}}</td>
                                <td>{{isset($item->payment_fee_base->to_bank_account->owner) ? $item->payment_fee_base->to_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->payment_fee_base->to_bank_account->bank) ? $item->payment_fee_base->to_bank_account->bank : '-'}}</td>
                                <td>{{isset($item->payment_fee_base->to_bank_account->no_rekening) ? $item->payment_fee_base->to_bank_account->no_rekening : '-'}}</td>

                                <td>{{isset($item->payment_maintenance->payment_amount) ? format_idr($item->payment_maintenance->payment_amount) : '-'}}</td>
                                <td>{{isset($item->payment_maintenance->to_bank_account->owner) ? $item->payment_maintenance->to_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->payment_maintenance->to_bank_account->bank) ? $item->payment_maintenance->to_bank_account->bank : '-'}}</td>
                                <td>{{isset($item->payment_maintenance->to_bank_account->no_rekening) ? $item->payment_maintenance->to_bank_account->no_rekening : '-'}}</td>
                                
                                <td>{{isset($item->payment_admin_agency->payment_amount) ? format_idr($item->payment_admin_agency->payment_amount) : '-'}}</td>
                                <td>{{isset($item->payment_admin_agency->to_bank_account->owner) ? $item->payment_admin_agency->to_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->payment_admin_agency->to_bank_account->bank) ? $item->payment_admin_agency->to_bank_account->bank : '-'}}</td>
                                <td>{{isset($item->payment_admin_agency->to_bank_account->no_rekening) ? $item->payment_admin_agency->to_bank_account->no_rekening : '-'}}</td>

                                <td>{{isset($item->payment_agen_penutup->payment_amount) ? format_idr($item->payment_agen_penutup->payment_amount) : '-'}}</td>
                                <td>{{isset($item->payment_agen_penutup->to_bank_account->owner) ? $item->payment_agen_penutup->to_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->payment_agen_penutup->to_bank_account->bank) ? $item->payment_agen_penutup->to_bank_account->bank : '-'}}</td>
                                <td>{{isset($item->payment_agen_penutup->to_bank_account->no_rekening) ? $item->payment_agen_penutup->to_bank_account->no_rekening : '-'}}</td>

                                <td>{{isset($item->payment_operasional_agency->payment_amount) ? format_idr($item->payment_operasional_agency->payment_amount) : '-'}}</td>
                                <td>{{isset($item->payment_operasional_agency->to_bank_account->owner) ? $item->payment_operasional_agency->to_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->payment_operasional_agency->to_bank_account->bank) ? $item->payment_operasional_agency->to_bank_account->bank : '-'}}</td>
                                <td>{{isset($item->payment_operasional_agency->to_bank_account->no_rekening) ? $item->payment_operasional_agency->to_bank_account->no_rekening : '-'}}</td>

                                <td>{{isset($item->payment_handling_fee_broker->payment_amount) ? format_idr($item->payment_handling_fee_broker->payment_amount) : '-'}}</td>
                                <td>{{isset($item->payment_handling_fee_broker->to_bank_account->owner) ? $item->payment_handling_fee_broker->to_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->payment_handling_fee_broker->to_bank_account->bank) ? $item->payment_handling_fee_broker->to_bank_account->bank : '-'}}</td>
                                <td>{{isset($item->payment_handling_fee_broker->to_bank_account->no_rekening) ? $item->payment_handling_fee_broker->to_bank_account->no_rekening : '-'}}</td>

                                <td>{{isset($item->payment_referal_fee->payment_amount) ? format_idr($item->payment_referal_fee->payment_amount) : '-'}}</td>
                                <td>{{isset($item->payment_referal_fee->to_bank_account->owner) ? $item->payment_referal_fee->to_bank_account->owner : '-'}}</td>
                                <td>{{isset($item->payment_referal_fee->to_bank_account->bank) ? $item->payment_referal_fee->to_bank_account->bank : '-'}}</td>
                                <td>{{isset($item->payment_referal_fee->to_bank_account->no_rekening) ? $item->payment_referal_fee->to_bank_account->no_rekening : '-'}}</td>
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