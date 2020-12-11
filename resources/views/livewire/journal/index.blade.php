<div>
    <div class="row">
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
        <div class="col-md-3">
            <a href="javascript:void(0)" class="btn btn-info" wire:click="downloadExcel"><i class="fa fa-download"></i> Download Excel</a>
            @if($set_multiple_cashflow)
                <a href="javascript:void(0)" class="btn btn-danger" wire:click="$set('set_multiple_cashflow',false)"><i class="fa fa-times"></i> Cancel</a>
                <a href="javascript:void(0)" class="btn btn-success" wire:click="submitCashFlow"><i class="fa fa-check"></i> Submit</a>
            @else
                <a href="javascript:void(0)" class="btn btn-warning" wire:click="$set('set_multiple_cashflow',true)"><i class="fa fa-check"></i> Set Cash Flow</a>
            @endif
        </div>
    </div>
    <div class="px-0 body">
        <div class="table-responsive">
            <table class="table table-striped m-b-0 c_list table-bordered table-style1 table-hover">
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
                        <th style="text-align:center;">
                            @if($set_multiple_cashflow)
                                <label class="text-succes" wire:click="checkAll"><input type="checkbox" wire:model="check_all" value="1" /> Check All</label>
                            @else
                                Code Cashflow
                            @endif
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php($br=0)
                    @php($key_code_cashflow=0)
                    @foreach($data as $k => $item)
                    @if($item->no_voucher!=$br)
                    <tr><td colspan="9"></td></tr>
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
                        <td class="text-right">{{format_idr($item->debit)}}</td>
                        <td class="text-right">{{format_idr($item->kredit)}}</td>
                        <td class="text-right">{{format_idr($item->saldo)}}</td>
                        <td style="text-align:center;">
                            @if(isset($item->code_cashflow->code))
                                <span>{{$item->code_cashflow->code}}</span>
                            @elseif($set_multiple_cashflow)
                                <input type="checkbox" wire:model="value_multiple_cashflow.{{$key_code_cashflow}}" value="{{$item->id}}" />
                                @php($key_code_cashflow++)
                            @else
                                <a href="javascript:void(0)" title="{{isset($item->code_cashflow->code)?$item->code_cashflow->name : ''}}" class="{{isset($item->code_cashflow->code) ? 'btn btn-warning btn-sm' :''}}" wire:click="setCodeCashflow({{$item->id}})"><i class="fa fa-edit"></i> Set</a>
                            @endif
                        </td>
                    </tr>
                    @php($br=$item->no_voucher)
                    @endforeach
                </tbody>
            </table>
        </div>
        <br />
        {{$data->links()}}
        <div wire:ignore.self class="modal fade" id="modal_set_code_cashflow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <livewire:journal.set-code-cashflow>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="modal_set_code_cashflow_checkbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <livewire:journal.set-code-cashflow-checkbox>
                </div>
            </div>
        </div>
    </div>
</div>
@section('page-script')
    Livewire.on('message', msg =>{
        alert(msg);
    });

    Livewire.on('modalEdit', () =>{
        $("#modal_set_code_cashflow").modal("show");
    });
    Livewire.on('modalEditHide', () =>{
        $("#modal_set_code_cashflow").modal("hide");
    });
    Livewire.on('modalSetCodeCashflowCheckbox', () =>{
        $("#modal_set_code_cashflow_checkbox").modal("show");
    });
    Livewire.on('modalSetCodeCashflowCheckboxHide', () =>{
        $("#modal_set_code_cashflow_checkbox").modal("hide");
    });
@endsection