@section('title', 'Account Payable')
@section('parentPageTitle', 'Home')

<div class="row clearfix">
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
                    <a href="{{route('account-receivable.insert')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Account Receivable</a>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>COA</th>                                    
                                <th>No Voucher</th>                                    
                                <th>Date</th>                                    
                                <th>Account</th>
                                <th>Description</th>
                                <th>Nominal</th>
                                <th>Saldo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>{{isset($item->coa->code) ? $item->coa->code : ''}}</td>
                                <td>{{$item->no_voucher}}</td>
                                <td>{{$item->date_journal}}</td>
                                <td>{{isset($item->coa->name) ? $item->coa->name : ''}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{format_idr($item->debit)}}</td>
                                <td>{{format_idr($item->saldo)}}</td>
                                <td><a href="javascript:void(0)" wire:click="delete({{$item->id}})" class="text-danger"><i class="fa fa-trash"></i></a></td>
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