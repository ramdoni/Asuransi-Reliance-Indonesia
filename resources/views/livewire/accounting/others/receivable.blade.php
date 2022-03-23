<div class="body">
    <div class="mb-2 row">
        <div class="col-md-3">
            <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
        </div>
        <div class="col-md-7">
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
                    <th>Created Date</th>                                    
                    <th>Voucher Date</th>                                    
                    <th>Reference Date</th>
                    <th>Debit Note / Kwitansi</th>
                    <th>Client</th>                    
                    <th>Description</th>                    
                    <th>Amount</th>
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
                    <td>{{date('d M Y', strtotime($item->created_at))}}</td>
                    <td>{{date('d M Y', strtotime($item->reference_date))}}</td>
                    <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                    <td>{{$item->client ? $item->client : '-'}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{isset($item->payment_amount) ? format_idr($item->payment_amount) : '-'}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <br />
    {{$data->links()}}
</div>