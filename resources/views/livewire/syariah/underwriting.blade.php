<div class="mt-2">
    <div class="row">
        <div class="col-md-3">
            <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..."/>
        </div>
        <div class="col-md-2">
            <select class="form-control" wire:model="status">
                <option value=""> --- Status --- </option>
                <option value="1">Draft</option>
                <option value="2">Sync</option>
            </select>
        </div>
        <div class="col-md-3">
            <a href="javascript:void(0)"  data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_upload_teknis_conven" class="mb-2 btn btn-info" style="width:150px;"><i class="fa fa-upload"></i> Upload</a>
            @if($total_sync>0)
            <a href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal_confirm_sync" class="mb-2 btn btn-warning"><i class="fa fa-refresh"></i> Sync {{$total_sync?"(".$total_sync.")" : "(0)"}}</a>
            @endif
        </div>
        <div class="col-md-4 text-right">
            <h6>Sync : <span class="text-info">{{format_idr(\App\Models\SyariahUnderwriting::where('status',2)->count())}}</span>, Draft : <span class="text-warning">{{format_idr(\App\Models\SyariahUnderwriting::where('status',1)->count())}}</span>, Total : <span class="text-success">{{format_idr($data->total())}}</span></h6>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped m-b-0 table-hover c_list">
            <thead>
                <tr>
                    <th>No</th>               
                    <th>Status</th>                  
                    @foreach(\Illuminate\Support\Facades\Schema::getColumnListing('syariah_underwritings') as $column)
                    @if(in_array($column,['created_at','updated_at','id','status','is_temp','parent_id','user_id','type_transaksi']))@continue @endif
                    <th>{{ucfirst($column)}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php($num=$data->firstItem())
                @foreach($data as $item)
                <tr>
                    <td>{{$num}}</td>
                    <td>
                        @if($item->status==1)
                        <span class="badge text-warning">Draft</span>
                        @endif
                        @if($item->status==2)
                        <span class="badge text-success">Sync</span>
                        @endif
                    </td>
                    @foreach(\Illuminate\Support\Facades\Schema::getColumnListing('syariah_underwritings') as $column)
                    @if(in_array($column,['created_at','updated_at','id','status','is_temp','parent_id','user_id','type_transaksi']))@continue @endif
                    <td>{{ in_array($column,['manfaat_Kepesertaan_tertunda','kontribusi_kepesertaan_tertunda','jml_kepesertaan','nilai_manfaat','dana_tabbaru','dana_ujrah','kontribusi','ektra_kontribusi','total_kontribusi','pot_langsung','jumlah_diskon','handling_fee','jumlah_fee','jumlah_pph','jumlah_ppn','biaya_polis','biaya_sertifikat','extpst','net_kontribusi','pembayaran','piutang','pengeluaran_ujroh']) ? format_idr($item->$column) : $item->$column }}</td>
                    @endforeach
                </tr>
                @php($num++)
                @endforeach
            </tbody>
        </table>
    </div>
    <br />
    {{$data->links()}}
</div>
<div class="modal fade" id="modal_confirm_sync" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:syariah.underwriting-sync>
        </div>
    </div>
</div>
<div wire:ignore.self class="modal fade" id="modal_upload_teknis_conven" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:syariah.underwriting-upload>
        </div>
    </div>
</div>