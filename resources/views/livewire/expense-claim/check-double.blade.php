<div class="modal-dialog modal-lg" role="document" style="min-width: 90%;">
    <div class="modal-content">
        <form wire:submit.prevent="save">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Double Data</h5>
                <span wire:loading>
                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    <span class="sr-only">{{ __('Loading...') }}</span>
                </span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="max-height: 500px;">
                    <table class="table table-striped table-hover m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>           
                                <th></th>                         
                                <th>Policy Number / Policy Holder</th>                       
                                <th>No / Nama Peserta</th>  
                                <th>Payment Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="badge badge-danger badge-active" wire:click="delete({{$item->id}})"><i class="fa fa-danger"></i> Delete</a>
                                        <a href="javascript:void(0)" class="badge badge-warning badge-active" wire:click="keep({{$item->id}})"><i class="fa fa-warning"></i> Keep</a>
                                    </td>
                                    <td>{{$item->reference_no ? $item->reference_no : '-'}}</td>
                                    <td>
                                        @if(isset($item->pesertas))
                                            @foreach($item->pesertas as $peserta)
                                                <span>{{$peserta->no_peserta}} / {{$peserta->nama_peserta}}</span><br />
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{isset($item->payment_amount) ? format_idr($item->payment_amount) : '-'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                <button type="button" class="btn btn-danger" wire:click="deleteAll"> Delete All</button>
                <button type="button" class="btn btn-warning" wire:click="keepAll"> Keep All</button>
            </div>
        </form>
    </div>
</div>