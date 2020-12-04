@section('title', 'Journal')
@section('parentPageTitle', 'Home')

<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <select class="form-control" wire:model="coa_id">
                        <option value=""> --- COA --- </option>
                        @foreach(\App\Models\Coa::orderBy('name','ASC')->get() as $k=>$i)
                        <option value="{{$i->id}}">{{$i->name}} / {{$i->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pl-0 col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="px-0 col-md-1">
                    <select class="form-control" wire:model="year">
                        <option value=""> -- Year -- </option>
                        @foreach(\App\Models\Journal::select( DB::raw( 'YEAR(date_journal) AS year' ))->groupBy('year')->get() as $i)
                        <option>{{$i->year}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" wire:model="month">
                        <option value=""> --- Month --- </option>
                        @foreach(month() as $k=>$i)
                        <option value="{{$k}}">{{$i}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="px-0 col-md-2">
                    <select class="form-control" wire:model="code_cashflow_id">
                        <option value=""> --- Code Cash Flow --- </option>
                        @foreach(get_group_cashflow() as $k=>$i)
                        <optgroup label="{{$i}}">
                            @foreach(\App\Models\CodeCashflow::where('group',$k)->get() as $k => $item)
                                <option value="{{$item->id}}">{{$item->code}} - {{$item->name}}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="javascript:void(0)" class="btn btn-info" wire:click="downloadExcel"><i class="fa fa-download"></i> Download Excel</a>
                </div>
            </div>
            <div class="pt-0 body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        <thead>
                            <tr>                    
                                <th>COA</th>                                    
                                <th>No Voucher</th>                                    
                                <th>Date</th>                                    
                                <th>Account</th>                                    
                                <th>Description</th>                                    
                                <th>Debit</th>                                    
                                <th>Kredit</th>
                                <th>Saldo</th>
                                <th style="text-align:center;">Kode Cashflow</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($br=0)
                            @foreach($data as $k => $item)
                            @if($item->no_voucher!=$br)
                            <tr>
                                <td colspan="9">&nbsp;</td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{isset($item->coa->code)?$item->coa->code:''}}</td>
                                <td>
                                    @if($item->transaction_table =='income')
                                    <a href="{{route('account-receivable.view',['id'=>$item->transaction_id])}}">{{$item->no_voucher}}</a>
                                    @elseif($item->transaction_table =='expenses')
                                    <a href="{{route('account-payable.view',['id'=>$item->transaction_id])}}">{{$item->no_voucher}}</a>
                                    @else
                                    {{$item->no_voucher}}
                                    @endif
                                </td>
                                <td>{{date('d-M-Y',strtotime($item->date_journal))}}</td>
                                <td>{{isset($item->coa->name)?$item->coa->name:''}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{format_idr($item->debit)}}</td>
                                <td>{{format_idr($item->kredit)}}</td>
                                <td>{{format_idr($item->saldo)}}</td>
                                <td style="text-align:center;">
                                    <a href="javascript:void(0)" class="{{isset($item->code_cashflow->code) ? 'btn btn-warning btn-sm' :''}}" wire:click="setCodeCashflow({{$item->id}})">
                                    @if(isset($item->code_cashflow->code))
                                        {{$item->code_cashflow->code}}
                                    @else
                                        <i class="fa fa-edit"></i> Set</a>
                                    @endif
                                    </a>
                                </td>
                            </tr>
                            @php($br=$item->no_voucher)
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

<div wire:ignore.self class="modal fade" id="modal_set_code_cashflow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:journal.set-code-cashflow>
        </div>
    </div>
</div>
@section('page-script')
    Livewire.on('modalEdit', () =>{
        $("#modal_set_code_cashflow").modal("show");
    });
    Livewire.on('modalEditHide', () =>{
        $("#modal_set_code_cashflow").modal("hide");
    });
@endsection