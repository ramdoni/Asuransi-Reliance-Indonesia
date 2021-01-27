<div class="modal-content">
    <form wire:submit.prevent="save">
        <div class="row p-3">
            <h5 class="modal-title ml-3" id="exampleModalLabel"><i class="fa fa-plus"></i> Add Titipan Premi</h5>
            <div class="col-md-3">
                <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
            </div>
            <div class="col-md-3 px-0" wire:ignore>
                <select class="form-control titipan_from_bank_account" wire:model="from_bank_account_id">
                    <option value=""> --- {{__('From Bank Account')}} --- </option>
                    @foreach (\App\Models\BankAccount::where('is_client',1)->orderBy('owner','ASC')->get() as $bank)
                        <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                    @endforeach
                </select>
            </div>
            <div wire:loading class="mt-1 ml-3">
                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover m-b-0 c_list">
                    <thead>
                        <tr>
                            <th>No</th>                                    
                            <th></th>                                    
                            <th>No Voucher</th>                                    
                            <th>Payment Date</th>                                    
                            <th>Voucher Date</th>                                    
                            <th>Reference Date</th>
                            <th>Reference No</th>                                      
                            <th>From Bank Account</th>
                            <th>To Bank Account</th>
                            <th>Payment Amount</th>
                            <th>Outstanding Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $item)
                        <tr>
                            <td style="width: 50px;">{{$k+1}}</td>
                            <td><a href="javascript:void(0)" wire:click="$emit('set-titipan-premi',{{$item->id}})"><i class="fa fa-check"></i> Select</a></td>
                            <td><a href="{{route('income.titipan-premi.detail',$item->id)}}" target="_blank">{{$item->no_voucher}}</a></td>
                            <td>{{$item->payment_date?date('d M Y', strtotime($item->payment_date)):'-'}}</td>
                            <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                            <td>{{date('d M Y', strtotime($item->reference_date))}}</td>
                            <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                            <td>{{isset($item->from_bank_account->no_rekening) ? $item->from_bank_account->no_rekening .'- '.$item->from_bank_account->bank.' an '. $item->from_bank_account->owner : '-'}}</td>
                            <td>{{isset($item->bank_account->no_rekening) ? $item->bank_account->no_rekening .' - '.$item->bank_account->bank.' an '. $item->bank_account->owner : '-'}}</td>
                            <td>{{isset($item->nominal) ? format_idr($item->nominal) : '-'}}</td>
                            <td>{{isset($item->outstanding_balance) ? format_idr($item->outstanding_balance) : '-'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br />
            {{$data->links()}}
        </div>
        <div class="modal-footer">
            <a href="#" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
        </div>
    </form>
</div>
@push('after-scripts')
<script>
    select__2 = $('.titipan_from_bank_account').select2();
    $('.titipan_from_bank_account').on('change', function (e) {
        var data = $(this).select2("val");
        @this.set('from_bank_account_id', data);
    });
    var selected__ = $('.titipan_from_bank_account').find(':selected').val();
    if(selected__ !="") select__2.val(selected__);
    
</script>
@endpush