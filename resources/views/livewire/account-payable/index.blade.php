@section('title', 'Account Payable')
@section('parentPageTitle', 'Home')

<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="col-md-2">
                    <select class="form-control" wire:model="coa_id">
                        <option value=""> --- COA --- </option>
                        @foreach(\App\Models\Coa::orderBy('name','ASC')->get() as $i)
                        <option value="{{$i->id}}">{{$i->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="{{route('account-payable.insert')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Account Payable</a>
                </div>
            </div>
            <div class="pt-0 body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Voucher</th>                                    
                                <th>Recipient</th>                                    
                                <th>Reference Type</th>                                    
                                <th>Reference No.</th>
                                <th>Referense Date</th>
                                <th>Description</th>
                                <th>Tax Inclusive Amount</th>
                                <th>Tax Code</th>
                                <th>Exclusive Amount</th>
                                <th>Tax Amount</th>
                                <th>Outstanding Balance</th>
                                <th>Account Number</th>
                                <th>Payment Amount</th>
                                <th>Payment Date</th>
                                <th>Bank Code</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>{{$item->no_voucher ? $item->no_voucher : '-'}}</td>
                                <td>{{$item->recipient ? $item->recipient : '-'}}</td>
                                <td>{{$item->reference_type ? $item->reference_type : '-'}}</td>
                                <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                <td>{{$item->reference_date ? $item->reference_date : '-'}}</td>
                                <td>{{$item->description ? $item->description : '-'}}</td>
                                <td>{{isset($item->tax->name) ? $item->tax->name : '-'}}</td>
                                <td>{{isset($item->tax->code) ? $item->tax->code : '-'}}</td>
                                <td>{{isset($item->amount) ? $item->amount : '-'}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{isset($item->bank->name)?$item->bank->name : '-'}}</td>
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