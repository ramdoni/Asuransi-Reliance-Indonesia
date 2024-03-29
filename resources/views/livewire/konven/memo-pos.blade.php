<div class="mt-2" id="keydown">
    <div class="row">
        <div class="col-md-3">
            <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..."/>
        </div>
        <div class="px-0 col-md-1">
            <select class="form-control" wire:model="status">
                <option value=""> --- Status --- </option>
                <option value="0">Draft</option>
                <option value="1">Sync</option>
                <option value="2">Invalid</option>
            </select>
        </div>
        <div class="col-md-4">
            <a href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal_upload_memo_pos" class="mb-2 btn btn-info btn-sm" style="width:150px;"><i class="fa fa-upload"></i> Upload</a>
            @if($total_sync>0)
            <a href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal_confirm_sync_memo_pos" class="mb-2 btn btn-warning btn-sm"><i class="fa fa-refresh"></i> Sync {{$total_sync?"(".$total_sync.")" : "(0)"}}</a>
            @endif
        </div>
        <div class="col-md-4 text-right">
            <h6>Sync : <span class="text-info">{{format_idr(\App\Models\KonvenMemo::where('status_sync',1)->count())}}</span>, Draft : <span class="text-warning">{{format_idr(\App\Models\KonvenMemo::where('status_sync',0)->count())}}</span>, Invalid : <span class="text-danger">{{format_idr(\App\Models\KonvenMemo::where('status_sync',2)->count())}}</span>, Total : <span class="text-success">{{format_idr($data->total())}}</span></h6>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped m-b-0 table-hover c_list">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Bulan</th>
                    <th>User</th>
                    <th>User Akseptasi</th>
                    <th>Berkas Akseptasi</th>
                    <th>Tgl Pengajuan Email</th>
                    <th>Tgl Produksi</th>
                    <th>No Reg</th>
                    <th>No Reg Sistem</th>
                    <th>No DN/CN</th>
                    <th>No DN/CN Sistem</th>
                    <th>Jenis POS</th>
                    <th>Status</th>
                    <th>Posting</th>
                    <th></th>
                    <th>Ket Perubahan 1</th>
                    <th>Ket Perubahan 2</th>
                    <th>No Polis</th>
                    <th>Pemegang Polis</th>
                    <th>Cabang</th>
                    <th>Produk</th>
                    <th>Alamat</th>
                    <th>UP Tujuan Surat</th>
                    <th>Tujuan Pembayaran</th>
                    <th>Bank</th>
                    <th>No Rekening</th>
                    <th>Jumlah Peserta Pending</th>
                    <th>Up Peserta Pending</th>
                    <th>Premi Peserta Pending</th>
                    <th>Peserta</th>
                    <th>No Peserta Awal</th>
                    <th>sd</th>
                    <th>No Peserta Akhir</th>
                    <th>No Sertifikat Awal</th>
                    <th>No Sertifikat Akhir</th>
                    <th>Periode Awal</th>
                    <th>Periode Akhir</th>
                    <th>Tgl Proses</th>
                    <th>Movement</th>
                    <th>Tgl Invoice</th>
                    <th>Tgl Invoice 2</th>
                    <th>No Kwitansi Finance</th>
                    <th>No Kwitansi Finance 2</th>
                    <th>Total Gross Kwitansi</th>
                    <th>Total Gross Kwitansi 2</th>
                    <th>Jumlah Peserta Update</th>
                    <th>UP Cancel</th>
                    <th>Premi Gross Cancel</th>
                    <th>Extra Premi</th>
                    <th>ExtXtra</th>
                    <th>RpXtra</th>
                    <th>Diskon Premi</th>
                    <th>Jml Diskon</th>
                    <th>RpDiskon</th>
                    <th>extDiskon</th>
                    <th>Fee</th>
                    <th>Jml Handling Fee</th>
                    <th>ExtFee</th>
                    <th>RpFee</th>
                    <th>TampilanFee</th>
                    <th>PPH</th>
                    <th>Jml PPH</th>
                    <th>ExtPPh</th>
                    <th>RpPPh</th>
                    <th>Ppn</th>
                    <th>Jml Ppn</th>
                    <th>ExtPPn</th>
                    <th>RpPPn</th>
                    <th>Biaya Sertifikat</th>
                    <th>ExtBiayaSertifikat</th>
                    <th>RpBiayaSertifikat</th>
                    <th>extPstSertifikat</th>
                    <th>Net Sblm Endors</th>
                    <th>Data Stlh Endors</th>
                    <th>UP Stlh Endors</th>
                    <th>Premi Gross Endors</th>
                    <th>Extra Premi</th>
                    <th>extEM</th>
                    <th>RpXtra</th>
                    <th>Discount</th>
                    <th>Jml Discount</th>
                    <th>ExtDiskon</th>
                    <th>RpDiskon</th>
                    <th>Handling fee</th>
                    <th>Jml Fee</th>
                    <th>ExtFee</th>
                    <th>RpFee</th>
                    <th>tampilanFee</th>
                    <th>Pph</th>
                    <th>Jml Pph</th>
                    <th>extPPH</th>
                    <th>RpPPH</th>
                    <th>Ppn</th>
                    <th>Jml Ppn</th>
                    <th>extPPN</th>
                    <th>RpPPn</th>
                    <th>Biaya Sertifikat</th>
                    <th>ExtBiayaSertifikat</th>
                    <th>RpBiayaSertifikat</th>
                    <th>extPstSertifikat</th>
                    <th>Net Stlh Endors</th>
                    <th>Refund</th>
                    <th>Terbilang</th>
                    <th>Ket Lampiran</th>
                    <th>Grace Periode</th>
                    <th>Grace Periode</th>
                    <th>Tgl Jatuh Tempo</th>
                    <th>Tgl Update Database</th>
                    <th>Tgl Update Sistem</th>
                    <th>No Berkas Sistem</th>
                    <th>Tgl Posting Sistem</th>
                    <th>No Debet Note Finance</th>
                    <th>Tgl Bayar</th>
                    <th>Ket</th>
                    <th>Tgl Output Email</th>
                    <th>No Berkas 2</th>
                </tr>
            </thead>
            <tbody>
                @php($num=$data->firstItem())
                @foreach($data as $item)
                <tr>
                    <td>{{$num}}</td>
                    <td>
                        @if($item->status_sync==0)
                            <span class="badge badge-warning">Draft</span>
                        @elseif($item->status_sync==1)
                            <span class="badge badge-success">Sync</span>
                        @elseif($item->status_sync==2)
                            <span class="badge badge-danger" title="{{$item->note_invalid}}">Invalid</span>
                        @endif
                    </td>
                    <td>{{$item->bulan}}</td>
                    <td>{{$item->user}}</td>
                    <td>{{$item->user_akseptasi}}</td>
                    <td>{{$item->berkas_akseptasi}}</td>
                    <td>{{$item->tgl_pengajuan_email}}</td>
                    <td>{{$item->tgl_produksi}}</td>
                    <td>{{$item->no_reg}}</td>
                    <td>{{$item->no_reg_sistem}}</td>
                    <td>{{$item->no_dn_cn}}</td>
                    <td>{{$item->no_dn_cn_sistem}}</td>
                    <td>{{$item->jenis_po}}</td>
                    <td>{{$item->status}}</td>
                    <td>{{$item->posting}}</td>
                    <td>{{$item->jenis_po_2}}</td>
                    <td>{{$item->ket_perubahan1}}</td>
                    <td>{{$item->ket_perubahan2}}</td>
                    <td>{{$item->no_polis}}</td>
                    <td>{{$item->pemegang_polis}}</td>
                    <td>{{$item->cabang}}</td>
                    <td>{{$item->produk}}</td>
                    <td>{{$item->alamat}}</td>
                    <td>{{$item->up_tujuan_surat}}</td>
                    <td>{{$item->tujuan_pembayaran}}</td>
                    <td>{{$item->bank}}</td>
                    <td>{{$item->no_rekening}}</td>
                    <td>{{$item->jumlah_peserta_pending}}</td>
                    <td>{{format_idr($item->up_peserta_pending)}}</td>
                    <td>{{format_idr($item->premi_peserta_pending)}}</td>
                    <td>{{$item->peserta}}</td>
                    <td>{{$item->no_peserta_awal}}</td>
                    <td>s/d</td>
                    <td>{{$item->no_peserta_akhir}}</td>
                    <td>{{$item->no_sertifikat_awal}}</td>
                    <td>{{$item->no_sertifikat_akhir}}</td>
                    <td>{{$item->periode_awal}}</td>
                    <td>{{$item->periode_akhir}}</td>
                    <td>{{$item->tgl_proses}}</td>
                    <td>{{$item->movement}}</td>
                    <td>{{$item->tgl_invoice}}</td>
                    <td>{{$item->tgl_invoice2}}</td>
                    <td>{{$item->no_kwitansi_finance}}</td>
                    <td>{{$item->no_kwitansi_finance2}}</td>
                    <td>{{format_idr($item->total_gross_kwitansi)}}</td>
                    <td>{{format_idr($item->total_gross_kwitansi2)}}</td>
                    <td>{{$item->jumlah_peserta_update}}</td>
                    <td>{{format_idr($item->up_cancel)}}</td>
                    <td>{{format_idr($item->premi_gross_cancel)}}</td>
                    <td>{{format_idr($item->extra_premi)}}</td>
                    <td>{{$item->extextra}}</td>
                    <td>{{$item->rpextra}}</td>
                    <td>{{format_idr($item->diskon_premi)}}</td>
                    <td>{{format_idr(abs($item->jml_diskon))}}</td>
                    <td>{{$item->rp_diskon}}</td>
                    <td>{{$item->extdiskon}}</td>
                    <td>{{format_idr($item->fee)}}</td>
                    <td>{{$item->handling_fee}}</td>
                    <td>{{format_idr($item->ext_fee)}}</td>
                    <td>{{$item->rp_fee}}</td>
                    <td>{{$item->tampilan_fee}}</td>
                    <td>{{$item->pph}}</td>
                    <td>{{($item->jml_pph)}}</td>
                    <td>{{($item->extpph)}}</td>
                    <td>{{($item->rppph)}}</td>
                    <td>{{($item->ppn)}}</td>
                    <td>{{($item->jml_ppn)}}</td>
                    <td>{{($item->extppn)}}</td>
                    <td>{{($item->rpppn)}}</td>
                    <td>{{format_idr($item->biaya_sertifikat)}}</td>
                    <td>{{format_idr($item->extbiayasertifikat)}}</td>
                    <td>{{format_idr($item->rpbiayasertifikat)}}</td>
                    <td>{{format_idr($item->extpstsertifikat)}}</td>
                    <td>{{format_idr($item->net_sblm_endors)}}</td>
                    <td>{{format_idr($item->data_stlh_endors)}}</td>
                    <td>{{format_idr($item->up_stlh_endors)}}</td>
                    <td>{{format_idr($item->premi_gross_endors)}}</td>
                    <td>{{format_idr($item->extra_premi2)}}</td>
                    <td>{{format_idr($item->extem)}}</td>
                    <td>{{format_idr($item->rpxtra)}}</td>
                    <td>{{format_idr($item->discount)}}</td>
                    <td>{{format_idr($item->jml_discount)}}</td>
                    <td>{{$item->ext_discount}}</td>
                    <td>{{$item->rpdiscount}}</td>
                    <td>{{$item->handling_fee}}</td>
                    <td>{{$item->jml_fee}}</td>
                    <td>{{$item->extfee}}</td>
                    <td>{{format_idr($item->rpfee)}}</td>
                    <td>{{$item->tampilanfee}}</td>
                    <td>{{$item->pph2}}</td>
                    <td>{{$item->jml_pph2}}</td>
                    <td>{{$item->extpph2}}</td>
                    <td>{{$item->rppph2}}</td>
                    <td>{{$item->ppn2}}</td>
                    <td>{{$item->jml_ppn2}}</td>
                    <td>{{$item->extppn2}}</td>
                    <td>{{$item->rpppn2}}</td>
                    <td>{{$item->biaya_sertifikat2}}</td>
                    <td>{{$item->extbiayasertifikat2}}</td>
                    <td>{{$item->rpbiayasertifikat2}}</td>
                    <td>{{$item->extpstsertifikat2}}</td>
                    <td>{{format_idr($item->net_stlh_endors)}}</td>
                    <td>{{format_idr($item->refund)}}</td>
                    <td>{{$item->terbilang}}</td>
                    <td>{{$item->ket_lampiran}}</td>
                    <td>{{$item->grace_periode}}</td>
                    <td>{{$item->grace_periode_nominal}}</td>
                    <td>{{$item->tgl_jatuh_tempo}}</td>
                    <td>{{$item->tgl_update_database}}</td>
                    <td>{{$item->tgl_update_sistem}}</td>
                    <td>{{$item->no_berkas_sistem}}</td>
                    <td>{{$item->tgl_posting_sistem}}</td>
                    <td>{{$item->no_debit_note_finance}}</td>
                    <td>{{$item->tgl_bayar}}</td>
                    <td>{{$item->ket}}</td>
                    <td>{{$item->tgl_output_email}}</td>
                    <td>{{$item->no_berkas2}}</td>
                </tr>
                @php($num++)
                @endforeach
            </tbody>
        </table>
        <br />
        {{$data->links()}}
    </div>
    <div wire:ignore.self class="modal fade" id="modal_upload_memo_pos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <livewire:konven.memo-pos-upload>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_confirm_sync_memo_pos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <livewire:konven.memo-pos-sync>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_check_data_memo_pos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;" role="document">
            <div class="modal-content">
                <livewire:konven.memo-pos-check-data>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
<script>
    Livewire.on('emit-check-data-memo-pos',()=>{
        $("#modal_upload_memo_pos").modal("hide");
        setTimeout(function(){
            $("#modal_check_data_memo_pos").modal(
                {
                    backdrop: 'static',
                    keyboard: false
                });
        },1000);
    });
</script>
@endpush