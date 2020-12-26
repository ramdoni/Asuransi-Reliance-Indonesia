<div class="mt-2">
    <div class="row">
        <div class="col-md-3">
            <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..."/>
        </div>
        <div class="px-0 col-md-1">
            <select class="form-control" wire:model="status">
                <option value=""> --- Status --- </option>
                <option value="1">Waiting</option>
                <option value="2">Save As Draft</option>
                <option value="3">Journal</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_upload_teknis_conven" class="mb-2 btn btn-info btn-sm" style="width:150px;"><i class="fa fa-upload"></i> Upload</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped m-b-0 table-hover c_list">
            <thead>
                <tr>
                    <th>No</th>                                 
                    <th>Bulan</th>                                    
                    <th>User Memo</th>                                    
                    <th>User Akseptasi</th>                                    
                    <th>Transaksi ID</th>     
                    <th>Berkas Akseptasi</th>
                    <th>Tgl Pengajuan Email</th>
                    <th>Tgl Produksi</th>
                    <th>No Reg</th>
                    <th>No Polis</th>
                    <th>No Polis Sistem</th>
                    <th>Pemegang Polis</th>
                    <th>Alamat</th>
                    <th>Cabang</th>
                    <th>Produk</th>
                    <th>Jml Peserta Pending</th>
                    <th>UP Peserta Pending</th>
                    <th>Premi Peserta Pending</th>
                    <th>Jml Peserta</th>
                    <th>No Peserta Awal</th>
                    <th>No Peserta Akhir</th>
                    <th>Periode Awal</th>
                    <th>Periode Akhir</th>
                    <th>UP</th>
                    <th>Premi Gross</th>
                    <th>Extra Premi</th>
                    <th>Discount</th>
                    <th>Jml Discount</th>
                    <th>Jml Cad Klaim</th>
                    <th>ExtDiskon</th>
                    <th>Cad Klaim</th>
                    <th>Handling Fee</th>
                    <th>Jml Fee</th>
                    <th>PPh</th>
                    <th>Jml PPh</th>
                    <th>PPN</th>
                    <th>Jml PPN</th>
                    <th>Biaya Polis</th>
                    <th>Biaya Sertifikat</th>
                    <th>Ext Sertifikat</th>
                    <th>Premi Netto</th>
                    <th>Terbilang</th>
                    <th>Tgl Update Database</th>
                    <th>Tgl Update Sistem</th>
                    <th>No Berkas Sistem</th>
                    <th>Tgl Posting Sistem</th>
                    <th>Ket Posting</th>
                    <th>Tgl Invoice</th>
                    <th>No Kwitansi / Debit Note</th>
                    <th>Total Gross Kwitansi</th>
                    <th>Grace Periode Terbilang</th>
                    <th>Grace Periode</th>
                    <th>Tgl Jatuh Tempo</th>
                    <th>Extend Tgl Jatuh Tempo</th>
                    <th>Tgl Lunas</th>
                    <th>Ket Lampiran</th>
                </tr>
            </thead>
            <tbody>
                @php($num=$data->firstItem())
                @foreach($data as $item)
                <tr style="cursor:pointer;" onclick="document.location='{{route('konven.underwriting.detail',['id'=>$item->id])}}'">
                    <td>{{$num}}</td>
                    <td>{{$item->bulan}}</td>
                    <td>{{$item->user_memo}}</td>
                    <td>{{$item->user_akseptasi}}</td>
                    <td>{{$item->transaksi_id}}</td>
                    <td>{{$item->berkas_akseptasi}}</td>
                    <td>{{$item->tanggal_pengajuan_email}}</td>
                    <td>{{$item->tanggal_produksi}}</td>
                    <td>{{$item->no_reg}}</td>
                    <td>{{$item->no_polis}}</td>
                    <td>{{$item->no_polis_sistem}}</td>
                    <td>{{$item->pemegang_polis}}</td>
                    <td>{{$item->alamat}}</td>
                    <td>{{$item->cabang}}</td>
                    <td>{{$item->produk}}</td>
                    <td>{{$item->jumlah_peserta_pending}}</td>
                    <td>{{format_idr($item->up_peserta_pending)}}</td>
                    <td>{{format_idr($item->premi_peserta_pending)}}</td>
                    <td>{{$item->jumlah_peserta}}</td>
                    <td>{{$item->nomor_peserta_awal}}</td>
                    <td>{{$item->nomor_peserta_akhir}}</td>
                    <td>{{$item->periode_awal}}</td>
                    <td>{{$item->periode_akhir}}</td>
                    <td>{{format_idr($item->up)}}</td>
                    <td>{{format_idr($item->premi_gross)}}</td>
                    <td>{{format_idr($item->extra_premi)}}</td>
                    <td>{{$item->discount}}</td>
                    <td>{{format_idr($item->jumlah_discount)}}</td>
                    <td>{{format_idr($item->jumlah_cad_klaim)}}</td>
                    <td>{{$item->ext_diskon}}</td>
                    <td>{{$item->cad_klaim}}</td>
                    <td>{{format_idr($item->handling_fee)}}</td>
                    <td>{{format_idr($item->jumlah_fee)}}</td>
                    <td>{{$item->pph}}%</td>
                    <td>{{format_idr($item->jumlah_pph)}}</td>
                    <td>{{$item->ppn}}%</td>
                    <td>{{format_idr($item->jumlah_ppn)}}</td>
                    <td>{{format_idr($item->biaya_polis)}}</td>
                    <td>{{format_idr($item->biaya_sertifikat)}}</td>
                    <td>{{format_idr($item->extsertifikat)}}</td>
                    <td>{{format_idr($item->premi_netto)}}</td>
                    <td>{{$item->terbilang}}</td>
                    <td>{{$item->tgl_update_database}}</td>
                    <td>{{$item->tgl_update_sistem}}</td>
                    <td>{{$item->no_berkas_sistem}}</td>
                    <td>{{$item->tgl_postingan_sistem}}</td>
                    <td>{{$item->ket_postingan}}</td>
                    <td>{{$item->tgl_invoice}}</td>
                    <td>{{$item->no_kwitansi_debit_note}}</td>
                    <td>{{format_idr($item->total_gross_kwitansi)}}</td>
                    <td>{{$item->grace_periode_terbilang}}</td>
                    <td>{{format_idr($item->grace_periode)}}</td>
                    <td>{{$item->tgl_jatuh_tempo}}</td>
                    <td>{{$item->extend_tgl_jatuh_tempo}}</td>
                    <td>{{$item->tgl_lunas}}</td>
                    <td>{{$item->ket_lampiran}}</td>
                </tr>
                @php($num++)
                @endforeach
            </tbody>
        </table>
    </div>
    <br />
    {{$data->links()}}
</div>

<div wire:ignore.self class="modal fade" id="modal_upload_teknis_conven" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:syariah.underwriting-upload>
        </div>
    </div>
</div>