@section('title', 'Journal')
@section('parentPageTitle', 'Home')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
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
                                <th>Debit</th>                                    
                                <th>Kredit</th>
                                <th>Saldo</th>
                                <th>Kode Cashflow</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>{{isset($item->coa->code)?$item->coa->code:''}}</td>
                                <td>{{$item->no_voucher}}</td>
                                <td>{{date('d-M-Y',strtotime($item->date_journal))}}</td>
                                <td>{{isset($item->coa->name)?$item->coa->name:''}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{format_idr($item->debit)}}</td>
                                <td>{{format_idr($item->kredit)}}</td>
                                <td>{{format_idr($item->saldo)}}</td>
                                <td></td>
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